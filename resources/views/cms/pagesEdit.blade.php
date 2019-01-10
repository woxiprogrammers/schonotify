<?php
/**
 * Created by PhpStorm.
 * User: Nishank Rathod
 * Date: 10/1/18
 * Time: 12:01 PM
 */
?>

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
                            <h1 class="mainTitle">Pages</h1>
                            <span class="mainDescription">Create</span>
                        </div>
                        <div class="col-sm-5">
                            <!-- start: MINI STATS WITH SPARKLINE -->
                            <!-- end: MINI STATS WITH SPARKLINE -->
                        </div>
                    </div>
                </section>
                <div class="container-fluid container-fullw bg-white">
                    <form action="/cms/sub-pages-edit/{{$pagesDetail['id']}}" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Main Menu :
                                    </label>
                                    <select class="form-control" name="main_pages" style="-webkit-appearance: menulist;">
                                        @foreach($tabNames as $tabname)
                                            @if($pagesDetail['display_name'] == $tabname['display_name'])
                                                <option value="{{$pagesDetail['slug']}}" selected>{{$pagesDetail['display_name']}}</option>
                                            @else
                                                <option value="{{$tabname['slug']}}">{{$tabname['display_name']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Title :
                                    </label>
                                    <input type="text" class="form-control" name="sub_tab_name" value="{{$pagesDetail['display_name']}}" placeholder="Enter title">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="control-label col-md-2">Select Page Icon: <b>size(16*16 pixels)</b></label>
                            <input id="imageupload" type="file" class="btn blue col-md-3"/>
                            <div class="col-md-3" >
                                <div id="preview-image" class="row">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="control-label">
                                Description :
                            </label>
                            <div class="col-md-12">
                                <textarea id="" name="page_description" cols="50" rows="4"> {{$pagesDetail['description']}}</textarea>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-md-5">
                                <label class="control-label" style="font-size: 100%">
                                    <b><i>Please tick to select the Slider 1</i></b>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <input type="checkbox" id="slider1_checked" name="sliderImages[sliderImages1][is_checked_slider]">
                            </div>
                        </div>
                        <?php
                            if(count($sliderImages) > 0){
                                $sliderImagesPath = env('SLIDER_IMAGES_UPLOAD').DIRECTORY_SEPARATOR.sha1($pagesDetail['id']);
                            }
                        ?>
                        <div class="form-group">
                            <label class="control-label">Select Images  : <b>size(1920*500 pixels)</b></label>
                            <input id="imageUpload1" type="file" class="btn blue"/>
                            @if(count($sliderImages) > 0)
                                <img src="{{$sliderImagesPath.'/'.$sliderImages[0]['name']}}" style="height: 150px; width: 150px" />
                            @endif
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
                                <input type="text" name="sliderImages[sliderImages1][message_1]" id="message_1" value="" placeholder="enter the message">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Message 2
                                </label>
                                <input type="text" name="sliderImages[sliderImages1][message_2]" id="message_2" value="" placeholder="enter the message">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Hyper Link title
                                </label>
                                <input type="text" name="sliderImages[sliderImages1][link_title]" id="link_title" value="" placeholder="enter link title">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Hyper Link
                                </label>
                                <input type="text" name="sliderImages[sliderImages1][link]" id="link_title" value="" placeholder="enter hyper Link">
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
                                <input type="checkbox"  name="sliderImages[sliderImages2][is_checked_slider]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select Images : <b>size(1920*500 pixels)</b></label>
                            <input id="imageUpload2" type="file" class="btn blue"/>
                            @if(count($sliderImages) > 1)
                                <img src="{{$sliderImagesPath.'/'.$sliderImages[1]['name']}}" style="height: 150px; width: 150px" />
                            @endif
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
                                <input type="text" name="sliderImages[sliderImages2][message_1]" id="message_1" value="" placeholder="enter the message">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Message 2
                                </label>
                                <input type="text" name="sliderImages[sliderImages2][message_2]" id="message_2" value="" placeholder="enter the message">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Hyper Link title
                                </label>
                                <input type="text" name="sliderImages[sliderImages2][link_title]" id="link_title" value="" placeholder="enter link title">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Hyper Link
                                </label>
                                <input type="text" name="sliderImages[sliderImages2][link]" id="link_title" value="" placeholder="enter hyper Link">
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
                                <input type="checkbox" name="sliderImages[sliderImages3][is_checked_slider]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select Images : <b>size(1920*500  pixels)</b></label>
                            <input id="imageUpload3" type="file" class="btn blue"/>
                            @if(count($sliderImages) > 2)
                                <img src="{{$sliderImagesPath.'/'.$sliderImages[2]['name']}}" style="height: 150px; width: 150px" />
                            @endif
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
                                <input type="text" name="sliderImages[sliderImages3][message_1]" id="message_1" value="" placeholder="enter the message">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Message 2
                                </label>
                                <input type="text" name="sliderImages[sliderImages3][message_2]" id="message_2" value="" placeholder="enter the message">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Hyper Link title
                                </label>
                                <input type="text" name="sliderImages[sliderImages3][link_title]" id="link_title" value="" placeholder="enter link title">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Hyper Link
                                </label>
                                <input type="text" name="sliderImages[sliderImages3][link]" id="link_title" value="" placeholder="enter hyper Link">
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
                                <input type="checkbox" name="sliderImages[sliderImages4][is_checked_slider]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Select Images : <b>size(1920*500 pixels)</b></label>
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
                                <input type="text" name="sliderImages[sliderImages4][message_1]" id="message_1" value="" placeholder="enter the message">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Message 2
                                </label>
                                <input type="text" name="sliderImages[sliderImages4][message_2]" id="message_2" value="" placeholder="enter the message">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Hyper Link title
                                </label>
                                <input type="text" name="sliderImages[sliderImages4][link_title]" id="link_title" value="" placeholder="enter link title">
                            </div>
                            <div class="col-md-3">
                                <label class="control-label">
                                    Hyper Link
                                </label>
                                <input type="text" name="sliderImages[sliderImages4][link]" id="link_title" value="" placeholder="enter hyper Link">
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <button class="btn btn-primary btn-wide pull-right" type="submit">
                                    Save <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </div>
                    </form>
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
    });
    $("#imageupload").on('change', function () {
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#preview-image");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof (FileReader) != "undefined") {
                for (var i = 0; i < countFiles; i++) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        var imagePreview = '<div class="col-md-2"><input type="hidden" name="page_icon" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" style="width:50px;height: 50px " />' + '</div>';
                        image_holder.append(imagePreview);
                    };
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                alert("It doesn't supports");
            }
        } else {
            alert("Select Only images");
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
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages[sliderImages1][slider_image]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages[sliderImages2][slider_image]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages[sliderImages3][slider_image]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
                            var imagePreview = '<div class="col-md-2"><input type="hidden" name="sliderImages[sliderImages4][slider_image]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
</script>
@stop

