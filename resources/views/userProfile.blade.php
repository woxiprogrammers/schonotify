
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

            <section id="page-title">
                <div class="row">
                    <div class="col-sm-8">
                        <h1 class="mainTitle">User Profile</h1>
                        <span class="mainDescription">There are many systems which have a need for user profile pages which display personal information on each member.</span>
                    </div>
                    <ol class="breadcrumb">
                        <li>
                            <span>Pages</span>
                        </li>
                        <li class="active">
                            <span>User Profile</span>
                        </li>
                    </ol>
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

            </ul>
            <div class="tab-content">
            <div id="panel_overview" class="tab-pane fade in active">
            <div class="row">
            <div class="col-sm-5 col-md-4">
                <div class="user-left">
                    <div class="center">
                        <h4>{!! Auth::User()->name !!}</h4>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="user-image">
                                <div class="fileinput-new thumbnail"><img src="assets/images/{!! Auth::User()->image !!}" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div class="user-image-buttons">
																			<span class="btn btn-azure btn-file btn-sm"><span class="fileinput-new"><i class="fa fa-pencil"></i></span><span class="fileinput-exists"><i class="fa fa-pencil"></i></span>
																				<input type="file">
																			</span>
                                    <a href="#" class="btn fileinput-exists btn-red btn-sm" data-dismiss="fileinput">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="social-icons block">
                            <ul>
                                <li data-placement="top" data-original-title="Twitter" class="social-twitter tooltips">
                                    <a href="http://www.twitter.com" target="_blank">
                                        Twitter
                                    </a>
                                </li>
                                <li data-placement="top" data-original-title="Facebook" class="social-facebook tooltips">
                                    <a href="http://facebook.com" target="_blank">
                                        Facebook
                                    </a>
                                </li>
                                <li data-placement="top" data-original-title="Google" class="social-google tooltips">
                                    <a href="http://google.com" target="_blank">
                                        Google+
                                    </a>
                                </li>
                                <li data-placement="top" data-original-title="LinkedIn" class="social-linkedin tooltips">
                                    <a href="http://linkedin.com" target="_blank">
                                        LinkedIn
                                    </a>
                                </li>
                                <li data-placement="top" data-original-title="Github" class="social-github tooltips">
                                    <a href="#" target="_blank">
                                        Github
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <hr>
                    </div>
                    <table class="table table-condensed">
                        <thead>
                        <tr>
                            <th colspan="3">Contact Information</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>url</td>
                            <td>
                                <a href="#">
                                    www.example.com
                                </a></td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>email:</td>
                            <td>
                                <a href="">
                                    {!! Auth::User()->email !!}
                                </a></td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>phone:</td>
                            <td>{!! Auth::User()->mobile !!}</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>skye</td>
                            <td>
                                <a href="">
                                    peterclark82
                                </a></td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="3">General information</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Position</td>
                            <td>UI Designer</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Last Logged In</td>
                            <td>56 min</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Position</td>
                            <td>Senior Marketing Manager</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Supervisor</td>
                            <td>
                                <a href="#">
                                    Kenneth Ross
                                </a></td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td><span class="label label-sm label-info">Administrator</span></td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                        <tr>
                            <th colspan="3">Additional information</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Birth</td>
                            <td>21 October 1982</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        <tr>
                            <td>Groups</td>
                            <td>New company web site development, HR Management</td>
                            <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-sm-7 col-md-8">
                <div class="row space20">
                    <div class="col-sm-3">
                        <button class="btn btn-icon margin-bottom-5 margin-bottom-5 btn-block">
                            <i class="ti-layers-alt block text-primary text-extra-large margin-bottom-10"></i>
                            Projects
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-icon margin-bottom-5 btn-block">
                            <i class="ti-comments block text-primary text-extra-large margin-bottom-10"></i>
                            Messages <span class="badge badge-danger"> 23 </span>
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-icon margin-bottom-5 btn-block">
                            <i class="ti-calendar block text-primary text-extra-large margin-bottom-10"></i>
                            Calendar
                        </button>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-icon margin-bottom-5 btn-block">
                            <i class="ti-flag block text-primary text-extra-large margin-bottom-10"></i>
                            Notifications
                        </button>
                    </div>
                </div>
                <div class="panel panel-white" id="activities">
                    <div class="panel-heading border-light">
                        <h4 class="panel-title text-primary">Recent Activities</h4>
                        <paneltool class="panel-tools" tool-collapse="tool-collapse" tool-refresh="load1" tool-dismiss="tool-dismiss"></paneltool>
                    </div>
                    <div collapse="activities" ng-init="activities=false" class="panel-wrapper">
                        <div class="panel-body">
                            <ul class="timeline-xs">
                                <li class="timeline-item success">
                                    <div class="margin-left-15">
                                        <div class="text-muted text-small">
                                            2 minutes ago
                                        </div>
                                        <p>
                                            <a class="text-info" href>
                                                Steven
                                            </a>
                                            has completed his account.
                                        </p>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <div class="margin-left-15">
                                        <div class="text-muted text-small">
                                            12:30
                                        </div>
                                        <p>
                                            Staff Meeting
                                        </p>
                                    </div>
                                </li>
                                <li class="timeline-item danger">
                                    <div class="margin-left-15">
                                        <div class="text-muted text-small">
                                            11:11
                                        </div>
                                        <p>
                                            Completed new layout.
                                        </p>
                                    </div>
                                </li>
                                <li class="timeline-item info">
                                    <div class="margin-left-15">
                                        <div class="text-muted text-small">
                                            Thu, 12 Jun
                                        </div>
                                        <p>
                                            Contacted
                                            <a class="text-info" href>
                                                Microsoft
                                            </a>
                                            for license upgrades.
                                        </p>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <div class="margin-left-15">
                                        <div class="text-muted text-small">
                                            Tue, 10 Jun
                                        </div>
                                        <p>
                                            Started development new site
                                        </p>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <div class="margin-left-15">
                                        <div class="text-muted text-small">
                                            Sun, 11 Apr
                                        </div>
                                        <p>
                                            Lunch with
                                            <a class="text-info" href>
                                                Nicole
                                            </a>
                                            .
                                        </p>
                                    </div>
                                </li>
                                <li class="timeline-item warning">
                                    <div class="margin-left-15">
                                        <div class="text-muted text-small">
                                            Wed, 25 Mar
                                        </div>
                                        <p>
                                            server Maintenance.
                                        </p>
                                    </div>
                                </li>
                                <li class="timeline-item">
                                    <div class="margin-left-15">
                                        <div class="text-muted text-small">
                                            Fri, 20 Mar
                                        </div>
                                        <p>
                                            New User Registration
                                            <a class="text-info" href>
                                                more details
                                            </a>
                                            .
                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="panel panel-white space20">
                    <div class="panel-heading">
                        <h4 class="panel-title">Recent Tweets</h4>
                    </div>
                    <div class="panel-body">
                        <ul class="ltwt">
                            <li class="ltwt_tweet">
                                <p class="ltwt_tweet_text">
                                    <a href class="text-info">
                                        @Shakespeare
                                    </a>
                                    Some are born great, some achieve greatness, and some have greatness thrust upon them.
                                </p>
                                <span class="block text-light"><i class="fa fa-fw fa-clock-o"></i> 2 minuts ago</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            </div>
            </div>
            <div id="panel_edit_account" class="tab-pane fade">
                <form action="#" role="form" id="form">
                    <fieldset>
                        <legend>
                            Account Info
                        </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        User name
                                    </label>
                                    <input type="text" placeholder="{!! Auth::User()->name !!}" value="{!! Auth::User()->name !!}" class="form-control" id="firstname" name="firstname">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">
                                        Email Address
                                    </label>
                                    <input type="email" placeholder="{!! Auth::User()->email !!}" value="{!! Auth::User()->email !!}" class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        Phone
                                    </label>
                                    <input type="text" placeholder="{!! Auth::User()->mobile !!}" value="{!! Auth::User()->mobile !!}" class="form-control" id="phone" name="email">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Gender
                                    </label>
                                    <div class="clip-radio radio-primary">
                                        <input type="radio" value="female" name="gender" id="us-female">
                                        <label for="us-female">
                                            Female
                                        </label>
                                        <input type="radio" value="male" name="gender" id="us-male" checked>
                                        <label for="us-male">
                                            Male
                                        </label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Zip Code
                                            </label>
                                            <input class="form-control" placeholder="12345" type="text" name="zipcode" id="zipcode">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Address
                                            </label>
                                            <input class="form-control tooltips" placeholder="London (UK)" type="text" data-original-title="We'll display it when you write reviews" data-rel="tooltip"  title="" data-placement="top" name="city" id="city">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>
                                        Image Upload
                                    </label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail"><img src="assets/images/{!! Auth::User()->image !!}" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div class="user-edit-image-buttons">
																			<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i> Select image</span><span class="fileinput-exists"><i class="fa fa-picture"></i> Change</span>
																				<input type="file">
																			</span>
                                            <a href="#" class="btn fileinput-exists btn-red" data-dismiss="fileinput">
                                                <i class="fa fa-times"></i> Remove
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>
                            Additional Info
                        </legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Twitter
                                    </label>
																	<span class="input-icon">
																		<input class="form-control" type="text" placeholder="Text Field">
																		<i class="fa fa-twitter"></i> </span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        Facebook
                                    </label>
																	<span class="input-icon">
																		<input class="form-control" type="text" placeholder="Text Field">
																		<i class="fa fa-facebook"></i> </span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        Google Plus
                                    </label>
																	<span class="input-icon">
																		<input class="form-control" type="text" placeholder="Text Field">
																		<i class="fa fa-google-plus"></i> </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Github
                                    </label>
																	<span class="input-icon">
																		<input class="form-control" type="text" placeholder="Text Field">
																		<i class="fa fa-github"></i> </span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        Linkedin
                                    </label>
																	<span class="input-icon">
																		<input class="form-control" type="text" placeholder="Text Field">
																		<i class="fa fa-linkedin"></i> </span>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        Skype
                                    </label>
																	<span class="input-icon">
																		<input class="form-control" type="text" placeholder="Text Field">
																		<i class="fa fa-skype"></i> </span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                Required Fields
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <p>
                                By clicking UPDATE, you are agreeing to the Policy and Terms &amp; Conditions.
                            </p>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary pull-right" type="submit">
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
            <!-- end: USER PROFILE -->



            <!-- start: FOURTH SECTION -->
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
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script>
    jQuery(document).ready(function() {
        Main.init();
    });
</script>


@stop














