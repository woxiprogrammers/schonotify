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
                            <h1 class="mainTitle">Attendance</h1>
                        </div>
                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div>
                            <div class="panel panel-transparent">

                                <div class="panel-body">

                                    <div class="form-group col-sm-4">
                                        <label for="form-field-select-2">
                                            Select Batch
                                        </label>
                                        <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                                            <option value="1">morning</option>
                                            <option value="2">evening</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="class-select-div">
                                        <label for="form-field-select-2">
                                            Select Class
                                        </label>
                                        <select class="form-control" id="class-select" style="-webkit-appearance: menulist;">
                                            <option value="1">first</option>
                                            <option value="2">second</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="division-select-div">
                                        <label for="form-field-select-2">
                                            Select Division
                                        </label>
                                        <select class="form-control" id="division-select" style="-webkit-appearance: menulist;">
                                            <option value="1">A</option>
                                            <option value="2">B</option>
                                            <option value="3">C</option>
                                            <option value="4">D</option>
                                            <option value="5">E</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-8 col-sm-offset-2">
                            <div id='full-calendar'></div>
                        </div>

                    </div>
                </div>

                <div class="modal fade modal-aside horizontal right events-modal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog modal-sm">
                        <div class="modal-content">
                            <form class="form-full-event">
                                <div class="modal-body">
                                    <div class="form-group ">
                                        <h4>Attendance</h4>
                                    </div>
                                    <div class="form-group">
                                        <label>
                                            <h3><span class="label label-danger" id="today"></span></h3>
                                        </label>

                                    </div>
                                    <div class="form-group">
                                        <label class="text-bold">
                                            Students
                                        </label>
                                        <div id="stud-list"></div>
                                        <div>
                                            <table class="table">
                                                <tr>
                                                    <td><div class="col-sm-10"><label class="padding-left-5">Absent Students</label></div><div class=" absent-tag"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="col-sm-10"><label class="padding-left-5">Leave Applied</label></div><div class=" leave-applied-tag"></div></td>
                                                </tr>
                                                <tr>
                                                    <td><div class="col-sm-10"><label class="padding-left-5">Leave Approved</label></div><div class=" leave-approved-tag"></div></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-info btn-o pull-left" type="button" data-dismiss="modal">
                                        Cancel
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
<script src="vendor/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="vendor/moment/moment.min.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/fullcalendar/fullcalendar.min.js"></script>
<script src="vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/attendance-calender.js"></script>

<script>
    jQuery(document).ready(function() {
        Main.init();
        Calendar.init();
        $('.fc-agendaWeek-button').hide();
        $('.fc-agendaDay-button ').hide();
    });

</script>

@stop

