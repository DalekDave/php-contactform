<?php
// French language localization (L10n) file
$LANG['page_heading'] = "Formulaire de contact";

// UI labels and text
$LANG['label_name'] = "Votre nom";
$LANG['label_email'] = "Adresse e-mail";
$LANG['label_telephone'] = "Numéro de téléphone";
$LANG['label_website'] = "Lien Web";
$LANG['label_address'] = "Adresse postale";
$LANG['label_department'] = "Service à contacter";
$LANG['label_hear_about'] = "Moyen d\'avoir trouvé ce site";
$LANG['label_priority'] = 'Niveau de priorité de ce message';
$LANG['label_message'] = "Votre message";
$LANG['label_attachment'] = "Pièce(s) jointe(s)";
$LANG['label_attachment_delete'] = "Enlever pièce jointe";
$LANG['label_attachment_addmore'] = "Cliquez ici pour ajouter une autre pièce jointe";
$LANG['label_emailcopy'] = "Envoyez-moi également une copie de ce message";
$LANG['label_captcha'] = "Captcha pour prouver que vous êtes humain";
$LANG['label_consent'] = "J\'accepte que mes données soient traitées (dans le respect des règles du RGPD).";
$LANG['send_button'] = "Envoyer message";
$LANG['sending_status'] = "Envoi en cours ...";
$LANG['sending_ack_status'] = "Envoi en cours d\'une copie à votre adresse e-mail ...";
$LANG['email_subject'] = 'Message depuis le formulaire de contact : exemplaire recipient';
$LANG['ack_email_subject'] = 'Message depuis le formulaire de contact : exemplaire expediteur';
$LANG['acknowledgement_message'] = "Merci, votre message a bien été reçu. Si vous attendez une réponse, vous devriez la recevoir bientôt.";
$LANG['message_thank_you'] = "Merci, votre message a bien été envoyé. Si vous attendez une réponse, vous devriez la recevoir bientôt";
$LANG['label_note'] = "Les informations que vous soumettez seront traitées conformément au Règlement Général sur la Protection des Données (RGPD) de l\'Union européenne, et ne seront utilisées que dans le but que vous avez prévu à l\'origine. Votre adresse e-mail ne sera pas mise à la disposition d'autres personnes et ne sera pas utilisée pour vous envoyer des messages commerciaux non sollicités.</br>2) Types de fichiers acceptés pour téléchargement : .png .jpg .jpeg .bmp .gif .avi .mp4 .wmv .mp3 .flv .mkv .pdf .doc .docx .odt .rtf .xls .csv .dif .ods .xlsx .xps .odp .ppt .pptx .xps .txt .log .md .svg .xml .html .htm .zip .tar .tar.gz .gz .rar";

// Dropdown menu options - these accompany the above field label_department
$LANG['department_option_default'] = "Choisissez un service";
$LANG['department_option'] = array(
    "Service de facturation",
    "Service marketing",
    "Service assistance client",
    "Autre service"
);
// Checkbox options - these accompany the above label label_hear_about
$LANG['hear_about_option'] = array(
    "Moteur de recherche",
    "Médias sociaux",
    "Autre"
);
// Radio button options - these accompany the above label label_priority
$LANG['priority_option'] = array(
    'Priorité normale',
    'Priorité élevée',
    'Urgence extrême'
);
// UI validation messages
$LANG['message_required'] = "Renseignement obligatoire";
$LANG['message_invalid_email'] = "Adresse e-mail invalide";
$LANG['captcha_validation'] = "Désolé, la validation Captcha est obligatoire";
$LANG['captcha_validation_failure'] = 'Désolé, vous n\'avez pas réussi la validation Captcha. Veuillez réessayer';
$LANG['gdpr_consent_validation'] = "Veuillez donner votre autorisation pour que vos données soient traitées (pour la conformité au RGPD)";
$LANG['attachment_size_validation'] = "Désolé, la taille totale de la ou des pièce(s) jointe(s) dépasse la limite autorisée (50 Mo)";
$LANG['attachment_type_validation'] = "Désolé, un ou plusieurs de vos pièces jointes sont d\'un type non accepté";

// Error messages for attenion of developer/maintainer
$LANG['message_curl_validation'] = "Erreur 1001. Pour utiliser Google reCaptcha, vous devez activer l\'extension Curl dans vos paramètres PHP";
$LANG['csrf_validation'] = "Erreur 1002. Atteinte de sécurité. Attaque CSRF détectée";
$LANG['ajax_request_validation'] = "Erreur 1003. Anomalie dans une requête Ajax";
$LANG['brute_force_attack_validation'] = "Erreur 1004. Atteinte de sécurité. Attaque par force brute détectée";
$LANG['bot_spam_validation'] = "Erreur 1005. Problème de sécurité. Spam bot détecté";
$LANG['message_debug_smtp'] = "Définissez SMTP_DEBUG=2 dans Config pour obtenir plus d\'informations sur la transmission du courrier";
$LANG['message_smtp_conf_issue'] = "Erreur 1006. Problème de configuration SMTP";
$LANG['message_add_more_alert'] = "Téléchargez un fichier à la fois (vous pouvez en ajouter d'autres par la suite, si vous le souhaitez). Envisagez d\'inclure multiples fichiers dans une archive comprimée";
