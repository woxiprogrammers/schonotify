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
                                            <h4 class="panel-title no-margin text-primary" style="padding: 14px;">Applying leave for two days</h4>
                                            <h5 style=" background-color: rgb(0, 122, 255);color: #fff;padding: 10px;">
                                                <strong>Student Name:</strong>
                                                    <i> Aadarsh Varma</i>
                                                <small class="label label-sm label-white">Roll No. : 202</small>

                                                    <p class="pull-right">
                                                        <strong>Batch :</strong> <i>Morning</i>
                                                        <strong>Class :</strong> <i>Fourth </i>
                                                        <strong>Div : </strong> <i> A</i>
                                                    </p>
                                            </h5>
                                        </div>
                                        <div class="panel-tools">
                                            <i class="fa fa-clock-o"></i> Wednesday 12 Nov, 2015 12:00 PM
                                            <a data-original-title="Refresh" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-refresh" href="#"><i class="ti-reload"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="panel-scroll height-280 ps-container ps-active-y">


                                            <h4>Description:</h4>
                                            Due to my official work we are decided to move my native for 2 days. so, I am applying this leave for my son Sumit studying in forth standard A division.

                                            <br>
                                            <br>

                                            <address>
                                                <span class="text-bold">Leave From:</span> 12 Nov, 2015 12:00 PM
                                                <br>
                                                <span class="text-bold">Leave To:</span> 14 Nov, 2015 6:00 PM
                                            </address>

                                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 82px;"></div></div></div>
                                    </div>
                                    <div class="panel-footer col-sm-12">

                                        Applicant :<h4>Mr. Naveen Sharma </h4>

                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-wide pull-right panel-refresh" type="button" id="btnPublish">
                                                <i class="fa fa-cloud-upload"></i> Approve
                                            </button>
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
<script>
    jQuery(document).ready(function() {
        Main.init();

        $('#btnStatus').html('<h5> Status :<i class="fa fa-warning"></i> <i>Pending</i></h5>');

    });


    $('#btnPublish').click(function(){
        $('#btnPublish').hide();
        $('#btnStatus').html('<h5> Status :<i class="fa fa-flag"></i> <i>Approved</i></h5>');
    });



</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop