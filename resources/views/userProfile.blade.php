
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
@include('alerts.errors')
<div id="message-error-div"></div>
<section id="page-title">
    <div class="row">
        <div class="col-sm-8">
            <h1 class="mainTitle">My Profile</h1>
            <div id="error-div"></div>
        </div>
    </div>
</section>
<!-- end: PAGE TITLE -->
<!-- start: USER PROFILE -->
<div class="container-fluid container-fullw bg-white">
<div class="row">
<div class="col-md-12">


<div class="tabbable">
<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
    <li class="active">
        <a data-toggle="tab" href="#panel_overview">
            Overview
        </a>
    </li>
    <li>
        <a data-toggle="tab" href="#panel_edit_account">
            Edit Account
        </a>
    </li>
    <li>
        <a data-toggle="tab" href="#panel_module_assigned">
            Assigned Modules to me
        </a>
    </li>
    <li>
        <a data-toggle="tab" href="#panel_change_password">
            Change password
        </a>
    </li>

</ul>
<div class="tab-content">
<div id="panel_overview" class="tab-pane fade in active">
    <div class="row">
        <div class="col-sm-5 col-md-4">
            <div class="user-left">
                <div class="center">
                    <h4>{!! $user->name !!}</h4>
                    <input type="hidden" id="hiddenRoleId" value="{{ $user->role_id }}">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="user-image">
                            <div class="fileinput-new thumbnail"><img src="uploads/profile-picture/{!! $user->avatar !!}" alt="">
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                            <div class="user-image-buttons">

                                <a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a>

                                </a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="col-sm-7 col-md-8">
            <div class="row space20">

                <div class="col-sm-4">
                    <button onclick="window.location='timetable'" class="btn btn-icon margin-bottom-5 btn-block">
                        <i class="fa fa-clock-o block text-primary text-extra-large margin-bottom-10"></i>
                        Timetable
                    </button>
                </div>
                <div class="col-sm-4">
                    <button onclick="window.location='event'" class="btn btn-icon margin-bottom-5 btn-block">
                        <i class="ti-calendar block text-primary text-extra-large margin-bottom-10"></i>
                        Events <span class="badge badge-danger"> 23 </span>
                    </button>
                </div>
                <div onclick="window.location='noticeBoard'" class="col-sm-4">
                    <button class="btn btn-icon margin-bottom-5 btn-block">
                        <i class="ti-flag block text-primary text-extra-large margin-bottom-10"></i>
                        Notifications <span class="badge badge-danger"> 9 </span>
                    </button>
                </div>
            </div>
            <div class="panel panel-white" id="activities">
                <div class="col-sm-6">
                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="3">General information</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{!! $user->first_name !!} {!! $user->last_name !!}</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>{!! $user->username !!}</td>
                            <td><a href="#panel_edit_account" class="show-tab"></a></td>
                        </tr>
                        <tr>
                            <td>Gender</td>
                            <td>@if($user->gender=='M') Male @else Female @endif</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>

                        </tbody>
                    </table>

                </div>
                <div class="col-sm-6">
                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="3">Contact Information</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Email:</td>
                            <td>
                                <a href="">
                                    {!! $user->email !!}
                                </a></td>
                            <td><a href="#panel_edit_account" class="show-tab"></a></td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td>{!! $user->mobile !!}</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>{!! $user->address !!}</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
<div id="panel_edit_account" class="tab-pane fade">
    <form id="form4" method="post" action="my-profile/{!! $user->id !!}"  enctype="multipart/form-data">
        <input name="_method" type="hidden" value="PUT">
        <fieldset>
            <legend>
                Account Info
            </legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            Username
                        </label>
                        <input type="text" value="{!! $user->username !!}" readonly class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            First name
                        </label>
                        <input type="text" value="{!! $user->first_name !!}" class="form-control" id="firstname" name="firstname">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Last name
                        </label>
                        <input type="text" value="{!! $user->last_name !!}" class="form-control" id="lastname" name="lastname">
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Email Address
                        </label>
                        <input type="email" readonly placeholder="{!! $user->email !!}" value="{!! $user->email !!}" class="form-control" id="email" name="email">

                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Phone
                        </label>
                        <input type="text" placeholder="{!! $user->mobile !!}" value="{!! $user->mobile !!}" class="form-control" id="mobile" name="mobile">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">
                            Gender
                        </label>
                        <div class="clip-radio radio-primary">
                            <input type="radio" value="F" name="gender" id="us-female" @if($user->gender=='F') checked @endif>
                            <label for="us-female">
                                Female
                            </label>

                            <input type="radio" value="M" name="gender" id="us-male" @if($user->gender=='M') checked @endif>

                            <label for="us-male">
                                Male
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Address
                        </label>
                        <textarea maxlength="250"  id="address" name="address"  class="form-control limited">{!! $user->address !!}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Date of Birth </label>
                        <div class="input-group input-append datepicker date col-sm-6">
                            <input type="text" class="form-control" name="DOB" value="{!! $user->birth_date !!}"/>
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-default">
                                                                            <i class="glyphicon glyphicon-calendar"></i>
                                                                        </button>
                                                                    </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Alternate number
                        </label>
                        <input type="text" placeholder="{!! $user->alternate_number !!}" value="{!! $user->alternate_number !!}" class="form-control" id="alternate_number" name="alternate_number">

                    </div>
                    <div class="form-group">
                        <label>
                            Image Upload
                        </label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail  col-sm-4">

                                <img src="/uploads/profile-picture/{!! $user->avatar !!}" alt="">

                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail  col-sm-6 pull-right"></div>
                            <div class="user-edit-image-buttons pull-right col-sm-6">
                                                                                <span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i>Browse Image</span><span class="fileinput-exists"><i class="fa fa-picture"></i></span>
                                                                                    <input type="file" name="avatar" >
                                                                                </span>
                                <a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="row">

            <div class="col-md-4">
                <button class="btn btn-primary pull-right" type="submit" id="updateUserInfo" >
                    Update <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </form>
