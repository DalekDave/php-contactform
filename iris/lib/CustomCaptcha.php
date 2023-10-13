<?php
namespace Iris;

/**
 * Class for handling custom captcha
 */
class CustomCaptcha
{

    /**
     * Return random alphanumeric text of supplied argument length.
     * Can be used when random aplha text to be used instead of
     * simple math calculation
     *
     * @param int $length
     * @return string alphanumeric text
     */
    function getRandomAlphaText($length)
    {
        $random_alpha = md5(random_bytes(64));
        $captcha_code = substr($random_alpha, 0, $length);
        $_SESSION['iris_custom_captcha'] = $captcha_code;
        return $captcha_code;
    }

    function getSimpleMathEquation()
    {
        $digit1 = mt_rand(6, 10);
        $digit2 = mt_rand(1, 5);
        if (mt_rand(0, 1) === 1) {
            $math = "$digit1 + $digit2";
            $_SESSION['iris_custom_captcha'] = $digit1 + $digit2;
        } else {
            $math = "$digit1 - $digit2";
            $_SESSION['iris_custom_captcha'] = $digit1 - $digit2;
        }
        return $math;
    }

    function getSession($key)
    {
        $value = "";
        if (! empty($key) && ! empty($_SESSION["$key"])) {
            $value = $_SESSION["$key"];
        }
        return $value;
    }

    /**
     * Create a new true color image. Uses PHP's core function imagecreatetruecolor
     *
     * @param string $textInImage
     * @return resource
     */
    function createCaptchaImage($textInImage)
    {
        $target_layer = imagecreatetruecolor(72, 28);
        $captcha_background = imagecolorallocate($target_layer, 230, 230, 230);
        imagefill($target_layer, 0, 0, $captcha_background);
        $textColor = imagecolorallocate($target_layer, 0, 0, 0);
        imagestring($target_layer, 5, 10, 5, $textInImage, $textColor);

        return $target_layer;
    }

    function renderCaptchaImage($imageData)
    {
        header("Content-type: image/jpeg");
        imagejpeg($imageData);
    }

    function validateCaptcha($formData)
    {
        $isValid = false;
        $captchaSessionData = $this->getSession('iris_custom_captcha');
        if ($captchaSessionData == $formData) {
            $isValid = true;
        }
        return $isValid;
    }
}
