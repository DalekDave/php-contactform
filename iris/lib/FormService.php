<?php
namespace Iris;

/**
 * Service class for handling the email sending process.
 */
class FormService
{

    private $locale;

    private $lang;

    function __construct($locale)
    {
        $this->locale = $locale;
        require_once __DIR__ . '/../lib/Language.php';
        $this->lang = new Language($locale);
    }

    /**
     * Entry point for sending the email message.
     *
     * @param string $name
     * @param string $email
     * @param string $telephone
     * @param string $website
     * @param string $address
     * @param string $department
     * @param string $hearAbout
     * @param string $message
     * @param string $copyUser
     * @param array $attachmentArray
     */
    function sendEmail($name, $email, $telephone, $website, $address, $department, $hearAbout, $priority, $message, $copyUser, $attachmentArray, $isGdpr)
    {
        $subject = $this->lang->value("email_subject");

        require_once __DIR__ . '/../template/html-email-message.php';
        $emailBodyHtml = getHTMLMailMessage($this->lang, $name, $email, $telephone, $website, $address, $department, $hearAbout, $priority, $message, $isGdpr);
        // Set the recipient ('To' email address), which is generally the admin
        $recipientArray = explode(",", Config::RECIPIENT_EMAIL);
        $recipientArray = $this->sanitizeEmails($recipientArray);
        // Set the CC email list entered in the Config
        $ccArray = array();
        if (! empty(Config::CC_EMAIL)) {
            $ccArray = explode(",", Config::CC_EMAIL);
            $ccArray = $this->sanitizeEmails($ccArray);
        }
        // Set CC if user has checked copy user checkbox
        if (Config::ENABLE_COPY_USER == true) {
            if (! empty($copyUser)) {
                $ccArray[] = $email;
            }
        }
        $bccArray = array();
        if (! empty(Config::BCC_EMAIL)) {
            $bccArray = explode(",", Config::BCC_EMAIL);
            $bccArray = $this->sanitizeEmails($bccArray);
        }
        require_once __DIR__ . '/../lib/PHPMailerAdapter.php';
        $replyToEmail = $email;
        if (! empty($name)) {
            $replyToName = $name;
        } else {
            $replyToName = $replyToEmail;
        }
        $mailResult = null;
        if ('sendinblue' == Config::MAILER) {
            require_once __DIR__ . '/SendInBlueFacade.php';
            $sendInBlue = new SendInBlueFacade(Config::SENDINBLUE_API_KEY);
            $mailResult = $sendInBlue->send($replyToEmail, $replyToName, $subject, $emailBodyHtml, $recipientArray, $ccArray, $bccArray, $attachmentArray, Config::SENDER_EMAIL, Config::SENDER_NAME);
        } else {
            $phpMailerAdapter = new PHPMailerAdapter($this->locale);
            $mailResult = $phpMailerAdapter->send($replyToEmail, $replyToName, $subject, $emailBodyHtml, $recipientArray, $ccArray, $bccArray, $attachmentArray);
        }
        $mailResultJson = json_decode($mailResult);
        if ($mailResultJson->type == 'message') {
            // success part - mail sent successfully
            if (Config::ENABLE_ACKNOWLEDGEMENT == false) {
                $this->endAction($mailResult, true);
            } else {
                $this->endAction($mailResult, false);
            }
        } else {
            $this->endAction($mailResult);
        }
    }

    /**
     * Sanitizes the input email
     *
     * @param string $emailArray
     * @return string[]
     */
    function sanitizeEmails($emailArray)
    {
        $cleanEmailArray = array();
        foreach ($emailArray as $email) {
            $cleanEmail = trim($email);
            if (! empty($cleanEmail)) {
                filter_var($cleanEmail, FILTER_SANITIZE_EMAIL);
                $cleanEmailArray[] = $cleanEmail;
            }
        }
        return $cleanEmailArray;
    }

