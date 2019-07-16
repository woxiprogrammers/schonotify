<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 6/1/18
 * Time: 5:43 PM
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
                                <h1 class="mainTitle">Students</h1>
                                <span class="mainDescription">All Students Report</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/reports/all-student-report" role="form" id="dailyAttendanceReport">
                            <input type="hidden" name="body_id" value="{!! Auth::User()->body_id !!}">
                            <div class="row">
                                <div class="col-md-3" id="UserSearch" style="">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Batch
                                        </label>
                                        <select class="form-control" id="Batchdropdown" name="Batchdropdown" style="-webkit-appearance: menulist;">
                                            <option value="">Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{{$batch['id']}}">{{$batch['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3" id="ClassSearch" style="">
                                </div>
                                <div class="col-md-3" id="DivSearch">
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label">&nbsp;
                                    </label>
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-wide" id="generate-student-report-button" type="submit">
                                            Generate <i class="fa fa-arrow-circle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/ckeditor/adapters/jquery.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/exam-form-validation.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormValidator.init();
        });
    </script>
    <script>
        $(document).ready(function(){
            $('#Batchdropdown').change(function(){
                $('div#loadmoreajaxloader').show();
                var batch=this.value;
                var route='/get-classes-search';
                $.ajax({
                    method: "get",
                    url: route,
                    data: { batch }
                })
                    .done(function(res){
                        $('#ClassSearch').html(res);
                        $('div#loadmoreajaxloader').hide();
                    })
            })
        })
    </script>
@stop


