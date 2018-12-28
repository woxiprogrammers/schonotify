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
            <style>
                img{
                    max-width:300px;
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
                                <h1 class="mainTitle">Images</h1>
                                <span class="mainDescription">Uploader</span>
                            </div>
                            <div class="col-sm-5">
                                <!-- start: MINI STATS WITH SPARKLINE -->
                                <!-- end: MINI STATS WITH SPARKLINE -->
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <form action="/cms/upload-image" method="post">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input id="file-uploder" type="file" class="btn blue"/>
                                        <br />
                                        <div class="row">
                                            <div id="preview" class="row">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <button class="btn btn-primary btn-wide pull-right" type="submit">
                                        Save <i class="fa fa-arrow-circle-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" >
                            <fieldset>
                                <div id="foldertable">
                                </div>
                            </fieldset>
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
        jQuery(document).ready(function() {
            Main.init();
            TableData.init();
            FormElements.init();
            var strrr=0;
            $.ajax({
                url: "/cms/images-listing",
                data:{str1 : strrr},
                success: function(response)
                {
                    $("#foldertable").html(response);
                    var switcheryHandler = function() {
                        var elements = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                        elements.forEach(function(html) {
                            var switchery = new Switchery(html);
                        });
                    };
                    switcheryHandler();
                    TableData.init();
                }
            });
        });
        $("#file-uploder").on('change', function () {
            var imgPath = $(this)[0].value;
            var countFiles = $(this)[0].files.length;
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var size = this.files[0].size/1024/1024;
            var image_holder = $("#preview");
            if(size <= 1){
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        for (var i = 0; i < countFiles; i++) {
                            var reader = new FileReader()
                            reader.onload = function (e) {
                                var imagePreview = '<div class="col-md-2"><input type="hidden" name="image" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
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
            function removeImage(status,id) {
                var remove = confirm('Are you sure you want to remove this image');
                if(remove == true){
                    $.ajax({
                        url: "/cms/remove-image/"+id,
                        success: function(response)
                        {
                            location.reload();
                        }
                    })
                }else{
                    location.reload();
                }
            }
    </script>
@stop

