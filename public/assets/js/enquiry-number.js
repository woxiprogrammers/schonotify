var FormValidator = function () {

    "use strict";
    var validateCheckRadio = function (val) {
        $("input[type='radio'], input[type='checkbox']").on('ifChecked', function(event) {
            $(this).parent().closest(".has-error").removeClass("has-error").addClass("has-success").find(".help-block").hide().end().find('.symbol').addClass('ok');
        });
    };



    var enquiryForm = function () {
        var form1 = $('#checkEnquiry');
        var errorHandler1 = $('.errorHandler', form1);
        var successHandler1 = $('.successHandler', form1);

        $('#checkEnquiry').validate({
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
                enquiry_number:{
                    required: true,
                    /*remote: {
                        type: "POST",
                        url: "/check-enquiry"
                    },*/
                    remote: {
                        url: "/check-enquiry",
                        type: "POST",
                        data: {
                            enquiry_number: function() {
                                return $( "#enquiry_number" ).val();
                            },
                            bodySlug:function() {
                                return $( "#bodySlug" ).val();
                            }
                        }
                    }
                }
            },
            messages: {
                enquiry_number:{
                    remote : "Your enquiry is not yet approved by school officials. Please contact administration for details."
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
                successHandler1.show();
                errorHandler1.hide();
                // submit form

                form.submit();
            }
        });
    };

    return {

        init: function () {
            enquiryForm();
        }
    };
}();