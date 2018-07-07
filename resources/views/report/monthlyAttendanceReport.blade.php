<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 7/2/18
 * Time: 10:40 AM
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
                                <h1 class="mainTitle">Monthly</h1>
                                <span class="mainDescription">Attendance Report</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/reports/monthly-attendance-report" role="form" id="monthlyAttendanceReport">
                            <input type="hidden" name="body_id" value="{!! Auth::User()->body_id !!}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Batch <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" name="batch" id="batchDrpdn" style="-webkit-appearance: menulist;">
                                            <option>Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{!! $batch['id'] !!}">{!! $batch['name'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="class-select-div" >
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Class <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="select-div" >
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Div <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="div-select" name="div_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" id="select-student">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Student List <span class="symbol required"></span>
                                        </label>
                                        <div class="form-control" >
                                            <ul id="student-select" class="list-group" style="height: 200px;overflow: scroll;">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Month <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="month-select" name="month_select" style="-webkit-appearance: menulist;">
                                            <option value="">please select the Month</option>
                                            <option value="01">January</option>
                                            <option value="02">February</option>
                                            <option value="03">March</option>
                                            <option value="04">April</option>
                                            <option value="05">May</option>
                                            <option value="06">June</option>
                                            <option value="07">July</option>
                                            <option value="08">August</option>
                                            <option value="09">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Year <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="year-select" name="year_select" style="-webkit-appearance: menulist;">
                                            <option value="">Please select the year</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="loadmoreajaxloaderClass" style="display:none;"><center><img src="/assets/images/loader1.gif"></center></div>
                            <div class="row">
                                <div class="col-md-6 pull-right" >
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-wide" type="submit" id="submitButton" >
                                            Submit <i class="fa fa-arrow-circle-right"></i>
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
    <script src="/assets/js/report/report-validation.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormValidator.init();
            $('#batchDrpdn').change(function(){
                var id=this.value;
                var route='/get-all-classes/'+id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#class-select').html("no record found");
                        $('#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select class</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                        }
                        $('#class-select').html(str);
                        $('#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#class-select').change(function(){
                var id=this.value;
                var route='/get-all-division/'+id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#div-select').html("no record found");
                        $('#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select division</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['division_id']+'">'+res[i]['division_name']+'</option>';
                        }
                        $('#div-select').html(str);
                        $('#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#div-select').change(function(){
                var division_id = this.value;
                var class_id = $('#class-select').val();
                var batch_id = $('#batchDrpdn').val();
                var route='get-all-students/'+division_id+'/'+class_id+'/'+batch_id;
                $.get(route,function(res){
                    $('#student-select').html(res);
                });
            });

            $('#student-select').on('change',function(){
               var length =  $("#student-select input:checkbox:checked").length;
                if(length > 15){
                    alert("only 15 students are allowed");
                    $('#submitButton').hide();
                }else{
                    $('#submitButton').show();
                }
            });
        });
    </script>
@stop

