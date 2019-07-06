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
        background:#c2c2c5;
    }
</style>
<div class="main-content" >
<div class="wrap-content container" id="container">
@include('alerts.errors')
<div id="message-error-div"></div>
<section id="page-title" class="padding-top-15 padding-bottom-15">
    <div class="row">
        <div class="col-sm-7">
            <h1 class="mainTitle">CMS</h1>
            <span class="mainDescription">Admin</span>
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
        <li>
            <a href="#tab_10" data-toggle="tab"> Marquee </a>
        </li>
    </ul>
</div>
<div class="col-md-9">
<div class="tab-content">
<div class="tab-pane active" id="tab_1">
<div class="container-fluid container-fullw">
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
    <div class="col-md-2">
        <lable class="control-label">
            <h4>Hyper links</h4>
        </lable>
    </div>
</div>

@if($tabNames == null &&  empty($tabNames))
<div class="row form-group">
    <div class="col-md-1">
        <input type="checkbox" checked="checked" name="is_check_home[status]">
    </div>
    <div class="col-md-6">
        <input type="text" value="Home" class="form-control" name="is_check_home[menu_tab]" id="home_tab" readonly>
    </div>
    <div class="col-md-2">
        <input type="hidden" value="home" name="is_check_home[slug]">
        <input type="text" value="" class="form-control" size="5" name="is_check_home[priority_menu_tab]" id="priority_home_tab" placeholder="enter priority">
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
        <input type="text" value="" size="5" class="form-control" name="is_check_gallery[priority_menu_tab]" id="priority_gallery_tab" placeholder="enter priority">
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
        <input type="text" value="" class="form-control" size="5" name="is_check_events[priority_menu_tab]" id="priority_events_tab" placeholder="enter priority">
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
        <input type="text" value="" size="5" class="form-control" name="is_check_about_us[priority_menu_tab]" id="priority_about_us_tab" placeholder="enter priority">
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
        <input type="text" value="" size="5" class="form-control" name="is_check_contact_us[priority_menu_tab]" id="priority_contact_us_tab" placeholder="enter priority">
    </div>
</div>
<br>
<div class="row form-group">
    <div class="col-md-1">
        <input type="checkbox" name="is_check_custom_1[status]">
    </div>
    <div class="col-md-2">
        <label class="control-label">
            Custom tab 1:
        </label>
    </div>
    <div class="col-md-4">
        <input type="text" value="" class="form-control" name="is_check_custom_1[menu_tab]" id="custom_1"  placeholder="enter custom tab name">
    </div>
    <div class="col-md-2">
        <input type="hidden" value="custom-1" name="is_check_custom_1[slug]">
        <input type="text" value="" class="form-control" size="5" name="is_check_custom_1[priority_menu_tab]" id="priority_custom_1" placeholder="enter priority">
    </div>
</div>
<br>
<div class="row form-group">
    <div class="col-md-1">
        <input type="checkbox" name="is_check_custom_2[status]">
    </div>
    <div class="col-md-2">
        <label class="control-label">
            Custom tab 2:
        </label>
    </div>
    <div class="col-md-4">
        <input type="text" value="" class="form-control" name="is_check_custom_2[menu_tab]" id="custom_2"  placeholder="enter custom tab name">
    </div>
    <div class="col-md-2">
        <input type="hidden" value="custom-2" name="is_check_custom_2[slug]">
        <input type="text" value="" class="form-control" size="5" name="is_check_custom_2[priority_menu_tab]" id="priority_custom_2" placeholder="enter priority">
    </div>
</div>
<br>
<div class="row form-group">
    <div class="col-md-1">
        <input type="checkbox" name="is_check_custom_3[status]">
    </div>
    <div class="col-md-2">
        <label class="control-label">
            Custom tab 3:
        </label>
    </div>
    <div class="col-md-4">
        <input type="text" value="" class="form-control" name="is_check_custom_3[menu_tab]" id="custom_3" placeholder="enter custom tab name">
    </div>
    <div class="col-md-2">
        <input type="hidden" value="custom-3" name="is_check_custom_3[slug]">
        <input type="text" value="" class="form-control" size="5" name="is_check_custom_3[priority_menu_tab]" id="priority_custom_3" placeholder="enter priority">
    </div>
</div>
<br>
<div class="row form-group">
    <div class="col-md-1">
        <input type="checkbox" name="is_check_custom_link_1[status]">
    </div>
    <div class="col-md-2">
        <label class="control-label">
            Custom tab link-1:
        </label>
    </div>
    <div class="col-md-4">
        <input type="text" value="" class="form-control" name="is_check_custom_link_1[menu_tab]" id="custom_link_1" placeholder="enter custom link name">
    </div>
    <div class="col-md-2">
        <input type="hidden" value="custom-link-1" name="is_check_custom_link_1[slug]">
        <input type="text" value="" class="form-control" size="5" name="is_check_custom_link_1[priority_menu_tab]" id="priority_custom_link_1" placeholder="enter priority">
    </div>
    <div class="col-md-3">
        <input type="text" value="" class="form-control" name="is_check_custom_link_1[link]" id="custom_link_1_link" placeholder="enter link">
    </div>
