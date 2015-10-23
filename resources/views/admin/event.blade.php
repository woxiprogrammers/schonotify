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
                            <h1 class="mainTitle">Search</h1>
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-sm-12 space20">
                            <a href="#newFullEvent" class="btn btn-primary btn-o add-event"><i class="fa fa-plus"></i> Add New Event</a>
                        </div>
                        <div class="col-sm-12">
                            <div id='full-calendar'></div>
                        </div>

                    </div>
                </div>

                <div class="modal fade modal-aside horizontal right events-modal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog modal-sm">
                        <div class="modal-content">
                            <form class="form-full-event">
                                <div class="modal-body">
                                    <div class="form-group hidden">
                                        <label>
                                            ID
                                        </label>
                                        <input type="text" id="event-id">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Event Title
                                        </label>
                                        <input type="text" id="event-name" style="background-color: #fff !important;" placeholder="Enter title" class="form-control underline text-large" name="eventName">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Start
                                        </label>
												<span class="input-icon">
													<input type="text" id="start-date-time" style="background-color: #fff !important;"  class="form-control underline" name="eventStartDate"/>
													<i class="ti-calendar"></i> </span>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            End
                                        </label>
												<span class="input-icon">
													<input type="text" id="end-date-time" style="background-color: #fff !important;"  class="form-control underline" name="eventEndDate" />
													<i class="ti-calendar"></i> </span>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Select Users Type
                                        </label>
                                        <div class="row">
                                        <div class="col-xs-6">
                                            <div class="checkbox clip-check check-primary">
                                                <input type="checkbox" id="checkbox1" name="roles">
                                                <label for="checkbox1">
                                                    Admin
                                                </label>
                                            </div>
                                            <div class="checkbox clip-check check-primary">
                                                <input type="checkbox" id="checkbox2" name="roles">
                                                <label for="checkbox2">
                                                    Teacher
                                                </label>
                                            </div>
                                        </div>
                                            <div class="col-xs-6">
                                                <div class="checkbox clip-check check-primary">
                                                    <input type="checkbox" id="checkbox3" name="roles">
                                                    <label for="checkbox3">
                                                        Student
                                                    </label>
                                                </div>
                                                <div class="checkbox clip-check check-primary">
                                                    <input type="checkbox" id="checkbox4" name="roles">
                                                    <label for="checkbox4">
                                                        Parent
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger btn-o delete-event">
                                        Delete
                                    </button>
                                    <button class="btn btn-primary btn-o save-event" type="submit">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @include('footer')

    @include('rightSidebar')


</div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="vendor/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
    <script src="vendor/moment/moment.min.js"></script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="vendor/fullcalendar/fullcalendar.min.js"></script>
    <script src="vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="assets/js/main.js"></script>
    <!-- start: JavaScript Event Handlers for this page -->
    <script src="assets/js/pages-calendar.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            Calendar.init();
        });
    </script>


<!-- start: MAIN JAVASCRIPTS -->

@stop

