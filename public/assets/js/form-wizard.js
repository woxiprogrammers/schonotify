var FormWizard = function () {

	"use strict";
    var wizardContent = $('#wizard');
    var wizardForm = $('#registrationForm');
    var numberOfSteps = $('.swMain > ul > li').length;
    var initWizard = function () {
        // function to initiate Wizard Form
        wizardContent.smartWizard({
            selected: 0,
            keyNavigation: false,
            onLeaveStep: leaveAStepCallback,
            onShowStep: onShowStep
        });
        var numberOfSteps = 0;
        initValidator();

    };

    $.validator.addMethod("alpha", function(value, element) {
        return this.optional(element) || /^[A-z]+$/.test(value);
    });
    $.validator.addMethod("mobileNumber", function(value, element) {
        return this.optional(element) || /^[0-9]{10}(\-[0-9]{4})?$/.test(value);
    });

    $.validator.addMethod("requiredIfChecked", function (val, ele, arg) {
        if ($("#checkbox9").is(":checked") && ($.trim(val) == '')) { return false; }
        return true;
    }, "This field is required if Make as Class Teacher is checked...");

    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    });
    $.validator.addMethod("chkMail", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
    });
    $.validator.addMethod("allowAccess", function(value, elem, param) {
        if ($("#checkbox6").is(":checked") || $("#checkbox7").is(":checked")) { return true; }
        return false;
    },"You must select at least one!");
    jQuery.validator.addMethod("removespace", function(value, element) {
        	if (value.trim().length >=15)
        {
            return true;
        }else{
            return false;
        }
    }, "Address must contain at-least 15 characters");
    var initValidator = function () {

        $.validator.setDefaults({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
                    error.insertAfter($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: ':hidden',
            rules: {
                firstName: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                lastName: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                userName:{
                    minlength: 2,
                    required: true,
                    alphanumeric: true
                },
                 /*email: {
                    required: true,
                     chkMail: true
                },*/
                password: {
                    minlength: 6,
                    required: true
                },
                password2: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                },
                studid:{
                    minlength: 1,
                    required: true
                },
                address:{
                    minlength:15,
                    required: true,
                    removespace:true
                },
                modules: {
                    required: true,
                    minlength:2
                },
                mobile:{
                    required:true,
                    number:true,
                    minlength:10,
                    mobileNumber:true
                },
                alt_number:{
                    number:true,
                    minlength:10,
                    mobileNumber:true
                },
                batch:{
                    requiredIfChecked:true
                },
                class:{
                    requiredIfChecked:true
                },
                division:{
                    requiredIfChecked:true
                },
                'access[]':{
                    required:true,
                    minlength:1
                }
            },
            messages: {
                firstName: {
                    required: "First Name is required" ,
                    alpha: "First name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                lastName: {
                     required: "Last Name is required",
                     alpha: "Last name must contain only letters",
                     minlength:"Please enter at least 2 character"
                },
                userName: {
                    required: "User Name is required",
                    alphanumeric: "User name must contain only letters"
                },
                studid:"please provide correct student id",
               /* email: {
                    required: "Please provide valid email id",
                    chkMail: "Your email address must be in the format of name@domain.com"
                },*/
                address:{
                     required:"Please provide address",
                     address:"Address must contain at-least 15 characters"
                },

                password:{
                    required:"Password is required",
                    minlength: jQuery.validator.format("Password must contain at least {0} characters")
                },
                password2:{
                    required:"Password is required",
                    minlength: jQuery.validator.format("Password must contain at least {0} characters")
                },
                mobile:{
                    required:"Mobile number is required",
                    number:"Mobile number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only "
                },
                alt_number:{
                    number:"Alternate number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only"
                },
                'access[]':{
                    required:"Please select al least one",
                    minlength: jQuery.validator.format("Please select  at least {0} types of Access")
                }
            },

            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
                $('#feedback').remove();
                $('#emailfeedback').remove();


            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                $('#userNameFeedback').html('<div id="feedback"></div>');
                $('#emailIdfeedback').html('<div id="emailfeedback"></div>');
                $('#feedback').show();
                $('#emailfeedback').show();
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $('#feedback').remove();
                $('#emailfeedback').remove();
            }
        });
    };
    var displayConfirm = function () {
        $('.display-value', form).each(function () {
            var input = $('[name="' + $(this).attr("data-display") + '"]', form);
            if (input.attr("type") == "text" || input.attr("type") == "email" || input.is("textarea")) {
                $(this).html(input.val());
            } else if (input.is("select")) {
                $(this).html(input.find('option:selected').text());
            } else if (input.is(":radio") || input.is(":checkbox")) {

                $(this).html(input.filter(":checked").closest('label').text());
            } else if ($(this).attr("data-display") == 'card_expiry') {
                $(this).html($('[name="card_expiry_mm"]', form).val() + '/' + $('[name="card_expiry_yyyy"]', form).val());
            }
        });
    };
    var onShowStep = function (obj, context) {
    	if(context.toStep == numberOfSteps){
    		$('.anchor').children("li:nth-child(" + context.toStep + ")").children("a").removeClass('wait');
            displayConfirm();

    	}
        $(".next-step").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goForward");

        });
        $(".back-step").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goBackward");
        });
        $(".go-first").unbind("click").click(function (e) {
            e.preventDefault();
            wizardContent.smartWizard("goToStep", 1);
        });
        $(".finish-step").unbind("click").click(function (e) {
            e.preventDefault();

            onFinish(obj, context);
        });
    };
    var leaveAStepCallback = function (obj, context) {
        return validateSteps(context.fromStep, context.toStep);
        // return false to stay on step and true to continue navigation
    };
    var onFinish = function (obj, context) {

        if (validateAllSteps()) {
            $('div#loadmoreajaxloader').show();
            $('.anchor').children("li").last().children("a").removeClass('wait').removeClass('selected').addClass('done').children('.stepNumber').addClass('animated tada');
            var form=$('#registrationForm').serialize();
            $.ajax({
                url:'save-user',
                data: form,
                processData: false,
                type: 'POST',

                success: function(data){
                    $('#error-div').html('');
                    $('div#loadmoreajaxloader').hide();
                    wizardContent.smartWizard("goForward");
                    $('.stepNumber').click(false);
                },
                error:function(data){
                    var errors = $.parseJSON(data.responseText);

                    var errorsHtml = '<div class="alert alert-danger"><ul>';

                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></di>';

                    $('#error-div').html(errorsHtml);
                    $('div#loadmoreajaxloader').hide();
                    wizardContent.smartWizard("goToStep", 2);
                }
            });

        }
    };
    var validateSteps = function (stepnumber, nextstep) {

        var isStepValid = false;

        if (numberOfSteps >= nextstep && nextstep > stepnumber) {

            // cache the form element selector
            if (wizardForm.valid()) { // validate the form

            wizardForm.validate().focusInvalid();
                for (var i=stepnumber; i<=nextstep; i++){
        		$('.anchor').children("li:nth-child(" + i + ")").not("li:nth-child(" + nextstep + ")").children("a").removeClass('wait').addClass('done').children('.stepNumber').addClass('animated tada');
        		}
                //focus the invalid fields
                isStepValid = true;
                return true;
            };
        } else if (nextstep < stepnumber) {
        	for (i=nextstep; i<=stepnumber; i++){
        		$('.anchor').children("li:nth-child(" + i + ")").children("a").addClass('wait').children('.stepNumber').removeClass('animated tada');
        	}
            
            return true;
        } 
    };
    var validateAllSteps = function () {
        return true;

    };
    return {
        init: function () {
            initWizard();
        }
    };
}();