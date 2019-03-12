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
                                <h1 class="mainTitle">Student Listing</h1>
                                <span class="mainDescription">Student listing</span>
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
                                <div class="col-md-4" id="DivSearch">
                                    <div class="form-group" id="DivisionBlock">
                                        <label class="control-label">
                                            Division
                                        </label>
                                        <select class="form-control" id="div-select" name="div-select" style="-webkit-appearance: menulist;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="row">
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
                                <div class="col-md-4" id="subject-select-div" >
                                    <label class="control-label">
                                        Select Subject<span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="subject-select" name="subject_select" style="-webkit-appearance: menulist;">
                                    </select>
                                </div>
                                <div class="col-md-4" id="role-select-div" >
                                    <label class="control-label">
                                        Select Role<span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="role-select" name="role-select" style="-webkit-appearance: menulist;">
                                        <option>Select Role</option>
                                        @foreach($paperCheckerRoles as $paperCheckerRole)
                                            <option value="{!! $paperCheckerRole['id'] !!}">{!! $paperCheckerRole['name'] !!}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div class="container-fluid container-fullw bg-white">
                            <div class="row">
                                <div id="loadmoreajaxloader" style="display:none;"><center><img src="/assets/images/loader1.gif" /></center></div>
                                <div class="col-md-12" id="tableContent">
                                </div>
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
    <script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <script src="/assets/js/table-data.js"></script>
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

        $('#class-select').change(function(){
            var id=this.value;
            var route='/get-all-division/'+id;
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#div-select').html("no record found");
                } else {
                    var str='<option value="">Please select division</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['division_id']+'">'+res[i]['division_name']+'</option>';
                    }
                    $('#div-select').html(str);
                }
            });
        });

        $('#div-select').change(function(){
            $('div#loadmoreajaxloader').show();
            var division= this.value;
            var route='studentListing';
            $.ajax({
                method: "get",
                url: route,
                data: { division }
            })
                .done(function(res){
                    $('div#loadmoreajaxloader').hide();
                    $("#tableContent").html(res);
                    TableData.init();
                })
        });

        $('#exam-select').change(function(){
            var id=this.value;
            var classId = $('#class-select').val();
            if(classId != null) {
                var route = 'get-exam-subject/' + id + '/' + classId;
                $.get(route, function (res) {
                    if (res.length == 0) {
                        $('#subject-select').html("no record found");
                    } else {
                        var str = '<option value="">Please Select Subject</option>';
                        for (var i = 0; i < res.length; i++) {
                            str += '<option value="' + res[i]['subject_id'] + '">' + res[i]['subject_name'] + '</option>';
                        }
                        $('#subject-select').html(str);
                    }
                });
            }
        });
    </script>
@stop
