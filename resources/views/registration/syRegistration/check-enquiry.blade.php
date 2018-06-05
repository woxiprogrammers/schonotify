@extends('master')

@section('content')
    <div id="app">
        <div class="sidebar app-aside" id="sidebar" style="top: 0px!important;">
            <img class="img-responsive" src="/assets/images/bodyLogo/wadia.jpg">
        </div>
        <div class="app-content">
            <!-- start: TOP NAVBAR -->
            <!-- end: TOP NAVBAR -->
            <div class="main-content" >
                <div class="wrap-content container" id="container">
                    <!-- start: DASHBOARD TITLE -->
                    <div id="message-error-div"></div>
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <span class="mainDescription">Waiting/Merit Form</span>
                            </div>
                        </div>
                    </section>
                    <!-- end: DASHBOARD TITLE -->
                    <!-- start: DYNAMIC TABLE -->
                    @include('alerts.errors')
                    <div class="col-md-12">
                        <form method="post" action="/syEnquiry/redirect" role="form" id="checkEnquiry">
                            <div class="row">
                                <br><br><br><br><br>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label  class="control-label">
                                            Enter Waiting/Merit Form Number
                                        </label>
                                        <input type="text" placeholder="Enter Waiting/Merit Form Number" class="form-control" name="enquiry_number" id="enquiry_number" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label  class="control-label"></label>
                                    </div>
                                    <button class="btn btn-primary btn-wide pull-left" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('footer')
    </div>
    <!-- start: MAIN JAVASCRIPTS -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/ckeditor/adapters/jquery.js"></script>
    <script src="/assets/js/form-validation.js"></script>
    <script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/assets/js/enquiry-number.js"></script>
    <script>
        jQuery(document).ready(function() {
            getMsgCount();
            Main.init();
            FormValidator.init();
            var date_input=$('input[name="dob"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    </script>
@stop
