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
<div class="col-md-12">
<form action="#" role="form" class="smart-wizard" id="registrationForm">
<div id="wizard" class="swMain col-sm-12">
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
        <input type="hidden" id="role" name="role" value="4">
        <input type="hidden" id="role_name" name="role_name" value="parent">
        <div class="col-md-8 col-md-offset-2">
            <fieldset>
                <legend>
                    Personal Information (parent)
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
                        <div class="form-group" id="asd">
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
                <div class="row">

                    <div class="col-md-6">
                        <label class="block">
                            Address
                        </label>
                        <div class="form-group">
                            <div class="note-editor">
                                <textarea class="form-control autosize area-animated" name="address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                                </textarea>
                            </div>
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
                <div id="loadmoreajaxloader" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>
                <button class="btn btn-primary btn-o finish-step btn-wide pull-right" id="submitStep" onclick="this.disabled = true">
                    Next <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
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
                <a class="btn btn-primary btn-o" href="parentCreate">
                    Back to first step
                </a>
            </div>
        </div>
    </div>
</div>
</div>
</form>
</div>

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

<script src="assets/js/form-wizard.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>

<script>
    jQuery(document).ready(function() {
        userAclModule();
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormWizard.init();
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
        $('div#loadmoreajaxloader').show();

        var disableModules = ['create_timetable','update_timetable','delete_timetable','publish_timetable','create_user','view_user','update_user','delete_user','publish_user','delete_homework','publish_homework','update_homework','create_homework','delete_user','update_message','delete_message','publish_message','delete_leave','update_leave','publish_leave','publish_attendance','update_attendance','delete_attendance','create_attendance','update_announcement','delete_announcement','publish_announcement','create_announcement','delete_achievement','create_achievement','publish_achievement','update_achievement','create_subject','view_subject','update_subject','publish_subject','delete_subject','create_class','publish_class','view_class','delete_class','update_class','create_event','update_event','publish_event','delete_event'];
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
                        '<div class="checkbox form-group clip-check check-primary checkbox-inline">';

                    if($.inArray(arr2[j]['slug']+'_'+arr1[i],disableModules) === -1) {
                        str+='<input type="checkbox" class="'+arr1[i]+'" value="'+arr2[j]['slug']+'_'+arr1[i]+'" id="'+arr2[j]['slug']+'_'+arr1[i]+'" name="modules[]">'+
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


