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
                                <span class="mainDescription">Listing</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="structure-create" role="form" id="examStructureForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Batch <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="batchDrpdn" style="-webkit-appearance: menulist;">
                                            <option>Select Batch</option>
                                            @foreach($batches as $batch)
                                                <option value="{!! $batch['id'] !!}">{!! $batch['name'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Class <span class="symbol required"></span>
                                        </label>
                                        <div id="classesDropdown">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Subject <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="batchDrpdn" name="select_subject" style="-webkit-appearance: menulist;">
                                            <option value="">Select Subject</option>
                                            @foreach($examSubjects as $examSubject)
                                                <option value="{!! $examSubject['id'] !!}">{!! $examSubject['subject_name'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-wide" type="submit">
                                Create <i class="fa fa-arrow-circle-right"></i>
                            </button>
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
            $('#extra').hide();
            $('#abc').hide();
            $('#batchDrpdn').change(function(){
                var str = this.value;
                $.ajax({
                    method: "get",
                    url: "/exam/get-classes/"+str,
                    success: function(response)
                    {
                        $("#classesDropdown").html(response);
                    }
                });
            });
        });

    </script>
@stop