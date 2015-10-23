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
    @include('admin.userRoleDropdown')
</div>

<form action="#" role="form" class="smart-wizard" id="form">
<div id="wizard" class="swMain col-sm-12">
<!-- start: WIZARD SEPS -->
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

<div class="col-md-8 col-md-offset-2">
<fieldset>
    <legend>
        Personal Information (student)
    </legend>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    Select class
                </label>
                <select class="form-control" name="country" style="-webkit-appearance: menulist;">
                    <option value=""></option>
                    <option value="first">First</option>
                    <option value="second">Second</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    Select division
                </label>
                <select class="form-control" name="country" style="-webkit-appearance: menulist;">
                    <option value=""></option>
                    <option value="a">A</option>
                    <option value="b">B</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <div class="form-group">
                <label>
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
                    Email <span class="symbol required"></span>
                </label>
                <input type="email" placeholder="Enter a valid E-mail" class="form-control" name="email">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="block">
                    Gender
                </label>
                <div class="clip-radio radio-primary">
                    <input type="radio" id="wz-female" name="gender" value="female">
                    <label for="wz-female">
                        Female
                    </label>
                    <input type="radio" id="wz-male" name="gender" value="male" checked>
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
    <button class="btn btn-primary btn-o next-step btn-wide pull-right">
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
                    <div class="row" style="margin-bottom: 14px;">
                        <div class="col-sm-3"><h4 class="center" style="margin:0px !important; color:#ccc;">Modules</h4></div>
                        <div>

                            <span class="label label-info" style="margin:6px;">View</span>

                            <span class="label label-default" style="margin:6px;">Create</span>

                            <span class="label label-warning" style="margin:6px;">Update</span>

                            <span class="label label-danger" style="margin:6px;">Delete</span>

                        </div>
                    </div>
                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h4 style="margin:0px !important;">Users Management</h4></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox" value="1">
                            <label for="checkbox"></label>

                            <input type="checkbox" id="checkbox1" value="1">
                            <label for="checkbox1"></label>

                            <input type="checkbox" id="checkbox2" value="1">
                            <label for="checkbox2"></label>

                            <input type="checkbox" id="checkbox3" value="1">
                            <label for="checkbox3"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h4 style="margin:0px !important;">Event Management</h4></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox4" value="1">
                            <label for="checkbox4"></label>

                            <input type="checkbox" id="checkbox5" value="1">
                            <label for="checkbox5"></label>

                            <input type="checkbox" id="checkbox6" value="1">
                            <label for="checkbox6"></label>

                            <input type="checkbox" id="checkbox7" value="1">
                            <label for="checkbox7"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h4 style="margin:0px !important;">Class Management</h4></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox8" value="1">
                            <label for="checkbox8"></label>

                            <input type="checkbox" id="checkbox9" value="1">
                            <label for="checkbox9"></label>

                            <input type="checkbox" id="checkbox10" value="1">
                            <label for="checkbox10"></label>

                            <input type="checkbox" id="checkbox11" value="1">
                            <label for="checkbox11"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h4 style="margin:0px !important;">Subjects Management</h4></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox12" value="1">
                            <label for="checkbox12"></label>

                            <input type="checkbox" id="checkbox13" value="1">
                            <label for="checkbox13"></label>

                            <input type="checkbox" id="checkbox14" value="1">
                            <label for="checkbox14"></label>

                            <input type="checkbox" id="checkbox15" value="1">
                            <label for="checkbox15"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h4 style="margin:0px !important;">Exams Management</h4></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox16" value="1">
                            <label for="checkbox16"></label>

                            <input type="checkbox" id="checkbox17" value="1">
                            <label for="checkbox17"></label>

                            <input type="checkbox" id="checkbox18" value="1">
                            <label for="checkbox18"></label>

                            <input type="checkbox" id="checkbox19" value="1">
                            <label for="checkbox19"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h4 style="margin:0px !important;">Timetable Management</h4></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox20" value="1">
                            <label for="checkbox20"></label>

                            <input type="checkbox" id="checkbox21" value="1">
                            <label for="checkbox21"></label>

                            <input type="checkbox" id="checkbox22" value="1">
                            <label for="checkbox22"></label>

                            <input type="checkbox" id="checkbox23" value="1">
                            <label for="checkbox23"></label>
                        </div>
                    </div>
                </div>
            </fieldset>
            <div class="form-group">
                <button class="btn btn-primary btn-o back-step btn-wide pull-left">
                    <i class="fa fa-circle-arrow-left"></i> Back
                </button>
                <button class="btn btn-primary btn-o next-step btn-wide pull-right">
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
                <a class="btn btn-primary btn-o go-first" href="javascript:void(0)">
                    Back to first step
                </a>
            </div>
        </div>
    </div>
</div>
</div>
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

<script src="assets/js/form-wizard.js"></script>

<script>
    jQuery(document).ready(function() {
        Main.init();
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

</script>

@stop
