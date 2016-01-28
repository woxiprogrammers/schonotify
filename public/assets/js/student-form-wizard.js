var FormWizard = function () {

    "use strict";
    var wizardContent = $('#wizard');
    var wizardForm = $('#student-registration-form');
    var numberOfSteps = $('.swMain > ul > li').length;
    var initWizard = function () {
        // function to initiate Wizard Form
        wizardContent.smartWizard({
            selected: 0,
            keyNavigation: false,
            onLeaveStep: leaveAStepCallback,
            onShowStep: onShowStep,
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
        if ($("#checkbox8").is(":checked") && ($.trim(val) == '')) { return false; }
        return true;
    }, "This field is required if Make as Class Teacher is checked...");
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
    });
    $.validator.addMethod("chkMail", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
    });
    var initValidator = function () {

        $.validator.setDefaults({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
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
                email: {
                    chkMail: true
                },
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
                    required:true
                },
                modules: {
                    required: true,
                    minlength: 2
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
                    required:true
                },
                class:{
                    required:true
                },
                division:{
                    required:true
                },
                parent_name:{
                    required:true,
                    remote:{
                        url:"/check-parent",
                        type:"POST",
                        data:{
                            parentID:function() {
                                return $( "#parent_id" ).val();
                            }
                        }
                    }
                },
                userName:{
                    minlength: 2,
                    required: true,
                    alphanumeric: true
                }

            },
            messages: {
                firstName: {
                    required: "First Name is required" ,
                    alpha: "First name must contain only letters"
                },
                lastName: {
                    required: "Last Name is required",
                    alpha: "Last name must contain only letters"
                },
                studid:"please provide correct student id",
                email: {
                    chkMail: "Your email address must be in the format of name@domain.com"
                },
                address:{
                    required:"Address is required",
                    address:"Address must contain at-least 15 characters"
                },
                modules: {
                    minlength: jQuery.validator.format("Please select  at least {0} types of Service")
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
                    mobileNumber : "Mobile number must be 10 digit only "
                },
                'batch':{
                    required:"Please Select Batch"
                },
                'class':{
                    required:"Please Select Class"
                },
                'division':{
                    required:"Please Select Division"
                },
                'userName':{
                    required:"User name is required",
                    alphanumeric: "User name must contain only letters"
                },
                parent_name:{
                    required:"Parent name is required",
                    remote:"Please Select proper parent"
                }
            },

            highlight: function (element) {
                $('#feedback').remove();
                $('#emailfeedback').remove();

                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group

            },
            unhighlight: function (element) { // revert the change done by hightlight
                $('#userNameFeedback').html('<div id="feedback"></div>');
                $('#emailIdfeedback').html('<div id="emailfeedback"></div>');
                $('#feedback').show();
                $('#emailfeedback').show();
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group

            },
            success: function (label, element) {
                $('#feedback').remove();
                $('#emailfeedback').remove();
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');

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


                onFinish(obj, context);


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


            $('.anchor').children("li").last().children("a").removeClass('wait').removeClass('selected').addClass('done').children('.stepNumber').addClass('animated tada');
            var form=$('#student-registration-form').serialize();
            $.ajax({
                url:'save-user',
                data: form,
                processData: false,

                type: 'POST',

                success: function(data){
                    $('#error-div').html('');

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
        if(wizardForm.valid()){
            return true;
        }else{
            return false;
        }
    };
    return {
        init: function () {
            initWizard();
        }
    };
}();