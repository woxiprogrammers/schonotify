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
                    <h1 class="mainTitle">Notice Board</h1>
                </div>
                <ul class="mini-stats col-sm-2 pull-right">

                    <li>
                        <div class="values">
                            <a href="/show-create-announcement" class="btn btn-primary"><i class="ti-plus"></i></a> Create New
                        </div>
                    </li>

                </ul>

            </div>
        </section>
        <!-- end: DASHBOARD TITLE -->
        <div class="container-fluid container-fullw bg-white">
            <div class="col-sm-12">
                <!-- start: MINI STATS WITH SPARKLINE -->
                <ul class="mini-stats pull-right">
                    <li>
                        <div style="width:20px;height: 20px; background: #fff; border: 1px solid #ccc; float:left;"></div><label style="padding:4px;">Announcement</label>
                    </li>
                    <li>
                        <div style="width:20px;height: 20px; background: #666; border: 1px solid #ccc; float: left;"></div> <label style="padding:4px;">Achievement</label>
                    </li>

                </ul>
                <!-- end: MINI STATS WITH SPARKLINE -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="timeline">
                        <div class="timeline" id="tmlin">
                            <div class="spine"></div>
                            <div class="date_separator" id="november">
                                <span>{!! strtoupper(Date('F Y')) !!}</span>
                            </div>
                            <ul class="columns">
                                <li>
                                    <div class="timeline_element partition-white">
                                        <div class="timeline_date">
                                            <div>
                                                <div class="inline-block">
                                                    <span class="day text-bold">02</span>
                                                </div>
                                                <div class="inline-block">
                                                    <span class="block week-day text-extra-large">Wensdey</span>
                                                    <span class="block month text-large text-light">1:00 PM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline_title">
                                            <i class="fa fa-bullhorn fa-2x pull-left fa-border"></i>
                                            <h4 class="light-text no-margin padding-5">Parent Meet for this month</h4>
                                        </div>
                                        <div class="timeline_content">
                                            <b>Parent Meet</b> for this month is scheduled. And everyone should be requested to have their presence. this parent meet will have focused on renovation of school and faculty.
                                        </div>
                                        <div class="readmore">
                                            <a href="detailAnnouncement" class="btn btn-primary btn-o btn-wide">
                                                Read More <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="timeline_element partition-gray">
                                        <div class="timeline_date">
                                            <div>
                                                <div class="inline-block">
                                                    <span class="day text-bold">05</span>
                                                </div>
                                                <div class="inline-block">
                                                    <span class="block week-day text-extra-large">Wensdey</span>
                                                    <span class="block month text-large text-light">5:00 AM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="timeline_title">
                                            <i class="fa fa-trophy fa-2x pull-left fa-border"></i>
                                            <h4 class="text-white no-margin padding-5">Platinum Jubilee of trust</h4>
                                        </div>
                                        <div class="timeline_content ">
                                            <div class="row">
                                                <div class="col-md-3 col-xs-4"><img src="assets/images/photodune-4043508-3d-modern-office-room-l.jpg" alt="offce" class="img-responsive"/>
                                                </div>
                                                <div class="col-md-9 col-xs-8">
                                                    <b>Platinum Jubilee</b> : We are feeling proud to announce that we are completing 75 years of trust. so, this is notify you that you will get schedule and agenda of ceremony.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="readmore">
                                            <a href="detailAchievement" class="btn btn-transparent-white">
                                                Read More <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>

                            </ul>




                        </div>
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
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
    });


    var loaded = false;
        $(window).scroll(function()
        {
            if($(window).scrollTop() == $(document).height() - $(window).height())
            {
                $('div#loadmoreajaxloader').show();


                if(loaded){
                    $('div#loadmoreajaxloader').html('<center>No more notices to show.</center>');
                    return;
                }

                $.ajax({
                    url: "loadMore",
                    success: function(html)
                    {
                        if(html)
                        {
                            var obj = $.parseJSON(html);

                            var arr = $.map(obj, function(value, index) {
                                return [value];
                            });

                            var str="";
                            var dt=new Date();

                            for(var i=0; i<arr.length; i++)
                            {

                                str+='<div class="date_separator" id="october">';
                                                if(i==0)
                                                {
                                                    str+='<span>AUGUST 2015</span>';
                                                }else{
                                                    str+='<span>JULY 2015</span>';
                                                }

                                       str+= '</div>';

                                str+='<ul class="columns">';


                                for(var j=0; j<arr[i].length; j++)
                                {


                                    if(arr[i][j]['type']=='announcement')
                                    {


                                        str+='<li>' +
                                            '<div class="timeline_element partition-white">' +
                                            '<div class="timeline_date">' +
                                            '<div>'+
                                            '<div class="inline-block">'+
                                            '<span class="day text-bold">'+ arr[i][j]['date'] +'</span>'+
                                            '</div>'+
                                            '<div class="inline-block">'+
                                            '<span class="block week-day text-extra-large">'+ arr[i][j]['day'] +'</span>'+
                                            '<span class="block month text-large text-light">'+ arr[i][j]['time'] +'</span>'+
                                            '</div>'+
                                            '</div>'+
                                            '</div>'+
                                            '<div class="timeline_title">'+
                                            '<i class="fa fa-bullhorn fa-2x pull-left fa-border"></i>'+
                                            '<h4 class="light-text no-margin padding-5">'+ arr[i][j]['title'] +'</h4>'+
                                            '</div>'+
                                            '<div class="timeline_content">'+
                                                "For this concern please have contact to your head of department and clear your all doubts. Be sure to aware about all necessary documents"+
                                            '</div>'+
                                            '<div class="readmore">'+
                                            '<a href="#" class="btn btn-primary btn-o btn-wide">'+
                                            "Read More" +
                                            '<i class="fa fa-arrow-circle-right"></i>'+
                                            '</a>'+
                                            '</div>'+
                                            '</li>';
                                    }else{
                                        str+='<li>' +
                                            '<div class="timeline_element partition-gray">' +
                                            '<div class="timeline_date">' +
                                            '<div>'+
                                            '<div class="inline-block">'+
                                            '<span class="day text-bold">'+ arr[i][j]['date'] +'</span>'+
                                            '</div>'+
                                            '<div class="inline-block">'+
                                            '<span class="block week-day text-extra-large">'+ arr[i][j]['day'] +'</span>'+
                                            '<span class="block month text-large text-light">'+ arr[i][j]['time'] +'</span>'+
                                            '</div>'+
                                            '</div>'+
                                            '<div class="timeline_title">'+
                                            '<i class="fa fa-trophy fa-2x pull-left fa-border"></i>'+
                                            '<h4 class="text-white no-margin padding-5">'+ arr[i][j]['title'] +'</h4>'+
                                            '</div>'+
                                            '</div>' +
                                            '<div class="timeline_content ">'+
                                            '<div class="row">'+
                                            '<div class="col-md-3 col-xs-4"><img src="assets/images/photodune-4043508-3d-modern-office-room-l.jpg" alt="offce" class="img-responsive">'+
                                            '</div>'+
                                            '<div class="col-md-9 col-xs-8">'+
                                            '<b>Lorem Ipsum</b>'+
                                            "is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged." +
                                            '</div>'+
                                            '</div>'+
                                            '</div>'+
                                            '</div>' +
                                            '<div class="readmore">'+
                                            '<a href="#" class="btn btn-transparent-white">'+
                                            "Read More"+
                                            '<i class="fa fa-arrow-circle-right"></i>'+
                                            '</a>'+
                                            '</div>'+

                                            '</div>'+

                                            '</li>';
                                    }


                                }
                                str+='</ul>';

                            }


                            $("#tmlin").append(str);
                            $('div#loadmoreajaxloader').hide();
                        }else
                        {
                            $('div#loadmoreajaxloader').html('<center>No more notices to show.</center>');
                        }
                    }
                });


                loaded=true;




            }


        });

</script>




<!-- start: MAIN JAVASCRIPTS -->

@stop