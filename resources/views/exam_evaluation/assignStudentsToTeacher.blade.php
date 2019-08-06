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
                                <h1 class="mainTitle">Assign</h1>
                                <span class="mainDescription">Assign Students to Teacher</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/exam-evaluation/assign-students" role="form" id="examCreateForm">
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
                                    <div class="col-md-4" id="class-select-div" >
                                        <label class="control-label">
                                            Select Department <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="DivSearch">
                                        <div class="form-group" id="DivisionBlock">
                                            <label class="control-label">
                                                Semester
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
                                <div class="row" id="exam-teacher-div">
                                    <div class="col-md-4" id="exam-select-div" >
                                        <label class="control-label">
                                            Select Exam <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="exam-select" name="exam_select" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="teacher-select-div" >
                                        <label class="control-label">
                                            Select Teacher<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="teacher-select" name="teacher_select" style="-webkit-appearance: menulist;" required>
                                        </select>
                                    </div>
                                    <div class="col-md-4" id="role-select-div" >
                                        <label class="control-label">
                                            Select Role<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="role-select" name="role_select" style="-webkit-appearance: menulist;" required>
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
    <script src="/assets/js/table-data.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
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
            $('#submit-button').hide();
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
                        var str = '<option>Please Select Department</option>';
                        for (var i = 0; i < res.length; i++) {
                            str += '<option value="' + res[i]['class_id'] + '">' + res[i]['class_name'] + '</option>';
                        }
                        $('#class-select').html(str);
                        $('#class-select').prop('selectedIndex', 1);
                        $('#loadmoreajaxloaderClass').hide();
                        var classId=$('#class-select').val();
                        if(classId != null) {
                            var route='/get-all-division/'+classId;
                            $.get(route,function(res){
                                if (res.length == 0)
                                {
                                    $('#div-select').html("no record found");
                                } else {
                                    var str='<option value="">Please select Semester</option>';
                                    for(var i=0; i<res.length; i++)
                                    {
                                        str+='<option value="'+res[i]['division_id']+'">'+res[i]['division_name']+'</option>';
                                    }
                                    $('#div-select').html(str);
                                    $('#div-select').prop('selectedIndex', 1);
                                }
                            });

                            var route1 = 'get-academicYear/' + classId;
                            $.get(route1, function (res) {
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
                                                                        var str = '<option value="">Please Select Exam</option>';
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
                    }
                });
            }
        });

        $('#batchDrpdn').change(function(){
            var id=this.value;
            var route='/get-all-classes/'+id;
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#class-select').find('option').remove();
                    $('#academic-year').find('option').remove();
                    $('#subject-select').find('option').remove();
                    $('#term-select').find('option').remove();
                    $('#exam-select').find('option').remove();
                    $('#div-select').find('option').remove();
                    $('#class-select').html("no record found");
                } else {
                    var str='<option value="">Please Select Class</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                    }
                    $('#class-select').html(str);
                    $('#class-select').prop('selectedIndex', 1);
                    var classId=$('#class-select').val();
                    if(classId != null) {
                        var route='/get-all-division/'+classId;
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
                                $('#div-select').prop('selectedIndex', 1);
                            }
                        });

                        var route1 = 'get-academicYear/' + classId;
                        $.get(route1, function (res) {
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
                                                                    var str = '<option value="">Please Select Exam</option>';
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
            var id=this.value;
            $('#submit-button').hide();
            $('#tableContent').hide();
            var route='/get-all-division/'+id;
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#div-select').find('option').remove();
                    $('#div-select').html("no record found");
                } else {
                    var str='<option value="">Please select division</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['division_id']+'">'+res[i]['division_name']+'</option>';
                    }
                    $('#div-select').html(str);
                    $('#div-select').prop('selectedIndex', 1);
                }
            });

            var classId=this.value;
            var route1 = 'get-academicYear/' + classId;
            $.get(route1, function (res) {
                if (res.length == 0) {
                    $('#academic-year').find('option').remove();
                    $('#subject-select').find('option').remove();
                    $('#term-select').find('option').remove();
                    $('#exam-select').find('option').remove();
                    $('#exam-select').html("no record found");
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
        });

        $('#academic-year').change(function(){
            var academicYear=this.value;
            $("#tableContent").hide();
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
                                            var str = '<option value="">Please Select Exam</option>';
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
            $("#tableContent").hide();
        });

        $('#term-select').change(function(){
            var termId=this.value;
            $('#exam-select').prop('selectedIndex',0);
            $("#tableContent").hide();
            var route = 'get-exams/' + termId;
            $.get(route, function (res) {
                if (res.length == 0) {
                    $('#exam-select').html("no record found");
                } else {
                    var str = '<option value="">Please Select Exam</option>';
                    for (var i = 0; i < res.length; i++) {
                        str += '<option value="' + res[i]['exam_id'] + '">' + res[i]['exam_name'] + '</option>';
                    }
                    $('#exam-select').html(str);
                }
            });
        });

        $('#exam-select').change(function(){
            var id=$('#class-select').val();
            var route='get-teachers/'+id;
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#div-select').html("no record found");
                } else {
                    var str='<option value="">Please select teacher</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['teacher_id']+'">'+res[i]['name']+'</option>';
                    }
                    $('#teacher-select').html(str);
                }
            });
        });

        $('#role-select').change(function(){
            var division= $('#div-select').val();
            var subject= $('#subject-select').val();
            var teacher= $('#teacher-select').val();
            var exam= $('#exam-select').val();
            var role= this.value;
            if(subject != "" && teacher != "" && exam != "" && division != "") {
                $('div#loadmoreajaxloader').show();
                var route = 'searchStudent';
                $.ajax({
                    method: "get",
                    url: route,
                    data: {division, subject, teacher, exam, role}
                })
                    .done(function (res) {
                        $('div#loadmoreajaxloader').hide();
                        $("#tableContent").show();
                        $("#tableContent").html(res);
                        TableData.init();
                        $('#submit-button').show();
                    })
            }
        });

        $('#div-select').change(function(){
            $('#role-select').prop('selectedIndex',0);
            $("#tableContent").hide();
        });


        $('#subject-select').change(function(){
            $('#role-select').prop('selectedIndex',0);
            $('#teacher-select').prop('selectedIndex',0);
            $("#tableContent").hide();
        });

        $('#teacher-select').change(function(){
            $('#role-select').prop('selectedIndex',0);
            $("#tableContent").hide();
        });

        function checkAll() {
            if($('#check_all').prop('checked') == true) {
                $('.assign-student').prop("checked", true);
            } else {
                $('.assign-student').prop("checked", false);
            }
        }
    </script>
@stop
