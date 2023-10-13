<?php

namespace Iris;

/**
 * This class contains the configuration options that helps to
 * customize the look and behavior of the contact form.
 *
 * Options to send email and
 * standard UI configuration.
 *
 * The contact form will function, if and only
 * if the values are entered and correct.
 * You need to go through every one of the below constants and
 * enter the appropriate values.
 */
class Config
{

    // ----------------- Sender and Recipient Configuration STARTS --------------
    const SENDER_NAME = 'Contact form';

    const SENDER_EMAIL = 'admin@collaboration.cafe';

    // In all the below three recipient options,
    // you can add one or more emails separated by a comma (,).

    // To whom the contact form should send the email, generally the Admin of the site.
    const RECIPIENT_EMAIL = 'admin@collaboration.cafe';

    // If you want to send the same email message as a copy (CC),
    // then enter the email(s) in below option.
    const CC_EMAIL = '';

    // If you want to send the same email message as a blind copy (BCC),
    // then enter the email(s) in below option.
    const BCC_EMAIL = '';

    // ----------------- Sender and Recipient Configuration ENDS --------------

    // The mechanism to use, to send email.
    // Options: phpmail, smtp, sendmail, qmail, sendinblue. Default is phpmail.
    // phpmail uses your web server's default email server setup to send email.
    const MAILER = 'phpmail';

    // ----------------- SMTP Configuration STARTS - Required for MAILER smtp mode --------

    // The email username using which the SMTP authenticates
    // In majority of the servers SENDER_EMAIL (defined above) and SMTP_USERNAME will be same.
    const SMTP_USERNAME = '';

    const SMTP_PASSWORD = '';

    const SMTP_HOST = 'localhost';

    // In general TLS on ports 25, 2525, and 587. SSL on port 465.
    // Contact your web or email hosting provider to get this information.
    const SMTP_PORT = 25;

    // Nowadays, every email server requires AUTH to be true. Which is good.
    const SMTP_AUTH = true;

    // Options: ssl, tls.
    const SMTP_SECURE = 'ssl';

    // To get detailed error message from SMTP server via PHPMailer.
    // IMPORTANT: Make this as 0 when you go live.
    // Option: 0 or 4 - default is 0, to debug issues change it to 4.
    const SMTP_DEBUG = 0;

    // ----------------- SMTP Configuration ENDS --------------

    // ----------------- Required for sendmail or qmail mode, ignore otherwise
    // path to your sendmail installation. Ensure you have provided sufficient permissions.
    // Example '/user/sbin/sendmail';
    // Example '/var/qmail/bin/qmail-inject'; // for qmail this is optional.
    const SENDMAIL_PATH = '/usr/sbin/sendmail';

    // ----------------- Required for sendinblue ignore otherwise
    const SENDINBLUE_API_KEY = '';

    // To enable SSL certificate verification.
    // Options: true or false. Default is true.
    const SSL_VERIFYPEER = true;

    // If you wish to redirect to another page after sending the mail enter the url here.
    // example: const REDIRECT_URL = 'http://example.com/anotherPage.php';
    const REDIRECT_URL = '';

    // IMPORTANT: Use this with caution!
    // To enable enter as true. If you enable, the contact form will send an acknowledgement
    // message to the user who submits the form.
    // The reason to use this with caution is, the contact form will send two emails
    // consequetively. Importantly, it will send an acknowledgement email to the email-id
    // that is given as input by the user. So there is a possibility for an anonymous user
    // to misuse this feature. The user can submit the form by providing an email that he
    // does not owns.
    // Options: true or false. Default is false.
    const ENABLE_ACKNOWLEDGEMENT = true;

    // ----------------- Customize the form UI STARTS ------------------
    const FIELD_NAME = array(
        true,
        true
    );

    const FIELD_EMAIL = array(
        true,
        true
    );

    const FIELD_TELEPHONE = array(
        true,
        false
    );

    const FIELD_WEBSITE = array(
        true,
        false
    );

    const FIELD_ADDRESS = array(
        false,
        false
    );

    const FIELD_DEPARTMENT = array(
        false,
        false
    );

    const FIELD_HEAR_ABOUT = array(
        false,
        false
    );

    const FIELD_PRIORITY = array(
        false,
        false
    );

    const FIELD_SUBJECT = array(
        true,
        true
    );

