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
                    <h1 class="mainTitle">Notifications</h1>

                </div>

            </div>
        </section>
        <!-- end: DASHBOARD TITLE -->
        <div class="container-fluid container-fullw bg-white">

            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel-body">
                        <ul class="timeline-xs" id="tmln">
                            <li class="timeline-item success">
                                <div class="notificationSection">
                                    <div class="text-muted text-small">
                                        2 minutes ago
                                    </div>
                                    <div class="col-sm-8" style="margin-top: 4px;">

                                        <h5 class="text-bold">Homework have been created for Class Fifth. </h5>
                                        <p>Assignment for class fifth on chapter no. 5 & 6</p>
                                        <p>Due Date:<i> 8 Nov, 2015 </i></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>Created By:
                                        <small class="label label-sm label-info">Mr. Vishnu</small></p>

                                        <p>On : 5 Nov, 2015 12:00 PM</p>
                                    </div>

                                </div>

                                <h1 class="tmln-h2 tmln-h2-homework ">H</h1>

                            </li>
                            <li class="timeline-item success">
                                <div class="notificationSection">
                                    <div class="text-muted text-small">
                                        2 minutes ago
                                    </div>
                                    <div class="col-sm-8" style="margin-top: 4px;">

                                        <h5 class="text-bold">Seek Leave for 2 days</h5>
                                        <p>Applying leave for 2 days ...</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>Created By:
                                            <small class="label label-sm label-info">Mr.Sali</small></p>
                                        <p>On : 2 Nov, 2015 12:00 PM</p>
                                    </div>

                                </div>

                                <h1 class="tmln-h2 tmln-h2-leave">L</h1>

                            </li>
                            <li class="timeline-item success">
                                <div class="notificationSection">
                                    <div class="text-muted text-small">
                                        2 minutes ago
                                    </div>
                                    <div class="col-sm-8" style="margin-top: 4px;">

                                        <h5 class="text-bold">Event Created </h5>
                                        <p>Meeting for annual sport planning.</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>Created By:
                                            <small class="label label-sm label-info">Mrs. Jadhav</small></p>
                                        <p>On : 1 Nov, 2015 12:00 PM</p>
                                    </div>

                                </div>

                                <h1 class="tmln-h2 tmln-h2-event">E</h1>

                            </li>
                            <li class="timeline-item success">
                                <div class="notificationSection">
                                    <div class="text-muted text-small">
                                        2 minutes ago
                                    </div>
                                    <div class="col-sm-8" style="margin-top: 4px;">

                                        <h5 class="text-bold">25 th Anniversary of organization</h5>
                                        <p>On upcoming sunday we are completing 25 years.</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <p>Created By:
                                            <small class="label label-sm label-info">Mr. Vishnu</small></p>
                                        <p>On : 28 oct, 2015 12:00 PM</p>
                                    </div>

                                </div>

                                <h1 class="tmln-h2 tmln-h2-noticeboard">N</h1>

                            </li>

                        </ul>
                        <div id="loadmoreajaxloader" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>
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
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/custom-project.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
    });


    var loaded = false;
    $(window).scroll(function()
    {
        if($(window).scrollTop() == $(document).height() - $(window).height())
        {
            $('div#loadmoreajaxloader').show();


            if(loaded){
                $('div#loadmoreajaxloader').html('<center>No more leaves to show.</center>');
                return;
            }else{

                var str='<li class="timeline-item success">'+
                    '<div class="notificationSection">'+
                    '<div class="text-muted text-small">'+
                    '2 minutes ago'+
                '</div>'+
                '<div class="col-sm-8" style="margin-top: 4px;">'+

                    '<h5 class="text-bold">Homework have been created for Class Fifth. </h5>'+
                    '<p>Assignment for class fifth on chapter no. 5 & 6</p>'+
                    '<p>Due Date:<i> 8 Nov, 2015 </i></p>'+
                '</div>'+
                '<div class="col-sm-4">'+
                    '<p>Created By:'+
                    '<small class="label label-sm label-info">Mr. Vishnu</small></p>'+
                    '<p>On : 5 Nov, 2015 12:00 PM</p>'+
                '</div>'+

                '</div>'+

                '<h1 class="tmln-h2 tmln-h2-homework ">H</h1>'+

                '</li>'+
                '<li class="timeline-item success">'+
                    '<div class="notificationSection">'+
                    '<div class="text-muted text-small">'+
                    '2 minutes ago'+
                '</div>'+
                '<div class="col-sm-8" style="margin-top: 4px;">'+
                    '<h5 class="text-bold">Seek Leave for 2 days</h5>'+
                    '<p>Applying leave for 2 days ...</p>'+
                '</div>'+
                '<div class="col-sm-4">'+
                    '<p>Created By:'+
                    '<small class="label label-sm label-info">Mr.Sali</small></p>'+

                    '<p>On : 2 Nov, 2015 12:00 PM</p>'+
                '</div>'+

                '</div>'+

                '<h1 class="tmln-h2 tmln-h2-leave">L</h1>'+

                '</li>'+
                '<li class="timeline-item success">'+
                    '<div class="notificationSection">'+
                    '<div class="text-muted text-small">'+
                    '2 minutes ago'+
                '</div>'+
                '<div class="col-sm-8" style="margin-top: 4px;">'+

                    '<h5 class="text-bold">Event Created </h5>'+
                    '<p>Meeting for annual sport planning.</p>'+
                '</div>'+
                '<div class="col-sm-4">'+
                    '<p>Created By:'+

                    '<small class="label label-sm label-info">Mrs. Jadhav</small></p>'+

                    '<p>On : 1 Nov, 2015 12:00 PM</p>'+

                '</div>'+

                '</div>'+

                '<h1 class="tmln-h2 tmln-h2-event">E</h1>'+

                '</li>'+
                '<li class="timeline-item success">'+
                    '<div class="notificationSection">'+
                    '<div class="text-muted text-small">'+
                    '2 minutes ago'+
                '</div>'+
                '<div class="col-sm-8" style="margin-top: 4px;">'+

                    '<h5 class="text-bold">25 th Anniversary of organization</h5>'+

                    '<p>On upcoming sunday we are completing 25 years.</p>'+
                '</div>'+
                '<div class="col-sm-4">'+
                    '<p>Created By:'+
                    '<small class="label label-sm label-info">Mr. Vishnu</small></p>'+

                    '<p>On : 28 oct, 2015 12:00 PM</p>'+

                '</div>'+

                '</div>'+

                '<h1 class="tmln-h2 tmln-h2-noticeboard">N</h1>'+

                '</li>';
                $("#tmln").append(str);
                $('div#loadmoreajaxloader').hide();

            }

            loaded=true;

        }

    });

</script>

@stop