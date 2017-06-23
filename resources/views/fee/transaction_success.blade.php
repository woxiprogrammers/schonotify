@extends('master')

@section('content')

<div id="app">
    <div class="sidebar app-aside" id="sidebar" style="top: 0px!important;">
        <img style="margin-left: 20%;" class="img-responsive" src="/assets/images/bodyLogo/sspss.jpg">
    </div>
    <div class="app-content">

        <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div class="wrap-content container"  style="width: 80% !important;" id="container">
                @include('alerts.errors')
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-2">
                            <h1 class="mainTitle">Ganesh International School , Chikhali</h1> <br><br>
                            <h2 class="mainTitle" style="margin-left:20%;color: {{$data['color']}};">{{$data['message_title']}}</h2>
                      </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-sm-11 col-sm-offset-1">
                        <h4> {{$data['message']}} </h4>
                        <fieldset>
                            <legend style="font-size: 18px"> Transaction Details</legend>
                            <div class="row">
                                <div class="col-sm-6">
                                    <span> Transaction Id: </span>
                                    <span> {{$data['transaction_id']}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span> Reference Id: </span>
                                    <span> {{$data['reference_id']}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <span> Amount: </span>
                                    <span> {{$data['amount']}}</span>
                                </div>
                                <div class="col-sm-6">
                                    <span> Date: </span>
                                    <span> {{$data['date']}}</span>
                                </div>
                            </div>
                            <div class="col-md-offset-3" style="margin-top: 10%">
                                <a class="btn btn-primary btn-wide"  href="/fees/billing-page">
                                    Go to Fees Payment Page
                                </a>
                            </div>
                        </fieldset>
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
