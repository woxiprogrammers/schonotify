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
    return (!($("#checkbox8").is(":checked") && ($.trim(val) == '')));
}, "This field is required if Make as Class Teacher is checked...");


var FormValidation = function(){
    var studentEditValidator = function () {
        var form = $('#formEditStudentAccount');
        var errorHandler = $('.errorHandler', form);
        var successHandler = $('.successHandler', form);
        form.validate({
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
                birth_place: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                lastname: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                nationality: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                DOB: {
                    required:true
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
                },
                grn:{
                    remote: {
                        url: "/check-grn",
                        type: "POST",
                        data: {
                            grn: function() {
                                return $( "#grn" ).val();
                            },
                            userId:function() {
                                return $( "#userId" ).val();
                            }
                        }
                    }
                }

            },
            messages: {
                firstname: {
                    required: "First Name is required" ,
                    alpha: "First name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                birth_place: {
                    required: "Birth Place is required" ,
                    alpha: "Birth Place must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                lastname: {
                    required: "Last Name is required",
                    alpha: "Last name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                nationality: {
                    required: "Nationality is required",
                    alpha: "Nationality must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                mobile:{
                    required:"Mobile number is required",
                    number:"Mobile number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only ",
                    minlength: jQuery.validator.format("Please enter at least 10 digits.")
                },
                DOB:{
                    required:"DOB is required"
                },
                alternate_number:{
                    number:"Alternate number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only",
                    minlength: jQuery.validator.format("Please enter at least 10 digits.")
                },
                email: {
                    chkMail: "Your email address must be in the format of name@domain.com"
                },
                address:{
                    required:"Address is required"
                },
                roll_number:{
                    required:"Roll number is required",
                    number:"Roll number must be numeric"
                },
                grn:{
                    remote: "GRN number must be unique"
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler.hide();
                errorHandler.show();
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
                successHandler.show();
                errorHandler.hide();
            }
        });
    };

    var parentEdit = function () {
        var form1 = $('#formEditAccount');
        var errorHandler = $('.errorHandler', form1);
        var successHandler = $('.successHandler', form1);
        form1.validate({
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
                father_first_name: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                father_occupation: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                mother_first_name: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                mother_occupation: {
                    minlength: 2,
                    required: true,
                    alpha: true
                },
                father_income: {
                    number:true
                },
                mother_income: {
                    number:true
                },
                mobile:{
                    required:true,
                    number:true,
                    minlength:10,
                    mobileNumber:true
                },
                mother_contact:{
                    required:true,
                    number:true,
                    minlength:10,
                    mobileNumber:true
                },
                father_contact:{
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
                permanent_address:{
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
                },
                grn:{
                    remote: {
                        url: "/check-grn",
                        type: "POST",
                        data: {
                            grn: function() {
                                return $( "#grn" ).val();
                            },
                            userId:function() {
                                return $( "#userId" ).val();
                            }
                        }
                    }
                }

            },
            messages: {
                father_first_name: {
                    required: "First Name is required" ,
                    alpha: "First name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                father_occupation: {
                    required: "Father occupation is required",
                    alpha: "Last name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                mother_first_name: {
                    required: "Mother first name is required",
                    alpha: "Last name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                mother_occupation: {
                    required: "Mother occupation is required",
                    alpha: "Last name must contain only letters",
                    minlength:"Please enter at least 2 character"
                },
                father_income:{
                    required:"Father income is required",
                    number:"Father income must be numeric"
                },
                mother_income:{
                    required:"Mother income is required",
                    number:"Mother income must be numeric"
                },
                alternate_number:{
                    number:"Alternate number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only",
                    minlength: jQuery.validator.format("Please enter at least 10 digits.")
                },
                mother_contact:{
                    number:"Mother number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only",
                    minlength: jQuery.validator.format("Please enter at least 10 digits.")
                },
                 father_contact:{
                    number:"Father number must be numeric",
                    mobileNumber : "Mobile number must be 10 digit only",
                    minlength: jQuery.validator.format("Please enter at least 10 digits.")
                },
                email: {
                    chkMail: "Your email address must be in the format of name@domain.com"
                },
                permanent_address: {
                    required: "Address is required"
                },
                address:{
                    required:"Address is required"
                },
                roll_number:{
                    required:"Roll number is required",
                    number:"Roll number must be numeric"
                },
                grn:{
                    remote: "GRN number must be unique"
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler.hide();
                errorHandler.show();
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
            submitHandler: function (form1) {
                successHandler1.show();
                errorHandler1.hide();
            }
        });
    };
    return{
        init: function(){
            studentEditValidator();
            parentEdit();
        }
    };
}();

$(document).ready(function(){
    FormValidation.init();
});

