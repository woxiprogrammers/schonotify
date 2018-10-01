<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 9/27/18
 * Time: 12:33 PM
 */
?>
@extends('master')
@section('content')
    <div id="app">
        @include('sidebar')
        <div class="app-content">
            @include('header')
            <style>
                img{
                    max-width:180px;
                }
                input[type=file]{
                    padding:10px;
                    background:#c2c2c5;}
            </style>
            <div class="main-content" >
                <div class="wrap-content container" id="container">
                    @include('alerts.errors')
                    <div id="message-error-div"></div>
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1 class="mainTitle">Timetable</h1>
                                <span class="mainDescription">Create</span>
                            </div>
                            <div class="col-sm-5">
                                <!-- start: MINI STATS WITH SPARKLINE -->
                                <!-- end: MINI STATS WITH SPARKLINE -->
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="portlet-body">
                                <div class="tabbable-line">
                                    <div class="col-md-3">
                                        <ul class="nav nav flex-column">
                                            <li class="active">
                                                <a href="#tab_1" data-toggle="tab"> General Setting </a>
                                            </li>
                                            <li>
                                                <a href="#tab_2" data-toggle="tab"> Header Setting </a>
                                            </li>
                                            <li>
                                                <a href="#tab_3" data-toggle="tab"> Footer Setting </a>
                                            </li>
                                            <li>
                                                <a href="#tab_4" data-toggle="tab"> Slider Setting</a>
                                            </li>
                                            <li>
                                                <a href="#tab_5" data-toggle="tab"> Social Account </a>
                                            </li>
                                            <li>
                                                <a href="#tab_6" data-toggle="tab"> Pages </a>
                                            </li>
                                            <li>
                                                <a href="#tab_7" data-toggle="tab"> Contact Us </a>
                                            </li>
                                            <li>
                                                <a href="#tab_8" data-toggle="tab"> About Us </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_1">
                                                <form action="/cms/general-setting" method="Post" id="tabs_name">
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <lable class="control-label">

                                                            </lable>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <lable class="control-label">
                                                                <h4>Menus</h4>
                                                            </lable>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <lable class="control-label">
                                                               <h4>Priority</h4>
                                                            </lable>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_home">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="Home" class="form-control" name="home_tab" id="home_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" value="" class="form-control" size="5" name="priority_home_tab" id="priority_home_tab">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_gallery">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="Gallery" class="form-control" name="home_tab" id="gallery_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" value="" size="5" class="form-control" name="priority_gallery_tab" id="priority_gallery_tab">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_events">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="Events" class="form-control" name="events_tab" id="events_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" value="" class="form-control" size="5" name="priority_events_tab" id="priority_events_tab">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_about_us">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="About Us" class="form-control" name="about_us_tab" id="about_us_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" value="" size="5" class="form-control" name="priority_about_us_tab" id="priority_about_us_tab">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_contact_us">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="Contact Us" class="form-control" name="contact_us_tab" id="contact_us_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" value="" size="5" class="form-control" name="priority_contact_us_tab" id="priority_contact_us_tab">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="is_check_custom_1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Custom tab 1:
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" value="" class="form-control" name="custom_1" id="custom_1">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" value="" class="form-control" size="5" name="priority_custom_1" id="priority_custom_1">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="is_check_custom_2">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Custom tab 2:
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" value="" class="form-control" name="custom_2" id="custom_2">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" value="" class="form-control" size="5" name="priority_custom_1" id="priority_custom_2">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="is_check_custom_3">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Custom tab 3:
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" value="" class="form-control" name="custom_3" id="custom_3">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="text" value="" class="form-control" size="5" name="priority_custom_3" id="priority_custom_3">
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                                Save <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="tab_2">
                                                <form method="post" action="/cms/header-setting">
                                                    <div class="row">
                                                       <div class="col-md-2">
                                                            <label class="control-label">
                                                                Upload Logo :
                                                            </label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type='file' name="logo" onchange="readURL(this);" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img id="blah" src="#" alt="your image" />
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="control-label" style="font-size: 120%">
                                                                description:
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <textarea id="" name="description" cols="50" rows="4"> </textarea>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                                Save <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="tab_3">
                                                <form method="post" action="/cms/footer-setting">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="control-label" style="font-size: 120%">
                                                                footer:
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <textarea id="" name="footer" cols="50" rows="4"> </textarea>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                                Save <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="tab_4">
                                                <form method="post" action="/cms/slider-images">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Slider 1
                                                            </label>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="is_checked_slider1">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type='file' name="slider1" onchange="slider1(this);" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img id="slider_1" src="#" alt="your image" />
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Slider 2
                                                            </label>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="is_checked_slider2">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type='file' name="slider2" onchange="slider2(this);" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img id="slider_2" src="#" alt="your image" />
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Slider 3
                                                            </label>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="is_checked_slider3">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <input type='file' name="slider3" onchange="slider3(this);" />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <img id="slider_3" src="#" alt="your image" />
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                                Save <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="tab_5">
                                                <form method="post" action="/cms/social-links">
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="facebook_link_checked">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>
                                                                Your Facebook Account :
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="facebook_link" placeholder="Enter url">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="twitter_link_checked">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>
                                                                Your Twitter Account :
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="twitter_link" placeholder="Enter url">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="google_link_checked">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>
                                                                Your Google+ Account :
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="google_link" placeholder="Enter url">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="linkedIn_link_checked">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>
                                                                Your LinkedIn Account :
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="linkedIn_link" placeholder="Enter url">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="instagram_link_checked">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>
                                                                Your Instagram Account :
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="instagram_link" placeholder="Enter url">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" name="youtube_link_checked">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>
                                                                Your Youtube Account :
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="youtube_link" placeholder="Enter url">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                                Save <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="tab_6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <a href="/cms/pages" class="btn btn-red btn-wide pull-right"> Add </a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group" >
                                                            <fieldset>
                                                                <div id="tabsListing">
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="tab_7">
                                                <form action="/cms/contact-us-userForm" method="post">
                                                    <div class="row">
                                                        <div class="row">
                                                            <h4>User Form</h4>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="full_name_checked" value="">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Full name :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="full_name" class="form-control" placeholder="please enter full name">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="contact_no_checked" value="">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Contact no :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="number" name="contact_no" class="form-control" placeholder="please enter mobile number">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="full_email_checked" value="">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Contact no :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="email" name="email" class="form-control" placeholder="please enter email address">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="subject_checked" value="">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Subject :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="subject" class="form-control" placeholder="please enter subject">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="message_checked" value="">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Message :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="message" class="form-control" placeholder="please enter message">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <h4>Map</h4>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="map_checked" value="">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="control-label">
                                                                    Upload embed code :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="message" class="form-control" placeholder="enter embed code">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row ">
                                                            <h4>Contact Us Details</h4>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="address_checked" value="">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="control-label">
                                                                    Address :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="text" name="address" class="form-control" value="" placeholder="please enter address">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="contact_display_checked" value="">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label class="control-label">
                                                                    Contact No :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <input type="number" name="contact_display" class="form-control" value="" placeholder="please enter contact number">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="form-group col-md-1">
                                                                <input type="checkbox" name="email_display_checked" value="">
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label class="control-label">
                                                                    Email Id :
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-5">
                                                                <input type="email" class="form-control"  name="email_display" value="" placeholder="please enter email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                                Save <i class="fa fa-arrow-circle-right"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="tab_8">
                                                <form action="/cms/aboutUs" method="post">
                                                    <div class="row form-group">
                                                        <div class="row">
                                                            <h4>About Us</h4>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <textarea id="" name="About_us" cols="50" rows="4"> </textarea>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <img id="about_Us" src="#" alt="your image" />
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input type='file' name="aboutUs_image" onchange="aboutUs(this);" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                                Save <i class="fa fa-arrow-circle-right"></i>
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
                    @include('rightSidebar')
                </div>
            </div>
        </div>
        @include('footer')
    </div>
    <!-- start: MAIN JAVASCRIPTS -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/ckeditor/adapters/jquery.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
    <script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="/vendor/autosize/autosize.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/form-validation-edit.js"></script>
    <script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/form-elements.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script src="/assets/js/table-data.js"></script>
    <script src="/assets/js/form-validation.js"></script>
<script>
    $(document).ready(function (){
        $("textarea").ckeditor();
        Main.init();
        FormElements.init();
        tabListing()
    });
    function tabListing() {
        var str=0;
        $.ajax({
            url: "/cms/tabs-Listing",
            data:{str1 : str},
            success: function(response)
            {
                $("#tabsListing").html(response);
                TableData.init();
            }
        });
    }
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function slider1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#slider_1')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function slider2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#slider_2')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function slider3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#slider_3')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    function aboutUs(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#about_Us')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@stop
