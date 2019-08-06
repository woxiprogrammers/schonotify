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
                        <form method="post" action="/exam-evaluation/create-questionPaper" role="form" id="questionPaperCreateForm" enctype="multipart/form-data">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="control-label">
                                            Program <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" name="batch" id="batchDrpdn" style="-webkit-appearance: menulist;" required>
                                            <option>Select Program</option>
                                            @foreach($batches as $batch)
                                                @if($batch == $batches->first())
                                                    <option value="{!! $batch['id'] !!}" selected>{!! $batch['name'] !!}</option>
                                                    @else
                                                    <option value="{!! $batch['id'] !!}">{!! $batch['name'] !!}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="class-select-div">
                                        <label class="control-label">
                                            Select Department <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                            <label class="control-label">
                                                Academic Year <span class="symbol required"></span>
                                            </label>
                                            <select class="form-control" id="academic-year" name="startYear" style="-webkit-appearance: menulist;" required="required">
                                            </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="row">
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
                                    <div class="col-md-4" id="exam-select-div" >
                                        <label class="control-label">
                                            Select Exam <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="exam-select" name="exam_select" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-3" id="set-select-div" >
                                        <label class="control-label">
                                            Enter Paper Set<span class="symbol required"></span>
                                        </label>
                                        <input type="text" name="paper_set" id="paper_set" placeholder="Enter set" required>
                                    </div>
                                    <div class="col-md-4" id="question-paper-name" >
                                        <label class="control-label">
                                            Enter Question Paper Name <span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="paper_name" name="paper_name" placeholder="Question paper name" required>
                                        </input>
                                    </div>
                                    <div class="col-md-2" id="total-marks-div" >
                                        <label class="control-label">
                                            Enter Total Marks <span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="paper_marks" name="paper_marks" placeholder="marks" required disabled>
                                        </input>
                                    </div>
                                    <div class="col-md-3" id="question-select-div" >
                                        <label class="control-label">
                                            Enter Number of Questions <span class="symbol required"></span>
                                        </label>
                                        <input type="number" class="form-control" id="paper_questions" name="paper_questions" placeholder="No. of Questions">
                                    </div>
                                </div>
                            </fieldset>
                            <br><br>
                            <div id="paper-preview" style="">

                            </div>
                            <br><br><br>
                            <div id="question-structure">

                            </div>
                            <div class="row" id="submit-button-div">
                                <div class="col-md-4">
                                    <label class="control-label">
                                        Select Question Paper PDF
                                    </label>
                                    <input type="file" class="form-control" id="question-paper-pdf" accept="application/pdf" name="question_paper_pdf">
                                </div>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-2">
                                    <button class="btn btn-primary btn-wide" id="submit-button" type="submit">
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
    {{--<script src="/assets/js/form-wizard.js"></script>
    <script src="/assets/js/form-validation.js"></script>--}}
    <script src="/assets/js/form-elements.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            $('#submit-button-div').hide();
            var id=$('#batchDrpdn').val();
            if(id != null) {
                var route = '/get-all-classes/' + id;
                $('#loadmoreajaxloaderClass').show();
                $.get(route, function (res) {
                    if (res.length == 0) {
                        alert(1212);
                        $('#class-select').html("no record found");
                        $('#class-select').find('option').remove();
                        $('#academic-year').find('option').remove();
                        $('#subject-select').find('option').remove();
                        $('#term-select').find('option').remove();
                        $('#exam-select').find('option').remove();
                        $('#loadmoreajaxloaderClass').hide();
                    } else {
                        var str = '<option>Please Select Class</option>';
                        for (var i = 0; i < res.length; i++) {
                            str += '<option value="' + res[i]['class_id'] + '">' + res[i]['class_name'] + '</option>';
                        }
                        $('#class-select').html(str);
                        $('#class-select').prop('selectedIndex', 1);
                        $('#loadmoreajaxloaderClass').hide();
                        var classId=$('#class-select').val();
                        if(classId != null) {
                            var route = 'get-academicYear/' + classId;
                            $.get(route, function (res) {
                                if (res.length == 0) {
                                    $('#academic-year').find('option').remove();
                                    $('#subject-select').find('option').remove();
                                    $('#term-select').find('option').remove();
                                    $('#exam-select').find('option').remove();
                                    $('#academic-year').html("no record found");
                                } else {
                                    var str = '<option value="">Please Select Academic Year</option>';
                                    for (var i = 0; i < res.length; i++) {
                                        str += '<option value="' + res[i]['year'] + '">' + res[i]['year'] + '</option>';
                                    }
                                    $('#academic-year').html(str);
                                    $('#academic-year').prop('selectedIndex', res.length);
                                    academicYear = $('#academic-year').val();
                                    if (academicYear != null) {
                                        var route = 'get-subjects/' + academicYear;
                                        $.get(route, function (res) {
                                            if (res['subject'].length == 0) {
                                                $('#subject-select').find('option').remove();
                                                $('#term-select').find('option').remove();
                                                $('#exam-select').find('option').remove();
                                                $('#subject-select').html("no record found");
                                            } else {
                                                var str = '<option value="">Please Select Subject</option>';
                                                for (var i = 0; i < res['subject'].length; i++) {
                                                    str += '<option value="' + res['subject'][i]['subject_id'] + '">' + res['subject'][i]['subject_name'] + '</option>';
                                                }
                                                $('#subject-select').html(str);
                                                $('#subject-select').prop('selectedIndex', 1);

                                                var subId = $('#subject-select').val();
                                                var academicYear = $('#academic-year').val();
                                                if (subId != null && academicYear != null) {
                                                    var route = 'get-term/' + academicYear + '/' + subId;
                                                    $.get(route, function (res) {
                                                        if (res['term'].length == 0) {
                                                            $('#term-select').find('option').remove();
                                                            $('#exam-select').find('option').remove();
                                                            $('#term-select').html("no record found");
                                                        } else {
                                                            var str1 = '<option value="">Please Select Term</option>';
                                                            for (var i = 0; i < res['term'].length; i++) {
                                                                str1 += '<option value="' + res['term'][i]['term_id'] + '">' + res['term'][i]['term_name'] + '</option>';
                                                            }
                                                            $('#term-select').html(str1);
                                                            $('#term-select').prop('selectedIndex',1);
                                                            var termId=$('#term-select').val();
                                                            if(termId != null) {
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
                                                            }
                                                        }
                                                    });
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        }
                        $('#submit-button-div').hide();
                        /*$('#exam-select').prop('selectedIndex',0);
                        $('#subject-select').prop('selectedIndex',0);
                        $('#term-select').prop('selectedIndex',0);*/
                    }
                });
            }
        });
        $('#batchDrpdn').change(function(){
            var id=this.value;
            var route='/get-all-classes/'+id;
            $('#loadmoreajaxloaderClass').show();
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#class-select').find('option').remove();
                    $('#academic-year').find('option').remove();
                    $('#subject-select').find('option').remove();
                    $('#term-select').find('option').remove();
                    $('#exam-select').find('option').remove();
                    $('#class-select').html("no record found");
                    $('#loadmoreajaxloaderClass').hide();
                } else {
                    var str='<option>Please Select Class</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                    }
                    $('#class-select').html(str);
                    $('#loadmoreajaxloaderClass').hide();
                    $('#class-select').prop('selectedIndex', 1);
                    var classId=$('#class-select').val();
                    if(classId != null) {
                        var route = 'get-academicYear/' + classId;
                        $.get(route, function (res) {
                            if (res.length == 0) {
                                $('#academic-year').find('option').remove();
                                $('#subject-select').find('option').remove();
                                $('#term-select').find('option').remove();
                                $('#exam-select').find('option').remove();
                                $('#academic-year').html("no record found");
                            } else {
                                var str = '<option value="">Please Select Academic Year</option>';
                                for (var i = 0; i < res.length; i++) {
                                    str += '<option value="' + res[i]['year'] + '">' + res[i]['year'] + '</option>';
                                }
                                $('#academic-year').html(str);
                                $('#academic-year').prop('selectedIndex', res.length);
                                academicYear = $('#academic-year').val();
                                if (academicYear != null) {
                                    var route = 'get-subjects/' + academicYear;
                                    $.get(route, function (res) {
                                        if (res['subject'].length == 0) {
                                            $('#subject-select').find('option').remove();
                                            $('#term-select').find('option').remove();
                                            $('#exam-select').find('option').remove();
                                            $('#subject-select').html("no record found");
                                        } else {
                                            var str = '<option value="">Please Select Subject</option>';
                                            for (var i = 0; i < res['subject'].length; i++) {
                                                str += '<option value="' + res['subject'][i]['subject_id'] + '">' + res['subject'][i]['subject_name'] + '</option>';
                                            }
                                            $('#subject-select').html(str);
                                            $('#subject-select').prop('selectedIndex', 1);

                                            var subId = $('#subject-select').val();
                                            var academicYear = $('#academic-year').val();
                                            if (subId != null && academicYear != null) {
                                                var route = 'get-term/' + academicYear + '/' + subId;
                                                $.get(route, function (res) {
                                                    if (res['term'].length == 0) {
                                                        $('#term-select').find('option').remove();
                                                        $('#exam-select').find('option').remove();
                                                        $('#term-select').html("no record found");
                                                    } else {
                                                        var str1 = '<option value="">Please Select Term</option>';
                                                        for (var i = 0; i < res['term'].length; i++) {
                                                            str1 += '<option value="' + res['term'][i]['term_id'] + '">' + res['term'][i]['term_name'] + '</option>';
                                                        }
                                                        $('#term-select').html(str1);
                                                        $('#term-select').prop('selectedIndex',1);
                                                        var termId=$('#term-select').val();
                                                        if(termId != null) {
                                                            var route = 'get-exams/' + termId;
                                                            $.get(route, function (res) {
                                                                if (res.length == 0) {
                                                                    $('#exam-select').find('option').remove();
                                                                    $('#exam-select').html("no record found");
                                                                } else {
                                                                    var str = '<option value="">Please Select Subject</option>';
                                                                    for (var i = 0; i < res.length; i++) {
                                                                        str += '<option value="' + res[i]['exam_id'] + '">' + res[i]['exam_name'] + '</option>';
                                                                    }
                                                                    $('#exam-select').html(str);
                                                                }
                                                            });
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        });

        $('#class-select').change(function(){
            var classId=this.value;
            var route = 'get-academicYear/' + classId;
            $.get(route, function (res) {
                if (res.length == 0) {
                    $('#academic-year').find('option').remove();
                    $('#subject-select').find('option').remove();
                    $('#term-select').find('option').remove();
                    $('#exam-select').find('option').remove();
                    $('#academic-year').html("no record found");
                } else {
                    var str = '<option value="">Please Select Academic Year</option>';
                    for (var i = 0; i < res.length; i++) {
                        str += '<option value="' + res[i]['year'] + '">' + res[i]['year'] + '</option>';
                    }
                    $('#academic-year').html(str);
                    $('#academic-year').prop('selectedIndex',res.length);
                    academicYear = $('#academic-year').val();
                    if(academicYear != null) {
                        var route = 'get-subjects/' + academicYear;
                        $.get(route, function (res) {
                            if (res['subject'].length == 0) {
                                $('#subject-select').find('option').remove();
                                $('#term-select').find('option').remove();
                                $('#exam-select').find('option').remove();
                                $('#subject-select').html("no record found");
                            } else {
                                var str = '<option value="">Please Select Subject</option>';
                                for (var i = 0; i < res['subject'].length; i++) {
                                    str += '<option value="' + res['subject'][i]['subject_id'] + '">' + res['subject'][i]['subject_name'] + '</option>';
                                }
                                $('#subject-select').html(str);
                                $('#subject-select').prop('selectedIndex',1);

                                var subId=$('#subject-select').val();
                                var academicYear=$('#academic-year').val();
                                if(subId != null && academicYear !=null) {
                                    var route = 'get-term/' + academicYear + '/' + subId;
                                    $.get(route, function (res) {
                                        if (res['term'].length == 0) {
                                            $('#term-select').find('option').remove();
                                            $('#exam-select').find('option').remove();
                                            $('#term-select').html("no record found");
                                        } else {
                                            var str1 = '<option value="">Please Select Term</option>';
                                            for (var i = 0; i < res['term'].length; i++) {
                                                str1 += '<option value="' + res['term'][i]['term_id'] + '">' + res['term'][i]['term_name'] + '</option>';
                                            }
                                            $('#term-select').html(str1);
                                            $('#term-select').prop('selectedIndex',1);
                                            var termId=$('#term-select').val();
                                            if(termId != null) {
                                                var route = 'get-exams/' + termId;
                                                $.get(route, function (res) {
                                                    if (res.length == 0) {
                                                        $('#exam-select').find('option').remove();
                                                        $('#exam-select').html("no record found");
                                                    } else {
                                                        var str = '<option value="">Please Select Subject</option>';
                                                        for (var i = 0; i < res.length; i++) {
                                                            str += '<option value="' + res[i]['exam_id'] + '">' + res[i]['exam_name'] + '</option>';
                                                        }
                                                        $('#exam-select').html(str);
                                                    }
                                                });
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
            $('#submit-button-div').hide();
            //$('#paper_marks').prop('value',0);
        });

        $('#academic-year').change(function(){
            var academicYear=this.value;
                var route = 'get-subjects/' + academicYear;
                $.get(route, function (res) {
                    if (res['subject'].length == 0) {
                        $('#subject-select').find('option').remove();
                        $('#term-select').find('option').remove();
                        $('#exam-select').find('option').remove();
                        $('#subject-select').html("no record found");
                    } else {
                        var str = '<option value="">Please Select Subject</option>';
                        for (var i = 0; i < res['subject'].length; i++) {
                            str += '<option value="' + res['subject'][i]['subject_id'] + '">' + res['subject'][i]['subject_name'] + '</option>';
                        }
                        $('#subject-select').html(str);
                        $('#subject-select').prop('selectedIndex',1);

                        var subId=$('#subject-select').val();
                        if(subId != null && academicYear !=null) {
                            var route = 'get-term/' + academicYear + '/' + subId;
                            $.get(route, function (res) {
                                if (res['term'].length == 0) {
                                    $('#term-select').find('option').remove();
                                    $('#exam-select').find('option').remove();
                                    $('#term-select').html("no record found");
                                } else {
                                    var str1 = '<option value="">Please Select Term</option>';
                                    for (var i = 0; i < res['term'].length; i++) {
                                        str1 += '<option value="' + res['term'][i]['term_id'] + '">' + res['term'][i]['term_name'] + '</option>';
                                    }
                                    $('#term-select').html(str1);
                                    $('#term-select').prop('selectedIndex',1);
                                    var termId=$('#term-select').val();
                                    if(termId != null) {
                                        var route = 'get-exams/' + termId;
                                        $.get(route, function (res) {
                                            if (res.length == 0) {
                                                $('#exam-select').find('option').remove();
                                                $('#exam-select').html("no record found");
                                            } else {
                                                var str = '<option value="">Please Select Subject</option>';
                                                for (var i = 0; i < res.length; i++) {
                                                    str += '<option value="' + res[i]['exam_id'] + '">' + res[i]['exam_name'] + '</option>';
                                                }
                                                $('#exam-select').html(str);
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }
                });
        });

        $('#subject-select').change(function(){
            var subId=this.value;
            var academicYear=$('#academic-year').val();
            var route = 'get-term/' + academicYear + '/' +subId;
            $.get(route, function (res) {
                if (res['term'].length == 0) {
                    $('#term-select').find('option').remove();
                    $('#exam-select').find('option').remove();
                    $('#term-select').html("no record found");
                } else {
                    var str1 = '<option value="">Please Select Term</option>';
                    for (var i = 0; i < res['term'].length; i++) {
                        str1 += '<option value="' + res['term'][i]['term_id'] + '">' + res['term'][i]['term_name'] + '</option>';
                    }
                    $('#term-select').html(str1);
                    $('#term-select').prop('selectedIndex',1);
                    var termId=$('#term-select').val();
                    if(termId != null) {
                        var route = 'get-exams/' + termId;
                        $.get(route, function (res) {
                            if (res.length == 0) {
                                $('#exam-select').find('option').remove();
                                $('#exam-select').html("no record found");
                            } else {
                                var str = '<option value="">Please Select Subject</option>';
                                for (var i = 0; i < res.length; i++) {
                                    str += '<option value="' + res[i]['exam_id'] + '">' + res[i]['exam_name'] + '</option>';
                                }
                                $('#exam-select').html(str);
                            }
                        });
                    }
                }
            });
        });

        $('#term-select').change(function(){
            var termId=this.value;
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

        $('#exam-select').change(function(){
            var examId=this.value;
            var route = 'get-exam-marks/' + examId;
            $.get(route, function (res) {
                if (res > 0) {
                    $('#paper_marks').val(res);
                }
            });
        });


        $('#paper_questions').keyup(function(){
            $('#submit-button-div').show();
            var questions=this.value;
            var str = '';
            for(var i=0; i<questions; i++)
            {   var divId = i;
                var qNo = i+1;
                str += '<div class="row">'+
                            '<div class="col-md-2" id="question-id-div">'+
                                '<label class="control-label">'+
                                    'Question Number'+'<span class="symbol required"></span>'+
                                '</label>'+
                                '<input type="text" class="form-control" id="question-id" name="question-id[]" placeholder="Question Number" required>'+
                            '</div>'+
                            '<div class="col-md-4" id="question-name-div">'+
                                '<label class="control-label">'+
                                    'Enter Question' +
                                '</label>'+
                                '<input type="text" class="form-control" id="question-name" name="question-name[]" placeholder="Enter Question">'+
                            '</div>'+
                            '<div class="col-md-1" id="question-marks-div">'+
                                '<label class="control-label">'+
                                    'Marks<span class="symbol required"></span>'+
                                '</label>'+
                                '<input type="text" class="form-control" id="question-marks" name="question-marks[]" placeholder="marks" required>'+
                            '</div>'+
                            '<div class="col-md-2" id="or-question-div" >'+
                                '<label class="control-label">'+
                                    'Or'+
                                '</label>'+

                                '<select class="form-control or-question" id="or-question" name="or-question['+divId+'][]" multiple>'+
                                    '<option>Select or</option>';
                                    for(var j=0; j<questions; j++) {
                                        if (i != j) {
                                            var k = j+1;
                                            str += '<option value="'+j+'">' + k + '</option>';
                                        }
                                    }
                                    str +=
                                '</select>'+
                            '</div>'+
                                    '<div class="col-md-2" id="sub-question-select-div" >'+
                                        '<label class="control-label">'+
                                            'Add Sub Questions'+
                                        '</label>'+
                                        '<input type="number" class="form-control" id="'+divId+'sub-questions" name="sub_questions" onchange="add('+divId+')" placeholder="No. of Questions">'+
                                    '</div>'+
                                '<div class="col-md-1">'+
                                '<span>'+qNo+'</span>'+
                                '</div>'+
                        '</div>'+
                            '<div id="'+divId+'subQuestion-div">'+

                            '</div>'+
                    '<br><br>'+'<hr style="border-color: black">';
                $('#question-structure').html(str);
            }

            var qSet = $('#paper_set').val();
            var clss = $('#class-select').attr('data-fullText');
            var paperName = $('#paper_name').val();
            var sub = $('#subject-select').val();
            var mark = $('#paper_marks').val();
            var str1 = '';
            if(qSet != null && clss != null && paperName != null && sub != null){
                str1 =
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
            var elementId = divId+'sub-questions';
            $('.'+elementId).remove();
            var subQuestionCount = $('#'+elementId+'').val();
            for(var i=0 ; i<subQuestionCount ; i++) {
                str = '<br class="'+elementId+'"><br class="'+elementId+'">' + '<div class="row '+elementId+'">' +
                    '<div class="col-md-1"></div>' +
                    '<div class="col-md-2" id="question-id-div">' +
                    '<label class="control-label">' +
                    "Question Number" + '<span class="symbol required"></span>' +
                    '</label>' +
                    '<input type="text" class="form-control" id="question-id" name="sub-question-id[' + divId + '][]" placeholder="Question Number" required>' +
                    '</div>' +
                    '<div class="col-md-4" id="question-name-div">' +
                    '<label class="control-label">' +
                    'Enter Question' +
                    '</label>' +
                    '<input type="text" class="form-control" id="question-name" name="sub-question-name[' + divId + '][]" placeholder="Enter Question">' +
                    '</div>' +
                    '<div class="col-md-2" id="question-marks-div">' +
                    '<label class="control-label">' +
                    'Marks<span class="symbol required"></span>' +
                    '</label>' +
                    '<input type="text" class="form-control" id="question-marks" name="sub-question-marks[' + divId + '][]" placeholder="marks" required>' +
                    '</div>' +
                    '<div class="col-md-2" id="or-question-div" >' +
                    '<label class="control-label">' +
                    'Or' +
                    '</label>' +
                    '<select class="form-control" id="or-question" name="sub-or-question[' + divId + ']['+i+'][]" multiple>' +
                    '<option>Select or</option>';
                    for(var j=0 ; j<subQuestionCount ; j++) {
                        if(i != j) {
                            var k = j+1;
                            str += '<option value="'+j+'">' + k + '</option>';
                        }
                    }
                    str += '</select>' +
                    '</div>' +
                    '</div>';
                    if((i+1) < subQuestionCount) {
                        str +='<hr class="'+elementId+'" style="border-color: blue">';
                    }
                $('#' + divId + 'subQuestion-div').append(str);
            }
        }

        $("#question-paper-pdf").on('change', function () {
            $('#submit-button').show();
            var pdfPath = $(this)[0].value;
            var extn = pdfPath.substring(pdfPath.lastIndexOf('.') + 1).toLowerCase();
            var size = this.files[0].size/1024/1024;
            if(size <= 2){
                if (extn == "pdf" || extn == "PDF") {
                    if (typeof (FileReader) == "undefined") {
                        alert("It doesn't supports");
                        $("#question-paper-pdf").val('');
                    }
                } else {
                    alert("Select Only pdf File");
                    $("#question-paper-pdf").val('');
                }
            }else{
                alert("please select pdf less than 2 mb");
                $("#question-paper-pdf").val('');
            }
        });

    </script>
@stop
