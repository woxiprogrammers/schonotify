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
    @if($dropDownData != null)
    <div class="row">
        <div class="form-group col-sm-4">
            <label for="form-field-select-2">
                Select Batch
            </label>
            <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                @foreach($dropDownData['batch'] as $row)
                <option value="{!!$row['batch_id']!!}" >{!!$row['batch_name']!!}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-4" id="class-select-div">
            <label for="form-field-select-2">
                Select Class
            </label>
            <select class="form-control" id="class-select" style="-webkit-appearance: menulist;">
            </select>
        </div>
        <div class="form-group col-sm-4" id="division-select-div">
            <label for="form-field-select-2">
                Select Division
            </label>
            <select class="form-control" id="division-select" style="-webkit-appearance: menulist;">
            </select>
        </div>
    </div>
    @else
    <div class="row">
        <div class="form-group col-sm-4">
            <label for="form-field-select-2">
                Select Batch
            </label>

            <select class="form-control" name="batch-select" id="batch-select"  style="-webkit-appearance: menulist;">

                <option value="" >no record found</option>

            </select>
        </div>
        <div class="form-group col-sm-4"  id="class-select-div">
            <label for="form-field-select-2">
                Select Class
            </label>
            <select class="form-control" name="class-select" id="class-select" style="-webkit-appearance: menulist;">
                <option value="">no record found</option>
            </select>
        </div>
        <div class="form-group col-sm-4" id="division-select-div">
            <label for="form-field-select-2">
                Select Division
            </label>
            <select class="form-control" name="division-select" id="division-select" style="-webkit-appearance: menulist;">
                <option value="">no record found</option>
            </select>
        </div>
    </div>
    @endif
    @endif
    <div class="form-group col-sm-4" id="class-select-div">
        <label for="form-field-select-2">
            Leave Status
        </label>

        <select class="form-control" name="leave-status" id="leave-status" style="-webkit-appearance: menulist;">
            <option value="2" selected>Approved</option>
            <option value="1">Pending</option>
        </select>

    </div>
