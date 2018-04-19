/**
 * Created by Ameya Joshi on 7/4/18.
 */

var FormValidator1 = function(){
    var bonafideFormValidate = function(){
        var form = $("#bonafideCreateForm");
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
                $("#bonafideDiv").html();
                var formData = $("#bonafideCreateForm").serialize();
                $.ajax({
                    url: '/certificates/bonafide/bonafide-student-form',
                    data: formData,
                    type: "POST",
                    async: true,
                    success:function(data,textStatus,xhr){
                        $("#bonafideDiv").html(data);
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
            bonafideFormValidate();
        }
    }
}();

var FormValidator2 = function(){
    var bonafideFormValidate = function(){
        var form = $("#bonafideStudentForm");
        var errorHandler = $('.errorHandler', form);
        var successHandler = $('.successHandler', form);
        form.validate({
            rules: {
                taluka:{
                    required: true
                },
                district:{
                  required:true
                },
                from_date:{
                    required:true
                },
                to_date:{
                    required:true
                }
            },
            messages: {
                taluka:{
                    required: "Taluka is required."
                },
                district:{
                    required: "District is required"
                },
                from_date:{
                    required: "from date is required"
                },
                to_date:{
                    required:"to date is required"
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
                $("#bonafideStudentForm").html();
                var formData = $("#bonafideStudentForm").serialize();
                $.ajax({
                    url: '/certificates/bonafide/get-bonafide-view',
                    data: formData,
                    type: "POST",
                    async: true,
                    success:function(data,textStatus,xhr){
                        location.href="/certificates/bonafide/manage"
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
            bonafideFormValidate();
        }
    }
}();

jQuery(document).ready(function()
{
    FormValidator1.init();
    FormValidator2.init();
})