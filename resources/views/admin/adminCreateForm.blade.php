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
            <h1 class="mainTitle">Create</h1>
            <span class="mainDescription">Users</span>
        </div>

    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<!-- start: DYNAMIC TABLE -->
<div class="col-md-12">
    @include('admin.userRoleDropdownCreate')
</div>

<form role="form" class="smart-wizard" id="registrationForm">
    {{--new code start--}}
    <div class="row">
        <input type="hidden" id="role" name="role" value="1">
        <input type="hidden" id="role_name" name="role_name" value="admin">
        <div class="col-md-8 col-md-offset-2">
            <fieldset>
                <legend>
                    Personal Information (admin)
                </legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                First Name <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter your First Name" class="form-control" name="firstName"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Last Name <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter your Last Name" class="form-control" name="lastName"/>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                User Name <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter a User Name" class="form-control" name="userName" id="userName"/>
                            <div id="userNameFeedback"><div class="" id="feedback" ></div></div>
                        </div>
                    </div>

                </div>



                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Password <span class="symbol required"></span>
                            </label>
                            <input type="password" placeholder="Enter a Password" class="form-control" name="password" id="password"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Repeat Password <span class="symbol required"></span>
                            </label>
                            <input type="password" placeholder="Repeat Password" class="form-control" name="password2"/>
                        </div>
                    </div>

                </div>
            </fieldset>

            <div class="form-group">
                <button class="btn btn-primary btn-o next-step btn-wide pull-right" id="checkUser">
                    create <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </div>
    {{--new code end--}}
    {{--start commenting code for Exam Eval--}}
{{--<div id="wizard" class="swMain col-sm-12">
<!-- start: WIZARD SEPS -->
<div id="error-div"></div>
<ul>
    <li>
        <a href="#step-1">
            <div class="stepNumber">
                1
            </div>
            <span class="stepDesc"><small> Personal Information </small></span>
        </a>
    </li>
    <li>
        <a href="#step-2">
            <div class="stepNumber">
                2
            </div>
            <span class="stepDesc"><small> Assign Modules </small></span>
        </a>
    </li>
    <li>
        <a href="#step-3">
            <div class="stepNumber">
                3
            </div>
            <span class="stepDesc"> <small> Complete </small> </span>
        </a>
    </li>
</ul>
<div id="step-1">
    <div class="row">
        <input type="hidden" id="role" name="role" value="1">
        <input type="hidden" id="role_name" name="role_name" value="admin">
        <div class="col-md-8 col-md-offset-2">
            <fieldset>
                <legend>
                    Personal Information (admin)
                </legend>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                First Name <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter your First Name" class="form-control" name="firstName"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Last Name <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter your Last Name" class="form-control" name="lastName"/>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                User Name <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter a User Name" class="form-control" name="userName" id="userName"/>
                            <div id="userNameFeedback"><div class="" id="feedback" ></div></div>
                        </div>
                    </div>

                </div>



                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Password <span class="symbol required"></span>
                            </label>
                            <input type="password" placeholder="Enter a Password" class="form-control" name="password" id="password"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Repeat Password <span class="symbol required"></span>
                            </label>
                            <input type="password" placeholder="Repeat Password" class="form-control" name="password2"/>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Mobile Number <span class="symbol required"></span>
                            </label>
                            <input type="text" placeholder="Enter a Mobile Number" class="form-control" name="mobile"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Alternate Contact Number
                            </label>
                            <input type="text" placeholder="Enter a Alternate Contact Number" class="form-control" name="alt_number"/>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Email <span class="symbol required"></span>
                            </label>
                            <input type="email" placeholder="Enter a valid E-mail" class="form-control" name="email" id="email">
                            <div id="emailIdfeedback"><div class="" id="emailfeedback" ></div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="block">
                                    Gender
                                </label>
                                <div class="clip-radio radio-primary">
                                    <input type="radio" id="wz-female" name="gender" value="F">
                                    <label for="wz-female">
                                        Female
                                    </label>
                                    <input type="radio" id="wz-male" name="gender" value="M" checked>
                                    <label for="wz-male">
                                        Male
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">
                            Address <span class="symbol required"></span>
                        </label>

                        <div class="form-group">
                            <div class="note-editor">
                                <textarea class="form-control autosize area-animated" name="address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">
                            Employee Type <span class="symbol required"></span>
                        </label>

                        <div class="form-group">
                            <select class="form-control" id="emp_type" name="emp_type" style="-webkit-appearance: menulist;">
                                <option value="full_time">Full Time  </option>
                                <option value="part_time">Part Time</option>
                            </select>
                        </div>
                    </div>

                </div>


            </fieldset>

            <div class="form-group">
                <button class="btn btn-primary btn-o next-step btn-wide pull-right" id="checkUser" disabled>
                    Next <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="step-2">
    <div class="row">
        <div class="col-md-12">
            <fieldset>
                <div class="panel-body">
                    <div id="panel_module_assigned" class="tab-pane">
                        <div class="panel-body">
                            <div class="col-sm-10">

                                <table class="table table-responsive" id="aclModCreate">

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <button class="btn btn-primary btn-o back-step btn-wide pull-left">
                    <i class="fa fa-circle-arrow-left"></i> Back
                </button>
                <button class="btn btn-primary btn-o finish-step btn-wide pull-right" id="submitStep" onclick="this.disabled = true">
                    Next <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
            <div id="loadmoreajaxloader" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>

        </div>
     </div>
 </div>
<div id="step-3">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                <h1 class=" ti-check block text-primary"></h1>
                <h2 class="StepTitle">Congratulations!</h2>
                <p class="text-large">
                    You have created new user.
                </p>
                <p class="text-small">
                    User will get the mail confirmation about his/her account. This mail includes link for login and his/her login credentials.
                </p>
                <a class="btn btn-primary btn-o" href="adminCreate">
                    Back to first step
                </a>
            </div>
        </div>
    </div>
</div>
</div>--}}
    {{--end commenting code for Exam Eval--}}
