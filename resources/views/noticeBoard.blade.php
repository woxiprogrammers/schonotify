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
                    <h1 class="mainTitle">Notice Board</h1>
                </div>
                <div class="col-sm-5">
                    <!-- start: MINI STATS WITH SPARKLINE -->
                    <ul class="mini-stats pull-right">
                        <li>
                            <div style="width:20px;height: 20px; background: deepskyblue; float:left;"></div><label style="padding:4px;">Announcement</label>
                        </li>
                        <li>
                            <div style="width:20px;height: 20px; background: purple; float: left;"></div> <label style="padding:4px;">Achievement</label>
                        </li>

                    </ul>
                    <!-- end: MINI STATS WITH SPARKLINE -->
                </div>
            </div>
        </section>
        <!-- end: DASHBOARD TITLE -->
        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-md-12">
                    <div id="timeline">
                        <div class="timeline">
                            <div class="spine"></div>
                            <div class="date_separator" id="november">
                                <span>NOVEMBER 2014</span>
                            </div>
                            <ul class="columns">
                                <li>
                                    <div class="timeline_element partition-primary">
                                        <div class="timeline_date">
                                            <div>
                                                <div class="inline-block">
                                                    <span class="day text-bold">02</span>
                                                </div>
                                                <div class="inline-block">
                                                    <span class="block week-day text-extra-large">Wensdey</span>
                                                    <span class="block month text-large text-light">november 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline_title">
                                            <i class="fa fa-bullhorn fa-2x pull-left fa-border"></i>
                                            <h4 class="text-white no-margin padding-5">Announcement</h4>
                                        </div>
                                        <div class="timeline_content">
                                            <b>Lorem Ipsum</b> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                        </div>
                                        <div class="readmore">
                                            <a href="#" class="btn btn-transparent-white ">
                                                Read More <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline_element partition-purple">
                                        <div class="timeline_date">
                                            <div>
                                                <div class="inline-block">
                                                    <span class="day text-bold">05</span>
                                                </div>
                                                <div class="inline-block">
                                                    <span class="block week-day text-extra-large">Wensdey</span>
                                                    <span class="block month text-large text-light">november 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline_title">
                                            <i class="fa fa-trophy fa-2x pull-left fa-border"></i>
                                            <h4 class="text-white no-margin padding-5">Achievement</h4>
                                        </div>
                                        <div class="timeline_content ">
                                            <div class="row">
                                                <div class="col-md-3 col-xs-4"><img src="assets/images/photodune-4043508-3d-modern-office-room-l.jpg" alt="offce" class="img-responsive"/>
                                                </div>
                                                <div class="col-md-9 col-xs-8">
                                                    <b>Lorem Ipsum</b> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="readmore">
                                            <a href="#" class="btn btn-transparent-white btn-primary">
                                                Read More <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                            <div class="date_separator" id="october">
                                <span>OCTOBER 2014</span>
                            </div>
                            <ul class="columns">
                                <li>
                                    <div class="timeline_element partition-primary">
                                        <div class="timeline_date">
                                            <div>
                                                <div class="inline-block">
                                                    <span class="day text-bold">02</span>
                                                </div>
                                                <div class="inline-block">
                                                    <span class="block week-day text-extra-large">Wensdey</span>
                                                    <span class="block month text-large text-light">november 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline_title">
                                            <i class="fa fa-bullhorn fa-2x pull-left fa-border"></i>
                                            <h4 class="text-white no-margin padding-5">Announcement</h4>
                                        </div>
                                        <div class="timeline_content">
                                            <b>Lorem Ipsum</b> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                        </div>
                                        <div class="readmore">
                                            <a href="#" class="btn btn-transparent-white ">
                                                Read More <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline_element partition-primary">
                                        <div class="timeline_date">
                                            <div>
                                                <div class="inline-block">
                                                    <span class="day text-bold">02</span>
                                                </div>
                                                <div class="inline-block">
                                                    <span class="block week-day text-extra-large">Wensdey</span>
                                                    <span class="block month text-large text-light">november 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline_title">
                                            <i class="fa fa-bullhorn fa-2x pull-left fa-border"></i>
                                            <h4 class="text-white no-margin padding-5">Announcement</h4>
                                        </div>
                                        <div class="timeline_content">
                                            <b>Lorem Ipsum</b> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                        </div>
                                        <div class="readmore">
                                            <a href="#" class="btn btn-transparent-white ">
                                                Read More <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline_element partition-purple">
                                        <div class="timeline_date">
                                            <div>
                                                <div class="inline-block">
                                                    <span class="day text-bold">05</span>
                                                </div>
                                                <div class="inline-block">
                                                    <span class="block week-day text-extra-large">Wensdey</span>
                                                    <span class="block month text-large text-light">november 2014</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline_title">
                                            <i class="fa fa-trophy fa-2x pull-left fa-border"></i>
                                            <h4 class="text-white no-margin padding-5">Achievement</h4>
                                        </div>
                                        <div class="timeline_content ">
                                            <div class="row">
                                                <div class="col-md-3 col-xs-4"><img src="assets/images/photodune-4043508-3d-modern-office-room-l.jpg" alt="offce" class="img-responsive"/>
                                                </div>
                                                <div class="col-md-9 col-xs-8">
                                                    <b>Lorem Ipsum</b> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="readmore">
                                            <a href="#" class="btn btn-transparent-white btn-primary">
                                                Read More <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>
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
    });
</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop