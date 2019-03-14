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
                                <h1 class="mainTitle">Create</h1>
                                <span class="mainDescription">Question Paper</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/exam-evaluation/create-questionPaper" role="form" id="questionPaperCreateForm">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-3 ">
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
                                    <div class="col-md-3" id="class-select-div" >
                                        <label class="control-label">
                                            Select Class <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                    <div class="col-md-3" id="exam-select-div" >
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
                                    <div class="col-md-3" id="subject-select-div" >
                                        <label class="control-label">
                                            Select Subject<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="subject-select" name="subject-select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <br>
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-3" id="set-select-div" >
                                        <label class="control-label">
                                            Enter Paper Set<span class="symbol required"></span>
                                        </label>
                                        <input type="text" name="set-select" id="set-select" placeholder="Enter set">
                                    </div>
                                    <div class="col-md-4" id="question-paper-name" >
                                        <label class="control-label">
                                            Enter Question Paper Name <span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="paper_name" name="paper_name" placeholder="Question paper name">
                                        </input>
                                    </div>
                                    <div class="col-md-2" id="total-marks-div" >
                                        <label class="control-label">
                                            Enter Total Marks <span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="total_marks" name="total_marks" placeholder="marks">
                                        </input>
                                    </div>
                                    <div class="col-md-3" id="question-select-div" >
                                        <label class="control-label">
                                            Enter Number of Questions <span class="symbol required"></span>
                                        </label>
                                        <input type="number" class="form-control" id="questions-select" name="questions-select" placeholder="No. of Questions">
                                    </div>
                                </div>
                            </fieldset>
                            <br><br>
                            <div id="paper-preview" style="">

                            </div>
                            <br><br><br>
                            <div id="question-structure">

                            </div>
                            <div class="row">
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary btn-wide" type="submit">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
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
    <script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="/vendor/autosize/autosize.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/ckeditor/adapters/jquery.js"></script>
    <script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    {{--<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>--}}
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/form-wizard.js"></script>
    <script src="/assets/js/form-validation.js"></script>
    <script src="/assets/js/form-elements.js"></script>
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

        $('#questions-select').change(function(){
            var questions=this.value;
            var str = '';
            for(var i=0; i<questions; i++)
            {   var divId = i;
                ++divId;
                str += '<div class="row">'+
                            '<div class="col-md-1" id="question-id-div">'+
                                '<label class="control-label">'+
                                    'Id'+'<span class="symbol required"></span>'+
                                '</label>'+
                                '<input type="text" class="form-control" id="question-id" name="question-id[]" placeholder="Id">'+
                            '</div>'+
                            '<div class="col-md-5" id="question-name-div">'+
                                '<label class="control-label">'+
                                    'Enter Question' +'<span class="symbol required"></span>'+
                                '</label>'+
                                '<input type="text" class="form-control" id="question-name" name="question-name[]" placeholder="Enter Question">'+
                            '</div>'+
                            '<div class="col-md-1" id="question-marks-div">'+
                                '<label class="control-label">'+
                                    'Marks<span class="symbol required"></span>'+
                                '</label>'+
                                '<input type="text" class="form-control" id="question-marks" name="question-marks[]" placeholder="marks">'+
                            '</div>'+
                            '<div class="col-md-2" id="or-question-div" >'+
                                '<label class="control-label">'+
                                    'Or<span class="symbol required"></span>'+
                                '</label>'+
                                '<select class="form-control" id="or-question" name="or-question[]" style="-webkit-appearance: menulist;">'+
                                    '<option>Select or</option>'+
                                    '<option value="2">2</option>' +
                                    '<option value="3">3</option>' +
                                    '<option value="4">4</option>' +
                                    '<option value="5">5</option>' +
                                    '<option value="6">6</option>' +
                                    '<option value="7">7</option>' +
                                    '<option value="8">8</option>' +
                                    '<option value="9">9</option>' +
                                    '<option value="10">10</option>' +
                                '</select>'+
                            '</div>'+
                            '<div class="col-md-2">'+
                                '<a class="btn" onclick="add('+divId+')">'+
                                'Add Sub Question </a>'+
                            '</div>'+
                        '</div>'+
                            '<div id="'+divId+'subQuestion-div">'+

                            '</div>'+
                    '<br><br>';
                $('#question-structure').html(str);
            }

            var exm= $('#exam-select').val();
            var qSet = $('#set-select').val();
            var clss = $('#class-select').val();
            var paperName = $('#paper_name').val();
            var mark = $('#total_marks').val();
            var sub = $('#subject-select').val();
            var str1 = '';
            if(exm != null && qSet != null && clss != null && paperName != null && mark != null && sub != null){
                str1 = '<div class="row" style="text-align: center">'+
                            '<h4>'+exm+'</h4>'+
                        '</div>'+
                        '<div class="row" style="text-align: center">'+
                            '<h4>'+paperName+'</h4>'+
                        '</div>'+
                        '<div class="row" style="text-align: center">'+
                            '<h4>'+sub+' - '+qSet+'</h4>'+
                        '</div>'+
                        '<div class="row">'+
                            '<div class="col-sm-6" style="text-align: start">'+
                                '<h4>Class : '+clss+'</h4>'+
                            '</div>'+
                            '<div class="col-sm-6" style="text-align: end">'+
                                '<h4>Marks : '+mark+'</h4>'+
                            '</div>'+
                        '</div>';
                $('#paper-preview').html(str1);
            }

        });

        function add(divId) {
            str = '<br><br>'+'<div class="row">' +
                '<div class="col-md-1"></div>' +
                '<div class="col-md-1" id="question-id-div">' +
                '<label class="control-label">' +
                "Id" + '<span class="symbol required"></span>' +
                '</label>' +
                '<input type="text" class="form-control" id="question-id" name="sub-question-id['+divId+'][]" placeholder="Id">' +
                '</div>' +
                '<div class="col-md-5" id="question-name-div">' +
                '<label class="control-label">' +
                'Enter Question' + '<span class="symbol required"></span>' +
                '</label>' +
                '<input type="text" class="form-control" id="question-name" name="sub-question-name['+divId+'][]" placeholder="Enter Question">' +
                '</div>' +
                '<div class="col-md-2" id="question-marks-div">' +
                '<label class="control-label">' +
                'Marks<span class="symbol required"></span>' +
                '</label>' +
                '<input type="text" class="form-control" id="question-marks" name="sub-question-marks['+divId+'][]" placeholder="marks">' +
                '</div>' +
                '<div class="col-md-2" id="or-question-div" >' +
                '<label class="control-label">' +
                'Or<span class="symbol required"></span>' +
                '</label>' +
                '<select class="form-control" id="or-question" name="sub-or-question['+divId+'][]" style="-webkit-appearance: menulist;">' +
                '<option>Select or</option>' +
                '<option value="2">2</option>' +
                '<option value="3">3</option>' +
                '</select>' +
                '</div>' +
                '</div>';
            $('#'+divId+'subQuestion-div').append(str);
        }
    </script>
@stop
