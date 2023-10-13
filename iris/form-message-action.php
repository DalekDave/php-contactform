<?php

/**
 * This file is the AJAX endpoint for the contact form submission action.
 */

session_start();
use Iris\AntiSpam;
use Iris\FormService;
use Iris\Config;
use Iris\DataSource;

if ($_POST) {
    require_once __DIR__ . '/Config.php';

    // Set the error display level detail
    if (Config::IRIS_DEBUG == true) {
        ini_set('display_errors', 1);
        set_error_handler(function ($severity, $message, $file, $line) {
            if (error_reporting() & $severity) {
                throw new ErrorException($message, 0, $severity, $file, $line);
            }
        });
    }

    // Security validations
    require_once __DIR__ . '/lib/FormService.php';
    $formService = new FormService(Config::IRIS_LOCALE);
    $formService->validateAjaxRequest();

    if (Config::DISABLE_IRIS_UI_CACHE == true) {
        $formService->validateCSRFAttack();
        $formService->validateBruteForceAttack($_POST["form_token"]);

        // Check for spam submission
        require_once __DIR__ . '/lib/AntiSpam.php';
        $antiSpam = new AntiSpam();
        $honeyPotFieldName = $antiSpam->getHoneyPotFieldName();
        $honeyPot = $_POST[$honeyPotFieldName];
        if (isset($_POST["email"])) {
            $formService->validateBotSpam($honeyPot, $_POST["email"]);
        }
    }

    // Get user input and sanitize
    $userName = "";
    if (isset($_POST["pp-name"])) {
        $userName = filter_var($_POST["pp-name"], FILTER_SANITIZE_STRING);
    }
    if (Config::DISABLE_IRIS_UI_CACHE == true) {
        $emailFieldName = $antiSpam->getEmailFieldName();
    } else {
        $emailFieldName = 'pp-email';
    }
    $userEmail = trim($_POST[$emailFieldName]);
    $userEmail = filter_var($userEmail, FILTER_SANITIZE_EMAIL);

    $telephone = "";
    if (isset($_POST["pp-telephone"])) {
        $telephone = filter_var($_POST["pp-telephone"], FILTER_SANITIZE_STRING);
    }

    $website = "";
    if (isset($_POST["pp-website"])) {
        $website = filter_var($_POST["pp-website"], FILTER_SANITIZE_STRING);
    }

    $address = "";
    if (isset($_POST["pp-address"])) {
        $address = filter_var($_POST["pp-address"], FILTER_SANITIZE_STRING);
    }

    $department = "";
    if (isset($_POST["pp-department"])) {
        $department = filter_var($_POST["pp-department"], FILTER_SANITIZE_STRING);
    }

    $hearAbout = "";
    if (isset($_POST["pp-hear-about"])) {
        // $hearAbout = filter_var($_POST["pp-hear-about"], FILTER_SANITIZE_STRING);
        $hearAbout = $_POST["pp-hear-about"];
    }

    $priority = "";
    if (isset($_POST["pp-priority"])) {
        $priority = $_POST["pp-priority"];
    }

    $message = "";
    if (isset($_POST["pp-message"])) {
        $message = filter_var($_POST["pp-message"], FILTER_SANITIZE_STRING);
    }

    $copyUser = isset($_POST["pp-copy-user"]);

    // Additional fallback server-side validations
    // Required fields validation
    $formService->validateEmptyFields($userName, $userEmail, $telephone, $website, $address, $department, $hearAbout, $priority, $message);

    // Other field specific validations
    if ($userEmail != '') {
        $formService->validateUserEmail($userEmail);
    }
    if (isset($_POST['g-recaptcha-response'])) {
        $formService->validateReCaptcha($_POST['g-recaptcha-response']);
    }
    if (isset($_POST['pp-custom-captcha'])) {
        $customCaptchaInput = filter_var($_POST["pp-custom-captcha"], FILTER_SANITIZE_STRING);
        $formService->validateCustomCaptcha($customCaptchaInput);
    }

    $isGdpr = false;
    if (isset($_POST["pp-gdpr-consent"])) {
        $formService->validateGdprConsent($_POST["pp-gdpr-consent"]);
        $isGdpr = true;
    }

    $attachmentArray = Array();
    if (isset($_FILES['attachment'])) {
        $attachmentArray = $_FILES['attachment'];
        $formService->validateAttachment($attachmentArray);
    }
    if (Config::ENABLE_DATABASE == true) {
        require_once __DIR__ . '/lib/DataSource.php';
        $dataSource = new DataSource();
        $token = "";
        if (! empty($attachmentArray["tmp_name"][0]) && count($attachmentArray['tmp_name']) > 0) {
            $token = bin2hex(rand());
            $count = count($attachmentArray['tmp_name']);
            for ($i = 0; $i < $count; $i ++) {
                if (! empty($attachmentArray["tmp_name"][$i])) {
                    $targetPath = "data/" . $token . "/";
                    if (! file_exists($targetPath)) {
                        mkdir($targetPath, 0777, true);
                    }
                    $uploadFile = $targetPath . basename($attachmentArray["name"][$i]);
                    copy($attachmentArray["tmp_name"][$i], $uploadFile);
                }
            }
        }
        $dataSource->insertContact($userName, $userEmail, $telephone, $department, $website, $address, $hearAbout, $priority, $message, $copyUser, $token, $isGdpr);
    }
    if (Config::ENABLE_CSV_DUMP == true) {
        require_once __DIR__ . '/lib/FileHandler.php';
        $fileHandle = new FileHandler();
        $fileHandle->insertRecord($userName, $userEmail, $telephone, $website, $address, $department, $hearAbout, $priority, $message);
    }
    // All validations passed, now send email
    $formService->sendEmail($userName, $userEmail, $telephone, $website, $address, $department, $hearAbout, $priority, $message, $copyUser, $attachmentArray, $isGdpr);
}
