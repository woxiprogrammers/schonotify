/**
 * Created by Nishank Rathod on 2/7/18.
 */

var FormValidator = function(){
    var bonafideFormValidate = function(){
        var form = $("#monthlyAttendanceReport");
        var errorHandler = $('.alert-danger', form);
        var successHandler = $('.alert-success', form);
        form.validate({
            rules: {
                batch:{
                    required: true
                },
                class_select:{
                  required: true
                },
                div_select:{
                    required: true
                },
                month_select:{
                    required: true
                },
                year_select:{
                    required: true
                }
            },
            messages: {
                batch:{
                    required: "Please select Batch."
                },
                class_select : {
                    required : "Please select Class"
                },
                div_select:{
                    required: "Please select Division"
                },
                month_select:{
                    required: "please select month"
                },
                year_select:{
                    required: "please select year"
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
                form.submit();
            }
        });
    }
    return{
        init: function(){
            bonafideFormValidate();
        }
    }
}();


jQuery(document).ready(function()
{
    FormValidator.init();
});