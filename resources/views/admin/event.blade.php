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
                        <div class="col-sm-9">
                            <div id='full-calendar'></div>
                        </div>
                        <div class="col-sm-3">
                            <h4 class="space20">Draggable categories</h4>
                            <div id="event-categories">
                                <div class="event-category event-generic" data-class="generic">
                                    Generic
                                </div>
                                <div class="event-category event-home" data-class="home">
                                    Home
                                </div>
                                <div class="event-category event-job" data-class="job">
                                    Job
                                </div>
                                <div class="event-category event-off-site-work" data-class="off-site-work">
                                    Off-site work
                                </div>
                                <div class="event-category event-to-do" data-class="to-do">
                                    To Do
                                </div>
                                <div class="event-category event-cancelled" data-class="cancelled">
                                    Cancelled
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="grey" id="drop-remove" />
                                        Remove after drop
                                    </label>
                                </div>
                            </div>
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
                                        <input type="text" id="event-name" placeholder="Enter title" class="form-control underline text-large" name="eventName">
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Start
                                        </label>
												<span class="input-icon">
													<input type="text" id="start-date-time" class="form-control underline" name="eventStartDate"/>
													<i class="ti-calendar"></i> </span>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            End
                                        </label>
												<span class="input-icon">
													<input type="text" id="end-date-time" class="form-control underline" name="eventEndDate" />
													<i class="ti-calendar"></i> </span>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            Category
                                        </label>
                                        <div class="row">
                                        <div class="col-xs-6">
                                            <div class="checkbox clip-check check-primary check-inline">
                                                <input type="checkbox" id="checkbox1" >
                                                <label for="cancelled">
                                                    <span class="fa fa-circle text-yellow"></span> Admin
                                                </label>
                                            </div>
                                            <div class="checkbox clip-check check-primary check-inline">
                                                <input type="checkbox" id="checkbox2">
                                                <label for="generic">
                                                    <span class="fa fa-circle text-info"></span> Teacher
                                                </label>
                                            </div>
                                        </div>
                                            <div class="col-xs-6">
                                                <div class="checkbox clip-check check-primary check-inline">
                                                    <input type="checkbox" id="checkbox3" >
                                                    <label for="cancelled">
                                                        <span class="fa fa-circle text-yellow"></span> Student
                                                    </label>
                                                </div>
                                                <div class="checkbox clip-check check-primary check-inline">
                                                    <input type="checkbox" id="checkbox4" >
                                                    <label for="generic">
                                                        <span class="fa fa-circle text-info"></span> Parent
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

