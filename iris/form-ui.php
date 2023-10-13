<?php

/*
 * This page is supposed to be included inside another layout page.
 * It can be included in index.php to showcase how the include
 * should be done.
 */
use Iris\AntiCSRF;
use Iris\AntiSpam;
use Iris\Language;
use Iris\Config;

require_once __DIR__ . '/lib/AntiSpam.php';
$antiSpam = new AntiSpam();
require_once __DIR__ . '/lib/Language.php';

require_once __DIR__ . '/Config.php';

$lang = new Language(Config::IRIS_LOCALE);

?>

<header class="header-container">
<div class="header-block">

<div class="site-logo-container">
<span class="site-logo-img"><a href="https://blog.collaboration.cafe/" class="logo-link" rel="home">
<img width="96" height="96" src="https://blog.collaboration.cafe/wp-content/uploads/2022/07/logo-round.svg" class="site-logo" alt=""></a>
</span>
</div>

<div class="site-title-container">
<h1 class="site-title">
<a href="https://collaboration.cafe/" rel="home">Collaboration Café</a>
</h1>
<p class="site-description">Contact Form</p>
</div>

<div class="header-menu-container">
<nav class="site-navigation">
<ul class="blogmenu">

<li class="menu-item"><a href="https://collaboration.cafe/" class="menu-link">Home</a></li>

<li class="menu-item"><a href="https://blog.collaboration.cafe/about/" class="menu-link">About</a></li>

<li class="menu-item"><a href="https://blog.collaboration.cafe/legal/" class="menu-link">Legal</a></li>

<li class="menu-item"><a href="https://blog.collaboration.cafe/privacy/" class="menu-link">Privacy</a></li>

<li class="menu-item"><a href="https://blog.collaboration.cafe/credits/" class="menu-link">Credits</a></li>

<li class="menu-item"><a href="https://blog.collaboration.cafe/imprint/" class="menu-link">Imprint</a></li>

</ul>
</nav>
</div>

</div>
</header>

<div class="colcontainer">

<div class="iriscolumn">
	<h1><?php  echo $lang->value("page_heading"); ?></h1>
	<form class="iris-form" method="POST">

<?php if(Config::FIELD_NAME['0'] == true) { ?>
        <div class="iris-row">
			<div class="label">
                <?php
                echo $lang->value("label_name");
                $required = "";
                if (Config::FIELD_NAME['1'] == true) {
                $required = "required";
                echo " *";
                }
?>

                <div id="name-info" class="validation-message" data-required-message="<?php  echo $lang->value("message_required"); ?>">
                </div>
            </div>

            <input type="text" id="pp-name" name="pp-name"
				class="<?php echo $required; ?> iris-input"
				onfocusout='return (isEmpty("name-info","pp-name"))'>
		</div>
<?php } ?>

