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

    <div class="row">
        <div class="col-md-12">
            <div id="detail">

                    <div class="col-sm-12">
                        <div class="panel panel-white load1" id="panel6">
                            <div class="panel-heading">

                                <div class="timeline_title">
                                    <i class="fa fa-bullhorn fa-2x pull-left fa-border"></i>
                                    <h4 class="panel-title no-margin text-primary padding-15" style="word-wrap: break-word;">@foreach($announcements as $announcement){{ strtoupper($announcement['title']) }}@endforeach</h4>
                                </div>
                                <div class="panel-tools">
                                    @foreach($announcements as $announcement)
                                        @if($announcement['priority'] == 1)
                                        <span class="label label-sm label-danger">High</span>
                                        @elseif($announcement['priority'] == 3)
                                        <span class="label label-sm label-orange">Low</span>
                                        @else
                                        <span class="label label-sm label-success">Medium</span>
                                        @endif
                                    @endforeach
                                    Created by
                                    @foreach($announcements as $announcement)
                                    @if($announcement['gender'] == "M")

                                    Mr.

                                    @else

                                    Mrs.

                                    @endif

                                    {{ $announcement['first_name'] }}

                                    {{ $announcement['last_name'] }}

                                    ( {{ $announcement['username'] }} )

                                    @if($announcement['role_id'] == 1)
                                    <small><i>Admin</i></small>
                                    @else
                                    <small><i>Teacher</i></small>
                                    @endif

                                    Created On <i class="fa fa-clock-o"></i> {{ $announcement['created_at'] }}
                                    @endforeach
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="panel-scroll height-280 ps-container ps-active-y">
                                    <textarea class="col-sm-12" style="height:200px;" disabled>@foreach($announcements as $announcement){{ $announcement['detail'] }}@endforeach</textarea>
                                </div>
                            </div>

                            <div class="col-sm-12 margin-top-10 margin-bottom-10">
                                <div class="panel panel-primary">

                                    <div class="panel-heading">
                                        <h4 class="panel-title">This announcement is viewable to following Users and Classes.</h4>
                                        <div class="panel-tools">

                                        </div>
                                    </div>
                                    <div class="panel-body no-padding partition-white">

                                        @if(sizeOf($admins) != 0)

                                        <div class="col-md-4 no-padding">
                                            <div class="padding-15">
                                                <ul>
                                                    <h4>Admins</h4>
                                                    @foreach($admins as $admin)
                                                        <li>
                                                            {{ $admin['first_name'] }} {{ $admin['last_name'] }} ({{ $admin['username'] }})
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        @else

                                        <div class="col-md-4 no-padding">
                                            <div class="padding-15">

                                                <h4>Admins</h4>

                                                <p>No records !</p>

                                            </div>
                                        </div>

                                        @endif

                                        @if(sizeOf($teachers) != 0)

                                        <div class="col-md-4 no-padding">
                                            <div class="padding-15">
                                                <ul>
                                                    <h4>Teachers</h4>
                                                    @foreach($teachers as $teacher)
                                                    <li>
                                                        {{ $teacher['first_name'] }} {{ $teacher['last_name'] }} ({{ $teacher['username'] }})
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        @else

                                        <div class="col-md-4 no-padding">
                                            <div class="padding-15">

                                                <h4>Teachers</h4>

                                                <p>No records !</p>

                                            </div>
                                        </div>

                                        @endif

                                        @if(sizeOf($divisions) != 0)

                                        <div class="col-md-4 no-padding">
                                            <div class="padding-15">
                                                <ul>
                                                    <h4>Divisions</h4>
                                                    @foreach($divisions as $division)
                                                    <li>
                                                        {{ $division[0]['division_name'] }} {{ $division[0]['class_name'] }} ({{ $division[0]['batch_name'] }} batch)
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>

                                        @else

                                        <div class="col-md-4 no-padding">
                                            <div class="padding-15">

                                                <h4>Divisions</h4>

                                                <p>No records !</p>

                                            </div>
                                        </div>

                                        @endif

                                    </div>

                                </div>
                                <div class="margin-top-10">
                                    @if(Auth::User()->role_id == 2)
                                    @foreach($announcements as $announcement)
                                    @if($announcement['status'] == 0)
                                    <h5>
                                        Selected Admin to send request :

                                        @foreach($publishedBy as $row)
                                        @if($row['gender'] == 'M')
                                        Mr.
                                        @else
                                        Mrs.
                                        @endif

                                        {{ $row['first_name'] }} {{ $row['last_name'] }} ({{ $row['username'] }})

                                        @if($row['role_id'] == 1)
                                        <small><i>Admin</i></small>
                                        @else
                                        <small><i>Teacher</i></small>
                                        @endif
                                        @endforeach
                                    </h5>
                                    @elseif($announcement['status'] == 1)
                                    <h5>
                                        Request sent to :

                                        @foreach($publishedBy as $row)
                                        @if($row['gender'] == 'M')
                                        Mr.
                                        @else
                                        Mrs.
                                        @endif

                                        {{ $row['first_name'] }} {{ $row['last_name'] }} ({{ $row['username'] }})

                                        @if($row['role_id'] == 1)
                                        <small><i>Admin</i></small>
                                        @else
                                        <small><i>Teacher</i></small>
                                        @endif
                                        @endforeach
                                    </h5>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>


                            <div class="panel-footer col-sm-12">

                                @foreach($announcements as $announcement)
                                @if($announcement['status'] == 0)
                                <h5> Status :<i class="fa fa-flag"></i> <i>Draft</i></h5>
                                @elseif($announcement['status'] == 1)
                                <h5> Status :<i class="fa fa-flag"></i> <i>Pending</i></h5>
                                @else
                                <h5> Status :<i class="fa fa-flag"></i> <i>Published</i></h5>
                                @endif

                                <h4>
                                    <small class="pull-right">
                                        @if($announcement['status'] == 2)

                                        Published By

                                        @foreach($publishedBy as $row)
                                        @if($row['gender'] == 'M')
                                        Mr.
                                        @else
                                        Mrs.
                                        @endif

                                        {{ $row['first_name'] }} {{ $row['last_name'] }} ({{ $row['username'] }})

                                        @if($row['role_id'] == 1)
                                        <small><i>Admin</i></small>
                                        @else
                                        <small><i>Teacher</i></small>
                                        @endif
                                        @endforeach

                                        Published On <i class="fa fa-clock-o"></i> {{ $announcement['updated_at'] }} @endif
                                    </small>
                                </h4>

                                @endforeach
                                <div class="col-md-12" id="btnDiv">

                                    @if(Auth::User()->role_id == 1)
                                        @foreach($announcements as $announcement)
                                            @if($announcement['status'] == 0 && $announcement['created_by'] == Auth::User()->id)
                                                <button class="btn btn-primary btn-wide pull-left" type="button" id="btnEdit">
                                                    <i class="fa fa-wrench"></i> Update
                                                </button>
                                                <a href="/delete-announcement/{{ $announcement['id'] }}" class="btn btn-danger btn-wide pull-right margin-left-10" type="button" id="btnEdit">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                                <a class="btn btn-primary btn-wide pull-right" href="/check-publish-announcement/{{ $announcement['id'] }}" id="btnPublish">
                                                    <i class="fa fa-cloud-upload"></i> Publish
                                                </a>
                                            @elseif($announcement['status'] == 1 && $announcement['published_by'] == Auth::User()->id)
                                                <button class="btn btn-primary btn-wide pull-left" type="button" id="btnEdit">
                                                    <i class="fa fa-wrench"></i> Update
                                                </button>
                                                <a href="/delete-announcement/{{ $announcement['id'] }}" class="btn btn-danger btn-wide pull-right margin-left-10" type="button" id="btnEdit">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                                <a class="btn btn-primary btn-wide pull-right" href="/check-publish-announcement/{{ $announcement['id'] }}" id="btnPublish">
                                                    <i class="fa fa-cloud-upload"></i> Publish
                                                </a>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($announcements as $announcement)
                                            @if($announcement['status'] == 0)
                                                <button class="btn btn-primary btn-wide pull-left" type="button" id="btnEdit">
                                                    <i class="fa fa-wrench"></i> Update
                                                </button>
                                                <a href="/delete-announcement/{{ $announcement['id'] }}" class="btn btn-danger btn-wide pull-right margin-left-10" type="button" id="btnEdit">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                                <a class="btn btn-primary btn-wide pull-right" href="/check-publish-announcement/{{ $announcement['id'] }}" id="btnPublish">
                                                    <i class="fa fa-cloud-upload"></i> Publish
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                                <div class="col-md-12">

                                </div>
                            </div>
                        </div>
                    </div>

            </div>
            <div id="update">
                <form method="post" action="/update-announcement" role="form" id="update-announcement-form">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                            </div>
                            <div class="successHandler alert alert-success no-display">
                                <i class="fa fa-ok"></i> Your form validation is successful!
                            </div>
                        </div>
                        @foreach($announcements as $announcement)
                        <input type="hidden" name="hiddenAnnouncementId" id="hiddenAnnouncementId" value="{{ $announcement['id'] }}">

                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="control-label">
                                    Title <span class="symbol required"></span>
                                </label>
                                <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title" value="{{ strtoupper($announcement['title']) }}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                    Description <span class="symbol required"></span>
                                </label>
                                <textarea class="form-control col-sm-8" id="announcement" name="announcement" style="min-height: 180px;">{{ $announcement['detail'] }}</textarea>
                            </div>
                            <div class="">
                                <label>
                                    Priority <span class="symbol required"></span>
                                </label>
                                <div class="form-group">
                                    <div class="radio clip-radio radio-primary">
                                        <input type="radio" @if($announcement['priority'] == 1) checked @endif id="priority1" name="priority" value="1" class="event-categories">
                                        <label for="priority1">
                                            <span class="fa fa-circle text-red"></span> High
                                        </label>
                                        <input type="radio" @if($announcement['priority'] == 2) checked @endif id="priority2" name="priority" value="2" class="event-categories">
                                        <label for="priority2">
                                            <span class="fa fa-circle text-green"></span> Medium
                                        </label>
                                        <input type="radio" @if($announcement['priority'] == 3) checked @endif id="priority3" name="priority" value="3" class="event-categories">
                                        <label for="priority3">
                                            <span class="fa fa-circle text-yellow"></span> Low
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                        <div class="col-md-12 margin-top-10">

                            <div class="form-group col-sm-6">
                                <label class="control-label">
                                    User Roles <em>(select at least one)</em> <span class="symbol required"></span>
                                </label>
                                <div class="checkbox clip-check check-primary">

                                    @if(sizeOf($admins) != 0)
                                    <input type="checkbox" value="" name="userrole" id="service4" class="adminChk" checked>
                                    @else
                                    <input type="checkbox" value="" name="userrole" id="service4" class="adminChk">
                                    @endif
                                    <label for="service4">
                                        Admin
                                    </label>

                                    <div class="form-group">
                                        <br>
                                        <div class="adminList">
                                            @if(sizeOf($allAdmins) != 0)
                                            <select multiple="multiple" name="adminList[]" id="adminList" class="form-control">

                                                @if(sizeOf($admins) != 0)
                                                @foreach($allAdmins as $admin)

                                                        <option @foreach($admins as $row) @if($row['id'] == $admin['id']) selected @endif @endforeach value="{{ $admin['id'] }}">{{ $admin['first_name'] }} {{ $admin['last_name'] }}</option>

                                                @endforeach
                                                @else
                                                @foreach($allAdmins as $admin)

                                                    <option value="{{ $admin['id'] }}">{{ $admin['first_name'] }} {{ $admin['last_name'] }}</option>

                                                @endforeach
                                                @endif
                                            </select>
                                            <em>Please Use CTRL Button to select multiple options.</em>
                                            @else
                                            <div class="adminList"> No records found !</div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <div class="checkbox clip-check check-primary">
                                    @if(sizeOf($teachers) != 0)
                                    <input type="checkbox" value="" name="userrole" id="service1" class="teacherChk" checked>
                                    @else
                                    <input type="checkbox" value="" name="userrole" id="service1" class="teacherChk" >
                                    @endif
                                    <label for="service1">
                                        Teacher
                                    </label>

                                    <div class="form-group">
                                        <br>

                                        @if(sizeOf($allTeachers) != 0)
                                        <div class="teacherList">

                                            <select multiple="multiple" name="teacherList[]" id="teacherList" class="form-control teacherList">
                                                @if(sizeOf($teachers) != 0)
                                                @foreach($allTeachers as $teacher)
                                                        <option @foreach($teachers as $row) @if($teacher['id'] == $row['id']) selected @endif @endforeach value="{{ $teacher['id'] }}"> {{ $teacher['first_name'] }} {{ $teacher['last_name'] }}</option>
                                                @endforeach
                                                @else
                                                @foreach($allTeachers as $teacher)

                                                    <option value="{{ $teacher['id'] }}"> {{ $teacher['first_name'] }} {{ $teacher['last_name'] }}</option>

                                                @endforeach
                                                @endif
                                            </select>
                                            <em>Please Use CTRL Button to select multiple options.</em>
                                        </div>
                                        @else
                                        <div class="teacherList"> No records found !</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="checkbox clip-check check-primary">
                                    <input type="checkbox" @if(sizeOf($selectedBatches) != 0) checked @endif value="" name="userrole" class="parentChk" id="service2">
                                    <label for="service2">
                                        Student
                                    </label>
                                </div>
                                <div class="panel panel-white padding-10" id="parentClass">
                                    <div class="form-group">
                                        <label for="form-field-select-2">
                                            Select Batch
                                        </label>

                                        <select class="form-control" name="batch-select[]" id="batch-select" style="-webkit-appearance: menulist;">

                                            @foreach($batchList as $row)

                                                <option @foreach($selectedBatches as $batch) @if($batch == $row['id']) selected @endif @endforeach value="{{ $row['id'] }}">{{ $row['name'] }}</option>

                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group" id="batch-class-div-data">

                                    </div>

                                    <input type="hidden" name="hidenValue" id="hidenValue" value="0">

                                </div>
                            </div>

                        </div>
                        <div class="col-md-12">

                            @if(Auth::User()->role_id != 1)

                            <div class="form-group col-sm-6">
                                <label class="control-label">
                                    Select Admin  <span class="symbol required" aria-required="true"></span>
                                </label>
                                <select class="form-control" name="adminToPublish" style="-webkit-appearance: menulist;">
                                    <option value="">
                                        Please select admin...
                                    </option>
                                    @foreach($adminWithAcl as $admin)
                                    <option value="{{ $admin['id'] }}">{{ $admin['first_name'] }} {{ $admin['last_name'] }} ({{ $admin['username'] }})</option>
                                    @endforeach
                                </select>
                            </div>


                            @endif
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-wide pull-left" type="button" id="btnCancel">
                                Cancel <i class="fa fa-times-circle-o"></i>
                            </button>
                            <button class="btn btn-primary btn-wide pull-right" type="submit" id="btnUpdate">
                                Update <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


