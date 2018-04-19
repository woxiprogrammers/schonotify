/**
 * Created by Ameya Joshi on 7/4/18.
 */

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


jQuery(document).ready(function()
{
    FormValidator1.init();
})