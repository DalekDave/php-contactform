/**
 * Used in form UI validation. If a field is empty, then highlight that specific
 * field with border in red and show a message as required else if the field is
 * not empty then highlight with green border.
 * 
 * @param {object}
 *            messageElement The element where the message should be shown
 * @param {object}
 *            field The input field that is to be validated
 * @return {boolean} true if value present or false if empty
 */
function isEmpty(messageElement, field) {
	valid = true;
	console.log("Message Element: ", messageElement);
    console.log("Field: ", field);
	if ($("#" + field + ".required").length <= 0) {
		return true;
	}
	$("#" + messageElement).html(" ");
	$("#" + field).css("border-color", "#2ecc71");
	var fname = $("#" + field).val();

	if ($("#" + field).attr("type") == "checkbox") {

		if ($("#" + field + ":checked").length <= 0) {
			var message = $("#" + messageElement).data("required-message");
			console.log("Message to be displayed: ", message);
			$("#" + messageElement).html(message);
			$("#" + field).css("border-color", "#E46B66");
			valid = false;
		}
	} else if ($("#" + field).attr("type") == "radio") {
		if ($("#" + field + ":checked").length <= 0) {
			var message = $("#" + messageElement).data("required-message");
			$("#" + messageElement).html(message);
			$("#" + field).css("border-color", "#E46B66");
			valid = false;
		}
	} else {
		if (fname.trim() == "") {
			var message = $("#" + messageElement).data("required-message");
			$("#" + messageElement).html(message);
			$("#" + field).css("border-color", "#E46B66");
			valid = false;
		}
	}
	console.log("Final message in " + messageElement + ": ", $("#" + messageElement).html());
	return valid;
}

/**
 * Validates if the input value is in email format. If false, shows a red border
 * around the input field with an error message.
 * 
 * @param {object}
 *            messageElement The element where the message should be shown
 * @param {object}
 *            field The input field that is to be validated
 * @return {boolean} true if in email format else false
 */
function isValidEmailFormat(messageElement, field) {

	valid = true;
	var emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var email = $("#" + field).val();

	if ($("#" + field + ".required").length <= 0 && email == "") {
		return true;
	}
	$("#" + messageElement).html(" ");
	$("#" + field).css("border-color", "#2ecc71");
	var trimEmail = email.trim();
	if (!emailRegex.test(trimEmail)) {
		var message = $("#" + messageElement).data("validate-message");
		$("#" + messageElement).html(message);
		$("#" + field).css("border-color", "#E46B66");
		valid = false;
	}
	return valid;
}
/**
 * Facade function to validate the email field, checks for both empty and valid
 * format.
 * 
 * @returns {boolean} true on pass else fail.
 */
function validateEmail() {
	var valid = true;
	valid = (isEmpty("email-info", "pp-email"))
		&& (isValidEmailFormat("email-info", "pp-email"));
	return valid;
}

/**
 * validates the complete form fields. this is the entry function called when
 * AJAX submit is done. If you want to add more field/validation, this is the
 * place to do.
 * 
 * @returns {boolean} true on pass else fail.
 */
function validate() {
	var valid = true;
	var nameValid = true;
	var emailValid = true;
	var telephoneValid = true;
	var websiteValid = true;
	var addressValid = true;
	var departmentValid = true;
	var hearAboutValid = true;
	var priorityValid = true;
	var subjectValid = true;
	var messageValid = true;
	var customCaptchaValid = true;
	var gdprConsentValid = true;
	var attachmentValid = true;

	$("input").removeClass("error-field");
	$("textarea").removeClass("error-field");
	$("select").removeClass("error-field");

	nameValid = isEmpty("name-info", "pp-name");
	if (nameValid == false) {
		$("#pp-name").addClass("error-field");
	}

	emailValid = validateEmail();
	if (emailValid == false) {
		$("#pp-email").addClass("error-field");
	}

	telephoneValid = isEmpty("telephone-info", "pp-telephone");
	if (telephoneValid == false) {
		$("#pp-telephone").addClass("error-field");
	}

	websiteValid = isEmpty("website-info", "pp-website");
	if (websiteValid == false) {
		$("#pp-website").addClass("error-field");
	}

	addressValid = isEmpty("address-info", "pp-address");
	if (addressValid == false) {
		$("#pp-address").addClass("error-field");
	}

	subjectValid = isEmpty("subject-info", "pp-subject");
	if (subjectValid == false) {
		$("#pp-subject").addClass("error-field");
	}

	messageValid = isEmpty("message-info", "pp-message");
	if (messageValid == false) {
		$("#pp-message").addClass("error-field");
	}
	customCaptchaValid = isEmpty("custom-captcha-info", "pp-custom-captcha");
	if (customCaptchaValid == false) {
		$("#pp-custom-captcha").addClass("error-field");
	}
	departmentValid = isEmpty("department-info", "pp-department");
	if (departmentValid == false) {
		$("#pp-department").addClass("error-field");
	}
	hearAboutValid = isEmpty("hear-about-info", "pp-hear-about");
	if (hearAboutValid == false) {
		$("#pp-hear-about").addClass("error-field");
	}
	priorityValid = isEmpty("priority-info", "pp-priority");
	if (priorityValid == false) {
		$("#pp-priority").addClass("error-field");
	}
	gdprConsentValid = isEmpty("gdpr-consent-info", "pp-gdpr-consent");
	if (gdprConsentValid == false) {
		$("#pp-gdpr-consent").addClass("error-field");
	}
	attachmentValid = isEmpty("attachment-info", "attachment");
	if (attachmentValid == false) {
		$("#attachment").addClass("error-field");
	}

	if (nameValid == false || emailValid == false || telephoneValid == false
		|| websiteValid == false || addressValid == false
		|| subjectValid == false || priorityValid == false
		|| departmentValid == false || hearAboutValid == false
		|| messageValid == false || customCaptchaValid == false
		|| gdprConsentValid == false || attachmentValid == false) {
		valid = false;
		$(".error-field").first().focus();
	}
	return valid;
}

