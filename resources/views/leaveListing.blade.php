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
            <h1 class="mainTitle">Leaves</h1>

        </div>
    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<div class="container-fluid container-fullw bg-white">

<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel-body">

    @if(Auth::User()->role_id != 2)
    <div class="form-group col-sm-4">
        <label for="form-field-select-2">
            Select Batch
        </label>

        <select class="form-control" name="batch-select" id="batch-select"  style="-webkit-appearance: menulist;">
            @foreach($dropDownData['batch'] as $row)
            <option value="{!!$row['batch_id']!!}" >{!!$row['batch_name']!!}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-4"  id="class-select-div">
        <label for="form-field-select-2">
            Select Class
        </label>
        <select class="form-control" name="class-select" id="class-select" style="-webkit-appearance: menulist;">
            <option value="{!!$dropDownData['class_id']!!}">{!!$dropDownData['class_name']!!}</option>
        </select>
    </div>
    <div class="form-group col-sm-4" id="division-select-div">
        <label for="form-field-select-2">
            Select Division
        </label>
        <select class="form-control" name="division-select" id="division-select" style="-webkit-appearance: menulist;">
            <option value="{!!$dropDownData['division_id']!!}">{!!$dropDownData['division_name']!!}</option>
        </select>
    </div>
    @endif
    <div class="form-group col-sm-4" id="class-select-div">
        <label for="form-field-select-2">
            Leave Status
        </label>

        <select class="form-control" name="class-select" id="class-select" style="-webkit-appearance: menulist;">
            <option value="2">Approved</option>
            <option value="1">Pending</option>
        </select>

    </div>
</div>
    <div class="panel-body">
        <ul class="timeline-xs" id="tmln">
           @foreach($leaveArray as $row)
            <li class="timeline-item success">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                        {!! $row['created_date'] !!}

                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">{!! $row['parent'] !!}</small>  {!! $row['title'] !!}</h5>
                        <p>{!! $row['reason'] !!}...  <a class="text-info" href="detailedLeave/{!! $row['leave_id'] !!}">More</a></p>
                        <p>Leave From:<i>{!! $row['from_date'] !!}</i><br>Leave To:<i> {!! $row['end_date'] !!}</i></p>
                    </div>
                </div>
                    <img src="/uploads/profile-picture/{!! $row['avatar'] !!}" class="img img-circle tmln-img" alt="Peter">
            </li>
          @endforeach
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
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
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
    $('#batch-select').change(function(){
        var id=this.value;
        var route='get-all-classes/'+id;
        $.get(route,function(res){
            if (res.length == 0)
            {
                $('#class-select').html("no record found");
            } else {
                var str='<option value="">please select class</option>';
                for(var i=0; i<res.length; i++)
                {
                    str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                }
                $('#class-select').html(str);
            }
        });
    });

    $("#class-select").change(function() {
        var id = this.value;
        var route='get-all-division/'+id;
        $.get(route,function(res) {
            if(res.length == 0)
            {
                $('#division-select').html("no record found");
            } else {
                var str='<option value="">please select division</option>';
                for(var i=0; i<res.length; i++)
                {
                    str+='<option value="'+res[i]['division_id']+'">'+res[i]['division_name']+'</option>';
                }
                $('#division-select').html(str);
            }
        });
    });
    $('#batch-select').change(function(){
        $('#class-select').val('');
        $('#division-select').val('');
    })


</script>



<!-- start: MAIN JAVASCRIPTS -->

@stop