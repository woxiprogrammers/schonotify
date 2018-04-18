<?php
/**
 * Created by Ameya Joshi.
 * Date: 4/4/18
 * Time: 1:35 PM
 */
?>

@extends('master')
@section('content')
    <div id="app">
        @include('sidebar')
        <div class="app-content">
            <!-- start: TOP NAVBAR -->
        @include('header')
        <!-- end: TOP NAVBAR -->
            <div class="main-content" >
                <div class="wrap-content container" id="container">
                    <!-- start: DASHBOARD TITLE --><br><br><br>
                    @include('alerts.errors')
                    <div id="message-error-div"></div>
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1 class="mainTitle">Bonafide Certificates</h1>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <div class="row">
                            <div class="col-md-3 col-md-offset-9">
                                <a class="btn btn-primary btn-o add-event padding-10" href="/certificates/bonafide/create">
                                    <i class="fa fa-plus"></i>
                                    Create Bonafide
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid container-fullw">
                            <table class="table  table-striped table-bordered table-hover table-full-width" id="sample_1">
                                <thead>
                                <tr>
                                    <th width="10%"> Sr. No </th>
                                    <th width="20%"> Grn Number </th>
                                    <th width="10%"> Student Name </th>
                                    <th width="10%">  Date </th>
                                    <th width="10%"> Action </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($StudentData as $data)
                                    <tr>
                                        <td>{{$data['id']}}</td>
                                        <td>{{$data['grn']}}</td>
                                        <td>{{$data['first_name']}} {{$data['last_name']}}</td>
                                        <td>{{$data['created_at']}}</td>
                                        <td><a href="/certificates/bonafide/view/{{$data['grn']}}">view</a> / <a href="/certificates/bonafide/download/{{$data['grn']}}">download</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                    </div>
                    @include('rightSidebar')
                </div>
            </div>
        </div>
        @include('footer')
    </div>
    <!-- start: MAIN JAVASCRIPTS -->
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
    jQuery(document).ready(function(){
        Main.init();
        FormValidator.init();
        FormElements.init();
        TableData.init();
    })
</script>
@stop
