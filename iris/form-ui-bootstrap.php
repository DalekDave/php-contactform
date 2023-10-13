<?php

/**
 * This page is supposed to be included inside another layout page.
 * It is included in index.php to showcase how the include
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
<div class="container">
	<form method="POST" class="iris-form mb-5 w-75">
		<h3 class="pt-3 pb-3"><?php  echo $lang->value("page_heading"); ?></h3>
<?php if(Config::FIELD_NAME['0'] == true) { ?>
        <div class="form-row">
			<div class="form-group col-md-4">
				<label>
                                <?php
    echo $lang->value("label_name");
    $required = "";
    if (Config::FIELD_NAME['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
            <span id="name-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span>
				</label> <input type="text" id="pp-name" name="pp-name"
					class="<?php echo $required; ?> form-control"
					onfocusout='return (isEmpty("name-info","pp-name"))'>
			</div>

		</div>
<?php } ?>
<?php if(Config::FIELD_EMAIL['0'] == true) { ?>
<div class="form-row">
			<div class="form-group col-md-4">
				<label>
                <?php
    echo $lang->value("label_email");
    $required = "";
    if (Config::FIELD_EMAIL['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
            <span id="email-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"
					data-validate-message="<?php  echo $lang->value("message_invalid_email"); ?>"></span>
				</label> <input type="text" id="pp-email"
					name="<?php
    if (Config::DISABLE_IRIS_UI_CACHE == true) {
        $emailFieldName = $antiSpam->getEmailFieldName();
    } else {
        $emailFieldName = 'pp-email';
    }
    echo $emailFieldName;
    ?>"
					class="<?php echo $required; ?> form-control"
					onfocusout='return validateEmail();'>

			</div>
		</div>
<?php } ?>
<div class="form-row d-none">
			<div class="form-group col-md-4">
				<label>Leave this empty</label> <input type="text" name="email" />
			</div>
		</div>
<?php if(Config::FIELD_TELEPHONE['0'] == true) { ?>
<div class="form-row">
			<div class="form-group col-md-4">
				<label>
                                <?php
    echo $lang->value("label_telephone");
    $required = "";
    if (Config::FIELD_TELEPHONE['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
                <span id="telephone-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span>
				</label> <input type="text" id="pp-telephone" name="pp-telephone"
					class="<?php echo $required; ?> form-control"
					onfocusout='return (isEmpty("telephone-info","pp-telephone"))'>
			</div>
		</div>
<?php } ?>
<?php if(Config::FIELD_WEBSITE['0'] == true) { ?>
<div class="form-row">
			<div class="form-group col-md-4">
				<label>
                                <?php
    echo $lang->value("label_website");
    $required = "";
    if (Config::FIELD_WEBSITE['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
                <span id="website-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span>
				</label> <input type="text" id="pp-website" name="pp-website"
					class="<?php echo $required; ?> form-control"
					onfocusout='return (isEmpty("website-info","pp-website"))'>
			</div>
		</div>
<?php } ?>
<?php if(Config::FIELD_ADDRESS['0'] == true) { ?>
<div class="form-row">
			<div class="form-group col-md-4">
				<label> <?php
    echo $lang->value("label_address");
    $required = "";
    if (Config::FIELD_ADDRESS['1'] == true) {
        $required = "required";
        echo " *";
    }
    ?>
                <span id="address-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span></label>

				<input type="text" id="pp-address" name="pp-address"
					class="<?php echo $required; ?> form-control"
					onfocusout='return (isEmpty("address-info","pp-address"))'>
			</div>
		</div>
<?php } ?>
            <?php
            if (Config::FIELD_DEPARTMENT['0'] == true) {
                ?>
<div class="form-row">
			<div class="form-group col-md-4">
				<label><?php
                echo $lang->value("label_department");
                $required = "";
                if (Config::FIELD_DEPARTMENT['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?> <span id="department-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span></label>
				<select id="pp-department" name="pp-department"
					class="<?php echo $required; ?> form-control"
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
		</div>
<?php
            }
            if (Config::FIELD_HEAR_ABOUT['0'] == true) {
                ?>
<div class="form-row">
			<div class="form-group w-50">
				<label><?php
                echo $lang->value("label_hear_about");
                $required = "";
                if (Config::FIELD_HEAR_ABOUT['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?> <span id="hear-about-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span></label>
				<div class="row-value">
					<div class="checkboxes">
                <?php
                foreach ($lang->value("hear_about_option") as $hearAbout) {
                    ?>
                        <span class="checkbox"><input type="checkbox"
							value="<?php  echo $hearAbout; ?>" id="pp-hear-about"
							name="pp-hear-about[]"
							class="<?php echo $required; ?> form-control"
							onfocusout='return (isEmpty("hear-about-info","pp-hear-about"))'>
							<span class="checkbox-label"><?php  echo $hearAbout; ?></span></span>

               <?php
                }
                ?>
                  </div>
				</div>
			</div>
		</div>
<?php
            }
            ?>

            <?php
            if (Config::FIELD_PRIORITY['0'] == true) {
                ?>
<div class="form-row">
			<div class="form-group w-50">
				<label><?php
                echo $lang->value("label_priority");
                $required = "";
                if (Config::FIELD_PRIORITY['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?> <span id="priority-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span></label>
				<div class="row-value">
					<div class="checkboxes">
                <?php
                foreach ($lang->value("priority_option") as $priority) {
                    ?>

                        <span class="checkbox"><input type="radio"
							value="<?php  echo $priority; ?>" id="pp-priority"
							name="pp-priority[]"
							class="<?php echo $required; ?> form-control"
							onfocusout='return (isEmpty("priority-info","pp-priority"))'> <span
							class="checkbox-label"><?php  echo $priority; ?></span></span>

               <?php
                }
                ?>
                  </div>
				</div>

			</div>
		</div>
<?php
            }
            if (Config::FIELD_MESSAGE['0'] == true) {
                ?>
<div class="form-row">
			<div class="form-group col-md-4">
				<label>
                <?php
                echo $lang->value("label_message");
                $required = "";
                if (Config::FIELD_MESSAGE['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?>
                <span id="message-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span>
				</label>
				<textarea id="pp-message" rows="5" name="pp-message"
					class="<?php echo $required; ?> form-control"
					onfocusout='return (isEmpty("message-info","pp-message"))'></textarea>
			</div>
		</div>
<?php
            }
            ?>
            <?php
            if (Config::FIELD_ATTACHMENT['0'] == true && Config::ATTACHMENT_FILE_COUNT_LIMIT != 0) {
                ?>
<div class="form-row">
			<div class="form-group col-md-4">
				<label>
			<?php
                echo $lang->value("label_attachment");

                $required = "";
                if (Config::FIELD_ATTACHMENT['1'] == true) {
                    $required = "required";
                    echo " *";
                }
                ?><span id="attachment-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span>
				</label>
				<div class="attachment-row">
					<input type="file" name="attachment[]" id="attachment"
						class="form-control <?php echo $required;?>"
						onchange='return (isEmpty("attachment-info","attachment"))' /><span
						class="delete-attachment"><?php  echo $lang->value("label_attachment_delete"); ?></span>
				</div>
				
		<?php
                if (Config::ATTACHMENT_FILE_COUNT_LIMIT != 1) {
                    ?>
				<div onClick="addMoreAttachment(<?php echo Config::ATTACHMENT_FILE_COUNT_LIMIT; ?>);" class="mt-3">
                <?php  echo $lang->value("label_attachment_addmore"); ?>
            </div>
            <?php
                }
                ?>
			</div>
		</div>
<?php
            }
            if (Config::ENABLE_CAPTCHA == true) {
                $is_curl = in_array('curl', get_loaded_extensions());
                if ($is_curl) {
                    ?>
<div class="g-recaptcha"
			data-sitekey="<?php echo Config::RECAPTCHA_SITE_KEY; ?>"></div>
		<script src="https://www.google.com/recaptcha/api.js"></script>
<?php
                } else {
                    ?>
<div class="form-row">
			<span class="message error"><?php  echo $lang->value("message_curl_validation"); ?></span>
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
                <span id="custom-captcha-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span>
			</div>
			<input type="text" id="pp-custom-captcha" name="pp-custom-captcha"
				class="<?php echo $required; ?> iris-input custom-captcha-input"
				onfocusout='return (isEmpty("custom-captcha-info","pp-custom-captcha"))'>
		</div>
<?php } ?>
<div class="form-row d-none">
			<div class="form-group col-md-4">
				<div class="label">Leave this empty</div>
				<input type="text"
					name="<?php
    $honeyPotFieldName = $antiSpam->getHoneyPotFieldName();
    echo $honeyPotFieldName;
    ?>" />
			</div>
		</div>
<?php
if (Config::ENABLE_COPY_USER == true) {
    ?>
<div class="form-row">
			<div class="form-group col-md-4">
				<div>
                <?php  echo $lang->value("label_emailcopy"); ?>: <input
						type="checkbox" name="pp-copy-user" class="ml-1">
				</div>
			</div>
		</div>
        <?php } ?>
<?php
if (Config::ENABLE_GDPR_CONSENT == true) {
    ?>
        <div class="form-row">
			<div class="form-group col-md-4">
				<label>
                    <?php  echo $lang->value("label_consent"); ?>: * <input
					type="checkbox" name="pp-gdpr-consent" id="pp-gdpr-consent"
					class="required ml-1"
					onfocusout='return (isEmpty("gdpr-consent-info","pp-gdpr-consent"))'>
					<span id="gdpr-consent-info" class="text-danger"
					data-required-message="<?php  echo $lang->value("message_required"); ?>"></span>
				</label>
			</div>
		</div>
        <?php } ?>
        <div class="form-row pt-3">
			<div class="form-group col-md-4">
				<button type="submit" class="btn btn-primary mb-3"
					id="iris-btn-send"><?php  echo $lang->value("send_button"); ?></button>
				<div id="iris-loader-icon"><?php  echo $lang->value("sending_status"); ?></div>
				<div id="iris-loader-ack-icon"><?php  echo $lang->value("sending_ack_status"); ?></div>
				<div id="iris-message" class="alert alert-success"></div>
			</div>
		</div>
<?php
if (Config::ENABLE_NOTE == true) {
    ?>
			<div class="form-row">
			<span class="iris-note col-md-4"><?php  echo $lang->value("label_note"); ?></span>
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
<script src="iris/assets/js/iris.js"></script>
