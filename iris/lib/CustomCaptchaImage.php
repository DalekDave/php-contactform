<?php

/**
 * This page is used for displaying a custom captcha image.
 * It is included in form-ui.php if ENABLE_CUSTOM_CAPTCHA is set to true in the config
 */
use Iris\CustomCaptcha;
use Iris\Config;
session_start();
require_once __DIR__ . '/CustomCaptcha.php';
require_once __DIR__ . '/../Config.php';
$customCaptcha = new CustomCaptcha();
$captchaCode = '';
if (Config::ENABLE_CUSTOM_CAPTCHA == 1) {
    $captchaCode = $customCaptcha->getRandomAlphaText(6);
} else if (Config::ENABLE_CUSTOM_CAPTCHA > 1) {
    $captchaCode = $customCaptcha->getSimpleMathEquation();
}
$imageData = $customCaptcha->createCaptchaImage($captchaCode);
$customCaptcha->renderCaptchaImage($imageData);
imagedestroy($imageData);
