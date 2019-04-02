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
                                <h1 class="mainTitle">Exam</h1>
                                <span class="mainDescription">Edit Exam</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/exam-evaluation/edit-paper/{{$paperData['id']}}" role="form">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-3" id="set-select-div" >
                                        <label class="control-label">
                                            Enter Paper Set<span class="symbol required"></span>
                                        </label>
                                        <input type="text" name="paper_set" id="paper_set" value="{{$paperData['set_name']}}" placeholder="Enter set" required>
                                    </div>
                                    <div class="col-md-4" id="question-paper-name" >
                                        <label class="control-label">
                                            Enter Question Paper Name <span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="paper_name" name="paper_name" value="{{$paperData['question_paper_name']}}" placeholder="Question paper name" required>
                                        </input>
                                    </div>
                                    <div class="col-md-2" id="total-marks-div" >
                                        <label class="control-label">
                                            Enter Total Marks <span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="paper_marks" name="paper_marks" value="{{$paperData['marks']}}" placeholder="marks" required>
                                        </input>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="row">
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary btn-wide" type="submit">
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
    </script>
@stop