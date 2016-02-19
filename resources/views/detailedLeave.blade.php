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
                        <h1 class="mainTitle">Leave</h1>
                    </div>
                </div>
            </section>
            <!-- end: DASHBOARD TITLE -->
            <div class="container-fluid container-fullw bg-white">
                <div class="row">
                        <div class="col-sm-12" id="detail">
                                <div class="panel panel-white load1" id="panel6">
                                    <div class="panel-heading">
                                        <div class="timeline_title">
                                            <i class="fa fa-pencil-square-o fa-2x pull-left fa-border"></i>
                                            <h4 class="panel-title no-margin text-primary" style="padding: 14px;">{!! $leaveArray['title'] !!}</h4>
                                            <h5 style=" background-color: rgb(0, 122, 255);color: #fff;padding: 10px;">
                                                <strong>Student Name:</strong>
                                                    <i> {!! $leaveArray['student'] !!}</i>
                                                <small class="label label-sm label-white">Roll No. : {!! $leaveArray['roll_number'] !!}</small>
                                                    <p class="pull-right">
                                                        <strong>Batch :</strong> <i>{!! $leaveArray['batch_name'] !!}</i>
                                                        <strong>Class :</strong> <i>{!! $leaveArray['class_name'] !!} </i>
                                                        <strong>Div : </strong> <i> {!! $leaveArray['division_name'] !!}</i>
                                                    </p>
                                            </h5>
                                        </div>
                                        <div class="panel-tools">
                                            <i class="fa fa-clock-o"></i>{!! $leaveArray['created_date'] !!}
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="panel-scroll height-280 ps-container ps-active-y">
                                            <h4>Description:</h4>
                                            <textarea class="form-control col-sm-8" id="description" name="description" style="min-height: 180px; margin-bottom: 8px;" readonly="yes" >{!! $leaveArray['reason'] !!}</textarea>
                                            <br>
                                            <br>
                                            <address>
                                                <span class="text-bold">Leave From:</span>{!! $leaveArray['from_date'] !!}
                                                <br>
                                                <span class="text-bold">Leave To:</span> {!! $leaveArray['end_date'] !!}
                                                <br>
                                                <span class="text-bold">Leave Type:</span> {!! $leaveArray['leave_type'] !!}
                                            </address>
                                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 82px;"></div></div></div>
                                    </div>
                                    <div class="panel-footer col-sm-12">
                                        Applicant :<h4>{!! $leaveArray['parent'] !!} </h4>
                                        <div class="col-md-12">
                                            @if($leaveArray['leave_status'] == 1)
                                            <a href="/publish-leave/{!! $leaveArray['leave_id'] !!}" class="btn btn-primary btn-wide pull-right" type="submit" id="btnPublish" name="btnPublish" >
                                                <i class="fa fa-cloud-upload"></i> Approve
                                            </a>
                                            @endif
                                        </div>
                                        <div class="col-md-12" id="btnStatus">
                                        </div>
                                    </div>
                                </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('footer')

@include('rightSidebar')
</div>
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
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();

        $('#btnStatus').html('<h5> Status :<i class="fa fa-warning"></i> <i>Pending</i></h5>');

    });
    $('#btnPublish').click(function(){
        $('#btnPublish').hide();
        $('#btnStatus').html('<h5> Status :<i class="fa fa-flag"></i> <i>Approved</i></h5>');
    });
</script>
<!-- start: MAIN JAVASCRIPTS -->
@stop