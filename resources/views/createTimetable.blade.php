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
            <section id="page-title" class="padding-top-15 padding-bottom-15">
                <div class="row">
                    <div class="col-sm-7">
                        <h1 class="mainTitle">Timetable</h1>
                        <span class="mainDescription">Create</span>
                    </div>
                    <div class="col-sm-5">
                        <!-- start: MINI STATS WITH SPARKLINE -->

                        <!-- end: MINI STATS WITH SPARKLINE -->
                    </div>
                </div>
            </section>
            <!-- end: DASHBOARD TITLE -->


            <div class="container-fluid container-fullw bg-white">
                <div class="row">

                    @include('selectClassDivisionDropdown')

                    <div class="row">
                        <div class="col-sm-12">
                            <form action="#" role="form" id="form2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Batch <span class="symbol required"></span>
                                            </label>
                                            <select class="form-control" id="dropdown" name="dropdown">
                                                <option value="">Select Days</option>
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tuesday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">
                                                Enter class name <span class="symbol required"></span>
                                            </label>
                                            <input type="text" placeholder="Insert new class name" class="form-control" id="class" name="class">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                Create <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>

                            </form>
                        </div>

                    </div>

                </div>

            </div>

            <!-- start: FOURTH SECTION -->
            @include('rightSidebar')
            <!-- end: FOURTH SECTION -->
        </div>
    </div>
</div>

@include('footer')

<!-- start: MAIN JAVASCRIPTS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->

<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
    <script src="vendor/ckeditor/ckeditor.js"></script>
    <script src="vendor/ckeditor/adapters/jquery.js"></script>

    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>

    <script src="assets/js/form-validation.js"></script>

<script>
    $(document).ready(function(){
        Main.init();
        FormValidator.init();

    });

    $('#batch-select').attr('disabled',true);

    $('#class-select').attr('disabled',true);

    $('#division-select>option:eq(2)').prop('selected',true);

    $('#division-select').attr('disabled',true);

</script>

</div>
@stop

