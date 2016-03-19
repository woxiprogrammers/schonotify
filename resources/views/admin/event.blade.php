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

                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">Events</h1>
                        </div>
                    </div>
                </section>

                <div id="message-error-div"></div>
                <!-- end: DASHBOARD TITLE -->
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-sm-2 space20">
                            <a href="#newFullEvent" class="btn btn-primary btn-o add-event padding-10"><i class="fa fa-plus"></i> Add New Event</a>
                        </div>

                        <select class="col-sm-4 padding-10" id="event-select-dropdown" style="-webkit-appearance: menulist;">
                            <option value="1" @if($eventSelectionId == 1) selected @endif >All</option>
                            <option value="2" @if($eventSelectionId == 2) selected @endif>Pending</option>
                            <option value="3" @if($eventSelectionId == 3) selected @endif>Published</option>
                        </select>
                        <div class="col-sm-5 pull-right">
                            <div class="event-category col-sm-3 event-to-do" >
                                Draft
                            </div>
                            <div class="event-category col-sm-3 event-off-site-work" >
                                Pending
                            </div>
                            <div class="event-category col-sm-3 event-job" >
                                Published
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <input type="hidden" id="hiddenUserRole" value="{!! Auth::User()->role_id !!}">
                            <div id='full-calendar'>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="modal fade modal-aside horizontal right events-modal"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog modal-md">
                        <div class="modal-content">
                            <form class="form-full-event" id="create_event_form">
                                <input type="hidden" name="hiddenEventId" id="hiddenEventId">
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
                                            <textarea class="form-control" id="event-description" name="eventDescription"></textarea>
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
                                            <div class="editImageDiv">
                                                <div class=" col-sm-2 img-event-align-div" id="field-name-image"></div>
                                                <div class="col-sm-5">
                                                    <h5 id="img-title" class="text-bold padding-top-30"></h5>
                                                </div>
                                                <div class="col-sm-5">
                                                    <button type="button" class="btn btn-primary btn-red pull-left margin-top-20" id="removeBatch" onclick="deleteEventImage()"><i class="glyphicon glyphicon-trash"></i></button>
                                                </div>
                                            </div>
                                            <div id="imageUploader">
                                                <input class="form-control" type="file" name="image" id="img-file">
                                            </div>
                                            <input type="hidden" id="isNewImage" name="isNewImage">

                                        </div>

                                    </div>
                                    <div id="showEvent">
                                        <div id="error-div-edit"></div>
                                        <div class="panel panel-white">
                                            <div class="panel-heading">
                                                <div class="timeline_title">

                                                    <div class="col-sm-9">
                                                        <h4 class="panel-title no-margin text-primary" id="event-title"></h4>
                                                    </div>
                                                    <div class="panel-tools col-sm-3">
                                                        <div id="status-show" class="col-sm-4"></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <em class="text-bold">Created by </em><em class="text-bold" id="event-created-by"></em> <em class="text-bold"> on <span id="created_time"></span></em>
                                                </div>
                                            </div>


                                            <div class="panel-body">
                                                <div class="col-sm-12">
                                                    <textarea id="event-detail" readonly class="col-sm-12" style="min-height:180px">

                                                    </textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <address>
                                                        Event Start: <em class="text-bold" id="event-start-time"></em>
                                                        <br>
                                                        Event End: <em class="text-bold" id="event-end-time"></em>
                                                    </address>
                                                </div>

                                                <div class="col-sm-12">
                                                    <img class="thumbnail" id="event-image"  width="200">
                                                </div>

                                                <div class="col-sm-12">

                                                    <span id="published-by-div">
                                                        <em class="text-bold">Published by</em> <em class="text-bold" id="event-published-by"></em>
                                                    </span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">

                                    <input class="btn btn-info btn-o pull-left" type="submit" value="Publish" id="publishBtn">

                                    <button class="btn btn-info btn-o pull-left" type="button" data-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button class="btn btn-danger btn-o delete-event" id="delBtn">
                                        Delete
                                    </button>

                                    <input class="btn btn-primary btn-o save-event" type="submit" value="Save" id="upload">

                                    <input class="btn btn-primary btn-o save-edit-event" type="submit" value="Update" id="saveEdit">

                                    <a class="btn btn-primary btn-o edit-event" id="editEventBtn">
                                        Edit
                                    </a>

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

<div id="loadmoreajaxloader" class="loader-position-event" ><center><img src="/assets/images/loader1.gif" /></center></div>

<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
<script src="/vendor/moment/moment.min.js"></script>
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/vendor/fullcalendar/fullcalendar.min.js"></script>
<script src="/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="/assets/js/pages-calendar.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<script src="/assets/js/form-validation.js"></script>


<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        Calendar.init();
    });

    $('#event-select-dropdown').change(function(){
        var val=$('#event-select-dropdown').val();

        window.location.href="/event/"+val;
    });

    $('#delBtn').click(function(){

        var val=$('#hiddenEventId').val();

        $.ajax({
            url:'/delete-event/'+val,
            processData: false,
            contentType: false,
            type: 'GET',
            success: function(res){

                if(res == 1){

                    window.location.href="/event/1";

                    $('.events-modal').modal('hide');

                }else{
                    var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                        '<span area-hidden="true">&times;</span>'+
                        '</button>'+
                        "Currently you do not have permission to access this functionality. Please contact administrator to grant you access !"+
                        "</div>";
                    $('#error-div-edit').show();
                    $('#error-div-edit').html(str);
                }

            }

        });

    });

    $('#editEventBtn').click(function(){

        $.ajax({
            url:'/check-acl-edit-event',
            processData: false,
            contentType: false,
            type: 'GET',
            success: function(res){

                if(res==1){
                    $('.save-event').hide();
                    $('#delBtn').show();
                    $('.edit-event').hide();
                    $('#showEvent').hide();
                    $('.save-edit-event').show();
                    $('#editEvent').show();
                    $('#error-div-edit').html("");
                    $('#error-div-edit').hide();
                }else{
                    var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                        '<span area-hidden="true">&times;</span>'+
                    '</button>'+
                    "Currently you do not have permission to access this functionality. Please contact administrator to grant you access !"+
                "</div>";
                    $('#error-div-edit').show();
                    $('#error-div-edit').html(str);
                }

            }

        });

    });



    function deleteEventImage()
    {
        $('.editImageDiv').hide();
        $('#isNewImage').val(2); //status value of isNewImage is  0 : no new image 1: new image 2:deleted image
        $('#img-file').attr('disabled',false);
    }

</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop

