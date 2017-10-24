var FormValidator = function () {

    "use strict";
    var validateCheckRadio = function (val) {
        $("input[type='radio'], input[type='checkbox']").on('ifChecked', function(event) {
            $(this).parent().closest(".has-error").removeClass("has-error").addClass("has-success").find(".help-block").hide().end().find('.symbol').addClass('ok');
        });
    };
    // function to initiate Validation Sample 1
    var runValidator1 = function () {
        var form1 = $('#form');
        var errorHandler1 = $('.errorHandler', form1);
        var successHandler1 = $('.successHandler', form1);
        $.validator.addMethod("FullDate", function () {
            //if all values are selected
            if ($("#dd").val() != "" && $("#mm").val() != "" && $("#yyyy").val() != "") {
                return true;
            } else {
                return false;
            }
        }, 'Please select a day, month, and year');
        $('#form').validate({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
                    error.insertAfter($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: "",
            rules: {
                firstname: {
                    minlength: 2,
                    required: true
                },
                lastname: {
                    minlength: 2,
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    minlength: 6,
                    required: true
                },
                password_again: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                yyyy: "FullDate",
                gender: {
                    required: true
                },
                zipcode: {
                    required: true,
                    number: true,
                    minlength: 5
                },
                city: {
                    required: true
                },
                newsletter: {
                    required: true
                },
                batch:{
                    required:true
                },

                title: {
                    minlength: 2,
                    required: true
                },

                achievement:{
                    minlength:15,
                    required:true
                }

            },
            messages: {
                firstname: "Please specify your first name",
                lastname: "Please specify your last name",
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                },
                gender: "Please check a gender!",
                batch:"please enter batch name",
                achievement:{
                    minlength:"Please enter more words."
                }
            },
            groups: {
                DateofBirth: "dd mm yyyy"
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler1.hide();
                errorHandler1.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (form) {
                successHandler1.show();
                errorHandler1.hide();
                // submit form
                //$('#form').submit();
            }
        });
    };

    var runValidator2 = function () {
        var form4 = $('#formEditAccount');
        var errorHandler2 = $('.errorHandler', form4);
        var successHandler2 = $('.successHandler', form4);
        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        });
        $.validator.addMethod("mobileNumber", function(value, element) {
            return this.optional(element) || /^[0-9]{10}(\-[0-9]{4})?$/.test(value);
        });
        $.validator.addMethod("chkMail", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
        });
        $.validator.addMethod("requiredIfChecked", function (val, ele, arg) {
            if ($("#checkbox8").is(":checked") && ($.trim(val) == '')) { return false; }
            return true;
        }, "This field is required if Make as Class Teacher is checked...");
        $.validator.addMethod("getEditorValue", function () {
            $("#editor1").val($('#formEditAccount .summernote').code());
            if ($("#editor1").val() != "" && $("#editor1").val().replace(/(<([^>]+)>)/ig, "") != "") {
                $('#editor1').val('');
                return true;
            } else {
                return false;
            }
        }, 'This field is required.');
        form4.validate({
            errorElement: "span", // contain the error msg in a small tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.hasClass("ckeditor")) {
                    error.appendTo($(element).closest('.form-group'));
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: "",
            rules: {
                firstname: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                lastname: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                email: {
                    required: true,
                    chkMail: true
                },
                mobile:{
                    required:true,
                    number:true,
                    minlength:10,
                    mobileNumber:true
                },
                alternate_number:{
                    number:true,
                    minlength:10,
                    mobileNumber:true
                },
                address:{
                    required:true
                },
                access:{
                    required:true,
                    minlength:1
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
                roll_number:{
                    required:true,
                    number:true
                }

            },
            messages: {
                firstname: {
                    required: "First Name is required" ,
                    alpha: "First name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                lastname: {
                    required: "Last Name is required",
                    alpha: "Last name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                mobile:{
                    required:"Mobile number is required",
                    number:"Mobile number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only ",
                    minlength: jQuery.validator.format("Please enter at least 10 digits.")
                },
                alternate_number:{
                    number:"Alternate number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only",
                    minlength: jQuery.validator.format("Please enter at least 10 digits.")
                },
                email: {
                    required: "Please provide valid email id",
                    chkMail: "Your email address must be in the format of name@domain.com"
                },
                address:{
                    required:"Address is required"
                },
                roll_number:{
                    required:"Roll number is required",
                    number:"Roll number must be numeric"
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler2.hide();
                errorHandler2.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
                $('#emailfeedback').remove();
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
                $('#emailIdfeedback').html('<div id="emailfeedback"></div>');
                $('#emailfeedback').show();
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                $('#emailfeedback').remove();
            },
            submitHandler: function (form) {
                successHandler2.show();
                errorHandler2.hide();
                // submit form

                return true;
            }
        });
        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();
    };

    return {
        //main function to initiate template pages
        init: function () {
            runValidator1();
            runValidator2();
        }
    };
}();