    /**
     * Exit function for AJAX calls
     *
     * @param \JsonSerializable $output
     * @param boolean $clearToken
     */
    function endAction($output, $clearToken = false)
    {
        if ($clearToken == true) {
            require_once __DIR__ . '/../lib/AntiCSRF.php';
            $antiCSRF = new AntiCSRF();
            $antiCSRF->unsetToken();
            require_once __DIR__ . '/../lib/AntiSpam.php';
            $antiSpam = new AntiSpam();
            $antiSpam->cleanUp();
        }
        die($output);
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     * If the form submission includes the "g-captcha-response" field
     * Create an instance of the service using your secret
     * $recaptcha = new \ReCaptcha\ReCaptcha(RECAPTCHA_SECRET_KEY);
     * If file_get_contents() is locked down on your PHP installation to disallow
     * its use with URLs, then you can use the alternative request method instead.
     * This makes use of fsockopen() instead.
     *
     * @param string $reCaptchaResponse
     * @return boolean
     */
    function validateReCaptcha($reCaptchaResponse)
    {
        require_once __DIR__ . '/../vendor/recaptcha/src/autoload.php';
        $recaptcha = new \ReCaptcha\ReCaptcha(Config::RECAPTCHA_SECRET_KEY, new \ReCaptcha\RequestMethod\CurlPost());
        // Make the call to verify the response and also pass the user's IP address
        $resp = $recaptcha->verify($reCaptchaResponse, $_SERVER['REMOTE_ADDR']);
        if (! $resp->isSuccess()) {
            $output = $this->createJsonInstance($this->lang->value("captcha_validation"));
            $this->endAction($output);
        } else {
            return true;
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     * Validates the custom captcha input.
     *
     * @param
     *            string Custom Captcha Input
     * @return boolean
     */
    function validateCustomCaptcha($customCaptchaInput)
    {
        require_once __DIR__ . '/CustomCaptcha.php';
        $customCaptcha = new CustomCaptcha();
        $isValid = $customCaptcha->validateCaptcha($customCaptchaInput);
        if (! $isValid) {
            $output = $this->createJsonInstance($this->lang->value("captcha_validation_failure"));
            $this->endAction($output);
        } else {
            return true;
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     */
    function validateAjaxRequest()
    {
        // to check if its an ajax request, exit if not
        $http_request = $_SERVER['HTTP_X_REQUESTED_WITH'];
        if (! isset($http_request) && strtolower($http_request) != 'xmlhttprequest') {
            $output = $this->createJsonInstance($this->lang->value("ajax_request_validation"));
            $this->endAction($output);
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     */
    function validateCSRFAttack()
    {
        // to validate for CSRF attacks
        require_once __DIR__ . '/../lib/AntiCSRF.php';
        $antiCSRF = new AntiCSRF();
        $isValidRequest = $antiCSRF->isValidRequest();
        if (! $isValidRequest) {
            $output = $this->createJsonInstance($this->lang->value("csrf_validation"));
            $this->endAction($output);
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     *
     * @param string $formToken
     */
    function validateBruteForceAttack($formToken)
    {
        // Check for brute force or automatic throttled quick submission by bots
        require_once __DIR__ . '/../lib/AntiSpam.php';
        $antiSpam = new AntiSpam();
        $isValidInterval = $antiSpam->isBruteForce($formToken);
        if ($isValidInterval) {
            $output = $this->createJsonInstance($this->lang->value("brute_force_attack_validation"));
            $this->endAction($output);
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     *
     * @param string $honeyPot
     * @param string $dummyEmail
     */
    function validateBotSpam($honeyPot, $dummyEmail)
    {
        $cfSpinner = filter_var($honeyPot, FILTER_SANITIZE_STRING);
        $cfDummyEmail = filter_var($dummyEmail, FILTER_SANITIZE_STRING);
        $isDummyEmpty = (empty($cfSpinner) && empty($cfDummyEmail));
        if (! $isDummyEmpty) {
            $output = $this->createJsonInstance($this->lang->value("bot_spam_validation"));
            $this->endAction($output);
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     *
     * @param string $userEmail
     * @param string $message
     */
    function validateEmptyFields($name, $userEmail, $telephone, $website, $address, $department, $hearAbout, $priority, $message, $attachment = "")
    {
        if (Config::FIELD_NAME['1'] == true && empty($name)) {
            $empty[] = $this->lang->value("label_name");
        }
        if (Config::FIELD_EMAIL['1'] == true && empty($userEmail)) {
            $empty[] = $this->lang->value("label_email");
        }
        if (Config::FIELD_TELEPHONE['1'] == true && empty($telephone)) {
            $empty[] = $this->lang->value("label_telephone");
        }
        if (Config::FIELD_DEPARTMENT['1'] == true && empty($department)) {
            $empty[] = $this->lang->value("label_department");
        }
        if (Config::FIELD_HEAR_ABOUT['1'] == true && empty($hearAbout)) {
            $empty[] = $this->lang->value("label_hear_about");
        }
        if (Config::FIELD_PRIORITY['1'] == true && empty($priority)) {
            $empty[] = $this->lang->value("label_priority");
        }
        if (Config::FIELD_WEBSITE['1'] == true && empty($website)) {
            $empty[] = $this->lang->value("label_website");
        }
        if (Config::FIELD_ADDRESS['1'] == true && empty($address)) {
            $empty[] = $this->lang->value("label_address");
        }
        if (Config::FIELD_MESSAGE['1'] == true && empty($message)) {
            $empty[] = $this->lang->value("label_message");
        }
        if (! empty($empty)) {
            $output = $this->createJsonInstance(implode(", ", $empty) . ' ' . $this->lang->value("message_required"));
            $this->endAction($output);
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     *
     * @param string $userEmail
     */
    function validateUserEmail($userEmail)
    {
        if (! filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $output = $this->createJsonInstance($userEmail . ' ' . $this->lang->value("message_invalid_email"));
            $this->endAction($output);
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     *
     * @param string $gdprConsent
     */
    function validateGdprConsent($gdprConsent)
    {
        if (Config::ENABLE_GDPR_CONSENT == true) {
            if (! isset($gdprConsent)) {
                $output = $this->createJsonInstance($this->lang->value("gdpr_consent_validation"));
                $this->endAction($output);
            }
        }
    }

    /**
     * Short circuit type function to stop the process flow on validation failure.
     *
     * @param string $attachmentArray
     */
    function validateAttachment($attachmentArray)
    {
        if (! empty($attachmentArray["tmp_name"][0]) && count($attachmentArray['tmp_name']) > 0) {
            $count = count($attachmentArray['tmp_name']);
            $filesize = 0;
            for ($i = 0; $i < $count; $i ++) {
                if (! empty($attachmentArray["tmp_name"][$i])) {

                    // Calculate attachment filesize
                    $file = $attachmentArray['tmp_name'][$i];
                    // The filesize validation is for the total size
                    $filesize += filesize($file);
                    $this->validateAttachmentSize($filesize);

                    // Validate attachment type
                    if (! empty($attachmentArray["tmp_name"][$i])) {
                        $file_extension = pathinfo($attachmentArray["name"][$i], PATHINFO_EXTENSION);
                        if (! (in_array(strtolower($file_extension), Config::ATTACHMENT_TYPE))) {
                            $output = $this->createJsonInstance($this->lang->value("attachment_type_validation"));
                            $this->endAction($output);
                        }
                    }
                }
            }
        }
    }

    private function validateAttachmentSize($filesize)
    {
        $attachmentSize = ($filesize / 1024 / 1024);
        if ($attachmentSize > Config::ATTACHMENT_FILE_SIZE_LIMIT) {
            $output = $this->createJsonInstance($this->lang->value("attachment_size_validation") . " " . Config::ATTACHMENT_FILE_SIZE_LIMIT . " MB.");
            $this->endAction($output);
        }
    }

    /**
     * Utility function to create a JSON instance
     *
     * @param string $message
     * @param string $type
     * @return string
     */
    private function createJsonInstance($message, $type = 'error')
    {
        $messageArray = array(
            'type' => $type,
            'text' => $message
        );
        // Leave the below line commented out, and do not delete it.
        // It will be required to debug accented multi-language characters.
        // $messageArray = array_map('utf8_encode', $messageArray);
        $jsonObj = json_encode($messageArray);
        return $jsonObj;
    }
}