</div>
<br>
<div class="row form-group">
    <div class="col-md-1">
        <input type="checkbox" name="is_check_custom_link_2[status]">
    </div>
    <div class="col-md-2">
        <label class="control-label">
            Custom tab link-2:
        </label>
    </div>
    <div class="col-md-4">
        <input type="text" value="" class="form-control" name="is_check_custom_link_2[menu_tab]" id="custom_link_2" placeholder="enter custom link name">
    </div>
    <div class="col-md-2">
        <input type="hidden" value="custom-link-2" name="is_check_custom_link_2[slug]">
        <input type="text" value="" class="form-control" size="5" name="is_check_custom_link_2[priority_menu_tab]" id="priority_custom_link_2" placeholder="enter priority">
    </div>
    <div class="col-md-3">
        <input type="text" value="" class="form-control" name="is_check_custom_link_2[link]" id="custom_link_2_link" placeholder="enter link">
    </div>
</div>
<br>
<div class="row form-group">
    <div class="col-md-1">
        <input type="checkbox" name="is_check_custom_link_3[status]">
    </div>
    <div class="col-md-2">
        <label class="control-label">
            Custom tab link-3:
        </label>
    </div>
    <div class="col-md-4">
        <input type="text" value="" class="form-control" name="is_check_custom_link_3[menu_tab]" id="custom_link_3" placeholder="enter custom link name">
    </div>
    <div class="col-md-2">
        <input type="hidden" value="custom-link-3" name="is_check_custom_link_3[slug]">
        <input type="text" value="" class="form-control" size="5" name="is_check_custom_link_3[priority_menu_tab]" id="priority_custom_link_3" placeholder="enter priority">
    </div>
    <div class="col-md-3">
        <input type="text" value="" class="form-control" name="is_check_custom_link_3[link]" id="custom_link_3_link" placeholder="enter link">
    </div>
</div>
<br>
<div class="row form-group">
    <div class="col-md-1">
        <input type="checkbox" name="is_check_custom_link_4[status]">
    </div>
    <div class="col-md-2">
        <label class="control-label">
            Custom tab link-4:
        </label>
    </div>
    <div class="col-md-4">
        <input type="text" value="" class="form-control" name="is_check_custom_link_4[menu_tab]" id="custom_link_4" placeholder="enter custom link name">
    </div>
    <div class="col-md-2">
        <input type="hidden" value="custom-link-4" name="is_check_custom_link_4[slug]">
        <input type="text" value="" class="form-control" size="5" name="is_check_custom_link_4[priority_menu_tab]" id="priority_custom_link_4" placeholder="enter priority">
    </div>
    <div class="col-md-3">
        <input type="text" value="" class="form-control" name="is_check_custom_link_4[link]" id="custom_link_4_link" placeholder="enter link">
    </div>
</div>
@else
@foreach( $tabNames as $tabName)
<div class="row form-group">
    <div class="col-md-1">
        @if($tabName['is_active'] == 1)
        <input type="checkbox" checked="checked" name="is_check_{{$tabName['slug']}}[status]">
        @else
        <input type="checkbox" name="is_check_{{$tabName['slug']}}[status]">
        @endif
    </div>
    <div class="col-md-6">
        @if($tabName['display_name'] != null)
        <input type="text" value="{{$tabName['display_name']}}" class="form-control" name="is_check_{{$tabName['slug']}}[menu_tab]" id="custom_link_3" placeholder="{{$tabName['slug']}}">
        @else
        <input type="text" value="" class="form-control" name="is_check_{{$tabName['slug']}}[menu_tab]" id="custom_link_3" placeholder="{{$tabName['slug']}} tab">
        @endif
    </div>
    <div class="col-md-2">
        <input type="hidden" value="{{$tabName['slug']}}" name="is_check_{{$tabName['slug']}}[slug]">
        @if($tabName['priority'] != null)
        <input type="text" value="{{$tabName['priority']}}" class="form-control" size="5" name="is_check_{{$tabName['slug']}}[priority_menu_tab]" id="priority_custom_link_3" placeholder="enter priority">
        @else
        <input type="text" value="" class="form-control" size="5" name="is_check_{{$tabName['slug']}}[priority_menu_tab]" id="priority_custom_link_3" placeholder="enter priority">
        @endif
    </div>
    <div class="col-md-3">
        @if($tabName['link'] != null && ($tabName['slug'] == 'custom-link-1' || $tabName['slug'] == 'custom-link-2' || $tabName['slug'] == 'custom-link-3' || $tabName['slug'] == 'custom-link-4' || $tabName['slug'] == 'custom-link-5' || $tabName['slug'] == 'custom-link-6' || $tabName['slug'] == 'custom-link-7'))
        <input type="text" value="{{$tabName['link']}}" class="form-control" name="is_check_{{$tabName['slug']}}[link]" id="custom_link_3_link" placeholder="enter link">
        @elseif($tabName['link'] == null && ($tabName['slug'] == 'custom-link-1' || $tabName['slug'] == 'custom-link-2' || $tabName['slug'] == 'custom-link-3' || $tabName['slug'] == 'custom-link-4' || $tabName['slug'] == 'custom-link-5' || $tabName['slug'] == 'custom-link-6' || $tabName['slug'] == 'custom-link-7'))
        <input type="text" value="" class="form-control" name="is_check_{{$tabName['slug']}}[link]" id="custom_link_3_link" placeholder="enter link">
        @endif
    </div>
