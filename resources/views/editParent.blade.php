
@extends('master')

@section('content')

<div id="app">

@include('sidebar')

    <div class="app-content">

        @include('header')

        <div class="main-content" >
            <div class="wrap-content container" id="container">
                @include('alerts.errors')
                <div id="message-error-div"></div>
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">Edit</h1>
                            <span class="mainDescription">Parent</span>
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
                                            Edit Account
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#panel_module_assigned">
                                            Assigned Modules
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#panel_my_child">
                                            My Children
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="panel_edit_account" class="tab-pane fade in active ">
                                        <form id="formEditAccount" method="post" action="/edit-parent/{!! $user->id !!}"  enctype="multipart/form-data">
                                            <input type="hidden" name="userId" id="userId" value="{!! $user->id !!}">
                                            <input name="_method" type="hidden" value="PUT">
                                            <fieldset>
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
                                                            <input type="email" placeholder="{!! $user->email !!}" value="{!! $user->email !!}" class="form-control" id="editEmail" name="email">
                                                            <div id="emailIdfeedback"><div class="" id="emailfeedback" ></div></div>
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
                                                <form id="editAcl" method="post" action="/acl-update/{!! $user->id !!}">
                                                    <table class="table table-responsive" id="aclMod">

                                                    </table>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <button class="btn btn-primary pull-right" type="submit" >
                                                                Update <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <div id="panel_my_child" class="tab-pane fade" id="myChild">
                                        <div class="panel-body">
                                            <div class="col-sm-10">
                                            <table class="table">
                                                @foreach($students as $student)
                                                <tr>
                                                    <td>{!! $student->first_name !!} {!! $student->last_name !!}</td>
                                                    <td><a href="/edit-mychildrens/{!!  $student->id !!}">Edit <i class="fa fa-pencil edit-user-info"></i></a></td>
                                                </tr>
                                                @endforeach
                                            </table>
                                            </div>

                                        </div>
                                    </div>
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
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>4a
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
<script src="/assets/js/form-validation.js"></script>
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
    $('#email').on('keyup',function(){
        var email = $(this).val();
        var route='/check-email';
        $.post(route,{email:email},function(res){
            if(res == 0 ) {
                $('#emailfeedback').removeClass("alert alert-danger alert-dismissible");
                $('#emailfeedback').addClass("alert alert-success alert-dismissible");
                $('#emailfeedback').html("Email Id Can Be Used");
                $('#updateUserInfo').removeAttr('disabled');
            } else {
                document.getElementById("emailfeedback").disabled = true;
                $('#emailfeedback').addClass("alert alert-danger alert-dismissible");
                $('#emailfeedback').html("Email Id Already Exists");
                $('#updateUserInfo').attr('disabled','disabled');
            }
        });
    });
    function userAclModule()
    {
        var enabled_modules =['view_attendance','view_event','view_timetable','view_result','create_leave','view_leave','view_homework','create_message','delete_message','view_message'];
        var disableModules = ['create_timetable','update_timetable','delete_timetable','publish_timetable','create_user','view_user','update_user','delete_user','publish_user','delete_homework','publish_homework','update_homework','create_homework','delete_user','update_message','delete_message','publish_message','delete_leave','update_leave','publish_leave','publish_attendance','update_attendance','delete_attendance','create_attendance','update_announcement','delete_announcement','publish_announcement','create_announcement','delete_achievement','create_achievement','publish_achievement','update_achievement','create_subject','view_subject','update_subject','publish_subject','delete_subject','create_class','publish_class','view_class','delete_class','update_class','publish_subject','create_event','update_event','publish_event','delete_event','publish_class','publish_timetable'];
        var route='/user-module-acl-edit/{!! $user->id !!}';
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

                    if($.inArray(arr2[j]['slug']+'_'+arr1[i],disableModules) === -1) {
                        if($.inArray(arr2[j]['slug']+'_'+arr1[i],userModAclArr)!=-1)
                        {

                            str+='<input type="checkbox" class="'+arr1[i]+'" id="'+arr2[j]['slug']+'_'+arr1[i]+'" name="acls[]" value="'+arr2[j]['id']+'_'+allModules[i]['id']+'"  checked>'+
                                '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';
                        }else{
                            str+='<input type="checkbox" class="'+arr1[i]+'" id="'+arr2[j]['slug']+'_'+arr1[i]+'" name="acls[]" value="'+arr2[j]['id']+'_'+allModules[i]['id']+'" >'+
                                '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';
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

            /////////////////////Leave///////////

            $('.leave').change(function(){

                if($.inArray(this.id,["create_leave"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.leave').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.leave').each(function() {

                            this.checked = false;


                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_leave") {
                    $('.leave').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Message///////////

            $('.message').change(function(){

                if($.inArray(this.id,["create_message"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.message').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.message').each(function() {

                            this.checked = false;


                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_message") {
                    $('.message').each(function() {

                        this.checked = false;

                    });
                }

            });

        });
    }


</script>


@stop










