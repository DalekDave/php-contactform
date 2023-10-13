<?php

/**
 * This file is the AJAX endpoint for sending acknowledgement message to user.
 */
session_start();
use Iris\FormService;
use Iris\Config;
use Iris\Language;
use Iris\PHPMailerAdapter;
use Iris\AntiSpam;

require_once __DIR__ . '/Config.php';

$name = $_POST["pp-name"];

$telephone = "";
if (isset($_POST["pp-telephone"])) {
    $telephone = $_POST["pp-telephone"];
}

require_once __DIR__ . '/lib/AntiSpam.php';
$antiSpam = new AntiSpam();
if (Config::DISABLE_IRIS_UI_CACHE == true) {
    $emailFieldName = $antiSpam->getEmailFieldName();
} else {
    $emailFieldName = 'pp-email';
}
$email = trim($_POST[$emailFieldName]);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

$department = "";
if (isset($_POST["pp-department"])) {
    $department = $_POST["pp-department"];
}
$hearAbout = "";
if (isset($_POST["pp-hear-about"])) {
    $hearAbout = $_POST["pp-hear-about"];
}
$priority = "";
if (isset($_POST["pp-priority"])) {
    $priority = $_POST["pp-priority"];
}
$message = $_POST["pp-message"];

$website = "";
if (isset($_POST["pp-website"])) {
    $website = $_POST["pp-website"];
}

$address = "";
if (isset($_POST["pp-address"])) {
    $address = $_POST["pp-address"];
}

$locale = Config::IRIS_LOCALE;

require_once __DIR__ . '/lib/FormService.php';
$formService = new FormService($locale);

$attachmentArray = Array();
if (isset($_FILES['attachment'])) {
    $attachmentArray = $_FILES['attachment'];
    $formService->validateAttachment($attachmentArray);
}

require_once __DIR__ . '/lib/Language.php';
$lang = new Language($locale);

$acknowledgement = $lang->value('acknowledgement_message');

$subject = $lang->value("ack_email_subject");

require_once __DIR__ . '/template/html-acknowledgement-message.php';
$emailBodyHtml = getHTMLAcknowledgementMessage($lang, $name, $email, $telephone, $website, $address, $department, $hearAbout, $priority, $message, $acknowledgement);

$recipentArray = explode(",", $email);
$recipentArray = $formService->sanitizeEmails($recipentArray);

$ccArray = array();
$bccArray = array();

$replyToEmail = Config::SENDER_EMAIL;
$replyToName = Config::SENDER_NAME;

require_once __DIR__ . '/lib/PHPMailerAdapter.php';
$phpMailerAdapter = new PHPMailerAdapter($locale);

$mailResult = $phpMailerAdapter->send($replyToEmail, $replyToName, $subject, $emailBodyHtml, $recipentArray, $ccArray, $bccArray, $attachmentArray);
$mailResultJson = json_decode($mailResult);

if ($mailResultJson->type == 'message') {
    $formService->endAction($mailResult, true);
} else {
    $formService->endAction($mailResult);
}