</div>
@endforeach
@endif
<br><br>
<div class="row">
    <div class="form-group col-md-10">
        <button class="btn btn-primary btn-wide pull-right" id="submit" type="submit">
            Save <i class="fa fa-arrow-circle-right"></i>
        </button>
    </div>
</div>
</form>
</div>
</div>
<div class="tab-pane" id="tab_2">
    <form method="post" action="/cms/header-setting">
        <div class="row">
            <div class="col-md-8">
                <label class="control-label">
                    Upload logo
                </label>
                <br>
                <label class="control-label">Select Images : <b>size(121*108 pixels)</b></label>
                <input id="imageupload" type="file" class="btn blue"/>
                <br />
            </div>
            <div class="col-md-3">
                    @if($bodyDetails['logo_name'] != null)
                    <?php $ds=DIRECTORY_SEPARATOR;
                    $folderEncName = sha1($bodyDetails['body_id']);
                    $folderPath = env('LOGO_FILE_UPLOAD').$ds.$folderEncName;?>
                    <img src="{{$folderPath.$ds.$bodyDetails['logo_name']}}" style="height: 150px; width: 150px">
                    @endif
            </div>
        </div>
        <div class="row">
            <div id="preview-image" class="row">

            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-5">
                <label class="control-label">
                    Upload Image
                </label>
                <br>
                <label class="control-label">Select Images : <b>size(1920*120 pixels)</b></label>
                <input id="uploadImage" type="file" class="btn blue"/>
                <br />
            </div>
            <div class="col-md-3">
                <label class="control-label">
                    Tick to Select Image
                </label>
                @if($headerImage != null)
                    @if($headerImage['is_active'] == true)
                        <input type="checkbox" name="is_checked" checked>
                    @else
                        <input type="checkbox" name="is_checked">
                    @endif
                    @else
                    <input type="checkbox" name="is_checked">
                @endif
            </div>
            <div class="col-md-3">
                    @if($headerImage['image_name'] != null)
                        <?php $ds=DIRECTORY_SEPARATOR;
                        $folderEncName = sha1($headerImage['body_id']);
                        $folderPath = env('HEADER_IMAGE_UPLOAD').$ds.$folderEncName;?>
                        <img src="{{$folderPath.$ds.$headerImage['image_name']}}" style="height: 150px; width: 150px">
                    @endif
            </div>
        </div>
        <div class="row">
            <div id="preview-uploadImage" class="row">

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
                <textarea id="" name="description" cols="50" rows="4"> {{$bodyDetails['header_message']}}</textarea>
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
                <textarea id="" name="footer" cols="50" rows="4"> </textarea>
                @else
                <textarea id="" name="footer" cols="50" rows="4"> {{$bodyDetails['footer_message']}}</textarea>
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
<?php
$count = 1;
$sliderTotalCount = 4;
$sliderCount = (count($sliderImages));
?>
@if($sliderImages != null && !empty($sliderImages))
@foreach($sliderImages  as $key => $value)
<div class="row">
    <div class="col-md-5">
        <label class="control-label" style="font-size: 100%">
            <b><i>Please tick to select the Slider {{$count}}</i></b>
        </label>
    </div>
    <div class="col-md-2">
        @if($value['is_active'] == 1)
        <input type="checkbox" checked="checked" id="slider1_checked" name="sliderImages{{$count}}[is_checked_slider]">
        @else
        <input type="checkbox" id="slider1_checked" name="sliderImages{{$count}}[is_checked_slider]">
        @endif
    </div>
    <input type="hidden" name="sliderImages{{$count}}[id]" value="{{$value['id']}}">
    <input type="hidden" name="sliderImages{{$count}}[image]" value="{{$value['name']}}">
    <div class="col-md-4">
        <?php $ds=DIRECTORY_SEPARATOR;
        $folderEncName = sha1($value['id']);
        $folderPath = env('SLIDER_IMAGES_UPLOAD').$ds.$folderEncName;?>
        <img src="{{$folderPath.$ds.$value['name']}}" style="height: 100px; width: 150px">
    </div>
