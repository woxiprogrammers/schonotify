
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
                        <h1 class="mainTitle">Edit</h1>
                        <span class="mainDescription">Admin</span>
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
                                </ul>
                                <div class="tab-content">
                                    <div id="panel_edit_account" class="tab-pane fade in active ">
                                        <form id="formEditAccount" method="post" action="/edit-admin/{!! $user->id !!}"  enctype="multipart/form-data">
                                            <input type="hidden" name="userId" id="userId" value="{!! $user->id !!}">
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
                                                    <div class="col-md-6">
                                                        <label class="control-label">
                                                            Employee Type</span>
                                                        </label>

                                                        <div class="form-group">
                                                            <select class="form-control" id="emp_type" name="emp_type" style="-webkit-appearance: menulist;">
                                                                <option value='full_time' {!!($user->emp_type == 'full_time' ? ' selected="selected"' : ''); !!}>Full Time</option>
                                                                <option value='part_time' {!!($user->emp_type == 'part_time' ? ' selected="selected"' : ''); !!}>Part Time</option>
                                                            </select>
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
        var route='/user-module-acl-edit/{!! $user->id !!}';
        $.get(route,function(res){

            var str;

            var allModAclArr=res['allModAclArr'];

            var disableModules = ['create_homework','view_homework','update_homework','delete_homework','publish_homework','publish_user','create_message','view_message','update_message','publish_message','delete_message','publish_attendance','delete_attendance','delete_subject','update_subject','publish_subject','delete_class','update_class','publish_class','publish_timetable','create_leave','update_leave','delete_leave'];

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

            ///////////user///////////


            $('.user').change(function(){

                if($.inArray(this.id,["create_user","update_user"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.user').each(function() {

                            if(this.id == "view_user") {
                                this.checked = true;
                            }

                        });
                    } else {
                        $('.user').each(function() {

                            if(this.id == "view_user") {
                                this.checked = false;
                            }

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_user") {
                    $('.user').each(function() {

                        if($.inArray(this.id,["create_user","update_user"]) !== -1) {
                            this.checked = false;
                        }

                    });
                }

            });

            /////////////////////Announcement///////////

            $('.announcement').change(function(){

                if($.inArray(this.id,["update_announcement","create_announcement"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        var checkId = this.id;

                        $('.announcement').each(function() {

                            if(this.id == "view_announcement") {
                                this.checked = true;
                            }

                            if(this.id == "update_announcement" && checkId != "update_announcement") {
                                this.checked = true;
                            }

                            if(this.id == "create_announcement" && checkId != "create_announcement") {
                                this.checked = true;
                            }

                        });
                    } else if($.inArray(this.id,["delete_announcement","publish_announcement"]) !== -1){
                        $('.announcement').each(function() {
                            if(this.id == "view_announcement") {
                                this.checked = true;
                            }
                        });
                    } else {
                        $('.announcement').each(function() {

                            this.checked = false;

                        });
                    }

                } else  if($.inArray(this.id,["delete_announcement","publish_announcement"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.announcement').each(function() {
                            if(this.id == "view_announcement") {
                                this.checked = true;
                            }
                        });
                    }
                } else if($(this).prop('checked') == false && this.id == "view_announcement") {
                    $('.announcement').each(function() {

                        this.checked = false;

                    });
                }

            });


            /////////////////////Achievement///////////

            $('.achievement').change(function(){

                if($.inArray(this.id,["update_achievement","create_achievement"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        var checkId = this.id;

                        $('.achievement').each(function() {

                            if(this.id == "view_achievement") {
                                this.checked = true;
                            }

                            if(this.id == "update_achievement" && checkId != "update_achievement") {
                                this.checked = true;
                            }

                            if(this.id == "create_achievement" && checkId != "create_achievement") {
                                this.checked = true;
                            }

                        });
                    } else if($.inArray(this.id,["delete_achievement","publish_achievement"]) !== -1){
                        $('.achievement').each(function() {
                            if(this.id == "view_event") {
                                this.checked = true;
                            }
                        });
                    } else {
                        $('.achievement').each(function() {

                            this.checked = false;

                        });
                    }

                } else  if($.inArray(this.id,["delete_achievement","publish_achievement"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.achievement').each(function() {
                            if(this.id == "view_achievement") {
                                this.checked = true;
                            }
                        });
                    }
                } else if($(this).prop('checked') == false && this.id == "view_achievement") {
                    $('.achievement').each(function() {

                        this.checked = false;

                    });
                }

            });


            /////////////////////Attendance///////////

            $('.attendance').change(function(){

                if($.inArray(this.id,["create_attendance","update_attendance"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.attendance').each(function() {

                            this.checked = true;

                        });
                    } else {
                        $('.attendance').each(function() {

                            this.checked = false;


                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_attendance") {
                    $('.attendance').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Timetable///////////

            $('.timetable').change(function(){

                if($.inArray(this.id,["create_timetable","update_timetable","delete_timetable"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.timetable').each(function() {

                            if(this.id == "view_timetable") {
                                this.checked = true;
                            }

                        });
                    }else if($(this).prop('checked') == false) {
                        $('.timetable').each(function() {

                            if(this.id == "view_timetable") {
                                this.checked = true;
                            }

                        });
                    } else {
                        $('.timetable').each(function() {

                            if(this.id == "view_timetable") {

                                this.checked = false;

                            }

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_timetable") {
                    $('.timetable').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Class///////////

            $('.class').change(function(){

                if($.inArray(this.id,["create_class"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.class').each(function() {

                            if(this.id == "view_class") {

                                this.checked = true;

                            }

                        });
                    } else {
                        $('.class').each(function() {

                            this.checked = false;

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_class") {
                    $('.class').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Subject///////////

            $('.subject').change(function(){

                if($.inArray(this.id,["create_subject"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.subject').each(function() {

                            if(this.id == "view_subject") {

                                this.checked = true;

                            }

                        });
                    } else {
                        $('.subject').each(function() {

                            this.checked = false;

                        });
                    }

                } else if($(this).prop('checked') == false && this.id == "view_subject") {
                    $('.subject').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Event///////////

            $('.event').change(function(){

                if($.inArray(this.id,["update_event","create_event"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        var checkId = this.id;

                        $('.event').each(function() {

                            if(this.id == "view_event") {
                                this.checked = true;
                            }

                            if(this.id == "update_event" && checkId != "update_event") {
                                this.checked = true;
                            }

                            if(this.id == "create_event" && checkId != "create_event") {
                                this.checked = true;
                            }

                        });
                    } else if($.inArray(this.id,["delete_event","publish_event"]) !== -1){
                        $('.event').each(function() {
                            if(this.id == "view_event") {
                                this.checked = true;
                            }
                        });
                    } else {
                        $('.event').each(function() {

                            this.checked = false;

                        });
                    }

                } else  if($.inArray(this.id,["delete_event","publish_event"]) !== -1)
                {
                    if($(this).prop('checked') == true) {
                        $('.event').each(function() {
                            if(this.id == "view_event") {
                                this.checked = true;
                            }
                        });
                    }
                } else if($(this).prop('checked') == false && this.id == "view_event") {
                    $('.event').each(function() {

                        this.checked = false;

                    });
                }

            });

            /////////////////////Leave///////////

            $('.leave').change(function(){

                if($.inArray(this.id,["publish_leave"]) !== -1)
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


        });
    }



</script>


@stop














