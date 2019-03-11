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
                    <!-- start: DASHBOARD TITLE -->
                    @include('alerts.errors')
                    <div id="message-error-div"></div>
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1 class="mainTitle">Question Papers</h1>
                                <span class="mainDescription">Question paper listing</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <fieldset>
                            <div class="row">
                                <div class="col-md-4">
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
                                <div class="col-md-4" id="class-select-div" >
                                    <label class="control-label">
                                        Select Class <span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;">
                                    </select>
                                </div>
                                <div class="col-md-4" id="exam-select-div" >
                                    <label class="control-label">
                                        Select Exam <span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="exam-select" name="exam-select" style="-webkit-appearance: menulist;">
                                        <option>Please Select Exam</option>
                                        @foreach($exams as $exam)
                                            <option value="{!! $exam['id'] !!}">{!! $exam['exam_name'] !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15"><h2>Question paper listing</h2></h5>
                                <table class="table table-striped table-bordered table-hover table-full-width" id="sample_1">
                                    <thead>
                                    <tr>
                                        <th width="10%"> Sr.No. </th>
                                        <th width="20%"> Paper Name </th>
                                        <th width="10%"> Paper Set </th>
                                        <th width="10%"> Subject </th>
                                        <th width="10%"> Action </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Prelim Paper</td>
                                        <td>A</td>
                                        <td>Math</td>
                                        <td>View</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
    {{--<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>--}}
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
        });

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
                    var str='<option value="">Please Select Class</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                    }
                    $('#class-select').html(str);
                    $('#loadmoreajaxloaderClass').hide();
                }
            });
        });
    </script>
@stop
