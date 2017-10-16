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
                                <h1 class="mainTitle">Marks Entry</h1>
                                <span class="mainDescription">Students</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/exam/student-marks-entry" role="form" id="subjectMarksEntryForm">
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
                                <div class="col-md-4" id="select-subject" >
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Subject <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="subject-select" name="subject_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="select-sub-subject" >
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Sub Subject <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="sub-subject-select" name="sub_subject_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4" id="select-term" >
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Terms <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="term-select" name="term_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                                <div id="loadmoreajaxloaderClass" style="display:none;"><center><img src="assets/images/loader1.gif"></center></div>
                            </div>
                            <div id="structures"></div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-wide" type="submit">
                                    Create <i class="fa fa-arrow-circle-right"></i>
                                </button>
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
            $('#batchDrpdn').change(function(){
                var id=this.value;
                var route='get-all-classes/'+id;
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
                var route='get-all-div/'+id;
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
                            str+='<option value="'+res[i]['id']+'">'+res[i]['division_name']+'</option>';
                        }
                        $('#div-select').html(str);
                        $('#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#class-select').change(function(){
                var id=this.value;
                var route='get-subjects/'+id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#subject-select').html("no record found");
                        $('#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select subject</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['id']+'">'+res[i]['subject_name']+'</option>';
                        }
                        $('#subject-select').html(str);
                        $('#loadmoreajaxloaderClass').hide();
                    }
                });
            });

            $('#subject-select').change(function(){
                var id=this.value;
                var route='get-sub-subjects/'+id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#sub-subject-select').html("no record found");
                        $('#loadmoreajaxloaderClass').hide();
                    } else {
                        var str='<option value="">Please select subject</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['id']+'">'+res[i]['sub_subject_name']+'</option>';
                        }
                        $('#sub-subject-select').html(str);
                        $('#loadmoreajaxloaderClass').hide();
                    }
                });
            });
            $('#sub-subject-select').change(function(){
                var id=this.value;
                var route='get-terms/'+id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    if (res.length == 0)
                    {
                        $('#term-select').html("no record found");
                        $('#loadmoreajaxloaderClass,#structures').hide();
                    } else {
                        var str='<option value="">Please select subject</option>';
                        for(var i=0; i<res.length; i++)
                        {
                            str+='<option value="'+res[i]['id']+'">'+res[i]['term_name']+'</option>';
                        }
                        $('#term-select').html(str);
                        $('#loadmoreajaxloaderClass').hide();
                    }
                });
            });

            $('#term-select').change(function(){
                var term_id = this.value;
                var route='get-subject-marks/'+term_id+'/'+div_id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route,function(res){
                    $('#loadmoreajaxloaderClass').hide();
                    $('#structures').html(res);
                });
            });
            var div_id = 0;
            $('#div-select').change(function(){
                div_id=this.value;
            });
        });
    </script>
@stop


