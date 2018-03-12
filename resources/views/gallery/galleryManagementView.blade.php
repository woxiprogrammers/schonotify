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
                    <!-- start: DASHBOARD TITLE --><br><br><br>
                    @include('alerts.errors')
                    <div id="message-error-div"></div>
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1 class="mainTitle">Add</h1>
                                <span class="mainDescription">Images and Video</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/gallery/create-gallery-images" role="form" id="galleryCreateImageForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                           Select Folder <span class="symbol required"></span>
                                        </label>
                                        <select name="folder_id" class="form-control" id="folderDropdown" style="-webkit-appearance: menulist;">
                                            <option>Select Batch</option>
                                            @foreach($folderName as $name)
                                                <option value="{!! $name['id'] !!}">{!! $name['name'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="image-select" hidden>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Select Images :</label>
                                            <input id="imageupload" type="file" class="btn blue" multiple />
                                            <br />
                                            <div class="row">
                                                <div id="preview-image" class="row">

                                                </div>
                                            </div>
                                        </div>
                                        <span id="alreadyPresentImages">
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Select Video :
                                            </label>
                                            <input id="videoupload" name="video" type="file" >
                                        </div>
                                        <span id="alreadyPresentVideo">
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">&nbsp
                                        </label>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-wide" id="submit" type="submit">
                                                Create <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">&nbsp
                                        <div class="form-group">
                                            <a href="javascript:void(0)" class="btn btn-blue" id="viewButton">View / Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <input type="hidden" id="alreadyPresentCount">
                        <input type="hidden" id="alreadyPresentVideoCount">
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
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/exam-form-validation.js"></script>
    <script src="/assets/js/gallery-form-validations.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormValidator.init();
            $("#imageupload").on('change', function () {
                var alreadyPresentCount =  $('#alreadyPresentCount').val();
                var countFiles = $(this)[0].files.length;
                var allowedFiles = 10 - (alreadyPresentCount);
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                var image_holder = $("#preview-image");
                image_holder.empty();
                if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
                    if (typeof (FileReader) != "undefined") {
                        if(countFiles <= allowedFiles){
                            for (var i = 0; i < countFiles; i++) {
                                var reader = new FileReader()
                                reader.onload = function (e) {
                                    var imagePreview = '<div class="col-md-2"><input type="hidden" name="gallery_images[]" value="'+e.target.result+'"><img src="'+e.target.result+'" class="thumbimage" /></div>';
                                    image_holder.append(imagePreview);
                                };
                                image_holder.show();
                                reader.readAsDataURL($(this)[0].files[i]);
                            }
                        }else{
                            alert(allowedFiles + ' is only allowed not more than that ');
                        $('#submit').hide();
                        }
                    } else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only images");
                    $('#submit').hide();
                }
            });
            $("#videoupload").on('change', function () {
                var alreadyPresentCount =  $('#alreadyPresentVideoCount').val();
                var allowedFiles = 1 - (alreadyPresentCount);
                var imgPath = $(this)[0].value;
                var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
                if (extn == "mp4" || extn == "mov" || extn == "avi" || extn == "mkv") {
                    if (typeof (FileReader) != "undefined") {
                        if(allowedFiles == 0){
                            alert(' You cannot add more videos ');
                            $('#submit').hide();
                        }
                    }else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only video");
                    $('#submit').hide();
                }
            });
        });
    </script>
    <script>
        $('#folderDropdown').change(function(){
            var folder_id = this.value;
            $.ajax(
                {
                    url: "check-image-count",
                    method : "post",
                    data:{folder_id : folder_id},
                success: function(data,textStatus,xhr){
                $('#alreadyPresentCount').val(data.image);
                $('#alreadyPresentVideoCount').val(data.video);
                if(data.image == 0 && data.video == 0){
                    $('#viewButton').hide();
                }else{
                    $('#viewButton').show();
                }
                $('#image-select').show();
                $('#viewButton').attr("href","/gallery/images-view/"+folder_id);
                $('#alreadyPresentImages').html(data.image+" Images are already present");
                $('#alreadyPresentVideo').html(data.video+" Video is already present");
                }});
        })
    </script>
@stop


