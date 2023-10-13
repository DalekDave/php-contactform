<?php
namespace Iris;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Adapter for the PHPMailer class.
 */
class PHPMailerAdapter
{

    private $phpMailer;

    private $mailer;

    private $language;

    public function __construct($language = '')
    {
        require_once __DIR__ . '/../vendor/phpmailer/src/Exception.php';
        require_once __DIR__ . '/../vendor/phpmailer/src/PHPMailer.php';
        require_once __DIR__ . '/../vendor/phpmailer/src/SMTP.php';
        $this->phpMailer = new PHPMailer();
        $this->phpMailer->CharSet = 'UTF-8';
        $this->phpMailer->Encoding = 'base64';
        $this->mailer = Config::MAILER;
        $this->language = $language;
        $this->setHeaders();
    }

    /**
     * Set the email delivery mode.
     *
     * Options: smtp, sendmail, qmail, phpmail.
     */
    public function setMailer()
    {
        switch ($this->mailer) {
            case 'sendmail':
                $this->setSendmailSettings();
                break;
            case 'smtp':
                $this->setSmtpSettings();
                break;
            case 'phpmail':
                // no specific settings for PHP's mail()
                break;
        }
    }

    /**
     * Set the sendmail settings.
     */
    public function setSendmailSettings()
    {
        $this->phpMailer->Sendmail = Config::SENDMAIL_PATH;
    }

    /**
     * Set the SMTP settings.
     */
    public function setSmtpSettings()
    {
        $this->phpMailer->IsSMTP();
        $this->phpMailer->Username = Config::SMTP_USERNAME;
        $this->phpMailer->Password = Config::SMTP_PASSWORD;
        $this->phpMailer->Host = Config::SMTP_HOST;
        $this->phpMailer->Port = Config::SMTP_PORT;
        $this->phpMailer->SMTPAuth = Config::SMTP_AUTH;
        $this->phpMailer->SMTPSecure = Config::SMTP_SECURE;
        $this->phpMailer->SMTPDebug = Config::SMTP_DEBUG;
        if (Config::SSL_VERIFYPEER == false) {
            $this->phpMailer->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        }
    }

    /**
     * Set the send details for the email.
     * The user's input is received as argument, and is inserted for 'reply-to' field.
     *
     * @param string $replyToEmail
     * @param string $replyToName
     */
    public function setSender($replyToEmail, $replyToName)
    {
        $this->phpMailer->SetFrom(Config::SENDER_EMAIL, Config::SENDER_NAME);
        // Set the 'reply-to' as the form-submitting user's email,
        // so that, if required, the form recipient can simply 
        // click reply and send the submitter an email
        $this->phpMailer->AddReplyTo($replyToEmail, $replyToName);
    }

    /**
     * Set the recipient
     *
     * @param array $recipientArray
     * @param array $ccArray
     * @param array $bccArray
     */
    public function setRecipient($recipientArray, $ccArray, $bccArray)
    {
        foreach ($recipientArray as $recipient) {
            $this->phpMailer->AddAddress($recipient);
        }
        if (isset($ccArray) && ! empty($ccArray)) {
            foreach ($ccArray as $ccRecipient) {
                $this->phpMailer->AddCC($ccRecipient);
            }
        }
        if (isset($bccArray) && ! empty($bccArray)) {
            foreach ($bccArray as $bccRecipient) {
                $this->phpMailer->AddBCC($bccRecipient);
            }
        }
    }

    /**
     * Parse file attachments and send to PHPMailer.
     */
    public function setAttachment($attachmentArray = array())
    {
        // Attachments:
        // Even if there is no attachment, $_FILES array has one attachment
        // with empty value in first index, and so the check below is necessary
        if (! empty($attachmentArray["tmp_name"][0]) && count($attachmentArray['tmp_name']) > 0) {
            $count = count($attachmentArray['tmp_name']);
            for ($i = 0; $i < $count; $i ++) {
                if (! empty($attachmentArray['tmp_name'][$i])) {
                    if ($attachmentArray['tmp_name'][$i] != "") {
                        $this->phpMailer->AddAttachment($attachmentArray['tmp_name'][$i], $attachmentArray['name'][$i]);
                    }
                }
            }
        }
    }

    /**
     * Handle preparing the content for the message.
     *
     * @param string $subject
     * @param string $emailBodyHtml
     */
    public function setContent($subject, $emailBodyHtml)
    {
        $this->phpMailer->IsHTML(true);
        $this->phpMailer->Subject = $subject;
        $this->phpMailer->Body = $emailBodyHtml;
    }

    /**
     * Send additional headers to the message.
     * Do not insert user input directly into the headers.
     */
    public function setHeaders()
    {
        $this->phpMailer->addCustomHeader('X-Mailer', 'PP-Iris');
    }

    /**
     * Set the RECIPIENTS, ATTACHMENT, CONTENT to send email.
     *
     * @param string $replyToEmail
     * @param string $replyToName
     * @param string $subject
     * @param string $emailBodyHtml
     * @param array $recipentArray
     * @param array $ccArray
     * @param array $bccArray
     * @param array $attachmentArray
     * @return string json response for status
     */
    public function send($replyToEmail, $replyToName, $subject, $emailBodyHtml, $recipentArray, $ccArray, $bccArray, $attachmentArray)
    {
        $this->setMailer();

        $this->setSender($replyToEmail, $replyToName);

        $this->setRecipient($recipentArray, $ccArray, $bccArray);

        if (! empty($attachmentArray)) {
            $this->setAttachment($attachmentArray);
        }

        $this->setContent($subject, $emailBodyHtml);

        $mailResult = $this->sendMail();
        return $mailResult;
    }

    /**
     * Callback anonymous function to get the debugoutput.
     * Implemented simple closure using this anonymous function
     * &$debugOutput - by prefixing with &, the reference of the variable
     * is passed, as we need to append it to the array, and modify it, and keep 
     * the modification outside the anonymous function scope.
     * All this gets the complete debugging information.
     *
     * @return string
     */
    public function sendMail()
    {
        $debugOutput = array();
        $this->phpMailer->Debugoutput = function ($debugOutputLine, $level) use (&$debugOutput) {
            $debugOutput[] = $debugOutputLine;
        };

        $isMailSent = false;
        $isMailSent = $this->phpMailer->send();
        require_once __DIR__ . '/../lib/Language.php';
        $lang = new Language($this->language);

        $mailResult = array();
        if (! $isMailSent) {
            $debugOutputStr = '';
            if (! empty($debugOutput)) {
                $debugOutputStr = implode("\n", $debugOutput);
                $debugOutputStr = '<br><pre>' . htmlspecialchars($debugOutputStr) . '</pre>';
            } else {
                $debugOutputStr = $lang->value("message_debug_smtp");
            }
            $errorMessage = $lang->value("message_smtp_conf_issue") . ' ' . $debugOutputStr;
            $resultArray = array(
                'type' => 'error',
                'text' => $errorMessage
            );
        } else {
            // mail sent successfully
            $resultArray = array(
                'type' => 'message',
                'text' => $lang->value("message_thank_you")
            );
        }
        // Leave the below line commented out, and do not delete it. It may be required during debugging
        // $resultArray = array_map('utf8_encode', $resultArray);
        $mailResult = json_encode($resultArray);
        return $mailResult;
    }
}
