@extends('master')

@section('content')

<div id="app">

    <div class="app-content">

        <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div class="wrap-content container"  style="width: 80% !important; margin-top: 10%" id="container">
                @include('alerts.errors')
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7 col-sm-offset-3">
                            <h1 class="mainTitle" style="color: {{$data['color']}}">{{$data['message_title']}}</h1>
                        </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-sm-9 col-sm-offset-1">
                        <h4> {{$data['message']}} </h4>
                    </div>
                </div>
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
                </fieldset>
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