</div>
    <div class="panel-body">
        <ul class="timeline-xs" id="tmln">
            @if ($leaveArray ==null)
            <div class="col-sm-8" style="margin-top: 4px;">No Record Found</div>
            @else
            @foreach($leaveArray as $row)

            <li class="timeline-item success">
                <div class="leaveSection">
                    <div class="text-muted text-small">
                       {!! date('m-d-Y',strtotime($row['created_date'])) !!}

                    </div>
                    <div class="col-sm-8" style="margin-top: 4px;">

                        <h5><small class="label label-sm label-info">{!! $row['parent'] !!}</small>  {!! $row['title'] !!}
                        <a href="detailedLeave/{!! $row['leave_id'] !!}" >...More</a>
                        </h5>
                        <p>{!! $row['reason'] !!}</p>
                        <p>Leave From:<i>{!! date('d M,Y',strtotime($row['from_date'])) !!}</i><br>Leave To:<i> {!! date('d M,Y',strtotime($row['end_date'])) !!}</i></p>
                    </div>
                </div>
                    <img src="/uploads/profile-picture/{!! $row['avatar'] !!}" class="img img-circle tmln-img" alt="Peter">
            </li>

          @endforeach
            @endif
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
            var batchSelected = $('#batch-select').val();
            if(batchSelected != "")
            {
                getClasses(batchSelected);
            }
    });


    var loaded = false;
    var id = 1;
    $(window).scroll(function()
    {
        if($(window).scrollTop() == $(document).height() - $(window).height())
        {   $('div#loadmoreajaxloader').show();
            var leave_status = $('#leave-status').val();
            var division = $('#division-select').val();
            $.ajax({ url: "leaveListing",
                type: "get",
                data: { pageCount:id,leave_status:leave_status,division:division},
                success: function(data){
                    var res= $.map(data,function(value){
                        return value;

                    });
                    id++;
                    if(res.length > 0){
                        var str = '';
                        for(var i=0; i<res.length; i++)
                        {
                            str += '<li class="timeline-item success">'+
                                '<div class="leaveSection">'+
                                '<div class="text-muted text-small">';
                            var date=res[i]['created_date']['date'].split(/[- :]/);
                            var createdAt= date[2]+"-"+date[1]+"-"+date[0];
                            str += createdAt+
                                '</div>'+
                                '<div class="col-sm-8" style="margin-top: 4px;">'+
                                '<h5><small class="label label-sm label-info">'+
                                res[i]['parent'] +
                                '</small>'
                                +res[i]['title']+
                                '......'+
                                '<a href="detailedLeave/'+ res[i]['leave_id'] +'" >'+
                                'More'+
                                '</a>'+
                                '</h5>'+
                                '<p>'
                                + res[i]['reason']+
                                '</p>'+
                                '<p>Leave From:'+
                                '<i>';
                                    var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                                "Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ];
                                    var from_date = res[i]['from_date'].split(/[- :]/);
                                    var end_date = res[i]['end_date'].split(/[- :]/);
                                    var fromDate= from_date[2]+" "+monthNames[parseInt(from_date[1],10)-1]+" "+from_date[0];
                                    var endDate= end_date[2]+" "+monthNames[parseInt(end_date[1],10)-1]+" "+end_date[0];
                            str +=fromDate+
                                '</i><br>'+
                                'Leave To:'+
                                '<i>'+
                                endDate+
                                '</i></p>'+
                                '</div>'+
                                '</div>'+
                                '<img src="/uploads/profile-picture/'+res[i]['avatar']+'" class="img img-circle tmln-img" alt="Peter">'+
                                '</li>';
                        }
                        $("#tmln").append(str);
                        $('div#loadmoreajaxloader').hide();

                    }else{
                        $('div#loadmoreajaxloader').html('<center>No more leaves to show.</center>');
                        return;
                    }
            }});
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
    $('#leave-status').change(function(){
        var leave_status = $('#leave-status').val();
        var division = $('#division-select').val();
        var route='leave-status-listing/'+ leave_status +'/'+ division;
        $.get(route,function(res) {
            if(res.length == 0)
            {
                $('#tmln').html("no record found");
            } else {
                var str = '';
                for(var i=0; i<res.length; i++)
                {
                    str += '<li class="timeline-item success">'+
                        '<div class="leaveSection">'+
                        '<div class="text-muted text-small">';
                    var date=res[i]['created_date']['date'].split(/[- :]/);
                    var createdAt= date[2]+"-"+date[1]+"-"+date[0];
                    str +=createdAt +
                        '</div>'+
                        '<div class="col-sm-8" style="margin-top: 4px;">'+
                        '<h5><small class="label label-sm label-info">'+
                        res[i]['parent'] +
                        '</small>'
                        +res[i]['title']+
                        '<a href="detailedLeave/'+ res[i]['leave_id'] +'" >'+
                        '.......'+
                        'More'+
                        '</a>'+
                        '</h5>'+
                        '<p style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">'+
                         res[i]['reason']+
                        '</p>'+
                        '<p>Leave From:'+
                        '<i>';
                            var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                 "Jul", "Aug", "Sept", "Oct", "Nov", "Dec" ];
                                var from_date = res[i]['from_date'].split(/[- :]/);
                                var end_date = res[i]['end_date'].split(/[- :]/);
                                var fromDate= from_date[2]+" "+monthNames[parseInt(from_date[1],10)-1]+" "+from_date[0];
                                var endDate= end_date[2]+" "+monthNames[parseInt(end_date[1],10)-1]+" "+end_date[0];
                    str +=fromDate+
                        '</i><br>'+
                        'Leave To:'+
                        '<i>'+
                        endDate+
                        '</i></p>'+
                        '</div>'+
                        '</div>'+
                        '<img src="/uploads/profile-picture/'+res[i]['avatar']+'" class="img img-circle tmln-img" alt="Peter">'+
                        '</li>';
                }
                $('#tmln').html(str);
            }
        });

    });
    $('#batch-select').change(function(){
        var batch=$(this).val();
        getClasses(batch);

    });

    $('#class-select').change(function(){
        var classId=$(this).val();
        getDivisions(classId);
    });
    /**
     * Function Name: getDivisions
     * @param:classId
     * @return retrun all divisions related user
     * Desc:it will return list of divisions of releated user
     * Date: 22/2/2016
     * author manoj chaudahri
     */
    function getDivisions(classId)
    {   var route="/get-all-division/"+classId;

        $.get(route,function(res){
            console.log(res);
            var str="";

            if (res.length != 0)
            {

                for(var i=0;i<res.length; i++)
                {
                    str+="<option value='"+res[i]['division_id']+"'>"+res[i]['division_name']+"</option>"
                }

            } else {

                str+="<option value='0'>No divisions found</option>"

            }

            $('#division-select').html(str);

            var divisionSelected=$('#division-select').val();

        });
    }
    /**
     * Function Name: getClasses
     * @param:batchId
     * @return retrun all classes related user
     * Desc:it will return list of classes of releated user
     * Date: 22/2/2016
     * author manoj chaudahri
     */
    function getClasses(batchId)
    {
        var route="/get-all-classes/"+batchId;

        $.get(route,function(res){
            var str="";
            if (res.length != 0)
            {

                for(var i=0;i<res.length; i++)
                {
                    str+="<option value='"+res[i]['class_id']+"'>"+res[i]['class_name']+"</option>"
                }

            } else {

                str+="<option>No classes found</option>"

            }

            $('#class-select').html(str);

            var classSelected=$('#class-select').val();

            if (classSelected != "")
            {
                getDivisions(classSelected);
            }

        });
    }


</script>



<!-- start: MAIN JAVASCRIPTS -->

@stop