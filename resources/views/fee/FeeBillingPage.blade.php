
@extends('master')

@section('content')

<div id="app">

    @include('sidebar')

    <div class="app-content">

        @include('header')
        <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div class="wrap-content container" id="container">
                @include('alerts.errors')
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">Payment</h1>
                            <span class="mainDescription">Fee</span>
                        </div>
                    </div>
                </section>
                <fieldset>
                <legend> Student Details</legend>
                    <form id="getStudentDetialsForm" role="form">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    School: <span class="symbol required"></span>
                                </label>
                                <select name="school" class="form-control">
                                    @foreach($bodies as $body)
                                        <option value="{{$body['id']}}"> {{$body['name']}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group" >
                                <label class="control-label">
                                    GRN <span class="symbol required"></span>
                                </label>
                                <input name="grn" id="grn" type="text" PLACEHOLDER="Enter you GRN" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-5 col-md-offset-2">
                            <div class="form-group" >
                                <button class="btn btn-primary btn-wide" type="submit">
                                    Get Details
                                </button>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
            @include('rightSidebar')
        </div>
    </div>

    @include('footer')
</div>



<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>4a
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

                    var formData = $("#getStudentDetialsForm").serialize();
                    $.ajax({
                        url: '/fees/get-student-details',
                        data: formData,
                        type: "POST",
                        async: true,
                        success:function(){
                            console.log('in success');
                        },
                        error: function(){
                            console.log('in error');
                        }
                    });
                    console.log(formData);
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