</form>

<!-- end: DYNAMIC TABLE -->

<!-- start: FOURTH SECTION -->
@include('rightSidebar')
<!-- end: FOURTH SECTION -->
</div>
</div>
</div>

@include('footer')
</div>

<!-- start: MAIN JAVASCRIPTS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>

<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>
<script src="assets/js/form-wizard.js"></script>
<script src="assets/js/custom-project.js"></script>

<script>
    jQuery(document).ready(function() {
        userAclModule();
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormWizard.init();
        $('option#4').hide();
    });
</script>
<script type="text/javascript">

    $('#role-select').on('change',function(){

        var par=this.value;

        if(isNaN(par)==false)
        {
            var route= "/createUsers/"+par;

            window.location.replace(route);

        }

    });



    function userAclModule()
    {

        var clickModules = ['create_homework'];

        var clickBehaviorModules = ['create_homework'];

        var disableModules = ['create_homework','view_homework','update_homework','delete_homework','publish_homework','publish_user','create_message','view_message','update_message','publish_message','delete_message','publish_attendance','delete_attendance','delete_subject','update_subject','publish_subject','delete_class','publish_class','update_class','publish_timetable','create_leave','update_leave','delete_leave'];

        $('div#loadmoreajaxloader').show();
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
                        '<div class="checkbox clip-check check-primary">';

                        if($.inArray(arr2[j]['slug']+'_'+arr1[i],disableModules) === -1) {
                            str+='<input type="checkbox" name="modules[]" class="'+arr1[i]+'" value="'+arr2[j]['slug']+'_'+arr1[i]+'" id="'+arr2[j]['slug']+'_'+arr1[i]+'">'+
                                '<label for="'+arr2[j]['slug']+'_'+arr1[i]+'"></label>';
                        } else {
                            str+="--";
                        }


                    str+='</div>'+
                        '</td>';
                }

                str+="</tr>";
            }

            $('#aclModCreate').html(str);
            $('div#loadmoreajaxloader').hide();

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
