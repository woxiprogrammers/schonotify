var FormValidator = function () {
    "use strict";
    var validateCheckRadio = function (val) {
        $("input[type='radio'], input[type='checkbox']").on('ifChecked', function(event) {
            $(this).parent().closest(".has-error").removeClass("has-error").addClass("has-success").find(".help-block").hide().end().find('.symbol').addClass('ok');
        });
    };

// Validations For Gallery Management
    var runValidator1 = function () {
        var form3 = $('#galleryCreateImageForm');
        var errorHandler3 = $('.errorHandler', form3);
        var successHandler3 = $('.successHandler', form3);

        $.validator.addMethod("FullDate", function () {
            //if all values are selected
            if ($("#dd").val() != "" && $("#mm").val() != "" && $("#yyyy").val() != "") {
                return true;
            } else {
                return false;
            }
        }, 'Please select a day, month, and year');
        $('#galleryCreateImageForm').validate({
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
                gallery_images :{
                    upload_max_filesize :'1MB'
                },
                video :{
                    upload_max_filesize :'1MB'
                }
            },
            messages: {
                gallery_images:{
                    upload_max_filesize : "please select less than 1MB"
                },
                video:{
                    upload_max_filesize :"please select less than 1MB"
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler3.hide();
                errorHandler3.show();
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
            submitHandler: function (galleryCreateImageForm) {
                successHandler3.show();
                errorHandler3.hide();
                galleryCreateImageForm.submit();
                // submit form
            }
        });
    };
    // validation for folder create
    var runValidator2 = function () {
        var form2 = $('#galleryFolderCreateForm');
        var errorHandler2 = $('.errorHandler', form2);
        var successHandler2 = $('.successHandler', form2);

        $.validator.addMethod("FullDate", function () {
            //if all values are selected
            if ($("#dd").val() != "" && $("#mm").val() != "" && $("#yyyy").val() != "") {
                return true;
            } else {
                return false;
            }
        }, 'Please select a day, month, and year');
        $('#galleryFolderCreateForm').validate({
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
                folder_name :{
                    required: true,
                    remote: {
                        url: "/gallery/check-name",
                        type: "POST",
                        async: true,
                        data: {
                            folder_name: function() {
                                return $( "#name" ).val();
                            }
                        }
                    }
                }
            },
            messages: {
                folder_name:{
                    required:"please enter the folder name",
                    remote:" Folder already exists"
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
            submitHandler: function (galleryFolderCreateForm) {
                successHandler2.show();
                errorHandler2.hide();
                galleryFolderCreateForm.submit();
                // submit form
            }
        });
    };
    return {
        init: function () {
            validateCheckRadio();
            runValidator1();
            runValidator2();
        }
    };
}();