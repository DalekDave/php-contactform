<?php
// English language localization (L10n) file
$LANG['page_heading'] = "Contact form";

// UI labels and text
$LANG['label_name'] = "Your name";
$LANG['label_email'] = "Email address";
$LANG['label_telephone'] = "Telephone number";
$LANG['label_website'] = "Web link";
$LANG['label_address'] = "Postal address";
$LANG['label_department'] = "Department to contact";
$LANG['label_hear_about'] = "How you found this site";
$LANG['label_priority'] = 'Priority of message';
$LANG['label_message'] = "Your message";
$LANG['label_attachment'] = "Attachment(s)";
$LANG['label_attachment_delete'] = "Remove attachment";
$LANG['label_attachment_addmore'] = "Click here to add an attachment";
$LANG['label_emailcopy'] = "Email a copy of this message to me as well";
$LANG['label_captcha'] = "Captcha to prove you\'re human";
$LANG['label_consent'] = "I agree to have my data processed (in compliance with GDPR rules)";
$LANG['send_button'] = "Send message";
$LANG['sending_status'] = "Sending your message...";
$LANG['sending_ack_status'] = "Sending you a copy to your email address...";
$LANG['email_subject'] = 'Contact form message: recipient\'s copy';
$LANG['ack_email_subject'] = 'Contact form message: sender\'s copy';
$LANG['acknowledgement_message'] = "Thank you, your message has been received. If you are expecting a response, you should receive an answer soon.";
$LANG['message_thank_you'] = "Thank you, your message has been sent. If you are expecting a response, you should receive an answer soon";
$LANG['label_note'] = '<p><strong>Privacy info:</strong>The information you submit will will be processed in compliance with the European Union\'s General Data Privacy Regulation (GDPR), and will only be used for your original intended purpose. Your email address will not be made available to anyone else, and will not be used for sending you unsolicited commercial messages.</p>';
$LANG['label_filetypes'] = '<p><strong>Accepted file types for upload:</strong> .png .jpg .jpeg .bmp .gif .avi .mp4 .wmv .mp3 .flv .mkv .pdf .doc .docx .odt .rtf .xls .csv .dif .ods .xlsx .xps .odp .ppt .pptx .xps .txt .log .md .svg .xml .html .htm .zip .tar .tar.gz .gz .rar</p>';

// Dropdown menu options - these accompany the above label label_department
$LANG['department_option_default'] = "Choose a department";
$LANG['department_option'] = array(
    "Billing Department",
    "Marketing Department",
    "Customer Support Department",
    "Other Department"
);
// Checkbox options - these accompany the above label label_hear_about
$LANG['hear_about_option'] = array(
    "Search engine",
    "Social media",
    "Other source"
);
// Radio button options - these accompany the above label label_priority
$LANG['priority_option'] = array(
    'Normal priority',
    'High priority',
    'Extremely urgent'
);
// UI validation messages
$LANG['message_required'] = "Required information";
$LANG['message_invalid_email'] = "Invalid email address";
$LANG['captcha_validation'] = "Sorry, the Captcha validation is mandatory";
$LANG['captcha_validation_failure'] = 'Sorry, you failed the Captcha validation. Please try again';
$LANG['gdpr_consent_validation'] = "Please give your authorisation to have your data processed (for GDPR compliance)";
$LANG['attachment_size_validation'] = "Sorry, the total size of your file attachment(s) exceeds the allowed limit (50 MB)";
$LANG['attachment_type_validation'] = "Sorry, one or more of your file attachments is of an unaccepted type";

// Error messages for attention of developer/maintainer
$LANG['message_curl_validation'] = "Error 1001. To use Google reCaptcha, you need to enable the Curl extension in your PHP settings";
$LANG['csrf_validation'] = "Error 1002. Security issue. CSRF attack detected";
$LANG['ajax_request_validation'] = "Error 1003. Ajax request error";
$LANG['brute_force_attack_validation'] = "Error 1004. Security issue. Brute force attack detected";
$LANG['bot_spam_validation'] = "Error 1005. Security Issue. Bot spam detected";
$LANG['message_debug_smtp'] = "Set SMTP_DEBUG=2 in Config to get more information about mail transmission";
$LANG['message_smtp_conf_issue'] = "Error 1006. SMTP configuration problem";
$LANG['message_add_more_alert'] = "Upload one file at a time (you can add others afterwards, if you want). Consider including multiple files in a compressed archive";
