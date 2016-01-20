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

            }
        });
    };
    // function to initiate Validation Sample 2
    var runValidator2 = function () {
        var form2 = $('#form2');
        var errorHandler2 = $('.errorHandler', form2);
        var successHandler2 = $('.successHandler', form2);
        $.validator.addMethod("getEditorValue", function () {
            $("#editor1").val($('#form2 .summernote').code());
            if ($("#editor1").val() != "" && $("#editor1").val().replace(/(<([^>]+)>)/ig, "") != "") {
                $('#editor1').val('');
                return true;
            } else {
                return false;
            }
        }, 'This field is required.');
        form2.validate({
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
                firstname2: {
                    minlength: 2,
                    required: true
                },
                lastname2: {
                    minlength: 2,
                    required: true
                },
                email2: {
                    required: true,
                    email: true
                },
                occupation: {
                    required: true
                },
                dropdown: {
                    required: true
                },
                classDropdown:{
                    required:true
                },
                division:{
                    required:true
                },
                services: {
                    required: true,
                    minlength: 2
                },
                creditcard: {
                    required: true,
                    creditcard: true
                },
                url: {
                    required: true,
                    url: true
                },
                zipcode2: {
                    required: true,
                    number: true,
                    minlength: 5
                },
                city2: {
                    required: true
                },
                editor1: "getEditorValue",
                editor2: {
                    required: true
                },
                class: {
                    minlength: 2,
                    required: true,
                    remote: {
                        url: "/check-class",
                        type: "GET",
                        data: {
                            batch_id: function() {
                                return $( "#dropdown" ).val();
                            },
                            classname:function() {
                                return $( "#class" ).val();
                            }
                        }
                    }
                },
                periods:{
                    required:true,
                    number: true,
                    maxlength: 2,
                    min:1,
                    max:15

                },
                title: {
                    minlength: 2,
                    required: true
                },
                announcement:{
                    minlength:15,
                    required:true
                },
                userrole:{
                    required: true,
                    minlength: 1
                }

            },
            messages: {
                firstname: "Please specify your first name",
                lastname: "Please specify your last name",
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address must be in the format of name@domain.com"
                },
                services: {
                    minlength: jQuery.validator.format("Please select  at least {0} types of Service")
                },
                periods:{
                    maxlength: "You can not enter more than 2 digits",
                    max: "Your number of period should not be exceed than 15"
                },
                announcement:{
                    minlength:"Please enter more words."
                },
                userrole: {
                    minlength: jQuery.validator.format("Please select  at least {0} user role"),
                    required: "Please select at least one User Role"
                },
                class:{

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
                successHandler2.show();
                errorHandler2.hide();
                // submit form
                return true;
            }
        });
        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();
    };
    var runValidatorclassCreate = function () {
        var form2 = $('#classCreateForm');
        var errorHandler2 = $('.errorHandler', form2);
        var successHandler2 = $('.successHandler', form2);
        $.validator.addMethod("getEditorValue", function () {
            $("#editor1").val($('#classCreateForm .summernote').code());
            if ($("#editor1").val() != "" && $("#editor1").val().replace(/(<([^>]+)>)/ig, "") != "") {
                $('#editor1').val('');
                return true;
            } else {
                return false;
            }
        }, 'This field is required.');
        form2.validate({
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
                class: {
                    minlength: 2,
                    required: true,
                    remote: {
                        url: "/check-class",
                        type: "GET",
                        data: {
                            batch_id: function() {
                                return $( "#dropdown" ).val();
                            },
                            classname:function() {
                                return $( "#class" ).val();
                            }
                        }
                    }
                }

            },
            messages: {
                class:{
                    required:"Class name is required",
                    minlength:"Please enter at least 2 character",
                    remote:"Class name already in use !!"
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
                successHandler2.show();
                errorHandler2.hide();
                // submit form
                return true;
            }
        });
        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();
    };
    var runValidator3 = function () {
        var form3 = $('#form3');
        var errorHandler2 = $('.errorHandler', form3);
        var successHandler2 = $('.successHandler', form3);
        $.validator.addMethod("getEditorValue", function () {
            $("#editor1").val($('#form3 .summernote').code());
            if ($("#editor1").val() != "" && $("#editor1").val().replace(/(<([^>]+)>)/ig, "") != "") {
                $('#editor1').val('');
                return true;
            } else {
                return false;
            }
        }, 'This field is required.');
        form3.validate({
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
                password: {
                    minlength: 6,
                    required: true
                },
                password_again: {
                    required: true,
                    minlength: 6,
                    equalTo: "#password"
                }

            },
            messages: {
                password: {
                    minlength: jQuery.validator.format("Please enter  at least {0} character")
                },
                password_again: {
                    equalTo: "Password does not match"
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
                successHandler2.show();
                errorHandler2.hide();
                // submit form
               // $('#form3').submit();
                return true;
            }
        });
        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();
    };
   var runValidator4 = function () {
        var form4 = $('#form4');
        var errorHandler2 = $('.errorHandler', form4);
        var successHandler2 = $('.successHandler', form4);
       $.validator.addMethod("alpha", function(value, element) {
           return this.optional(element) || /^[A-z]+$/.test(value);
       });
       $.validator.addMethod("mobileNumber", function(value, element) {
           return this.optional(element) || /^[0-9]{10}(\-[0-9]{4})?$/.test(value);
       });
        $.validator.addMethod("getEditorValue", function () {
            $("#editor1").val($('#form4 .summernote').code());
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
                    email: true
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
                successHandler2.show();
                errorHandler2.hide();
                // submit form

                //$('#form4').submit();
                return true;
            }
        });

        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();

    };

    var runValidator5 = function () {
        var form5 = $('#compose-message-admin');
        var errorHandler5 = $('.errorHandler', form5);
        var successHandler5 = $('.successHandler', form5);
        form5.validate({
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
                description: {
                    required: true,
                    minlength:2
                },
                user_id: {
                    required: true
                }

            },
            messages: {

                description:{
                    required:"Meassage is required",
                    minlength:"Meassage must be at least 2 characters "
                },
                user_id:{
                    required:"Please Select Admin"
                }

            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler5.hide();
                errorHandler5.show();
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
                successHandler5.show();
                errorHandler5.hide();
                return true;
            }
        });

        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();

    };

    var runValidator6 = function () {
        var form6 = $('#compose-message-teacher');
        var errorHandler6 = $('.errorHandler', form6);
        var successHandler6 = $('.successHandler', form6);
        form6.validate({
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
                description: {
                    required: true,
                    minlength:2
                },
                user_id: {
                    required: true
                }

            },
            messages: {

                description:{
                    required:"Meassage is required",
                    minlength:"Meassage must be at least 2 characters "
                },
                user_id:{
                    required:"Please Select teacher"
                }

            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler6.hide();
                errorHandler6.show();
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
                successHandler6.show();
                errorHandler6.hide();
                // submit form

                return true;
            }
        });

        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();

    };

    var runValidator7 = function () {
        var form7 = $('#compose-message-student');
        var errorHandler7 = $('.errorHandler', form7);
        var successHandler7 = $('.successHandler', form7);
        form7.validate({
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
                description: {
                    required: true,
                    minlength:2
                },
                user_id: {
                    required: true
                },
                batch: {
                    required: true
                },
                class: {
                    required: true
                },
                division: {
                    required: true
                }

            },
            messages: {

                description:{
                    required:"Meassage is required",
                    minlength:"Meassage must be at least 2 characters "
                },
                user_id:{
                    required:"Please Select student"
                },
                batch:{
                    required:"Please Select Batch"
                },
                class:{
                    required:"Please Select Class"
                },
                division:{
                    required:"Please Select Division"
                }

            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler7.hide();
                errorHandler7.show();
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
                successHandler7.show();
                errorHandler7.hide();
                // submit form

                return true;
            }
        });

        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();

    };
    var runValidator24 = function () {
        var form24 = $('#form24');
        var errorHandler2 = $('.errorHandler', form24);
        var successHandler2 = $('.successHandler', form24);
        $.validator.addMethod("getEditorValue", function () {
            $("#editor1").val($('#form24 .summernote').code());
            if ($("#editor1").val() != "" && $("#editor1").val().replace(/(<([^>]+)>)/ig, "") != "") {
                $('#editor1').val('');
                return true;
            } else {
                return false;
            }
        }, 'This field is required.');
        form24.validate({
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
                subjectsDropdown: {
                    required: true
                },
                homeworkType: {
                    required: true
                },
                dueDate: {
                    required: true
                },
                title: {
                    minlength: 2,
                    required: true
                },
                description:{
                    minlength:15,
                    required:true
                },
                batch:{
                    required:true
                },
                pdfFile:{
                    maxlength:25000000
                     },
                classDropdown:{
                    required:true
                },
                studentinfo:{
                    required:true
                },
                divisions:{
                    required:true
                }
            },
            messages: {
                subjectsDropdown: "Please select subject",
                homeworkType: "Please select homework type",
                batch: "Please select batch",
                classDropdown: "Please select class",
                divisions: "Please select at least one division",
                studentinfo: "Please select at least one student",
                pdfFile:{
                    maxlength: "select only pdf files of size 25 mb"},
                dueDate: "please select due date ",
                title:{
                    minlength:"please enter at least 2 characters",
                    required:"please fill title date"
                      },
                description:{
                    minlength:"Please enter more words."
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
                successHandler2.show();
                errorHandler2.hide();
                // submit form

                return true;
            }
        });
        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();
    };

    var runValidatorBatch = function () {
        var form7 = $('#batch-create');
        var errorHandler7 = $('.errorHandler', form7);
        var successHandler7 = $('.successHandler', form7);
        form7.validate({
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
                batchesDefault:{
                    required:true,
                    minlength:2
                }
            },
            messages: {

                batchesDefault:{
                    required:"Please enter batch name",
                    minlength:"Please provide more words"
                }

            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler7.hide();
                errorHandler7.show();
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
                successHandler7.show();
                errorHandler7.hide();
                // submit form

                var i = $('input[name="batches"]').size();

                var batchVal=$('#batchesDefault').val();

                var route="create-batch/"+batchVal;

                $.get(route,function(res){

                    if(res!=0)
                    {
                        var batchDelId="_batch_"+i;

                        $('<div class="form-group col-sm-8 div'+res+'" id="divTxt"><input type="text" class="field form-control" id="_batch_'+i+'" value="'+batchVal+'" name="batches" readonly/></div><div class="col-sm-2 del'+res+'" id="del"><button type="button" class="btn btn-primary btn-red pull-left hideDelete" id="removeBatch" onclick="deleteBatch('+res+')"><i class="glyphicon glyphicon-trash"></i></button></div>').fadeIn('slow').appendTo('#batchDiv');

                        i++;

                        if(i<4)
                        {
                            $('#checkHeight').removeClass('flexcroll1');
                        }else{

                            $('#checkHeight').addClass('flexcroll1');
                        }

                        $('#batchesDefault').val("");

                        var route="get-batches";
                        $.get(route,function(res){
                            var str="<option>Select Batch</option>";
                            for(var i=0; i<res.length; i++)
                            {
                                str+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>"
                            }
                            $('#dropdown').html(str);
                        });

                    }else{
                        successHandler7.hide();
                        errorHandler7.show();

                        $('#batchesDefault').closest('.help-block').removeClass('valid');
                        // display OK icon
                        $('#batchesDefault').closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                        // add the Bootstrap error class to the control group
                        $('#batchesDefault-error').html('Batch Name is already in use !');

                    }

                });


            }
        });

        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();

    };
    var runValidatorDivision = function () {
        var form7 = $('#div-create');
        var errorHandler7 = $('.errorHandler', form7);
        var successHandler7 = $('.successHandler', form7);
        form7.validate({
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
                dropdown: {
                    required: true
                },
                classDropdown:{
                    required:true
                },
                division:{
                    required:true
                }
            },
            messages: {


            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler7.hide();
                errorHandler7.show();
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
                successHandler7.show();
                errorHandler7.hide();
                // submit form


                return true;

            }
        });

        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();

    };
    var runValidatorSubject = function () {
        var form7 = $('#createSubject');
        var errorHandler7 = $('.errorHandler', form7);
        var successHandler7 = $('.successHandler', form7);
        form7.validate({
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
                subject_name: {
                    required: true,
                    minlength:2
                },
                'class[]':{
                    required:true,
                    minlength:1
                }
            },
            messages: {
                subject_name:{
                    required:"Please enter subject title."
                },
                'class[]':{
                    required:"Please select atleast one class",
                    minlength:"Please select atleast one class"
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler7.hide();
                errorHandler7.show();
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
                successHandler7.show();
                errorHandler7.hide();
                // submit form

               return true;
            }
        });

        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();

    };
    var runValidatorSubjectTeacher = function () {
        var form7 = $('#subjectTeacher');
        var errorHandler7 = $('.errorHandler', form7);
        var successHandler7 = $('.successHandler', form7);
        form7.validate({
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
                subjectDropdown: {
                    required:true
                },
                batchDropdown:{
                    required:true
                },
                classDropdown:{
                    required:true
                },
                divisionDropdown:{
                    required:true
                },
                teacherDropdown:{
                    required:true
                }
            },
            messages: {
                subjectDropdown:{
                    required:"Please select subject !."
                },
                batchDropdown:{
                    required:"Please select batch !."
                },
                classDropdown:{
                    required:"Please select class !"
                },
                divisionDropdown:{
                    required:"Please select division !"
                },
                teacherDropdown:{
                    required:"Please select teacher !"
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler7.hide();
                errorHandler7.show();
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
                successHandler7.show();
                errorHandler7.hide();
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
        	validateCheckRadio();
            runValidator1();
            runValidator2();
            runValidator3();
            runValidator4();
            runValidator5();
            runValidator6();
            runValidator7();
            runValidator24();
            runValidatorBatch();
            runValidatorDivision();
            runValidatorSubject();
            runValidatorclassCreate();
            runValidatorSubjectTeacher();
        }
    };
}();