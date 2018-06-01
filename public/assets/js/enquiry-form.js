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
        $.validator.addMethod("custom_file_size", function(value, element) {
            return this.optional(element) || ($(element)[0].files[0].size <= 200000);
        }, "Please use file less than 200KB");
        //validate file extension custom  method.
        $.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, $.validator.format("Please enter a value with a valid extension."));

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
                first_name: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                last_name: {
                    minlength: 2,
                    alpha: true,
                    required: true,
                },
                middle_name: {
                    minlength: 2,
                    alpha: true,
                    required: true,
                },
                marks_obtained: {
                    required: true,
                    number:true
                },
                category: {
                    required: true,
                },
                email: {
                    required: true,
                    email:true
                },
                outOf_marks: {
                    required: true,
                    number:true
                },
                board: {
                    required: true,
                },
                caste: {
                    required: true,
                },
                date: {
                    required: true,
                },
                examination_year: {
                    required: true,
                },
                mobile_number:{
                    required: true,
                    mobileNumber: true
                },
                address:{
                    minlength:15,
                    required:true,
                    removespace:true
                },
                ssc_certificate: {
                    required: true,
                    extension: "png|jpeg|jpg|bmp",
                    custom_file_size: true

                },
                hsc_certificate: {
                    required: true,
                    extension: "png|jpeg|jpg|bmp",
                    custom_file_size: true

                }
            },
            messages: {
                first_name: {
                    alpha: "only Alphabets are allowed",
                    required: "First name is required",
                    minlength:"Enter minimum 2 characters."
                },
                last_name: {
                  alpha: "only Alphabets are allowed",
                  required: "First name is required",
                  minlength:"Enter minimum 2 characters."
                },
                middle_name: {
                  alpha: "only Alphabets are allowed",
                  required: "First name is required",
                  minlength:"Enter minimum 2 characters."
                },
                marks_obtained:{
                    required: "Marks are required",
                    number:"Only numbers are allowed"
                },
                category: {
                    required: "Category is required"
                },
                email:{
                      required: "Email required",
                      email:"Email is required"
                },
                outOf_marks:{
                      required: "Marks are required",
                      number:"Only numbers are allowed"
                },
                board:{
                    required: "Marks are required"
                },
                caste:{
                    required: "Caste is required"
                },
                date:{
                    required: "Date is required"
                },
                examination_year:{
                    required:"Year is required"
                },
                mobile_number:{
                    mobileNumber: "Only numbers are allowed"
                },
                address:{
                    required:"Address is required",
                    address:"Address must contain at-least 15 characters"
                },
                ssc_certificate: {
                    extension:"Please upload only JPEG,JPG,PNG,BMP files"
                },
                hsc_certificate: {
                    extension:"Please upload only JPEG,JPG,PNG,BMP files"
                },
                caste_certificate: {
                    extension:"Please upload only JPEG,JPG,PNG,BMP files"
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
