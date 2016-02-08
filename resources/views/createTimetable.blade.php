@extends('master')

@section('content')

<div id="app">

        @include('sidebar')

        <div class="app-content">

            @include('header')

            <div class="main-content" >
                <div class="wrap-content container" id="container">

                    @include('alerts.errors')

                    <div id="message-error-div"></div>

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

                    <div class="container-fluid container-fullw bg-white">

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="panel panel-transparent">

                                    <div class="panel-body">

                                        <label>Create Timetable For :</label>

                                        @foreach($divisions as $division)
                                            <span class="lato-font">Batch : {!! $division->batch_name !!}   Class : {!! $division->class_name !!}  Division : {!! $division->division_name !!}
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="row">

                                <div class="col-sm-12">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="errorHandler alert alert-danger no-display">
                                                    <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                                </div>
                                                <div class="successHandler alert alert-success no-display">
                                                    <i class="fa fa-ok"></i> Your form validation is successful!
                                                </div>
                                            </div>

                                            <div class="col-md-12">

                                                <form role="form" id="createStructureForm">

                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">
                                                            Day <span class="symbol required"></span>
                                                        </label>
                                                        <select class="form-control" id="dropdown" name="dropdown" style="-webkit-appearance: menulist;">
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

                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">
                                                            Number of periods: <span class="symbol required"></span>
                                                        </label>
                                                        <input type="number" min="0" max="55" class="form-control" id="periods" name="periods">
                                                    </div>

                                                    <div class="col-md-3">
                                                        <button class="btn" style="margin:22px 0px 0px 0px;" type="submit" id="structure-create">
                                                            Create <i class="fa fa-arrow-circle-right"></i>
                                                        </button>
                                                    </div>

                                                </form>

                                            </div>

                                            <div class="row">
                                        <div class="col-md-12">
                                            <div class="errorHandler alert alert-danger no-display">
                                                <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                            </div>
                                            <div class="successHandler alert alert-success no-display">
                                                <i class="fa fa-ok"></i> Your form validation is successful!
                                            </div>

                                            <div class="col-md-12">

                                                <div class="col-md-12" id="main-div-periods">
                                                   <form role="form" id="createTimetableForm">

                                                        <div id="periods-rows"></div>
                                                        <div class="col-md-3" id="periods-structure-save-btn">
                                                            <button class="btn btn-primary" style="margin:22px 0px 0px 0px;" type="button">
                                                                Create <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                        </div>

                                </div>

                            </div>

                        </div>
                    </div>

                    @include('rightSidebar')

                </div>

            </div>

        </div>

        @include('footer')

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/autosize/autosize.min.js"></script>
    <script src="vendor/selectFx/classie.js"></script>
    <script src="vendor/selectFx/selectFx.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="vendor/ckeditor/ckeditor.js"></script>
    <script src="vendor/ckeditor/adapters/jquery.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="assets/js/form-validation.js"></script>
    <script src="assets/js/form-elements.js"></script>
    <script src="assets/js/custom-project.js"></script>

    <script>
        $(document).ready(function(){
            getMsgCount();
            Main.init();
            FormValidator.init();

            $('#periods-structure-save-btn').hide();

            $('#main-div-periods').hide();

            });

    </script>

</div>
@stop