</div>
<div class="form-group">
    <label class="control-label">Select Images  : <b>size(1200*400 pixels)</b></label>
    <input id="imageUpload{{$count}}" type="file" class="btn blue"/>
    <br />
    <div class="row">
        <div id="preview-image{{$count}}" class="row">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="control-label">
            Message 1
        </label>
        @if($value['message_1'] != null)
        <input type="text" name="sliderImages{{$count}}[message_1]" id="message_1" value="{{$value['message_1']}}" placeholder="enter the message">
        @else
        <input type="text" name="sliderImages{{$count}}[message_1]" id="message_1" value="" placeholder="enter the message">
        @endif
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Message 2
        </label>
        @if($value['message_2'] != null)
        <input type="text" name="sliderImages{{$count}}[message_2]" id="message_2" value="{{$value['message_2']}}" placeholder="enter the message">
        @else
        <input type="text" name="sliderImages{{$count}}[message_2]" id="message_2" value="" placeholder="enter the message">
        @endif
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link title
        </label>
        @if($value['hyper_name'] != null)
        <input type="text" name="sliderImages{{$count}}[link_title]" id="link_title" value="{{$value['hyper_name']}}" placeholder="enter link title">
        @else
        <input type="text" name="sliderImages{{$count}}[link_title]" id="link_title" value="" placeholder="enter link title">
        @endif
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link
        </label>
        @if($value['hyper_link'] != null)
        <input type="text" name="sliderImages{{$count}}[link]" id="link_title" value="{{$value['hyper_link']}}" placeholder="enter hyper Link">
        @else
        <input type="text" name="sliderImages{{$count}}[link]" id="link_title" value="" placeholder="enter hyper Link">
        @endif
    </div>
</div>
<br>
<hr>
<?php $count++?>
@endforeach
@if($count <= $sliderTotalCount)
@for($i=$count ; $i <= $sliderTotalCount ; $i++,$count++)
<div class="row">
    <div class="col-md-5">
        <label class="control-label" style="font-size: 100%">
            <b><i>Please tick to select the Slider {{$count}}</i></b>
        </label>
    </div>
    <div class="col-md-2">
        <input type="checkbox" id="slider1_checked" name="sliderImages{{$count}}[is_checked_slider]">
    </div>

</div>
<div class="form-group">
    <label class="control-label">Select Images  :  <b>size(1200*400 pixels)</b></label>
    <input id="imageUpload{{$count}}" type="file" class="btn blue"/>
    <br />
    <div class="row">
        <div id="preview-image{{$count}}" class="row">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="control-label">
            Message 1
        </label>
        <input type="text" name="sliderImages{{$count}}[message_1]" id="message_1" value="" placeholder="enter the message">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Message 2
        </label>
        <input type="text" name="sliderImages{{$count}}[message_2]" id="message_2" value="" placeholder="enter the message">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link title
        </label>
        <input type="text" name="sliderImages{{$count}}[link_title]" id="link_title" value="" placeholder="enter link title">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link
        </label>
        <input type="text" name="sliderImages{{$count}}[link]" id="link_title" value="" placeholder="enter hyper Link">
    </div>
</div>
<br>
<hr>
@endfor
@endif
@else
<div class="row">
    <div class="col-md-5">
        <label class="control-label" style="font-size: 100%">
            <b><i>Please tick to select the Slider 1</i></b>
        </label>
    </div>
    <div class="col-md-2">
        <input type="checkbox" id="slider1_checked" name="sliderImages1[is_checked_slider]">
    </div>
</div>
<div class="form-group">
    <label class="control-label">Select Images  : <b>size(1200*400 pixels)</b></label>
    <input id="imageUpload1" type="file" class="btn blue"/>
    <br />
    <div class="row">
        <div id="preview-image1" class="row">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="control-label">
            Message 1
        </label>
        <input type="text" name="sliderImages1[message_1]" id="message_1" value="" placeholder="enter the message">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Message 2
        </label>
        <input type="text" name="sliderImages1[message_2]" id="message_2" value="" placeholder="enter the message">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link title
        </label>
        <input type="text" name="sliderImages1[link_title]" id="link_title" value="" placeholder="enter link title">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link
        </label>
        <input type="text" name="sliderImages1[link]" id="link_title" value="" placeholder="enter hyper Link">
    </div>
</div>
<br>
<hr>
<div class="row">
    <div class="col-md-5">
        <label class="control-label" style="font-size: 100%">
            <b><i>Please tick to select the Slider 2</i></b>
        </label>
    </div>
    <div class="col-md-1">
        <input type="checkbox"  name="sliderImages2[is_checked_slider]">
    </div>
</div>
<div class="form-group">
    <label class="control-label">Select Images : <b>size(1200*400 pixels)</b></label>
    <input id="imageUpload2" type="file" class="btn blue"/>
    <br />
    <div class="row">
        <div id="preview-image2" class="row">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="control-label">
            Message 1
        </label>
        <input type="text" name="sliderImages2[message_1]" id="message_1" value="" placeholder="enter the message">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Message 2
        </label>
        <input type="text" name="sliderImages2[message_2]" id="message_2" value="" placeholder="enter the message">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link title
        </label>
        <input type="text" name="sliderImages2[link_title]" id="link_title" value="" placeholder="enter link title">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link
        </label>
        <input type="text" name="sliderImages2[link]" id="link_title" value="" placeholder="enter hyper Link">
    </div>
</div>
<br>
<hr>
<div class="row">
    <div class="col-md-5">
        <label class="control-label" style="font-size: 100%">
            <b><i>Please tick to select the Slider 3</i></b>
        </label>
    </div>
    <div class="col-md-1">
        <input type="checkbox" name="sliderImages3[is_checked_slider]">
    </div>
</div>
<div class="form-group">
    <label class="control-label">Select Images : <b>size(1200*400  pixels)</b></label>
    <input id="imageUpload3" type="file" class="btn blue"/>
    <br />
    <div class="row">
        <div id="preview-image3" class="row">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label class="control-label">
            Message 1
        </label>
        <input type="text" name="sliderImages3[message_1]" id="message_1" value="" placeholder="enter the message">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Message 2
        </label>
        <input type="text" name="sliderImages3[message_2]" id="message_2" value="" placeholder="enter the message">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link title
        </label>
        <input type="text" name="sliderImages3[link_title]" id="link_title" value="" placeholder="enter link title">
    </div>
    <div class="col-md-3">
        <label class="control-label">
            Hyper Link
        </label>
        <input type="text" name="sliderImages3[link]" id="link_title" value="" placeholder="enter hyper Link">
    </div>
</div>
        <br>
        <hr>
        <div class="row">
            <div class="col-md-5">
                <label class="control-label" style="font-size: 100%">
                    <b><i>Please tick to select the Slider 4</i></b>
                </label>
            </div>
            <div class="col-md-1">
                <input type="checkbox" name="sliderImages4[is_checked_slider]">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label">Select Images : <b>size(1200*400 pixels)</b></label>
            <input id="imageUpload4" type="file" class="btn blue"/>
            <br />
            <div class="row">
                <div id="preview-image4" class="row">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label class="control-label">
                    Message 1
                </label>
                <input type="text" name="sliderImages4[message_1]" id="message_1" value="" placeholder="enter the message">
            </div>
            <div class="col-md-3">
                <label class="control-label">
                    Message 2
                </label>
                <input type="text" name="sliderImages4[message_2]" id="message_2" value="" placeholder="enter the message">
            </div>
            <div class="col-md-3">
                <label class="control-label">
                    Hyper Link title
                </label>
                <input type="text" name="sliderImages4[link_title]" id="link_title" value="" placeholder="enter link title">
            </div>
            <div class="col-md-3">
                <label class="control-label">
                    Hyper Link
                </label>
                <input type="text" name="sliderImages4[link]" id="link_title" value="" placeholder="enter hyper Link">
            </div>
        </div>
@endif
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
            @if($contactUsForm != null && !empty($contactUsForm))
            @foreach($contactUsForm as $contactForm)
            <div class="row form-group">
                <div class="col-md-1">
                    @if($contactForm['is_active'] == 1)
                    <input type="checkbox" checked="checked" name="{{$contactForm['slug']}}_checked[checked]">
                    @else
                    <input type="checkbox" name="{{$contactForm['slug']}}_checked[checked]">
                    @endif
                </div>
                <div class="col-md-2 ">
                    <label class="control-label">
                        {{$contactForm['name']}} :
                    </label>
                    <input type="hidden" name="{{$contactForm['slug']}}_checked[name]" value="{{$contactForm['name']}}">
                    <input type="hidden" name="{{$contactForm['slug']}}_checked[slug]" value="{{$contactForm['slug']}}">
                    <input type="hidden" name="{{$contactForm['slug']}}_checked[id]" value="{{$contactForm['id']}}">
                </div>
            </div>
            @endforeach
            @else
            <div class="row form-group">
                <div class="col-md-1">
                    <input type="checkbox" name="full_name_checked[checked]" >
                </div>
                <div class="col-md-2 ">
                    <label class="control-label">
                        Full name :
                    </label>
                    <input type="hidden" name="full_name_checked[name]" value="Full name">
                    <input type="hidden" name="full_name_checked[slug]" value="full_name">
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-1">
                    <input type="checkbox" name="contact_no_checked[checked]">
                </div>
                <div class="col-md-2 ">
                    <label class="control-label">
                        Contact no :
                    </label>
                    <input type="hidden" name="contact_no_checked[name]" value="Contact No">
                    <input type="hidden" name="contact_no_checked[slug]" value="contact_no">
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-1">
                    <input type="checkbox" name="full_email_checked[checked]">
                </div>
                <div class="col-md-2 ">
                    <label class="control-label">
                        Email :
                    </label>
                    <input type="hidden" name="full_email_checked[name]" value="Email">
                    <input type="hidden" name="full_email_checked[slug]" value="email">
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-1">
                    <input type="checkbox" name="subject_checked[checked]">
                </div>
                <div class="col-md-2 ">
                    <label class="control-label">
                        Subject :
                    </label>
                    <input type="hidden" name="subject_checked[name]" value="Subject">
                    <input type="hidden" name="subject_checked[slug]" value="subject">
                </div>
            </div>
            <br>
            <div class="row form-group">
                <div class="col-md-1">
                    <input type="checkbox" name="message_checked[checked]">
                </div>
                <div class="col-md-2 ">
                    <label class="control-label">
                        Message :
                    </label>
                    <input type="hidden" name="message_checked[name]" value="Message">
                    <input type="hidden" name="message_checked[slug]" value="message">
                </div>
            </div>
            @endif
            <div class="row">
                <div class="form-group col-md-7">
                    <button class="btn btn-primary btn-wide pull-right" type="submit">
                        Save <i class="fa fa-arrow-circle-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
    <hr>
    <form action="/cms/contact-us-detail" method="post">
        <div class="row">
            <div class="row">
                <h4>Map</h4>
            </div>
            <div class="row form-group">
                <div class="col-md-2">
                    <label class="control-label">
                       Google map Embed code(URL only):
                    </label>
                </div>
                <div class="col-md-5">
                    @if($bodyDetails == null)
                    <input type="text" name="map_embed" class="form-control" placeholder="enter embed code" >
                    @else
                    <input type="text" name="map_embed" value="{{$bodyDetails['map_embed']}}" class="form-control" placeholder="enter embed code" >
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
                        <textarea name="address" class="form-control"  placeholder="please enter address" required ></textarea>
                    @else
                        <textarea name="address" class="form-control"  placeholder="please enter address" required>{{$bodyDetails['address']}}</textarea>
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
                    <input type="text" name="contact_display" class="form-control" value="{{$bodyDetails['contact_number']}}" placeholder="please enter contact number" required>
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
                    <input type="email" class="form-control"  name="email_display" value="" placeholder="please enter email" required>
                    @else
                    <input type="email" class="form-control"  name="email_display" value="{{$bodyDetails['email']}}" placeholder="please enter email" required>
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
                <?php $ds=DIRECTORY_SEPARATOR;
                $folderPath = env('ABOUT_US_IMAGE_UPLOAD');
                $folderEncName = sha1($aboutUsDetails['body_id'])?>
                <img src="{{$folderPath.$ds.$folderEncName.$ds.$aboutUsDetails['image_name']}}" style="border: 1px black solid" width="200" height="120"/>
                @endif
                <br>
                <label class="control-label">upload Image :  <b>size(235*291 pixels)</b></label>
                <input id="aboutUsImage" type="file" class="btn blue"/>
                <br />
                <div class="row">
                    <div id="preview-about-us" class="row">

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
        <?php
        $count = 1;
        $testimonialTotalCount = 5;
        $testimonialCount = (count($testimonialData));
        ?>
        @if($testimonialData != null && !empty($testimonialData))
        @foreach($testimonialData as $testimoData)
        <div class="row form-group">
            <div class="row text-center">
                <h4 >Testimonial {{$count}}</h4>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1">
                    @if($testimoData['is_active'] == 1)
                    <input type="checkbox" checked="checked" name="description{{$count}}[is_check]">
                        @else
                        <input type="checkbox" name="description{{$count}}[is_check]">
                    @endif
                </div>
                <input type="hidden" value="{{$testimoData['id']}}" name="description{{$count}}[id]">
                <input type="hidden" value="{{$testimoData['image_name']}}" name="description{{$count}}[image_name]">
                <div class="col-md-6">
                    <textarea id="" name="description{{$count}}[testimonial]" cols="50" rows="4">{{$testimoData['description']}} </textarea>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Uploade Images  <b>size(123*123 pixels)</b></label>
                    <input id="TestimonialImageUpload_{{$count}}" type="file" class="btn blue"/>
                    <br />
                    <div class="row">
                        <div id="description-preview-image-{{$count}}" class="row">

                        </div>
                    </div>
                    <?php $ds=DIRECTORY_SEPARATOR;
                    $folderPath = env('TESTIMONIAL_IMAGE_UPLOAD');
                    $folderEncName = sha1($testimoData['id'])?>
                    <img src="{{$folderPath.$ds.$folderEncName.$ds.$testimoData['image_name']}}" style="border: 1px black solid" width="200" height="120"/>
                </div>
            </div>
        </div>
        <br><hr>
        <?php $count++?>
        @endforeach
        @if($count <= $testimonialTotalCount)
        @for($i=$count ; $i <= $testimonialTotalCount ; $i++,$count++)
        <div class="row form-group">
            <div class="row text-center">
                <h4 >Testimonial {{$count}}</h4>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1">
                    <input type="checkbox" name="description{{$count}}[is_check]">
                </div>
                <div class="col-md-6">
                    <textarea id="" name="description{{$count}}[testimonial]" cols="50" rows="4"> </textarea>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Uploade Images  <b>size(123*123 pixels)</b></label>
                    <input id="TestimonialImageUpload_{{$count}}" type="file" class="btn blue"/>
                    <br />
                    <div class="row">
                        <div id="description-preview-image-{{$count}}" class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><hr>
        @endfor
        @endif
        @else
        <div class="row form-group">
            <div class="row text-center">
                <h4 >Testimonial 1</h4>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1">
                    <input type="checkbox" name="description1[is_check]">
                </div>
                <div class="col-md-6">
                    <textarea id="" name="description1[testimonial]" cols="50" rows="4"> </textarea>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Uploade Images  <b>size(123*123 pixels)</b></label>
                    <input id="TestimonialImageUpload_1" type="file" class="btn blue"/>
                    <br />
                    <div class="row">
                        <div id="description-preview-image-1" class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><hr>
        <div class="row form-group">
            <div class="row text-center">
                <h4 >Testimonial 2</h4>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1">
                    <input type="checkbox" name="description2[is_check]">
                </div>
                <div class="col-md-6">
                    <textarea id="" name="description2[testimonial]" cols="50" rows="4"> </textarea>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Uploade Images  <b>size(123*123 pixels)</b></label>
                    <input id="TestimonialImageUpload_2" type="file" class="btn blue"/>
                    <br />
                    <div class="row">
                        <div id="description-preview-image-2" class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><hr>
        <div class="row form-group">
            <div class="row text-center">
                <h4 >Testimonial 3</h4>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1">
                    <input type="checkbox" name="description3[is_check]">
                </div>
                <div class="col-md-6">
                    <textarea id="" name="description3[testimonial]" cols="50" rows="4"> </textarea>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Uploade Images  <b>size(123*123 pixels)</b></label>
                    <input id="TestimonialImageUpload_3" type="file" class="btn blue"/>
                    <br />
                    <div class="row">
                        <div id="description-preview-image-3" class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><hr>
        <div class="row form-group">
            <div class="row text-center">
                <h4 >Testimonial 4</h4>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1">
                    <input type="checkbox" name="description4[is_check]">
                </div>
                <div class="col-md-6">
                    <textarea id="" name="description4[testimonial]" cols="50" rows="4"> </textarea>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Uploade Images  <b>size(123*123 pixels)</b></label>
                    <input id="TestimonialImageUpload_4" type="file" class="btn blue"/>
                    <br />
                    <div class="row">
                        <div id="description-preview-image-4" class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br><hr>
        <div class="row form-group">
            <div class="row text-center">
                <h4 >Testimonial 5</h4>
            </div>
            <br>
            <div class="row">
                <div class="col-md-1">
                    <input type="checkbox" name="description5[is_check]">
                </div>
                <div class="col-md-6">
                    <textarea id="" name="description5[testimonial]" cols="50" rows="4"> </textarea>
                </div>
                <div class="col-md-4">
                    <label class="control-label">Uploade Images  <b>size(123*123 pixels)</b></label>
                    <input id="TestimonialImageUpload_5" type="file" class="btn blue"/>
                    <br />
                    <div class="row">
                        <div id="description-preview-image-5" class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <br>
        <div class="row">
            <div class="form-group col-md-10">
                <button class="btn btn-primary btn-wide pull-right" type="submit">
                    Save <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </form>
</div>
    <div class="tab-pane" id="tab_10">
        <form action="/cms/marquee" method="post">
            <div class="row form-group">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">
                                marquee right to left:
                            </label>
                        </div>
                        <div class="col-md-9">
                            @if($marquee != null && $marquee != "")
                                    <textarea name="marquee[description_1]" cols="50" rows="4" required="required">{{$marquee['marquee_1']}} </textarea>
                                @else
                                    <textarea name="marquee[description_1]" cols="50" rows="4" required="required"> </textarea>
                            @endif
                        </div>
                    </div>
                </div>
                <br>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label">
                                marquee down to up:
                            </label>
                        </div>
                        <div class="col-md-9">
                            @if($marquee != null && $marquee != "")
                                <textarea name="marquee[description_2]" cols="50" rows="4" required="required">{{$marquee['marquee_2']}} </textarea>
                            @else
                                <textarea name="marquee[description_2]" cols="50" rows="4" required="required"> </textarea>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-10">
                        <button class="btn btn-primary btn-wide pull-right" type="submit">
                            Save <i class="fa fa-arrow-circle-right"></i>
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
    function deletePage(id){
        var remove = confirm('Are you sure you want to remove this page');
        if(remove == true){
            $.ajax({
                url: "/cms/pageRemove/"+id,
                success: function(response)
                {
                    location.reload();
                }
            })
        }else{
            location.reload();
        }
    }
$(document).ready(function (){
    $("textarea").ckeditor();
    Main.init();
    FormElements.init();
    tabListing();
    $("#imageupload").on('change', function () {
        var imgPath = $(this)[0].value;
        var countFiles = $(this)[0].files.length;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var size = this.files[0].size/1024/1024;
        var image_holder = $("#preview-image");
        if(size <= 1){
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
        }else{
            alert("please select image less than 1 mb");
        }
    });

    $("#uploadImage").on('change', function () {
        var imgPath = $(this)[0].value;
        var countFiles = $(this)[0].files.length;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var size = this.files[0].size/1024/1024;
        var image_holder = $("#preview-uploadImage");
        if(size <= 1){
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    for (var i = 0; i < countFiles; i++) {
                        var reader = new FileReader()
                        reader.onload = function (e) {
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="header_image" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }else{
            alert("please select image less than 1 mb");
        }
    });
    //for slider Images
    $("#imageUpload1").on('change', function () {
        var imgPath = $(this)[0].value;
        var countFiles = $(this)[0].files.length;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var size = this.files[0].size/1024/1024;
        var image_holder = $("#preview-image1");
        if(size <= 2){
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    for (var i = 0; i < countFiles; i++) {
                        var reader = new FileReader()
                        reader.onload = function (e) {
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages1[slider_images]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }else{
            alert("please select image less than 2 mb");
        }

    });
    $("#imageUpload2").on('change', function () {
        var imgPath = $(this)[0].value;
        var countFiles = $(this)[0].files.length;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var size = this.files[0].size/1024/1024;
        var image_holder = $("#preview-image2");
        if(size <= 2){
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    for (var i = 0; i < countFiles; i++) {
                        var reader = new FileReader()
                        reader.onload = function (e) {
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages2[slider_images]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }else{
            alert("please select image less than 2 mb");
        }

    });
    $("#imageUpload3").on('change', function () {
        var imgPath = $(this)[0].value;
        var countFiles = $(this)[0].files.length;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var size = this.files[0].size/1024/1024;
        var image_holder = $("#preview-image3");
        if(size <= 2){
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    for (var i = 0; i < countFiles; i++) {
                        var reader = new FileReader()
                        reader.onload = function (e) {
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages3[slider_images]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }else{
            alert("please select image less than 2 mb");
        }
    });
    $("#imageUpload4").on('change', function () {
        var imgPath = $(this)[0].value;
        var countFiles = $(this)[0].files.length;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var size = this.files[0].size/1024/1024;
        var image_holder = $("#preview-image4");
        if(size <= 2){
            if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                if (typeof (FileReader) != "undefined") {
                    for (var i = 0; i < countFiles; i++) {
                        var reader = new FileReader()
                        reader.onload = function (e) {
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages4[slider_images]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }else{
            alert("please select image less than 2 mb");
        }
    });
    //about Us Images
    $("#aboutUsImage").on('change', function () {
        var imgPath = $(this)[0].value;
        var countFiles = $(this)[0].files.length;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var size = this.files[0].size/1024/1024;
        var image_holder = $("#preview-about-us");
        if(size <= 1){
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
        }else{
            alert("please select image less than 1 mb");
        }
    });
});
// testimonial images
$("#TestimonialImageUpload_1").on('change', function () {
    var imgPath = $(this)[0].value;
    var countFiles = $(this)[0].files.length;
    var size = this.files[0].size/1024/1024;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    var image_holder = $("#description-preview-image-1");
    if(size <= 2){
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader()
                    reader.onload = function (e) {
                        var imagePreview = '<div class="col-md-2"><input type="hidden" name="description1[testimonialImage]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }
    }else{
        alert("please select image less than 2 mb");
    }

});
$("#TestimonialImageUpload_2").on('change', function () {
    var imgPath = $(this)[0].value;
    var countFiles = $(this)[0].files.length;
    var size = this.files[0].size/1024/1024;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    var image_holder = $("#description-preview-image-2");
    if(size <= 2){
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader()
                    reader.onload = function (e) {
                        var imagePreview = '<div class="col-md-2"><input type="hidden" name="description2[testimonialImage]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }
    }else{
        alert("please select image less than 2 mb");
    }

});
$("#TestimonialImageUpload_3").on('change', function () {
    var imgPath = $(this)[0].value;
    var countFiles = $(this)[0].files.length;
    var size = this.files[0].size/1024/1024;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    var image_holder = $("#description-preview-image-3");
    if(size <= 2){
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader()
                    reader.onload = function (e) {
                        var imagePreview = '<div class="col-md-2"><input type="hidden" name="description3[testimonialImage]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }
    }else{
        alert("please select image less than 2 mb");
    }

});
$("#TestimonialImageUpload_4").on('change', function () {
    var imgPath = $(this)[0].value;
    var countFiles = $(this)[0].files.length;
    var size = this.files[0].size/1024/1024;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    var image_holder = $("#description-preview-image-4");
    if(size <= 2){
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader()
                    reader.onload = function (e) {
                        var imagePreview = '<div class="col-md-2"><input type="hidden" name="description4[testimonialImage]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }
    }else{
        alert("please select image less than 2 mb");
    }

});
$("#TestimonialImageUpload_5").on('change', function () {
    var imgPath = $(this)[0].value;
    var countFiles = $(this)[0].files.length;
    var size = this.files[0].size/1024/1024;
    var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
    var image_holder = $("#description-preview-image-5");
    if(size <= 2){
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader()
                    reader.onload = function (e) {
                        var imagePreview = '<div class="col-md-2"><input type="hidden" name="description5[testimonialImage]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
        }
    }else{
        alert("please select image less than 2 mb");
    }
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

$('#submit').click(function () {
    $('#submit').hide();
})
</script>
@stop
