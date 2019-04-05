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
                                <h1 class="mainTitle">Upload</h1>
                                <span class="mainDescription">Upload Student Answer Sheet</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/exam-evaluation/upload-answerSheet" role="form" id="uploadAnswerSheetForm" enctype="multipart/form-data">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">
                                            Batch <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" name="batch" id="batchDrpdn" style="-webkit-appearance: menulist;" required>
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
                                        <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="DivSearch">
                                        <div class="form-group" id="DivisionBlock">
                                            <label class="control-label">
                                                Division
                                            </label>
                                            <select class="form-control" id="div-select" name="div_select" style="-webkit-appearance: menulist;" required>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">
                                            Academic Year <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="academic-year" name="academic_year" style="-webkit-appearance: menulist;" required="required">
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="subject-select-div" >
                                        <label class="control-label">
                                            Select Subject<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="subject-select" name="subject_select" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="control-label">
                                            Select Term<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="term-select" name="Term_number" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="row" id="exam-sub-div">
                                    <div class="col-md-4" id="exam-select-div" >
                                        <label class="control-label">
                                            Select Exam <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="exam-select" name="exam_select" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="set-select-div" >
                                        <label class="control-label">
                                            Question Paper Set <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="set-select" name="set_select" style="-webkit-appearance: menulist;" required>
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

                            <div class="row pull-right">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-wide" id="submit-button" type="submit">
                                        Submit
                                    </button>
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
            $('#submit-button').hide();
        });

        $('#batchDrpdn').change(function(){
            var id=this.value;
            var route='/get-all-classes/'+id;
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#class-select').html("no record found");
                } else {
                    var str='<option value="">Please Select Class</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                    }
                    $('#class-select').html(str);
                }
            });
        });

        $('#class-select').change(function(){
            var id=this.value;
            $('#tableContent').hide();
            $('#submit-button').hide();
            $('#exam-select').prop('selectedIndex',0);
            $('#subject-select').prop('selectedIndex',0);
            $('#term-select').prop('selectedIndex',0);
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

            var classId=this.value;
            var route1 = 'get-academicYear/' + classId;
            $.get(route1, function (res) {
                if (res.length == 0) {
                    $('#exam-select').html("no record found");
                } else {
                    var str = '<option value="">Please Select Academic Year</option>';
                    for (var i = 0; i < res.length; i++) {
                        str += '<option value="' + res[i]['year'] + '">' + res[i]['year'] + '</option>';
                    }
                    $('#academic-year').html(str);
                }
            });
        });

        $('#academic-year').change(function(){
            var academicYear=this.value;
            $('#exam-select').prop('selectedIndex',0);
            $('#subject-select').prop('selectedIndex',0);
            $('#term-select').prop('selectedIndex',0);
            $('#tableContent').hide();
            var route = 'get-subjects/' + academicYear;
            $.get(route, function (res) {
                if (res['subject'].length == 0) {
                    $('#subject-select').html("no record found");
                } else {
                    var str = '<option value="">Please Select Subject</option>';
                    for (var i = 0; i < res['subject'].length; i++) {
                        str += '<option value="' + res['subject'][i]['subject_id'] + '">' + res['subject'][i]['subject_name'] + '</option>';
                    }
                    $('#subject-select').html(str);
                }
            });
        });

        $('#subject-select').change(function(){
            var subId=this.value;
            var academicYear=$('#academic-year').val();
            var route = 'get-term/' + academicYear + '/' +subId;
            $.get(route, function (res) {
                if (res['term'].length == 0) {
                    $('#term-select').html("no record found");
                } else {
                    var str1 = '<option value="">Please Select Term</option>';
                    for (var i = 0; i < res['term'].length; i++) {
                        str1 += '<option value="' + res['term'][i]['term_id'] + '">' + res['term'][i]['term_name'] + '</option>';
                    }
                    $('#term-select').html(str1);
                }
            });
            $('#exam-select').prop('selectedIndex',0);
            $('#tableContent').hide();
        });

        $('#term-select').change(function(){
            var termId=this.value;
            $('#exam-select').prop('selectedIndex',0);
            $('#tableContent').hide();
            var route = 'get-exams/' + termId;
            $.get(route, function (res) {
                if (res.length == 0) {
                    $('#exam-select').html("no record found");
                } else {
                    var str = '<option value="">Please Select Subject</option>';
                    for (var i = 0; i < res.length; i++) {
                        str += '<option value="' + res[i]['exam_id'] + '">' + res[i]['exam_name'] + '</option>';
                    }
                    $('#exam-select').html(str);
                }
            });
        });

        $('#div-select').change(function(){
            var id=$('#class-select').val();
            $('#exam-select').prop('selectedIndex',0);
            $('#subject-select').prop('selectedIndex',0);
            $("#tableContent").hide();
            $('#submit-button').hide();
        });


        $('#exam-select').change(function(){
            var division = $('#div-select').val();
            var exam = this.value;
            var clss = $('#class-select').val();
            var subject= $('#subject-select').val();
            if(division != null && exam != null && clss != null && subject != null) {
                var route = 'get-paper-set/' + exam;
                $.get(route, function (res) {
                    if (res.length == 0) {
                        $('#set-select').html("no record found");
                    } else {
                        var strSet = '<option value="">Please Select Paper Set</option>';
                        for (var i = 0; i < res.length; i++) {
                            strSet += '<option value="' + res[i]['set_id'] + '">' + res[i]['set_name'] + '</option>';
                        }
                        $('#set-select').html(strSet);
                    }
                });
            }
        });

        $('#set-select').change(function(){
            var setId = this.value;
            var division = $('#div-select').val();
            var exam = $('#exam-select').val();
            var clss = $('#class-select').val();
            var subject= $('#subject-select').val();
            if(division != null && exam != null && clss != null && subject != null && setId != null) {
                $('div#loadmoreajaxloader').show();
                var route = 'student-upload';
                $.ajax({
                    method: "get",
                    url: route,
                    data: {division, exam, subject}
                })
                    .done(function (res) {
                        $('div#loadmoreajaxloader').hide();
                        $("#tableContent").show();
                        $("#tableContent").html(res);
                        $('#submit-button').show();
                        TableData.init();
                    });
            } else {
                $("#tableContent").hide();
            }
        });

    </script>
@stop
