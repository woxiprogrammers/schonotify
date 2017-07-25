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
                            <a href="/create-notice-board" class="btn btn-primary"><i class="ti-plus"></i></a> Create New
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

                    <input type="hidden" id="hiddenLoadingFlag">

                    <div id="timeline">


                        <div class="timeline" id="tmlin">
                            <div class="spine"></div>
                        </div>

                        <div id="loadmoreajaxloader"><center><img src="assets/images/loader1.gif" /></center></div>

                        <center>
                            <a class="btn btn-primary loadMoreBtn" id="loadMoreBtn" style="display:none;"> Load More Records... </a>
                        </center>
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
<script src="/vendor/moment/moment.min.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        loadMore(0);
        
        var stateStatus = sessionStorage.getItem('pageState');

        if(stateStatus == 1)
        {
            sessionStorage.setItem('pageState',0);
            location.reload();
        }
    });

    var loaded = true;

    var dateCount = 1;

    $('#loadMoreBtn').click(function()
    {

            $('div#loadmoreajaxloader').show();

            $('#loadMoreBtn').hide();

            loadMore(dateCount);

            dateCount++;

            if(loaded){
                $('div#loadmoreajaxloader').html('<center>No more notices to show.</center>');
                return;
            }


    });

    /*
     * Function Name : loadMore
     * Param : dateCount
     * Return : append data to view listing
     * Desc : it will recive data from controller and append to view listing.
     * Developed By : Suraj Bande
     * Date : 28/3/2016
     */

    function loadMore(dateCount)
    {

        $.ajax({
            url: "show-noticeboard-listing/"+dateCount,
            success: function(data)
            {

                var str = "";

                var dateNow = new Date();

                var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

                var days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

                var dateToShow = moment(dateNow).subtract(dateCount,'month');

                var monthTitle = months[moment(dateToShow).month()]+' '+moment(dateToShow).year();

                str+='<div class="date_separator" id="october">';

                str+='<span>'+monthTitle+'</span>';

                str+= '</div>';

                if(dateCount == 0 && data.length != 0)
                {

                   var dump = $.map(data,function(index,value){return [index];});

                   var html = $.map(dump[0],function(index,value){return [index];});

                   var date =  $.map(data,function(index,value){return [value];});

                   $('#hiddenLoadingFlag').val(date);

                } else {
                    var html = data;
                }

                var flagForLastRecord = 1;

                if(html.length != 0)
                {

                    var arr = $.map(html, function(value, index) {
                        return [value];
                    });

                    str+='<ul class="columns">';

                    for(var i=0; i<arr.length; i++)
                    {

                        var detail = arr[i]['detail'].substring(0,200) + ".....";

                        if(arr[i]['event_type_id'] == 1) {

                                str+='<li>' +
                                    '<div class="timeline_element partition-white">' +
                                        '<div class="timeline_date"><div>'+
                                        '<div class="inline-block">'+
                                            '<span class="day text-bold">'+ moment(arr[i]['created_at']).date() +'</span>'+
                                        '</div>'+
                                        '<div class="inline-block">'+
                                            '<span class="block week-day text-extra-large"> &nbsp;'+ days[moment(arr[i]['created_at']).day() - 1] +'</span>'+
                                            '<span class="block month text-large text-light"> &nbsp;'+ moment(arr[i]['created_at']).format('hh:mm A') ;

                                               if(arr[i]['priority'] == 1)
                                               {
                                                   str += '&nbsp;<span class="label label-sm label-danger">High</span>';
                                               } else if(arr[i]['priority'] == 3) {
                                                   str += '&nbsp;<span class="label label-sm label-orange">Low</span>';
                                               } else {
                                                    str += '&nbsp;<span class="label label-sm label-success">Medium</span>';
                                                }

                                         str +=   '</span>'+
                                        '</div>'+
                                        '<div class="inline-block pull-right">' ;

                                            if(arr[i]['status'] == 0)
                                            {
                                                str +='<span class="draft-block text-bold">Draft</span>';
                                            } else if(arr[i]['status'] == 1)
                                            {
                                                str +='<span class="pending-block text-bold">Pending</span>';
                                            } else {
                                                str +='<span class="published-block text-bold">Published</span>';
                                            }

                                        str += '</div>'+
                                    '</div>'+
                                    '<div class="timeline_title">'+
                                    '<i class="fa fa-bullhorn fa-2x pull-left fa-border"></i>';

                                    if(arr[i]['title'].length > 25)
                                    {
                                        str += '<h4 class="light-text no-margin padding-5" title="'+arr[i]["title"]+'">'+ arr[i]['title'].substring(0,20) + "....." +'</h4>';

                                    }else{

                                        str += '<h4 class="light-text no-margin padding-5" title="'+arr[i]['title']+'">'+ arr[i]['title'] +'</h4>';

                                    }

                                    str += '</div>'+

                                        '<div class="timeline_content" style="word-wrap: break-word;">'+
                                         detail +
                                    '</div>'+
                                    '<div class="readmore">'+
                                    '<a href="/detail-announcement/'+arr[i]['id']+'" class="btn btn-primary btn-o btn-wide">'+
                                    "Read More " +
                                    '<i class="fa fa-arrow-circle-right"></i>'+
                                    '</a>'+
                                    '</div>'+
                                    '</li>';
                            }else{
                                str+='<li>' +
                                            '<div class="timeline_element partition-gray">' +
                                                '<div class="timeline_date"><div>'+
                                                '<div class="inline-block">'+
                                                    '<span class="day text-bold"> '+ moment(arr[i]['created_at']).date() +' </span>'+
                                                '</div>'+
                                                '<div class="inline-block">'+
                                                    '<span class="block week-day text-extra-large"> &nbsp;'+ days[moment(arr[i]['created_at']).day() - 1] +'</span>'+
                                                    '<span class="block month text-large text-light"> &nbsp;'+ moment(arr[i]['created_at']).format('hh:mm A') +'</span>'+
                                                '</div>'+
                                                '<div class="inline-block pull-right">' ;

                                                    if(arr[i]['status'] == 0)
                                                    {
                                                        str +='<span class="draft-block text-bold">Draft</span>';
                                                    } else if(arr[i]['status'] == 1)
                                                    {
                                                        str +='<span class="pending-block text-bold">Pending</span>';
                                                    } else {
                                                        str +='<span class="published-block text-bold">Published</span>';
                                                    }

                                                 str += '</div>'+
                                                '</div>'+
                                            '<div class="timeline_title">'+
                                                '<i class="fa fa-trophy fa-2x pull-left fa-border"></i>';
                                                    if(arr[i]['title'].length > 120)
                                                    {

                                                        str += '<h4 class="text-light no-margin padding-5" title="'+arr[i]["title"]+'">'+ arr[i]['title'].substring(0,120) + "....." +'</h4>';

                                                    }else{

                                                        str += '<h4 class="text-light no-margin padding-5" title="'+arr[i]['title']+'">'+ arr[i]['title'] +'</h4>';

                                                    }
                            
                                            str +='</div>'+
                                            '</div>' +
                                            '<div class="timeline_content ">'+
                                            '<div class="row">'+
                                            '<div class="col-md-3 col-xs-4">' ;


                                            if(arr[i]['image'] == null)
                                            {
                                                str += '<img src="/assets/images/your-logo-here.png" alt="offce" class="img-responsive">';

                                            } else {

                                                str += '<img src="/uploads/achievement/events/'+arr[i]['id']+'/'+arr[i]['image'] +'" class="img-responsive">';

                                            }

                                            str +='</div>'+
                                            '<div class="col-md-9 col-xs-8" style="word-wrap: break-word;">'+
                                                detail +
                                            '</div>'+
                                            '</div>'+
                                            '</div>'+
                                            '<div class="readmore">'+
                                            '<a href="/detail-achievement/'+arr[i]['id']+'" class="btn btn-transparent-white">'+
                                            "Read More "+
                                            '<i class="fa fa-arrow-circle-right"></i>'+
                                            '</a>'+
                                            '</div>'+
                                            '</div>'+

                                        '</div>'+

                                    '</li>';
                            }

                        }

                        str+='</ul>';

                    $("#tmlin").append(str);
                    $('div#loadmoreajaxloader').hide();
                    $('#loadMoreBtn').show();
                } else {

                    if($('#hiddenLoadingFlag').val() != "")
                    {
                        var val = moment($('#hiddenLoadingFlag').val()).unix();

                        var dateToShowLast = moment(dateToShow).unix();

                        if(val > dateToShowLast)
                        {
                            loaded = false;
                        } else {
                            loaded = true;
                        }
                        if(loaded)
                        {
                            $("#tmlin").append(str);
                            $('div#loadmoreajaxloader').html('<center>No notices to show for this month.</center>');
                            $('div#loadmoreajaxloader').show();
                            $('#loadMoreBtn').show();
                        } else {
                            $('div#loadmoreajaxloader').html('<center>No more records found.</center>');
                            $('div#loadmoreajaxloader').show();
                            $('#loadMoreBtn').hide();
                        }
                    } else {
                        $("#tmlin").append(str);
                        $('div#loadmoreajaxloader').html('<center>No more records found.</center>');
                        $('div#loadmoreajaxloader').show();
                        $('#loadMoreBtn').hide();
                    }


                }
            }
        });

    }

</script>

<!-- start: MAIN JAVASCRIPTS -->

@stop