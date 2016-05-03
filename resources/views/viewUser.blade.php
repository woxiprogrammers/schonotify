
@extends('master')

@section('content')

<div id="app">

@include('sidebar')

<div class="app-content">

    @include('header')
    <!-- end: TOP NAVBAR -->
    <div class="main-content" >
        <div class="wrap-content container" id="container">
            @include('alerts.errors')
            <div id="message-error-div"></div>
            <section id="page-title" class="padding-top-15 padding-bottom-15">
                <div class="row">
                    <div class="col-sm-7">
                        <h1 class="mainTitle">View</h1>
                        @if($user->role_id == 1)
                        <span class="mainDescription">Admin</span>
                        @elseif($user->role_id == 2)
                        <span class="mainDescription">Teacher</span>
                        @elseif($user->role_id == 3)
                        <span class="mainDescription">Student</span>
                        @elseif($user->role_id == 4)
                        <span class="mainDescription">Parent</span>
                        @endif
                    </div>

                </div>
                <div id="error-div"></div>
            </section>
            <div class="container-fluid container-fullw bg-white">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tabbable">
                            <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                                <li class="active">
                                    <a data-toggle="tab" href="#panel_edit_account">
                                        User Account
                                    </a>
                                </li>
                                @if($user->role_id == 3)

                                <li >
                                    <a data-toggle="tab" href="#panel_edit_Parent">
                                        My Parent
                                    </a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#panel_module_assigned">
                                        parent Assigned Modules
                                    </a>
                                </li>
                                @else

                                <li>
                                    <a data-toggle="tab" href="#panel_module_assigned">
                                        Assigned Modules
                                    </a>
                                </li>

                                @endif
                                @if($user->role_id == 4)
                                <li>
                                    <a data-toggle="tab" href="#panel_my_child">
                                        Children
                                    </a>
                                </li>
                                @endif
                            </ul>
                            <div class="tab-content">
                                <div id="panel_edit_account" class="tab-pane fade in active ">

                                        <input type="hidden" name="userId" id="userId" value="{!! $user->id !!}">
                                        <input name="_method" type="hidden" value="PUT">
                                        <fieldset>
                                            <legend>
                                                Account Info
                                            </legend>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>
                                                            Profile Image
                                                        </label>
                                                        <div class="fileinput fileinput-new col-sm-12" data-provides="fileinput">
                                                            <div class="fileinput-new thumbnail  col-sm-4">

                                                                <img src="/uploads/profile-picture/{!! $user->avatar !!}" alt="">

                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Username
                                                        </label>
                                                        <input type="text" disabled value="{!! $user->username !!}" readonly class="form-control" id="username" name="username">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            First name
                                                        </label>
                                                        <input type="text" disabled value="{!! $user->first_name !!}" class="form-control" id="firstname" name="firstname">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Last name
                                                        </label>
                                                        <input type="text" disabled value="{!! $user->last_name !!}" class="form-control" id="lastname" name="lastname">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Email Address
                                                        </label>
                                                        <input type="email" disabled placeholder="{!! $user->email !!}" value="{!! $user->email !!}" class="form-control" id="editEmail" name="email">
                                                        <div id="emailIdfeedback"><div class="" id="emailfeedback" ></div></div>
                                                    </div>
                                                    @if($user->role_id == 2)
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    Class Teacher
                                                                </label>
                                                                <div class="checkbox clip-check check-primary col-sm-12">

                                                                    @if(isset($user->division_id))

                                                                    <input type="checkbox" disabled id="checkbox8" checked value="1" onchange="clsTeacher(this.checked)" name="checkbox8" @if($user->batch_id !='') checked @endif>
                                                                    <label for="checkbox8">

                                                                    </label>

                                                                    @else
                                                                    <input type="checkbox" disabled id="checkbox8" value="1" onchange="clsTeacher(this.checked)" name="checkbox8" @if($user->batch_id !='') checked @endif>
                                                                    <label for="checkbox8">

                                                                    </label>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if(isset($user->division_id))
                                                        <div class="col-md-6">
                                                            <div class="form-group" id="clstchr_batch" >
                                                                <label class="control-label">
                                                                    Batch
                                                                </label>

                                                                <select class="form-control" disabled name="batch" style="-webkit-appearance: menulist;" id="batch"  >
                                                                    <option>{{ $user->batch_name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group" id="clstchr_class" >
                                                                <label class="control-label">
                                                                    Class
                                                                </label>
                                                                <select class="form-control" disabled name="class" style="-webkit-appearance: menulist;" id="class">
                                                                    <option>{{ $user->class_name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group" id="clstchr_div">
                                                                <label class="control-label">
                                                                    Division
                                                                </label>
                                                                <select class="form-control" disabled name="division" style="-webkit-appearance: menulist;" id="division">
                                                                    <option>{{ strtoupper($user->division_name) }}</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                        @endif

                                                    </div>

                                                @elseif($user->role_id == 3)
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <div class="form-group" id="clstchr_batch" >
                                                                <label class="control-label">
                                                                    Batch
                                                                </label>

                                                                <select class="form-control" disabled name="batch" style="-webkit-appearance: menulist;" id="batch"  >
                                                                    <option>{{ $user->batch_name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group" id="clstchr_class" >
                                                                <label class="control-label">
                                                                    Class
                                                                </label>
                                                                <select class="form-control" disabled name="class" style="-webkit-appearance: menulist;" id="class">
                                                                    <option>{{ $user->class_name }}</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group" id="clstchr_div">
                                                                <label class="control-label">
                                                                    Division
                                                                </label>
                                                                <select class="form-control" disabled name="division" style="-webkit-appearance: menulist;" id="division">
                                                                    <option>{{ strtoupper($user->division_name) }}</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                    </div>
                                                @endif

                                                </div>



                                                <div class="col-md-6">
                                                    @if($user->role_id == 2)
                                                    <div class="form-group">
                                                        <label>
                                                            Allow For
                                                        </label>
                                                        <div class="checkbox clip-check check-primary">
                                                            <input type="checkbox" disabled id="checkbox6" value="web_view" name="access[]" @if($user->web_view=='1') checked @endif >
                                                            <label for="checkbox6">
                                                                Web Access
                                                            </label>
                                                            <input type="checkbox" disabled id="checkbox7"  value="mobile_view" name="access[]" @if($user->mobile_view=='1') checked @endif >
                                                            <label for="checkbox7">
                                                                Mobile Access
                                                            </label>
                                                        </div>
                                                    </div>

                                                    @endif

                                                    @if($user->role_id == 3)
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Roll No.
                                                        </label>
                                                        <input type="text" disabled placeholder="{!! $user->roll_number !!}" value="{!! $user->roll_number !!}" class="form-control" >
                                                    </div>
                                                    @endif

                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Phone
                                                        </label>
                                                        <input type="text" disabled placeholder="{!! $user->mobile !!}" value="{!! $user->mobile !!}" class="form-control" id="mobile" name="mobile">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Gender
                                                        </label>
                                                        <div class="clip-radio radio-primary">
                                                            <input type="radio" disabled value="F" name="gender" @if($user->gender == 'F') checked @endif>
                                                            <label for="us-female">
                                                                Female
                                                            </label>

                                                            <input type="radio" disabled value="M" name="gender" @if($user->gender == 'M') checked @endif>

                                                            <label for="us-male">
                                                                Male
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Address
                                                        </label>
                                                        <textarea maxlength="250" disabled id="address" name="address"  class="form-control limited">{!! $user->address !!}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Date of Birth </label>
                                                        <div class="input-group input-append date col-sm-6">
                                                            <input type="text" disabled class="form-control" name="DOB" value="{!! $user->birth_date !!}"/>

                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="control-label">
                                                            Alternate number
                                                        </label>
                                                        <input type="text" disabled placeholder="{!! $user->alternate_number !!}" value="{!! $user->alternate_number !!}" class="form-control" id="alternate_number" name="alternate_number">

                                                    </div>


                                                </div>
                                                @if($user->role_id == 1 || $user->role_id == 2)
                                                <div class="col-md-6">
                                                    <label class="control-label">
                                                        Employee Type</span>
                                                    </label>

                                                    <div class="form-group">
                                                        <select class="form-control" disabled id="emp_type" name="emp_type" style="-webkit-appearance: menulist;">
                                                            <option value='full_time' {!!($user->emp_type == 'full_time' ? ' selected="selected"' : ''); !!}>Full Time</option>
                                                            <option value='part_time' {!!($user->emp_type == 'part_time' ? ' selected="selected"' : ''); !!}>Part Time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif

                                            </div>
                                        </fieldset>


                                </div>

                                @if($user->role_id == 3)

                                <div id="panel_edit_Parent" class="tab-pane fade in  ">
                                    <div class="panel-body">

                                            <input name="_method" type="hidden" value="PUT">
                                            <input type="hidden" disabled name="userId" id="userPerentId" value="{!! $user->parentUserId !!}">
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Username
                                                            </label>
                                                            <input type="text" disabled value="{!! $user->parentUserName !!}" readonly class="form-control" id="username" name="username">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                First name
                                                            </label>
                                                            <input type="text" disabled value="{!! $user->parentFirstName !!}" class="form-control" id="firstname" name="firstname">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Last name
                                                            </label>
                                                            <input type="text" disabled value="{!! $user->parentLastName !!}" class="form-control" id="lastname" name="lastname">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Email Address
                                                            </label>
                                                            <input type="email" disabled placeholder="{!! $user->parentEmail !!}" value="{!! $user->parentEmail !!}" class="form-control" id="editEmailParent" name="email">
                                                            <div id="emailIdfeedback"><div class="" id="emailparentfeedback" ></div></div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Phone
                                                            </label>
                                                            <input type="text" disabled placeholder="{!! $user->parentMobile !!}" value="{!! $user->parentMobile !!}" class="form-control" id="mobile" name="mobile">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Gender
                                                            </label>
                                                            <div class="clip-radio radio-primary">
                                                                <input type="radio" disabled value="F"  id="us-female" @if($user->parentGender=='F') checked @endif>
                                                                <label for="us-female">
                                                                    Female
                                                                </label>

                                                                <input type="radio" disabled value="M"  id="us-male" @if($user->parentGender=='M') checked @endif>

                                                                <label for="us-male">
                                                                    Male
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Address
                                                            </label>
                                                            <textarea maxlength="250" disabled id="address" name="address"  class="form-control limited">{!! $user->parentAddress !!}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Date of Birth </label>
                                                            <div class="input-group input-append col-sm-6">
                                                                <input type="text" disabled class="form-control" name="DOB" value="{!! $user->parentBirth_date !!}"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">
                                                                Alternate number
                                                            </label>
                                                            <input type="text" disabled placeholder="{!! $user->parentAlternateNumber !!}" value="{!! $user->parentAlternateNumber !!}" class="form-control" id="alternate_number" name="alternate_number">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>
                                                                Image Upload
                                                            </label>
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-new thumbnail  col-sm-4">
                                                                    <img src="/uploads/profile-picture/{!! $user->parentAvatar !!}" alt="">
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </fieldset>

                                    </div>
                                </div>

                                @endif
                                <div id="panel_module_assigned" class="tab-pane fade">
                                    <div class="panel-body">
                                        <div class="col-sm-10">

                                                <table class="table table-responsive" id="aclMod">

                                                </table>

                                        </div>
                                    </div>
                                </div>

                                @if($user->role_id == 4)
                                <div id="panel_my_child" class="tab-pane fade">
                                    <div class="panel-body">
                                        <div class="col-sm-10">
                                            <table class="table">
                                                @foreach($students as $student)
                                                <tr>
                                                    <td>{!! $student->first_name !!} {!! $student->last_name !!}</td>
                                                    <td><a href="/view-user/{!!  $student->id !!}">View <i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                @endif

                                <input type="hidden" id="valHiddenId" @if($user->role_id != 3) value="{!! $user->id !!} @else value="{!! $user->parentUserId !!} @endif">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('rightSidebar')

    </div>
</div>
@include('footer')
</div>



<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="/vendor/autosize/autosize.min.js"></script>
<script src="/vendor/selectFx/classie.js"></script>
<script src="/vendor/selectFx/selectFx.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

<!-- start: JavaScript Event Handlers for this page -->

<script src="/assets/js/form-validation-edit.js"></script>

<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormElements.init();
        userAclModule();

    });

    function userAclModule()
    {

        var valHiddenId = $('#valHiddenId').val();

        var route='/user-module-acl-edit/'+valHiddenId;
        $.get(route,function(res){

            var str;

            var allModAclArr=res['allModAclArr'];

            var arr1= $.map(allModAclArr,function(index,value){
                return [value];
            });

            var allAcls=res['allAcls'];
            var arr2= $.map(allAcls,function(index,value){
                return [index];
            });

            var userModAclArr=res['userModAclArr'];

            var allModules=res['allModules'];

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

                    if($.inArray(arr2[j]['slug']+'_'+arr1[i],userModAclArr)!=-1)
                    {

                        str+='<input type="checkbox" disabled id="'+arr2[j]['slug']+'_'+arr1[i]+'" name="acls[]" value="'+arr2[j]['id']+'_'+allModules[i]['id']+'"  checked>'+
                            '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';
                    }else{
                        str+='<input type="checkbox" disabled id="'+arr2[j]['slug']+'_'+arr1[i]+'" name="acls[]" value="'+arr2[j]['id']+'_'+allModules[i]['id']+'" >'+
                            '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';
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














