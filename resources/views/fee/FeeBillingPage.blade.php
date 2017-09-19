@extends('master')

@section('content')

<div id="app">
    <div class="sidebar app-aside" id="sidebar" style="top: 0px!important;">
        <img style="margin-left: 20%;" class="img-responsive" src="/assets/images/bodyLogo/sspss.jpg">
    </div>
    <div class="app-content">

        <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div class="wrap-content container" id="container">
                @include('alerts.errors')
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">{{$schoolTitle}}</h1> <br>
                            <h1 class="mainTitle">Payment</h1>
                            <span class="mainDescription">Fee</span>
                        </div>
                    </div>
                </section>
                {{--<fieldset>--}}
                    {{--<legend> Enter Details</legend>--}}
                    {{--<form id="getStudentDetialsForm" role="form">--}}
                        {{--<div class="col-md-4">--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="control-label">--}}
                                    {{--School: <span class="symbol required"></span>--}}
                                {{--</label>--}}
                                {{--<select name="school" class="form-control">--}}
                                    {{--@foreach($bodies as $body)--}}
                                        {{--<option value="{{$body['id']}}"> {{$body['name']}} </option>--}}
                                    {{--@endforeach--}}
                                {{--</select>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-4">--}}
                            {{--<div class="form-group" >--}}
                                {{--<label class="control-label">--}}
                                    {{--GRN <span class="symbol required"></span>--}}
                                {{--</label>--}}
                                {{--<input name="grn" id="grn" type="text" PLACEHOLDER="Enter you GRN" class="form-control">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="col-md-1">--}}
                            {{--<div class="form-group" >--}}
                                {{--<label class="control-label">--}}
                                {{--</label>--}}
                                {{--<button class="btn btn-primary btn-wide form-control" type="submit">--}}
                                    {{--Get Details--}}
                                {{--</button>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</fieldset>--}}
                <div style="color: red; align-self: center; font-size: 40px; margin-left: 28%; margin-top:10%"> This page is under maintenance.</div>
                <div id="student_details">

                </div>
                <div style="height: 100px">

                </div>
                <hr>
                <div style="word-wrap: break-word" class="row">
                    <div class="col-md-7 col-md-offset-2" style="text-align: center">
                        <h3> Disclaimer and Terms & Conditions for Online Payment Facility</h3>
                        <h4>Please read these conditions of the Disclaimer carefully.</h4></span>
                    </div>
                    <div class="col-md-12">
                        <p>By using the online payment facility, you agree to be bound by these terms contained herein.<br>
                            <span style="margin-left: 5%">
                                S.S.P. Shikshan Sanstha offers you the option of the fees by using the online payment facilities.
                            For making online payment, you will access a third party site. S.S.P. Shikshan Sanstha does not in any way warrant the accuracy or completeness of the information, materials, services or the reliability of any service, advice, opinion, statement or other information displayed or distributed through such third party site. Parents may access this site solely for purposes of fees and acknowledge that availing of any services offered on the site or your reliance on any opinion, advice, statement, memorandum, or information available on the site shall be at your sole risk and discretion. It remains the Customer’s responsibility to verify success of the payment, with its bank.
                            Due to the way transactions are processed by the such third party bank sites, there may be delays in updating your payment in our records.
                            S.S.P. Shikshan Sanstha Terms and Conditions for online payments are subject to change at any time.
                            S.S.P. Shikshan Sanstha and its affiliates, subsidiaries, employees, officers, directors and agents, expressly disclaim any liability for any deficiency in the services of the Payment Gateway Provider. Neither S.S.P. Shikshan Sanstha nor any of its affiliates nor their directors, officers and employees will be liable to or have any responsibility of any kind for any loss that you incur arising out of any deficiency in the services of the Payment Gateway Provider to whom the site belongs, failure or disruption of the site of Payment Gateway Provider, or resulting from the act or omission of any other party involved in making this site or the data contained therein available to you, or from any other cause relating to your access to, inability to access, or use of the site or these materials.
                            S.S.P. Shikshan Sanstha may change the terms of this disclaimer, at any time and without notice. It is recommended that you review the terms of this disclaimer, periodically for changes.  S.S.P. Shikshan Sanstha shall not be held responsible for all or any actions that may subsequently result in any loss, damage and or liability on account of such change in the information on this website.
                            </span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('footer')
</div>



<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/jquery-modal/jquery.modal.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="/vendor/autosize/autosize.min.js"></script>
<script src="/vendor/selectFx/classie.js"></script>
<script src="/vendor/selectFx/selectFx.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

<!-- start: JavaScript Event Handlers for this page -->

<script src="/assets/js/form-validation-edit.js"></script>
<script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script src="/assets/js/table-data.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script>
    var FormValidator1 = function(){
        var detailsFormValidate = function(){
            var form = $("#getStudentDetialsForm");
            var errorHandler = $('.errorHandler', form);
            var successHandler = $('.successHandler', form);
            form.validate({
                rules: {
                    school :{
                        required: true
                    },
                    grn:{
                        required: true
                    }
                },
                messages: {
                    school :{
                        required: "School field is required."
                    },
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
                    $("#student_details").html();
                    var formData = $("#getStudentDetialsForm").serialize();
                    $.ajax({
                        url: '/fees/get-student-details',
                        data: formData,
                        type: "POST",
                        async: true,
                        success:function(data,textStatus,xhr){
                            $("#student_details").html(data);
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
                detailsFormValidate();
            }
        }
    }();

    jQuery(document).ready(function()
    {
        Main.init();
        FormValidator1.init();
    })
</script>
@stop