/**
 * AJAX entry point for contact form submission.
 * 
 */
$(document).ready(function(e) {
	$("#pp-gdpr-consent").on("click", function() {
	console.log("GDPR checkbox clicked.");
	});
	console.log("Document is ready, script is loaded.");
	$(".iris-form").on('submit', (function(e) {
		e.preventDefault();

		var form = new FormData(this);
		var enableAcknowledgement = $("#acknowledgement").val();

		var valid = validate();
		if (valid == true) {
			$("#iris-message").hide();
			$('#iris-btn-send').hide();
			$('#iris-loader-icon').css("display", "inline-block");
			$.ajax({
				url: "iris/form-message-action.php",
				type: "POST",
				dataType: 'json',
				data: form,
				contentType: false,
				cache: false,
				processData: false,

				success: function(response) {
					$('#iris-btn-send').hide();
					$('#iris-loader-icon').hide();
					if (response.type == "message") {
						if (enableAcknowledgement == 1) {
							$('#iris-loader-ack-icon').show();
							acknowledgement(form);
						} else {
							$("#iris-message").attr("class", "success");
							$("#iris-message").css("display", "inline-block");
						}
					} else if (response.type == "error") {
						$('#iris-btn-send').show();
						$("#iris-message").attr("class", "error");
						$("#iris-message").css("display", "inline-block");
					} else {
						$('#iris-btn-send').show();
						$("#iris-message").attr("class", "error");
						$("#iris-message").css("display", "inline-block");
					}
					$("#iris-message").html(response.text);
					if (response.type == "message") {
						var redirect_url = $('#redirect_url').val();
						if (redirect_url) {
							let timeOutFn = setTimeout(function() {
								window.location.href = redirect_url;
								window.clearTimeout(timeOutFn);
							}, 3000); // redirect after 3 seconds delay
						}
						$('input').val('');
						$('select[name="pp-department"]').val('');
						$('textarea[name="pp-message"]').val('');
					}
				},

				error: function(jqXHR, errorThrown) {
					var message = jqXHR.responseText;
					$("#iris-message").css("display", "inline-block");
					$('#iris-loader-icon').hide();
					$('#iris-btn-send').show();
					$("#iris-message").attr("class", "error");
					$("#iris-message").html(message);
				}
			});
		}
	}));

	$("body").on("click", ".delete-attachment", function() {
		$(this).parent().remove();
	});
});

/**
 * AJAX entry point for sending acknowledgement message.
 */
function acknowledgement(form) {

	$.ajax({
		url: "iris/form-acknowledgement-action.php",
		type: "POST",
		data: form,
		contentType: false,
		cache: false,
		processData: false,
		success: function(response) {
			var json = JSON.parse(response);

			$('#iris-loader-ack-icon').hide();
			$("#iris-message").css("display", "inline-block");

			if (json.type == "message") {
				$("#iris-message").attr("class", "alert alert-success");
			}
			if (json.type == "error") {
				$('#iris-btn-send').show();
				$("#iris-message").attr("class", "alert alert-danger");

			}
			$("#iris-message").html(json.text);
		},

		error: function(jqXHR, errorThrown) {
			var message = jqXHR.responseText;
			$("#iris-message").css("display", "inline-block");
			$('#iris-loader-icon').hide();
			$('#iris-btn-send').show();
			$("#iris-message").attr("class", "error");
			$("#iris-message").html(message);
		}
	});
}

/**
 * used in attachment field UI
 */
function addMoreAttachment(attachmentFileCountLimit) {
  var deleteLabel = $('.icon-add-more-attachment').data('delete-label');
  if (attachmentFileCountLimit == -1 || $(".attachment-row").length < attachmentFileCountLimit) {
    var isAddMore = true;
    if ($(".attachment-row").length > 0 && $(".attachment-row:last input").val() == "") {
      isAddMore = false;
    }

    $("#add-more-alert").hide();
    if (isAddMore) {
      var deleteLink = '<span class="delete-attachment" style="display: inline-block;">' + deleteLabel + '</span>';
      var attachmentRow = '<div class="attachment-row"><input type="file" name="attachment[]" id="attachment" class="iris-input" onchange="return (isEmpty(\'attachment-info\',\'attachment\'))" />' + deleteLink + '</div>';

      $(attachmentRow).insertBefore(".icon-add-more-attachment");
      $(".attachment-row:last").find("input").val("");
      $(".attachment-row:last").find("input").css("border-color", "#9a9a9a");
      $(".attachment-row:last").find(".delete-attachment").show();
    } else {
      $("#add-more-alert").show();
    }
  }
}
$('#attachment').on('click touchstart', function() {
	$(this).val('');
});
$("body").bind('change', '#attachment', function(e) {
	var deleteLabel = $('.icon-add-more-attachment').data('delete-label');
	$(e.target).next().html(deleteLabel);
});
