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
                            <h1 class="mainTitle">Events</h1>
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
                    <div class="modal-dialog modal-dialog modal-md">
                        <div class="modal-content">
                            <form class="form-full-event" id="form">
                                <div class="modal-body">
                                    <div id="editEvent">
                                        <div class="form-group ">
                                            <div id="error-div"></div>
                                            <h4>Event</h4>

                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Event Title
                                            </label>
                                            <input type="text" id="event-name" style="background-color: #fff !important;" placeholder="Enter title" class="form-control underline text-large" name="eventName">
                                        </div>
                                        <div class="form-group">
                                            <label>
                                                Event Details
                                            </label>
                                            <textarea class="form-control" id="event-name" name="eventDescription"></textarea>
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
                                                Select Image
                                            </label>
                                            <div id="imageUploader">
                                                <input class="form-control" type="file" name="image" id="img-file">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="showEvent">

                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <div class="timeline_title">

                                                    <h4 class="panel-title no-margin text-primary" id="event-title"></h4>

                                                </div>
                                                <div class="panel-tools">
                                                    <i class="fa fa-clock-o"></i> Wednesday 12 Nov, 2015 12:00 PM
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <p id="event-description">

                                                </p>
                                                <address>
                                                    Event Start: <em class="text-bold" id="event-start-time"></em>
                                                    <br>
                                                    Event End: <em class="text-bold" id="event-end-time"></em>
                                                </address>
                                                <img class="thumbnail" src="assets/images/picture.svg" onerror="this.onerror=null;this.width='200';this.src='assets/images/picture.svg'; " width="200">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    @foreach(session('functionArr') as $row)
                                    @if($row == 'publish_event')
                                    <button class="btn btn-info btn-o delete-event pull-left" onclick="confirm('Are you sure to publish this event?')">
                                        Publish
                                    </button>
                                    @endif
                                    @endforeach
                                    <button class="btn btn-info btn-o pull-left" type="button" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    @foreach(session('functionArr') as $row)
                                    @if($row == 'delete_event')
                                    <button class="btn btn-danger btn-o delete-event" id="delBtn">
                                        Delete
                                    </button>
                                    @endif
                                    @endforeach
                                    @foreach(session('functionArr') as $row)
                                    @if($row == 'create_event')
                                    <button class="btn btn-primary btn-o save-event" type="submit" id="upload">
                                        Save
                                    </button>
                                    @endif
                                    @endforeach
                                    @foreach(session('functionArr') as $row)
                                    @if($row == 'update_event')
                                    <a class="btn btn-primary btn-o edit-event" id="editEventBtn">
                                        Edit
                                    </a>
                                    @endif
                                    @endforeach
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
<script src="assets/js/custom-project.js"></script>



<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        Calendar.init();
    });

    $('#form').on('submit',function(e){
        e.preventDefault();

        var file=$(this);

        uploadImage(file);
    });

    function uploadImage(file)
    {
        var formData=new FormData(file[0]);

        $.ajax({
            url:'save-event',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                console.log(data);
            },
            error: function(data){
                // Error...
                var errors = $.parseJSON(data.responseText);


                errorsHtml = '<div class="alert alert-danger"><ul>';

                $.each( errors, function( key, value ) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></di>';

                $('#error-div').html(errorsHtml);
            }

        });

    }

    $('#editEventBtn').click(function(){
        $('.save-event').show();
        $('#delBtn').show();
        $('.edit-event').hide();
        $('#showEvent').hide();
        $('#editEvent').show();
    });

</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop

