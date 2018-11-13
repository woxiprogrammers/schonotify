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
                                            <li>
                                                <a href="#tab_9" data-toggle="tab"> Testimonial </a>
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
                                                            <input type="checkbox" checked="checked" name="is_check_home[status]">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="Home" class="form-control" name="is_check_home[menu_tab]" id="home_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" class="form-control" size="5" name="is_check_home[priority_menu_tab]" id="priority_home_tab">
                                                            @else
                                                                <input type="text" value="{{$tabNames[0]['priority']}}" class="form-control" size="5" name="is_check_home[priority_menu_tab]" id="priority_home_tab">
                                                            @endif
                                                            <input type="hidden" value="home" name="is_check_home[slug]">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_gallery[status]">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="Gallery" class="form-control" name="is_check_gallery[menu_tab]" id="gallery_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="hidden" value="gallery" name="is_check_gallery[slug]">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" size="5" class="form-control" name="is_check_gallery[priority_menu_tab]" id="priority_gallery_tab">
                                                            @else
                                                                <input type="text" value="{{$tabNames[1]['priority']}}" size="5" class="form-control" name="is_check_gallery[priority_menu_tab]" id="priority_gallery_tab">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_events[status]">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="Events" class="form-control" name="is_check_events[menu_tab]" id="events_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="hidden" value="events" name="is_check_events[slug]">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" class="form-control" size="5" name="is_check_events[priority_menu_tab]" id="priority_events_tab">
                                                            @else
                                                                <input type="text" value="{{$tabNames[2]['priority']}}" class="form-control" size="5" name="is_check_events[priority_menu_tab]" id="priority_events_tab">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_about_us[status]">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="About Us" class="form-control" name="is_check_about_us[menu_tab]" id="about_us_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="hidden" value="about-us" name="is_check_about_us[slug]">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" size="5" class="form-control" name="is_check_about_us[priority_menu_tab]" id="priority_about_us_tab">
                                                            @else
                                                                <input type="text" value="{{$tabNames[3]['priority']}}" size="5" class="form-control" name="is_check_about_us[priority_menu_tab]" id="priority_about_us_tab">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            <input type="checkbox" checked="checked" name="is_check_contact_us[status]">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" value="Contact Us" class="form-control" name="is_check_contact_us[menu_tab]" id="contact_us_tab" readonly>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="hidden" value="contact-us" name="is_check_contact_us[slug]">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" size="5" class="form-control" name="is_check_contact_us[priority_menu_tab]" id="priority_contact_us_tab">
                                                            @else
                                                                <input type="text" value="{{$tabNames[4]['priority']}}" size="5" class="form-control" name="is_check_contact_us[priority_menu_tab]" id="priority_contact_us_tab">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="checkbox" name="is_check_custom_1[status]">
                                                            @else
                                                                <input type="checkbox" checked="checked" name="is_check_custom_1[status]">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Custom tab 1:
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" class="form-control" name="is_check_custom_1[menu_tab]" id="custom_1">
                                                            @else
                                                                <input type="text" value="{{$tabNames[5]['display_name']}}" class="form-control" name="is_check_custom_1[menu_tab]" id="custom_1">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="hidden" value="custom-1" name="is_check_custom_1[slug]">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" class="form-control" size="5" name="is_check_custom_1[priority_menu_tab]" id="priority_custom_1">
                                                            @else
                                                                <input type="text" value="{{$tabNames[5]['priority']}}" class="form-control" size="5" name="is_check_custom_1[priority_menu_tab]" id="priority_custom_1">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="checkbox" name="is_check_custom_2[status]">
                                                            @else
                                                                <input type="checkbox" checked="checked" name="is_check_custom_2[status]">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Custom tab 2:
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" class="form-control" name="is_check_custom_2[menu_tab]" id="custom_2">
                                                            @else
                                                                <input type="text" value="{{$tabNames[6]['display_name']}}" class="form-control" name="is_check_custom_2[menu_tab]" id="custom_2">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="hidden" value="custom-2" name="is_check_custom_2[slug]">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" class="form-control" size="5" name="is_check_custom_2[priority_menu_tab]" id="priority_custom_2">
                                                            @else
                                                                <input type="text" value="{{$tabNames[6]['priority']}}" class="form-control" size="5" name="is_check_custom_2[priority_menu_tab]" id="priority_custom_2">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row form-group">
                                                        <div class="col-md-1">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="checkbox" name="is_check_custom_3[status]">
                                                            @else
                                                                <input type="checkbox" checked="checked" name="is_check_custom_3[status]">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label class="control-label">
                                                                Custom tab 3:
                                                            </label>
                                                        </div>
                                                        <div class="col-md-4">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" class="form-control" name="is_check_custom_3[menu_tab]" id="custom_3">
                                                            @else
                                                                <input type="text" value="{{$tabNames[7]['display_name']}}" class="form-control" name="is_check_custom_3[menu_tab]" id="custom_3">
                                                            @endif
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input type="hidden" value="custom-3" name="is_check_custom_3[slug]">
                                                            @if($tabNames == null || $tabNames == " ")
                                                                <input type="text" value="" class="form-control" size="5" name="is_check_custom_3[priority_menu_tab]" id="priority_custom_3">
                                                            @else
                                                                <input type="text" value="{{$tabNames[7]['priority']}}" class="form-control" size="5" name="is_check_custom_3[priority_menu_tab]" id="priority_custom_3">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <br><br>
                                                    <div class="row">
                                                        <div class="form-group col-md-7">
                                                            <button class="btn btn-primary btn-wide pull-right" id="submit" type="submit">
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
                                                                Upload Logo
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                            <label class="control-label">Select Images :</label>
                                                            <input id="imageupload" type="file" class="btn blue"/>
                                                            <br />
                                                            <div class="row">
                                                                <div id="preview-image" class="row">

                                                                </div>
                                                            </div>
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
                                                            @if($bodyDetails == null)
                                                                <textarea id="" name="description" cols="50" rows="4"> </textarea>
                                                            @else
                                                                <textarea id="" name="description" cols="50" rows="4"> {{$bodyDetails[0]['header_message']}}</textarea>
                                                            @endif
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
                                                            @if($bodyDetails == null)
                                                                <textarea id="" name="description" cols="50" rows="4"> </textarea>
                                                            @else
                                                                <textarea id="" name="description" cols="50" rows="4"> {{$bodyDetails[0]['footer_message']}}</textarea>
                                                            @endif
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
                                                        <div class="col-md-2">
                                                            <input type="checkbox" name="sliderImages1[is_checked_slider1]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Select Images  :</label>
                                                        <input id="imageUpload1" type="file" class="btn blue"/>
                                                        <br />
                                                        <div class="row">
                                                            <div id="preview-image1" class="row">

                                                            </div>
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
                                                            <input type="checkbox" name="sliderImages2[is_checked_slider2]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Select Images :</label>
                                                        <input id="imageUpload2" type="file" class="btn blue"/>
                                                        <br />
                                                        <div class="row">
                                                            <div id="preview-image2" class="row">

                                                            </div>
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
                                                            <input type="checkbox" name="sliderImages3[is_checked_slider3]">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">Select Images :</label>
                                                        <input id="imageUpload3" type="file" class="btn blue"/>
                                                        <br />
                                                        <div class="row">
                                                            <div id="preview-image3" class="row">

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
                                            <div class="tab-pane" id="tab_5">
                                                <form method="post" action="/cms/social-links">
                                                    @if($socialMediaDetails != null)
                                                        @foreach($socialMediaDetails as $social)
                                                            <div class="row form-group">
                                                                <div class="col-md-1">
                                                                    <?php $slug = \App\SocialPlatform::where('id',$social['social_platform_id'])->pluck('slug'); ?>
                                                                    @if($social['is_active'] == 1)
                                                                        <input type="checkbox" name="{{$slug}}_[is_check]" checked>
                                                                    @else
                                                                        <input type="checkbox" name="{{$slug}}_[is_check]">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>
                                                                        Your {{$slug}} Account :
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="hidden" value="{{$social['social_platform_id']}}" name="{{$slug}}_[social_platform_id]">
                                                                    <input type="text" class="form-control" name="{{$slug}}_[link]" value="{{$social['name']}}" placeholder="Enter url">
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @endforeach
                                                    @else
                                                        @foreach($socialPlatformNames as $socialLink)
                                                            <div class="row form-group">
                                                                <div class="col-md-1">
                                                                    <input type="checkbox" name="{{$socialLink['slug']}}_[is_check]">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label>
                                                                        Your {{$socialLink['name']}} Account :
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="hidden" value="{{$socialLink['id']}}" name="{{$socialLink['slug']}}_[social_platform_id]">
                                                                    <input type="text" class="form-control" name="{{$socialLink['slug']}}_[link]" placeholder="Enter url">
                                                                </div>
                                                            </div>
                                                            <hr>
                                                        @endforeach
                                                    @endif
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
                                                        </div>tabNames
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
                                                                <input type="checkbox" name="full_name_checked" >
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Full name :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="contact_no_checked" >
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Contact no :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="full_email_checked">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Email :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="subject_checked">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Subject :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-1">
                                                                <input type="checkbox" name="message_checked">
                                                            </div>
                                                            <div class="col-md-2 ">
                                                                <label class="control-label">
                                                                    Message :
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <h4>Map</h4>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label class="control-label">
                                                                    Upload embed code :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                @if($bodyDetails == null)
                                                                    <input type="text" name="map_embed" class="form-control" placeholder="enter embed code" >
                                                                @else
                                                                    <input type="text" name="map_embed" value="{{$bodyDetails[0]['map_embed']}}" class="form-control" placeholder="enter embed code" >
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row ">
                                                            <h4>Contact Us Details</h4>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label class="control-label">
                                                                    Address :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                @if($bodyDetails == null)
                                                                    <input type="text" name="address" class="form-control" value="" placeholder="please enter address" required>
                                                                @else
                                                                    <input type="text" name="address" class="form-control" value="{{$bodyDetails[0]['address']}}" placeholder="please enter address" required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="col-md-2">
                                                                <label class="control-label">
                                                                    Contact No :
                                                                </label>
                                                            </div>
                                                            <div class="col-md-5">
                                                                @if($bodyDetails == null)
                                                                    <input type="text" name="contact_display" class="form-control" value="" placeholder="please enter contact number" required>
                                                                @else
                                                                    <input type="text" name="contact_display" class="form-control" value="{{$bodyDetails[0]['contact_number']}}" placeholder="please enter contact number" required>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row form-group">
                                                            <div class="form-group col-md-2">
                                                                <label class="control-label">
                                                                    Email Id :
                                                                </label>
                                                            </div>
                                                            <div class="form-group col-md-5">
                                                                @if($bodyDetails == null)
                                                                    <input type="email" class="form-control"  name="email_display" value="" maxlength="10" placeholder="please enter email" required>
                                                                @else
                                                                    <input type="email" class="form-control"  name="email_display" value="{{$bodyDetails[0]['email']}}" maxlength="10" placeholder="please enter email" required>
                                                                @endif
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
                                                                @if($aboutUsDetails != null)
                                                                    <textarea id="" name="about_us" cols="50" rows="4"> {{$aboutUsDetails['description']}}</textarea>
                                                                @else
                                                                    <textarea id="" name="about_us" cols="50" rows="4"> </textarea>
                                                                @endif
                                                            </div>
                                                            @if($aboutUsDetails['image_name'] != null)
                                                                <? $ds=DIRECTORY_SEPARATOR;
                                                                $folderPath = env('ABOUT_US_IMAGE_UPLOAD');
                                                                $folderEncName = sha1($aboutUsDetails['body_id'])?>
                                                                <img src="{{$folderPath.$ds.$folderEncName.$ds.$aboutUsDetails['image_name']}}" style="border: 1px black solid" width="200" height="120"/>
                                                            @endif
                                                            <br>
                                                            <input id="imageUpload4" type="file" class="btn blue"/>
                                                            <br />
                                                            <div class="row">
                                                                <div id="preview-image4" class="row">

                                                                </div>
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
                                            <div class="tab-pane" id="tab_9">
                                                <form action="/cms/testimonial" method="post">
                                                    <div class="row form-group">
                                                        <div class="row">
                                                            <h4>Description</h4>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                    <textarea id="" name="description[testimonial_1]" cols="50" rows="4"> </textarea>
                                                            </div>
                                                            <input id="descriptionImageUpload_1" type="file" class="btn blue"/>
                                                            <br />
                                                            <div class="row">
                                                                <div id="description-preview-image" class="row">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="row">
                                                            <h4>Description</h4>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <textarea id="" name="description[testimonial_1]" cols="50" rows="4"> </textarea>
                                                            </div>
                                                            <input id="descriptionImageUpload_2" type="file" class="btn blue"/>
                                                            <br />
                                                            <div class="row">
                                                                <div id="description-preview-image-1" class="row">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="row">
                                                            <h4>Description</h4>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <textarea id="" name="description[testimonial_1]" cols="50" rows="4"> </textarea>
                                                            </div>
                                                            <input id="descriptionImageUpload_3" type="file" class="btn blue"/>
                                                            <br />
                                                            <div class="row">
                                                                <div id="description-preview-image-2" class="row">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="row">
                                                            <h4>Description</h4>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <textarea id="" name="description[testimonial_1]" cols="50" rows="4"> </textarea>
                                                            </div>
                                                            <input id="descriptionImageUpload_4" type="file" class="btn blue"/>
                                                            <br />
                                                            <div class="row">
                                                                <div id="description-preview-image-3" class="row">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="row">
                                                            <h4>Description</h4>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <textarea id="" name="description[testimonial_1]" cols="50" rows="4"> </textarea>
                                                            </div>
                                                            <input id="descriptionImageUpload_5" type="file" class="btn blue"/>
                                                            <br />
                                                            <div class="row">
                                                                <div id="description-preview-image-4" class="row">

                                                                </div>
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
            tabListing();
            $("#imageupload").on('change', function () {
                var imgPath = $(this)[0].value;
                var countFiles = $(this)[0].files.length;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#preview-image");
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader()
                            reader.onload = function (e) {
                                var imagePreview = '<div class="col-md-2"><input type="hidden" name="gallery_images" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
                                image_holder.append(imagePreview);
                            };
                            image_holder.show();
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    }else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only images");
                    $('#submit').hide();
                }
            });
            //for slider Images
            $("#imageUpload1").on('change', function () {
                var imgPath = $(this)[0].value;
                var countFiles = $(this)[0].files.length;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#preview-image1");
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader()
                            reader.onload = function (e) {
                                var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages1[slider_images_1]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
                                image_holder.append(imagePreview);
                            };
                            image_holder.show();
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    }else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only images");
                    $('#submit').hide();
                }
            });
            $("#imageUpload2").on('change', function () {
                var imgPath = $(this)[0].value;
                var countFiles = $(this)[0].files.length;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#preview-image2");
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader()
                            reader.onload = function (e) {
                                var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages2[slider_images_2]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
                                image_holder.append(imagePreview);
                            };
                            image_holder.show();
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    }else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only images");
                    $('#submit').hide();
                }
            });
            $("#imageUpload3").on('change', function () {
                var imgPath = $(this)[0].value;
                var countFiles = $(this)[0].files.length;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#preview-image3");
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader()
                            reader.onload = function (e) {
                                var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages3[slider_images_3]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
                                image_holder.append(imagePreview);
                            };
                            image_holder.show();
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    }else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only images");
                    $('#submit').hide();
                }
            });
            //about Us Images
            $("#imageUpload4").on('change', function () {
                var imgPath = $(this)[0].value;
                var countFiles = $(this)[0].files.length;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#preview-image4");
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader()
                            reader.onload = function (e) {
                                var imagePreview = '<div class="col-md-2"><input type="hidden" name="about_us_image" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
                                image_holder.append(imagePreview);
                            };
                            image_holder.show();
                            reader.readAsDataURL($(this)[0].files[i]);
                        }
                    }else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only images");
                    $('#submit').hide();
                }
            });
        });
        //
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

        $('#submit').click(function () {
            $('#submit').hide();
        })
    </script>
@stop