</div>

<div id="panel_module_assigned" class="tab-pane fade">
    <div class="panel-body">
        <div class="col-sm-10">

            <table class="table table-responsive" id="aclMod">

            </table>

        </div>
    </div>
</div>
<div id="panel_change_password" class="tab-pane fade">
    <form id="form3"  method="post" action="change-password">
        <input name="_method" type="hidden" value="PUT">
        <div class="row">
            <div class="form-group col-sm-6">
                <label class="control-label">
                    New Password <span class="symbol required" aria-required="true"></span>
                </label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-6">
                <label class="control-label">
                    Confirm New Password <span class="symbol required" aria-required="true"></span>
                </label>
                <input type="password" class="form-control" id="password_again" name="password_again">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <button class="btn btn-primary btn-wide pull-right" type="submit">
                    Change password <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>

</div>
</form>

</div>

</div>
</div>
</div>
</div>
</div>

@include('rightSidebar')
<!-- end: FOURTH SECTION -->
</div>
</div>
</div>

@include('footer')
</div>


<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>4a
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/autosize/autosize.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

<!-- start: JavaScript Event Handlers for this page -->
<script src="assets/js/form-validation.js"></script>

<script src="assets/js/main.js"></script>
<script src="assets/js/form-elements.js"></script>
<script src="assets/js/custom-project.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormElements.init();
        FormValidator.init();


        userAclModule();
    });

    function userAclModule()
    {

        var role = $('#hiddenRoleId').val();

        if(role == 1) {
            var disableModules = ['create_homework','view_homework','update_homework','delete_homework','publish_homework','publish_user','create_message','view_message','update_message','publish_message','delete_message','publish_attendance','delete_attendance','delete_subject','update_subject','publish_subject','delete_class','update_class','publish_class','publish_timetable','create_leave','update_leave','delete_leave'];
        } else {
            var disableModules = ['delete_homework','publish_homework','delete_user','publish_user','update_message','delete_message','delete_leave','update_leave','create_leave','publish_attendance','delete_attendance','publish_announcement','publish_achievement','delete_subject','update_subject','publish_subject','delete_class','publish_class','update_class','publish_event','delete_event','publish_message','publish_achievement','publish_announcement','publish_timetable','publish_timetable','delete_announcement','delete_achievement'];
        }

        var route='user-module-acl';
        $.get(route,function(res){

            var str;

            var arr=res['allModAclArr'];

            var arr1= $.map(arr,function(index,value){
                return [value];
            });

            var arr3=res['allAcls'];
            var arr2= $.map(arr3,function(index,value){
                return [index];
            });

            var arr4=res['userModAclArr'];

            str+='<tr>'+
                '<th><b>Modules</b></th>';
            for(var j=0; j<arr2.length; j++)
            {

                str+='<th><span class="label label-default" >'+arr2[j]['title']+'</span></th>';
            }

            str+='</tr>';


            for(var i=0; i<arr1.length; i++)
            {

                str+="<tr>"+
                    "<td>"+(arr1[i]).toUpperCase()+"</td>";
                for(var j=0; j<arr2.length; j++)
                {
                    str+='<td>'+
                        '<div class="checkbox clip-check check-primary checkbox-inline">';

                    if($.inArray(arr2[j]['slug']+'_'+arr1[i],disableModules) === -1) {

                    if($.inArray(arr2[j]['slug']+'_'+arr1[i],arr4)!=-1)
                    {

                        str+='<input type="checkbox" id="'+arr2[j]['slug']+'_'+arr1[i]+'" value="1" disabled checked>'+
                            '<label for="checkbox"></label>';
                    }else{
                        str+='<input type="checkbox" id="'+arr2[j]['slug']+'_'+arr1[i]+'" value="1" disabled>'+
                            '<label for="checkbox"></label>';
                    }

                    } else {
                        str += "--";
                    }

                    str+='</div>'+
                        '</td>';
                }

                str+="</tr>";
            }

            $('#aclMod').html(str);
        });
    }




</script>


@stop














