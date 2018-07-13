var FormValidator1 = function(){
    var livingCretificateFormValidate = function(){
        var form = $("#livingCretificateCreate");
        var errorHandler = $('.errorHandler', form);
        var successHandler = $('.successHandler', form);
        form.validate({
            rules: {
                grn:{
                    required: true
                }
            },
            messages: {
                grn:{
                    required: "GRN is required."
                }
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler.hide();
                errorHandler.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (form) {
                successHandler.show();
                errorHandler.hide();
                $("#livingDiv").html();
                var formData = $("#livingCretificateCreate").serialize();
                $.ajax({
                    url: '/certificates/livingCertificate/livingCertificate-student-form',
                    data: formData,
                    type: "POST",
                    async: true,
                    success:function(data,textStatus,xhr){
                        $("#livingDiv").html(data);
                    },
                    error: function(xhr,errorStatus){
                        if(xhr.status == 400){
                            alert(xhr.responseText);
                        }
                    }
                });
            }
        });
    }
    return{
        init: function(){
            livingCretificateFormValidate();
        }
    }
}();

var FormValidator2 = function(){
    var livingCretificateFormValidate = function(){
        var form = $("#livingCertificateStudentForm");
        var errorHandler = $('.errorHandler', form);
        var successHandler = $('.successHandler', form);
        form.validate({
            rules: {
                panCard:{
                    required: true
                },
                lastSchool:{
                    required: true
                },
                admissionDate:{
                    required: true
                },
                progress:{
                    required: true
                },
                conduct:{
                    required: true
                },
                livingSchoolDate:{
                    required: true
                },
                standard_studying_from_when:{
                    required: true
                },
                reason:{
                    required: true
                },
                remark:{
                    required: true
                }
            },
            messages: {
                panCard:{
                    required: "Pan Card is required."
                },
                lastSchool:{
                    required: "last School Name is required"
                },
                admissionDate:{
                    required: "Admission Date is required"
                },
                progress:{
                    required: "progress is required"
                },
                conduct:{
                    required: "conduct is required"
                },
                livingSchoolDate:{
                    required: "mention the date"
                },
                standard_studying_from_when:{
                    required: "required"
                },
                reason:{
                    required: "reason is required"
                },
                remark:{
                    required: "remark is required"
                }

            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler.hide();
                errorHandler.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (form) {
                successHandler.show();
                errorHandler.hide();
                var formData = $("#livingCertificateStudentForm").serialize();
                $.ajax({
                    url: '/certificates/livingCertificate/livingCertificate-student-form-create',
                    data: formData,
                    type: "POST",
                    async: true,
                    success:function(data,textStatus,xhr){
                        location.href="/certificates/livingCertificate/manage"
                    },
                    error: function(xhr,errorStatus){
                        if(xhr.status == 400){
                            alert(xhr.responseText);
                        }
                    }
                });
            }
        });
    }
    return{
        init: function(){
            livingCretificateFormValidate();
        }
    }
}();

var FormValidator3 = function(){
    var livingCretificateFormValidate = function(){
        var form = $("#livingCertificateEdit");
        var errorHandler = $('.errorHandler', form);
        var successHandler = $('.successHandler', form);
        form.validate({
            rules: {
                panCard:{
                    required: true
                },
                lastSchool:{
                    required: true
                },
                admissionDate:{
                    required: true
                },
                progress:{
                    required: true
                },
                conduct:{
                    required: true
                },
                livingSchoolDate:{
                    required: true
                },
                standard_studying_from_when:{
                    required: true
                },
                reason:{
                    required: true
                },
                remark:{
                    required: true
                }
            },
            messages: {
                panCard:{
                    required: "Pan Card is required."
                },
                lastSchool:{
                    required: "last School Name is required"
                },
                admissionDate:{
                    required: "Admission Date is required"
                },
                progress:{
                    required: "progress is required"
                },
                conduct:{
                    required: "conduct is required"
                },
                livingSchoolDate:{
                    required: "mention the date"
                },
                standard_studying_from_when:{
                    required: "required"
                },
                reason:{
                    required: "reason is required"
                },
                remark:{
                    required: "remark is required"
                }

            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                successHandler.hide();
                errorHandler.show();
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            },
            submitHandler: function (livingCertificateEdit) {
                successHandler.show();
                errorHandler.hide();
                livingCertificateEdit.submit();
            }
        });
    }
    return{
        init: function(){
            livingCretificateFormValidate();
        }
    }
}();
jQuery(document).ready(function()
{
    FormValidator1.init();
    FormValidator2.init();
    FormValidator3.init();
})