</div>
</div>

</div>
<div id="loadmoreajaxloader" style="display: block;" class="loader-position-event" ><center><img src="/assets/images/loader1.gif" /></center></div>
@include('footer')

@include('rightSidebar')


</div>
<!-- start: MAIN JAVASCRIPTS -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="/assets/js/custom-project.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script src="/vendor/moment/moment.min.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();

        $('#update').hide();
        $('#btnStatus').hide();
        $('#parentClass').hide();
        $('.teacherList').hide();
        $('.adminList').hide();

        if($('.parentChk').prop('checked') == true)
        {
            $('#parentClass').show();
        }
        if($('.teacherChk').prop('checked') == true)
        {
            $('.teacherList').show();
        }

        var id = $('#batch-select').val();

        batchChange(id);

            if($('.adminChk').prop('checked') == true)
            {
                $('.adminList').fadeIn(500);
            }

            if($('.parentChk').prop('checked') == true)
            {
                $('#parentClass').fadeIn(500);
            }

            if($('.teacherChk').prop('checked') == true)
            {
                $('.teacherList').fadeIn(500);
            }

        if($('#service2').is(":checked") == true){

            $('#hidenValue').val(1);
        } else {
            $('#hidenValue').val(0);
        }

        sessionStorage.setItem('pageState',1);

    });

    $('#btnCancel').click(function(){
        location.reload();
    });

    $('#batch-select').change(function(){
        $('#batch-class-div-data').html('');
        var id=this.value;
        batchChange(id);

    });
    function batchChange(batch_id) {

        var hiddenId = $('#hiddenAnnouncementId').val();

        var route = '/get-announcement-batch-class-with-updated/'+batch_id+'/'+hiddenId;

        $.get(route,function(data){

                var res= $.map(data[0],function(value){
                    return value;
                });

                if (res.length == 0) {
                    $('#save').prop('disabled',true);
                    $('#btnSubmit').prop('disabled',true);
                } else {
                    var str = "";

                    for(var i=0; i<res.length; i++)
                    {
                        if($.inArray(res[i]['class_id'],data[2]) != -1)
                        {

                            str +='<div class="checkbox clip-check check-primary">' +
                                '<input type="checkbox" checked value="'+res[i]['class_id']+'" name="classFirst[]" class="classFirst" id="class_'+res[i]['class_id']+'">'+
                                '<label for="class_'+res[i]['class_id']+'">'
                                + res[i]['class_name'] +
                                '</label>'+
                                '</div>';

                            var res1= $.map(res[i]['division'],function(value){
                                return value;
                            });

                            for(var j=0; j<res1.length; j++) {

                                if($.inArray(res[i]['division'][j]['division_id'],data[1]) != -1)
                                {
                                    str += '<div class="checkbox clip-check check-primary checkbox-inline">'+
                                        '<input type="checkbox" checked value="'+res1[j]['division_id']+'" name="FirstDiv[]" class="FirstDiv" id="class_'+res[i]['class_id']+'_'+res1[j]['division_id']+'" >'+
                                        '<label for="class_'+res[i]['class_id']+'_'+res1[j]['division_id']+'">'
                                        +res1[j]['division_name']+
                                        '</label>';
                                    str +='</div> ';
                                } else {
                                    str += '<div class="checkbox clip-check check-primary checkbox-inline">'+
                                        '<input type="checkbox" value="'+res1[j]['division_id']+'" name="FirstDiv[]" class="FirstDiv" id="class_'+res[i]['class_id']+'_'+res1[j]['division_id']+'" >'+
                                        '<label for="class_'+res[i]['class_id']+'_'+res1[j]['division_id']+'">'
                                        +res1[j]['division_name']+
                                        '</label>';
                                    str +='</div> ';
                                }

                            }
                            str+="<p></p>"

                        } else {
                            str +='<div class="checkbox clip-check check-primary">' +
                                '<input type="checkbox" value="'+res[i]['class_id']+'" name="classFirst[]" class="classFirst" id="class_'+res[i]['class_id']+'">'+
                                '<label for="class_'+res[i]['class_id']+'">'
                                + res[i]['class_name'] +
                                '</label>'+
                                '</div>';

                            var res1= $.map(res[i]['division'],function(value){
                                return value;
                            });

                            for(var j=0; j<res1.length; j++) {

                                if($.inArray(res[i]['division'][j]['division_id'],data[1]) != -1)
                                {
                                    str += '<div class="checkbox clip-check check-primary checkbox-inline">'+
                                        '<input type="checkbox" checked value="'+res1[j]['division_id']+'" name="FirstDiv[]" class="FirstDiv" id="class_'+res[i]['class_id']+'_'+res1[j]['division_id']+'" >'+
                                        '<label for="class_'+res[i]['class_id']+'_'+res1[j]['division_id']+'">'
                                        +res1[j]['division_name']+
                                        '</label>';
                                    str +='</div> ';
                                } else {
                                    str += '<div class="checkbox clip-check check-primary checkbox-inline">'+
                                        '<input type="checkbox" value="'+res1[j]['division_id']+'" name="FirstDiv[]" class="FirstDiv" id="class_'+res[i]['class_id']+'_'+res1[j]['division_id']+'" >'+
                                        '<label for="class_'+res[i]['class_id']+'_'+res1[j]['division_id']+'">'
                                        +res1[j]['division_name']+
                                        '</label>';
                                    str +='</div> ';
                                }

                            }
                            str+="<p></p>"

                        }


                    }
                }
                $('#batch-class-div-data').html(str);


                $('.classFirst').change(function(){
                    var classId = this.id;
                    if($(this).prop('checked') == true)
                    {
                        $('.FirstDiv').each(function() { //loop through each checkbox
                            var divId = this.id;
                            var req = new RegExp(classId, 'g');
                            var check =  divId.match(req);
                            if(check != null)
                            {
                                this.checked = true;
                            }
                        });
                    }else{
                        $('.FirstDiv').each(function() { //loop through each checkbox
                            var divId = this.id;
                            var req = new RegExp(classId, 'g');
                            var check =  divId.match(req);
                            if(check != null)
                            {
                                this.checked = false;
                            }
                        });
                    }
                });
            }
        );
    }


    $('#btnEdit').click(function(){

        $('#loadmoreajaxloader').show();

        var route = "/check-edit-announcement";

        $.get(route,function(res){

            if(res == 1)
            {
                $('#detail').hide();
                $('#update').show();
                $('#message-error-div').hide();
                $('#message-error-div').html("");
            } else {
                var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                    '<span area-hidden="true">&times;</span>'+
                    '</button>'+
                    "Currently you do not have permission to access this functionality. Please contact administrator to grant you access !"+
                    "</div>";
                $('#message-error-div').show();
                $('#message-error-div').html(str);
            }

            $('#loadmoreajaxloader').hide();

        });

    });

    $(window).load(function() {
        $('#loadmoreajaxloader').hide();
    });

    $('.parentChk').change(function(){
        if($(this).prop('checked') == true)
        {
            $('#parentClass').show();
        }else{
            $('#parentClass').hide();
        }
    });

    $('.teacherChk').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.teacherList').show();
        }else{
            $('.teacherList').hide();
        }
    });

    $('.adminChk').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.adminList').show();
        }else{
            $('.adminList').hide();
        }
    });

    $('.classFirst').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.FirstDiv').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.FirstDiv').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
            });
        }
    });

    $('#service2').click(function(){
        if(this.checked == true){
            $('#hidenValue').val(1);
        } else {
            $('#hidenValue').val(0);
        }
    });

    $('#service1').click(function(){
        if(this.checked == false)
        {
            $('#teacherList option').each(function(){ $(this).attr('selected',false); });
        }

    });

    $('#service4').click(function(){
        if(this.checked == false)
        {
            $('#adminList option').each(function(){ $(this).attr('selected',false); });
        }

    });

</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop