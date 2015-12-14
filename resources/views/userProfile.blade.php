
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
                        <h1 class="mainTitle">My Profile</h1>

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
                        <h4>{!! Auth::User()->name !!}</h4>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="user-image">
                                <div class="fileinput-new thumbnail"><img src="assets/images/{!! Auth::User()->avatar !!}" alt="">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div class="user-image-buttons">
																			<span class="btn btn-azure btn-file btn-sm"><span class="fileinput-new"></span><span class="fileinput-exists"><i class="fa fa-pencil"></i></span>
																				<input type="file">
																			</span>
                                    <a href="#" class="btn fileinput-exists btn-red btn-sm" data-dismiss="fileinput">
                                        <i class="fa fa-times"></i>
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
                    <div class="col-sm-4">
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
                                <td>{!! Auth::User()->first_name !!} {!! Auth::User()->last_name !!}</td>
                                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>{!! Auth::User()->username !!}</td>
                                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>{!! Auth::User()->gender !!}</td>
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
                                        {!! Auth::User()->email !!}
                                    </a></td>
                                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                            </tr>
                            <tr>
                                <td>Phone:</td>
                                <td>{!! Auth::User()->mobile !!}</td>
                                <td><a href="#panel_edit_account" class="show-tab"><i class="fa fa-pencil edit-user-info"></i></a></td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td>{!! Auth::User()->address !!}</td>
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
                <form action="#" role="form" id="form">
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
                                    <input type="text" value="{!! Auth::User()->username !!}" class="form-control" id="username" name="username">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        First name
                                    </label>
                                    <input type="text" value="{!! Auth::User()->first_name !!}" class="form-control" id="firstname" name="firstname">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">
                                        Last name
                                    </label>
                                    <input type="text" value="{!! Auth::User()->last_name !!}" class="form-control" id="lastname" name="lastname">
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
                                <div class="form-group">
                                    <label class="control-label">
                                        Address
                                    </label>
                                    <input type="text" value="{!! Auth::User()->address !!}" class="form-control" id="phone" name="email">
                                </div>
                                <div class="form-group">
                                    <label>
                                        Image Upload
                                    </label>
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail  col-sm-4"><img src="assets/images/{!! Auth::User()->avatar !!}" alt="">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail  col-sm-6 pull-right"></div>
                                        <div class="user-edit-image-buttons pull-right col-sm-6">
																			<span class="btn btn-azure btn-file"><span class="fileinput-new"><i class="fa fa-picture"></i>Browse Image</span><span class="fileinput-exists"><i class="fa fa-picture"></i></span>
																				<input type="file">
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
                            <button class="btn btn-primary pull-right" type="submit">
                                Update <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="panel_module_assigned" class="tab-pane fade">
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
                        <div class="col-sm-3 pull-left"><h5 style="margin:0px !important;">Users Management</h5></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox" value="1" checked disabled>
                            <label for="checkbox"></label>

                            <input type="checkbox" id="checkbox1" value="1" checked disabled>
                            <label for="checkbox1"></label>

                            <input type="checkbox" id="checkbox2" value="1" checked disabled>
                            <label for="checkbox2"></label>

                            <input type="checkbox" id="checkbox3" value="1" checked disabled>
                            <label for="checkbox3"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h5 style="margin:0px !important;">Event Management</h5></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox4" value="1" checked disabled>
                            <label for="checkbox4"></label>

                            <input type="checkbox" id="checkbox5" value="1" checked disabled>
                            <label for="checkbox5"></label>

                            <input type="checkbox" id="checkbox6" value="1" checked disabled>
                            <label for="checkbox6"></label>

                            <input type="checkbox" id="checkbox7" value="1" checked disabled>
                            <label for="checkbox7"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h5 style="margin:0px !important;">Class Management</h5></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox8" value="1" checked disabled>
                            <label for="checkbox8"></label>

                            <input type="checkbox" id="checkbox9" value="1" disabled>
                            <label for="checkbox9"></label>

                            <input type="checkbox" id="checkbox10" value="1" disabled>
                            <label for="checkbox10"></label>

                            <input type="checkbox" id="checkbox11" value="1" disabled>
                            <label for="checkbox11"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h5 style="margin:0px !important;">Subjects Management</h5></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox12" value="1" disabled>
                            <label for="checkbox12"></label>

                            <input type="checkbox" id="checkbox13" value="1" disabled>
                            <label for="checkbox13"></label>

                            <input type="checkbox" id="checkbox14" value="1" disabled>
                            <label for="checkbox14"></label>

                            <input type="checkbox" id="checkbox15" value="1" disabled>
                            <label for="checkbox15"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h5 style="margin:0px !important;">Exams Management</h5></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox16" value="1" disabled>
                            <label for="checkbox16"></label>

                            <input type="checkbox" id="checkbox17" value="1" disabled>
                            <label for="checkbox17"></label>

                            <input type="checkbox" id="checkbox18" value="1" disabled>
                            <label for="checkbox18"></label>

                            <input type="checkbox" id="checkbox19" value="1" disabled>
                            <label for="checkbox19"></label>
                        </div>
                    </div>

                    <div class="row" id="checkbox-acl">
                        <div class="col-sm-3 pull-left"><h5 style="margin:0px !important;">Timetable Management</h5></div>
                        <div class="checkbox clip-check check-primary checkbox-inline">

                            <input type="checkbox" id="checkbox20" value="1" disabled>
                            <label for="checkbox20"></label>

                            <input type="checkbox" id="checkbox21" value="1" disabled>
                            <label for="checkbox21"></label>

                            <input type="checkbox" id="checkbox22" value="1" disabled>
                            <label for="checkbox22"></label>

                            <input type="checkbox" id="checkbox23" value="1" disabled>
                            <label for="checkbox23"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div id="panel_change_password" class="tab-pane fade">
                <form id="form">
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














