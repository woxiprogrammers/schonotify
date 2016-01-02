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
            <h1 class="mainTitle">Leaves</h1>

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
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        2 minutes ago
                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">Mr. Vishnu</small> Applying leave for two days</h5>
                        <p>Leave Application for next 2 days...  <a class="text-info" href="detailedLeave">More</a></p>
                        <p>Leave From:<i> 2 Nov, 2015 </i><br>Leave To:<i> 4 Nov, 2015</i></p>
                    </div>
                    <div class="col-sm-2">
                        <small class="label label-sm label-danger pull-right">Pending</small>
                    </div>


                </div>

                    <img src="assets/images/avatar-6.jpg" class="img img-circle tmln-img" alt="Peter">

            </li>
            <li class="timeline-item">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        12:00
                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">Mrs. Sharma</small> Seek Leave for two days</h5>

                        <p>This is to applying for seek leave. ...<a class="text-info" href="detailedLeave">More</a></p>
                        <p>Leave From:<i> 2 Nov, 2015 </i><br>Leave To:<i> 4 Nov, 2015</i></p>
                    </div>
                    <div class="col-sm-2">
                        <small class="label label-sm label-danger pull-right">Pending</small>
                    </div>
                </div>

                <img src="assets/images/avatar-2.jpg" class="img img-circle tmln-img" alt="Peter">

            </li>
            <li class="timeline-item danger">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        11:11
                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">Mr. Aanand</small> Seek Leave for two days</h5>

                        <p>This is to applying for seek leave. ...<a class="text-info" href="detailedLeave">More</a></p>
                        <p>Leave From:<i> 1 Nov, 2015 </i><br>Leave To:<i> 4 Nov, 2015</i></p>
                    </div>
                    <div class="col-sm-2">
                        <small class="label label-sm label-inverse pull-right">Approved</small>
                    </div>
                </div>
                <img src="assets/images/1.jpg" class="img img-circle tmln-img" alt="Peter">

            </li>
            <li class="timeline-item info">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        Thus, 12 Jun
                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">Mr. Yadav</small> Half day leave</h5>

                        <p>Due to official work  i have to ove my native....<a class="text-info" href="detailedLeave">More</a></p>
                        <p>Leave From:<i> 2 Nov, 2015</i><br> Leave To<i> 4 Nov, 2015</i></p>

                    </div>
                    <div class="col-sm-2">
                        <small class="label label-sm label-inverse pull-right">Approved</small>
                    </div>
                </div>

                <img src="assets/images/avatar-1.jpg" class="img img-circle tmln-img" alt="Peter">

            </li>
            <li class="timeline-item">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        Thus, 10 Jun
                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">Mr. Vishnu</small> Applying leave for two days</h5>

                        <p>Leave Application for next 2 days...<a class="text-info" href="detailedLeave">More</a></p>

                        <p>Leave From: <i> 21 Jun, 2015 </i><br>Leave To: <i> 22 Jun, 2015</i></p>

                    </div>
                    <div class="col-sm-2">
                        <small class="label label-sm label-inverse pull-right">Approved</small>
                    </div>
                </div>


                <img src="assets/images/avatar-6.jpg" class="img img-circle tmln-img" alt="Peter">

            </li>
            <li class="timeline-item">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        Sun, 11 Apr
                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">Mr. Vishnu</small> Applying leave for two days</h5>

                        <p>Leave Application for next 2 days...<a class="text-info" href="detailedLeave">More</a></p>
                        <p>Leave From: <i> 20 Apr, 2015</i><br><i>Leave To: 22 Apr, 2015</i></p>
                    </div>
                    <div class="col-sm-2">
                        <small class="label label-sm label-inverse pull-right">Approved</small>
                    </div>
                </div>


                <img src="assets/images/avatar-3.jpg" class="img img-circle tmln-img" alt="Peter">

            </li>
            <li class="timeline-item warning">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        Wed, 25 Mar
                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">Mr. Vishnu</small> Applying leave for two days</h5>

                        <p>Leave Application for next 2 days...<a class="text-info" href="detailedLeave">More</a></p>
                        <p>Leave From: <i> 2 Apr, 2015</i><br><i>Leave To: 4 Apr, 2015</i></p>
                    </div>
                    <div class="col-sm-2">
                        <small class="label label-sm label-inverse pull-right">Approved</small>
                    </div>
                </div>


                <img src="assets/images/avatar-4.jpg" class="img img-circle tmln-img" alt="Peter">

            </li>
            <li class="timeline-item">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        Fri, 20 Mar
                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">Mr. Vishnu</small> Applying leave for two days</h5>

                        <p>Leave Application for next 2 days...<a class="text-info" href="detailedLeave">More</a></p>
                        <p>Leave From:<i> 2 Nov, 2015 </i><br>Leave To: <i> 4 Nov, 2015</i></p>
                    </div>
                    <div class="col-sm-2">
                        <small class="label label-sm label-inverse pull-right">Approved</small>
                    </div>
                </div>


                <img src="assets/images/avatar-9.jpg" class="img img-circle tmln-img" alt="Peter">

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
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>


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

                var str='<li class="timeline-item">'+
                            '<div class="leaveSection">'+
                                '<div class="text-muted text-small">'+
                                "Thus, 10 Jun"+
                                '</div>'+
                                '<div class="col-sm-8" style="margin-top: 4px;">'+

                    '<h5><small class="label label-sm label-info">Mr. Vishnu</small> Applying leave for two days</h5>'+

                        "<p>Leave Application for next 2 days..."+
                    '<a class="text-info" href="">More</a></p>'+
                    '<p>Leave From:<i> 2 Nov, 2015 </i><br>Leave To: <i> 4 Nov, 2015</i></p></div>'+
                '<div class="col-sm-2">'+
                    '<small class="label label-sm label-inverse pull-right">Approved</small>'+
                '</div>'+
                '</div>'+

                '<img src="assets/images/avatar-6.jpg" class="img img-circle tmln-img" alt="Peter">'+

                    '</li>'+'<li class="timeline-item">'+
                    '<div class="leaveSection">'+
                    '<div class="text-muted text-small">'+
                    "Thus, 10 Jun"+
                    '</div>'+
                    '<div class="col-sm-8" style="margin-top: 4px;">'+

                    '<h5><small class="label label-sm label-info">Mr. Vishnu</small> Applying leave for two days</h5>'+

                    "<p>Leave Application for next 2 days..."+
                    '<a class="text-info" href="">More</a></p>'+
                    '<p>Leave From:<i> 2 Nov, 2015 </i><br>Leave To:<i> 4 Nov, 2015</i></p></div>'+
                    '<div class="col-sm-2">'+
                    '<small class="label label-sm label-inverse pull-right">Approved</small>'+
                    '</div>'+
                    '</div>'+

                    '<img src="assets/images/avatar-6.jpg" class="img img-circle tmln-img" alt="Peter">'+

                    '</li>'+
                    '<li class="timeline-item">'+
                    '<div class="leaveSection">'+
                    '<div class="text-muted text-small">'+
                    "Thus, 10 Jun"+
                    '</div>'+
                    '<div class="col-sm-8" style="margin-top: 4px;">'+

                    '<h5><small class="label label-sm label-info">Mr. Vishnu</small> Applying leave for two days</h5>'+

                    "Leave Application for next 2 days..."+
                    '<a class="text-info" href="">More</a>'+
                    '</div>'+
                    '<div class="col-sm-2">'+
                    '<small class="label label-sm label-inverse pull-right">Approved</small>'+
                    '</div>'+
                    '</div>'+

                    '<img src="assets/images/avatar-6.jpg" class="img img-circle tmln-img" alt="Peter">'+

                    '</li>';

                        $("#tmln").append(str);
                        $('div#loadmoreajaxloader').hide();

                }


            loaded=true;

        }


    });


</script>



<!-- start: MAIN JAVASCRIPTS -->

@stop