<?php if(Config::FIELD_EMAIL['0'] == true) { ?>
        <div class="iris-row">
			<div class="label">
                <?php
    echo $lang->value("label_email");
    $required = "";
    if (Config::FIELD_EMAIL['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
                <div id="email-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"
					data-validate-message="<?php  echo $lang->value("message_invalid_email"); ?>"></div>
			</div>
			<input type="text" id="pp-email"
				name="<?php
    if (Config::DISABLE_IRIS_UI_CACHE == true) {
        $emailFieldName = $antiSpam->getEmailFieldName();
    } else {
        $emailFieldName = 'pp-email';
    }
    echo $emailFieldName;
    ?>"
				class="<?php echo $required; ?> email iris-input"
				onfocusout='return validateEmail();'>
		</div>
<?php } ?>
        <div class="iris-row display-none">
			<div class="label">Leave this empty</div>
			<input type="text" name="email" />
		</div>
<?php if(Config::FIELD_TELEPHONE['0'] == true) { ?>
        <div class="iris-row">
			<div class="label">
                                <?php
    echo $lang->value("label_telephone");
    $required = "";
    if (Config::FIELD_TELEPHONE['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
                <div id="telephone-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<input type="text" id="pp-telephone" name="pp-telephone"
				class="<?php echo $required; ?> iris-input"
				onfocusout='return (isEmpty("telephone-info","pp-telephone"))'>
		</div>
<?php } ?>
<?php if(Config::FIELD_WEBSITE['0'] == true) { ?>
        <div class="iris-row">
			<div class="label">
                                <?php
    echo $lang->value("label_website");
    $required = "";
    if (Config::FIELD_WEBSITE['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
                <div id="website-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<input type="text" id="pp-website" name="pp-website"
				class="<?php echo $required; ?> iris-input"
				onfocusout='return (isEmpty("website-info","pp-website"))'>
		</div>
<?php } ?>
<?php if(Config::FIELD_ADDRESS['0'] == true) { ?>
        <div class="iris-row">
			<div class="label">
                                <?php
    echo $lang->value("label_address");
    $required = "";
    if (Config::FIELD_ADDRESS['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
                <div id="address-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<input type="text" id="pp-address" name="pp-address"
				class="<?php echo $required; ?> iris-input"
				onfocusout='return (isEmpty("address-info","pp-address"))'>
		</div>
<?php } ?>
            <?php
            if (Config::FIELD_DEPARTMENT['0'] == true) {
                ?>
        <div class="iris-row">
			<div class="label"><?php

                echo $lang->value("label_department");

                $required = "";
                if (Config::FIELD_DEPARTMENT['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?> <div id="department-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<select id="pp-department" name="pp-department"
				class="<?php echo $required; ?> iris-select"
				onfocusout='return (isEmpty("department-info","pp-department"))'><option
					value=""><?php echo $lang->value("department_option_default"); ?></option>
                <?php
                foreach ($lang->value("department_option") as $department) {
                    ?>
                <option value="<?php  echo $department; ?>"><?php  echo $department; ?></option>
               <?php
                }
                ?>
            </select>
		</div>
                <?php
            }
            ?>
             <?php
            if (Config::FIELD_HEAR_ABOUT['0'] == true) {
                ?>
        <div class="iris-row">
			<div class="label"><?php

                echo $lang->value("label_hear_about");

                $required = "";
                if (Config::FIELD_HEAR_ABOUT['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?> <div id="hear-about-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<div class="row-value">
				<div class="checkboxes">
                <?php
                foreach ($lang->value("hear_about_option") as $hearAbout) {
                    ?>
                        <span class="checkbox"><input type="checkbox"
						value="<?php  echo $hearAbout; ?>" id="pp-hear-about"
						name="pp-hear-about[]"
						class="<?php echo $required; ?> iris-select"
						onfocusout='return (isEmpty("hear-about-info","pp-hear-about"))'>
						<span class="checkbox-label"><?php  echo $hearAbout; ?></span></span>

               <?php
                }
                ?>
                  </div>
			</div>
		</div>
                <?php
            }
            ?>

            <?php
            if (Config::FIELD_PRIORITY['0'] == true) {
                ?>
        <div class="iris-row">
			<div class="label"><?php

                echo $lang->value("label_priority");

                $required = "";
                if (Config::FIELD_PRIORITY['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?> <div id="priority-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<div class="row-value">
				<div class="checkboxes">
                <?php
                foreach ($lang->value("priority_option") as $priority) {
                    ?>

                        <span class="checkbox"><input type="radio"
						value="<?php  echo $priority; ?>" id="pp-priority"
						name="pp-priority[]" class="<?php echo $required; ?> iris-select"
						onfocusout='return (isEmpty("priority-info","pp-priority"))'> <span
						class="checkbox-label"><?php  echo $priority; ?></span></span>

               <?php
                }
                ?>
                  </div>
			</div>

		</div>
                <?php
            }
            ?>

            <?php
            if (Config::FIELD_MESSAGE['0'] == true) {
                ?>
        <div class="iris-row">
			<div class="label">
                <?php
                echo $lang->value("label_message");

                $required = "";
                if (Config::FIELD_MESSAGE['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?>
                <div id="message-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<textarea id="pp-message" rows="5" name="pp-message"
				class="<?php echo $required; ?> iris-textarea"
				onfocusout='return (isEmpty("message-info","pp-message"))'></textarea>
		</div>
        <?php
            }
            ?>
            <?php
            if (Config::FIELD_ATTACHMENT['0'] == true && Config::ATTACHMENT_FILE_COUNT_LIMIT != 0) {
                ?>
            <div class="iris-row">
			<div class="label">
			<?php
                echo $lang->value("label_attachment");

                $required = "";
                if (Config::FIELD_ATTACHMENT['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?><div id="attachment-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<div class="attachment-row">
				<input type="file" name="attachment[]" id="attachment"
					class="iris-input <?php echo $required;?>"
					onchange='return (isEmpty("attachment-info","attachment"))' /><span
					class="delete-attachment"><?php  echo $lang->value("label_attachment_delete"); ?></span>
			</div>
		</div>
		<?php
                if (Config::ATTACHMENT_FILE_COUNT_LIMIT != 1) {
                    ?>
		<div onClick="addMoreAttachment(<?php echo Config::ATTACHMENT_FILE_COUNT_LIMIT; ?>);" class="icon-add-more-attachment">
                <?php  echo $lang->value("label_attachment_addmore"); ?>
            </div>
            <?php
                }
                ?>
                <?php
            }
            ?>
                    <?php
                    if (Config::ENABLE_CAPTCHA == true) {
                        $is_curl = in_array('curl', get_loaded_extensions());
                        if ($is_curl) {
                            ?>
		<div class="g-recaptcha full-width"
			data-sitekey="<?php echo Config::RECAPTCHA_SITE_KEY; ?>"></div>
		<script src="https://www.google.com/recaptcha/api.js"></script>
		<?php
                        } else {
                            ?>
		<div class="iris-row">
			<div class="inline-block message error"><?php  echo $lang->value("message_curl_validation"); ?></div>
		</div>
		<?php
                        }
                    }
                    ?>
<?php if(Config::ENABLE_CUSTOM_CAPTCHA > 0) { ?>
        <div class="iris-row">
			<div class="label">
                                <?php
    echo $lang->value("label_captcha");
    $required = "required";
    echo " *";
    ?>
                <div id="custom-captcha-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
			<input type="text" id="pp-custom-captcha" name="pp-custom-captcha"
				class="<?php echo $required; ?> iris-input custom-captcha-input"
				onfocusout='return (isEmpty("custom-captcha-info","pp-custom-captcha"))'>
		</div>
<?php } ?>

            <div class="iris-row display-none">
			<div class="label">Leave this empty</div>
			<input type="text"
				name="<?php
    $honeyPotFieldName = $antiSpam->getHoneyPotFieldName();
    echo $honeyPotFieldName;
    ?>" />
		</div>
<?php
if (Config::ENABLE_COPY_USER == true) {
    ?>
        <div class="iris-row">
			<div class="label">
            <input
					type="checkbox" name="pp-copy-user" class="iris-input">
					<?php  echo $lang->value("label_emailcopy"); ?>
			</div>
		</div>
        <?php } ?>
<?php
if (Config::ENABLE_GDPR_CONSENT == true) {
    ?>
        <div class="iris-row">
			<div class="label inline-block">
                    <input
					type="checkbox" name="pp-gdpr-consent" id="pp-gdpr-consent"
					class="required iris-input"
					onfocusout='return (isEmpty("gdpr-consent-info","pp-gdpr-consent"))'>

                    <?php  echo $lang->value("label_consent"); ?> * 				<div id="gdpr-consent-info" class="validation-message"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></div>
			</div>
		</div>
        <?php } ?>
        <div class="iris-row">
			<button type="Submit" id="iris-btn-send"><?php  echo $lang->value("send_button"); ?></button>
			<div id="iris-loader-icon"><?php  echo $lang->value("sending_status"); ?></div>
			<div id="iris-loader-ack-icon"><?php  echo $lang->value("sending_ack_status"); ?></div>
			<div id="iris-message"></div>
		</div>
<?php
if (Config::ENABLE_NOTE == true) {
    ?>
			<div class="iris-row">
			<span class="iris-note"><?php  echo $lang->value("label_note"); ?></span>
		</div>
			<?php }?>
            <?php
            require_once __DIR__ . '/lib/AntiCSRF.php';
            $antiCSRF = new AntiCSRF();
            $antiCSRF->insertHiddenToken();
            ?>
    <input type="hidden" name="form_token"
			value="<?php
$csrfHoneyPot = $antiSpam->getCSRFHoneyPot();
echo $csrfHoneyPot;
?>" /> <input type="hidden" name="redirect_url"
			value="<?php echo Config::REDIRECT_URL; ?>" id='redirect_url' /> <input
			type="hidden" name="acknowledgement"
			value="<?php echo Config::ENABLE_ACKNOWLEDGEMENT; ?>"
			id='acknowledgement' />

	</form>
</div>


<div class="infocolumn">
    <h2>Other sites</h2>
    <p>Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem Ipsum lorem</p>

 </div>

</div class="colcontainer">

<script src="iris/assets/js/iris.js"></script>
