var FormValidator = function () {

    "use strict";
    var validateCheckRadio = function (val) {
        $("input[type='radio'], input[type='checkbox']").on('ifChecked', function(event) {
            $(this).parent().closest(".has-error").removeClass("has-error").addClass("has-success").find(".help-block").hide().end().find('.symbol').addClass('ok');
        });
    };



    var enquiryForm = function () {
        var form1 = $('#studentEnquiry');
        var errorHandler1 = $('.errorHandler', form1);
        var successHandler1 = $('.successHandler', form1);
        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || /^[A-z]+$/.test(value);
        });
        $.validator.addMethod("mobileNumber", function(value, element) {
            return this.optional(element) || /^[0-9]{10}(\-[0-9]{4})?$/.test(value);
        });
        $.validator.addMethod("alpha_num_space_sym", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+([ A-Za-z0-9-@./#',&%:()/\\+])*$/.test(value);
        }, "only alpha num & space are allowed and starting with space and special char not allowed");
        $.validator.addMethod("alpha_num", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+$/.test(value);
        }, "only alpha num characters are allowed");
        $.validator.addMethod("alpha_num_space", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9]+([ A-Za-z0-9])*$/.test(value);
        }, "only alpha num space characters are allowed , starting with space not allowed");

        $.validator.addMethod("greaterThan", function (value, element, param) {
            var $otherElement = $(param);
            if ($otherElement != '') { // <- the other field not empty?
                return parseInt(value, 10) > parseInt($otherElement.val(), 10);
            };
            return true; // <- other field was empty, no error message
        });
        $.validator.addMethod("chkMail", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i.test(value);
        });
        jQuery.validator.addMethod("removespace", function(value, element) {
            if (value.trim().length >=15)
            {
                return true;
            }else{
                return false;
            }
        }, "Address must contain at-least 15 characters");
        $('#studentEnquiry').validate({
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
                guardian_first_name: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                guardian_last_name: {
                    minlength: 2,
                    alpha: true
                },
                guardian_middle_name: {
                    minlength: 2,
                    alpha: true
                },
                student_first_name:{
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                student_last_name: {
                    minlength: 2,
                    alpha: true
                },
                student_middle_name: {
                    minlength: 2,
                    alpha: true
                },
                current_class:{
                    alpha_num: true

                },
                school_name:{
                    required: function(element){
                        return $("#current_class").val()!="";
                    },
                    alpha_num_space: true
                },
                admission_to_class:{
                    required: true,
                    alpha_num: true
                },
                mobile_number:{
                    required: true,
                    mobileNumber: true
                },
                alt_contact_no:{
                    mobileNumber: true
                },
                address:{
                    minlength:15,
                    required:true,
                    removespace:true
                },
                email: {
                    chkMail: true
                }
            },
            messages: {
                guardian_first_name: {
                    alpha: "only Alphabets are allowed"
                },
                guardian_last_name: {
                    alpha: "only Alphabets are allowed"
                },
                guardian_middle_name: {
                    alpha: "only Alphabets are allowed"
                },
                student_first_name:{
                    alpha: "only Alphabets are allowed"
                },
                student_last_name: {
                    alpha: "only Alphabets are allowed"
                },
                student_middle_name: {
                    alpha: "only Alphabets are allowed"
                },
                current_class:{
                    alpha_num: "only Alpha and numbers are allowed "

                },
                school_name:{
                    alpha_num: "only Alpha and numbers are allowed "
                },
                admission_to_class:{
                    alpha_num: "only Alpha and numbers are allowed "
                },
                mobile_number:{
                    mobileNumber: "Only numbers are allowed"
                },
                alt_contact_no:{
                    mobileNumber: "Only numbers are allowed"
                },
                address:{
                    required:"Address is required",
                    address:"Address must contain at-least 15 characters"
                },email: {
                    chkMail: "Your email address must be in the format of name@domain.com"
                }
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
                $('#btn_submit').attr('disabled',true);
                successHandler1.show();
                errorHandler1.hide();
                // submit form

                form.submit();
                $("#step-2ss").show();
            }
        });
    };

    return {

        init: function () {
            enquiryForm();
        }
    };
}();