    const FIELD_MESSAGE = array(
        true,
        true
    );

    const FIELD_ATTACHMENT = array(
        true,
        false
    );

    // If the following is true, a checkbox will be enabled in UI.
    // It will allow the user to choose to send a copy of email to himself.
    // The same email that is sent to the Admin will be sent to user as CC.
    // This is in a way similar to an acknowledgement feature.
    // Options: true or false. Default is false.
    const ENABLE_COPY_USER = true;

    // If the following is true, a field with checkbox will appear.
    // It says 'Agree to have my data processed'. This is to get a consent
    // from the user to process his data. This will help you to comply with
    // GDPR regulations. As per the GDPR requirement, the user's consent
    // proof is required. So, if this field is enabled and the user
    // selects it, then the user's IP address, timestamp, browser information
    // are added to the email message. This will serve as a proof for consent.
    // option: true or false
    const ENABLE_GDPR_CONSENT = true;

    // The total attachment file size can be limited. Even after increasing the limit
    // if the contact form works with only small files, you need to check your
    // PHP configuration for file size limit. In your php.ini there are constants as
    // post_max_size and upload_max_filesize, they should be increased.
    // Options: numeric - the size is in MB. Default is 2.
    const ATTACHMENT_FILE_SIZE_LIMIT = '50';

    // Options: numeric - the maximum number of attachments allowed. Default is -1 to allow unlimitted.
    const ATTACHMENT_FILE_COUNT_LIMIT = '5';

    // attachment types that are allowed, you can add more as you wish
    const ATTACHMENT_TYPE = array(
        'png',
        'jpg',
        'jpeg',
        'bmp',
        'gif',
        'avi',
        'mp4',
        'wmv',
        'mp3',
        'flv',
        'mkv',
        'pdf',
        'doc',
        'docx',
        'odt',
        'rtf',
        'xls',
        'csv',
        'dif',
        'ods',
        'xlsx',
        'xps',
        'odp',
        'ppt',
        'pptx',
        'xps',
        'txt',
        'log',
        'md',
        'svg',
        'xml',
        'html',
        'htm',
        'php',
        'zip',
        'tar',
        'tar.gz',
        'gz',
        'rar'
    );

    // To enable Google reCAPTCHA v2 in the form.
    // Options: true or false. Default is false.
    const ENABLE_CAPTCHA = false;

    // if ENABLE_CAPTCHA is true, then reCAPTCHA KEYs below should be supplied
    // to create the below two keys, go to http://www.google.com/recaptcha/admin
    const RECAPTCHA_SITE_KEY = '';

    const RECAPTCHA_SECRET_KEY = '';

    // To enable Simple math addition / subtraction captcha
    // GD Image library should be enabled in your php settings
    // in a new php file, execute phpinfo(); and in output find if GD library is enabled
    // Options: 0 or 1 or 2. Default is 0. For alphanumeric text as captcha - 1, simple math equation - 2
    const ENABLE_CUSTOM_CAPTCHA = 0;

    // Options: true or false. Default is false.
    const ENABLE_NOTE = true;

    // To store the submitted information in database as a record.
    // Attachments will be stored on disk.
    // Options: true or false. Default is false.
    const ENABLE_DATABASE = false;

    // To store the submitted information in a CSV file.
    // Options: true or false. Default is false.
    const ENABLE_CSV_DUMP = false;

    const CSV_FILE_NAME = '/var/www/contact-form/iris/contact.csv';

    // When you are using UI level cache, like Varnish
    // you should make the below constant false
    // Options: true or false. Default is true.
    const DISABLE_IRIS_UI_CACHE = false;

    // If the timezone is not defined in your server, then this timezone will be
    // used. Refer https://www.php.net/manual/en/timezones.php for supported timezone values
    const FALLBACK_TIMEZONE = 'Europe/Bucharest';

    // To change the theme look of contact form.
    // Options: dark. Default is empty without any value.
    const IRIS_THEME = 'dark';

    // Language configuration
    // Options: en, de, pl, es, nl, lu. Default is en
    const IRIS_LOCALE = 'en';

    // ----------------- Customize the form UI ENDS ------------------

    // To help with debug and get detailed error trace.
    // IMPORTANT: Make this as false when you go live.
    // Options: true or false. Default is false.
    const IRIS_DEBUG = true;

    const IRIS_VERSION = '3.2.3';
}
