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
                                <h1 class="mainTitle">Exam Structure</h1>
                                <span class="mainDescription">Grades Entry</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="grade-create" role="form" id="gradeStructureForm">
                            <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-6" id="class-select-div" >
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Class<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Min Marks:<span class="symbol required"></span>
                                        </label>
                                        <input type="number" class="form-control" id="minMarks" name="min_marks" placeholder="Enter Minimum marks">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Max Marks:<span class="symbol required"></span>
                                        </label>
                                        <input type="number" class="form-control" id="maxMarks" name="max_marks" placeholder="Enter Maximum marks">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Grades:<span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="grades" name="grades" placeholder="Enter Grades">
                                    </div>
                                </div>
                                <div id="loadmoreajaxloaderClass" style="display:none;"></div>
                            </div>
                            <div class="row">
                                <button class="btn btn-primary btn-wide" type="submit" id="gradeCreate" value="submit" >
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
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
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
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/exam-form-validation.js"></script>


    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormValidator.init();
        });
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
            $('#loadmoreajaxloaderClass').show();
            $.get(route,function(res){
                $('#loadmoreajaxloaderClass').hide();
            });
        });
        $('#gradeCreate').on('click', function() {
            $('#gradeStructureForm').attr('action', "/exam/grade-create");
            $('#gradeStructureForm').submit();
            $(this).prop('disabled', true);
            setTimeout(function () {
                location.reload()
            }, 550);
        });
    </script>
@stop