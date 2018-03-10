@extends('master')
@section('css')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
@endsection
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
                                <h1 class="mainTitle">Gallery</h1>
                                <span class="mainDescription">Images & Video</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <div class="form-group">
                            <label class="control-label">Images</label>
                            <div class="row">
                                <div class="container">
                                    <div class="row">
                                        @if(array_key_exists('image',$gallery))
                                        @foreach($gallery['image'] as  $image)
                                            <div class="col-md-3">
                                                <input type="checkbox" id="checkImage[]"  class="imageCheck" value="{{$image['id']}}">
                                                <img src="{{$image['image']}}" style="border: 1px black solid" width="200" height="120"/>
                                            </div>
                                        @endforeach
                                            @else
                                            <h4>Photo's is not present</h4>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Video</label>
                            <div class="row">
                                <div id="preview-video" class="row">
                                    @if(array_key_exists('video',$gallery))
                                    @foreach($gallery['video'] as $video)
                                            <iframe width="300" height="215"
                                              src="{{$video['video']}}">
                                            </iframe>
                                        <input type="checkbox" id="checkVideo" class="videoCheck" value="{{$video['id']}}">
                                    @endforeach
                                        @else
                                        <h4>Video is not present</h4>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" id="remove" value="{{$gallery['folder_id']}}" class="btn btn-blue"> Remove</a>
                        <br>
                        <button value="{{$gallery['folder_id']}}" class="btn btn-blue" id="edit">Edit</button>
                        <form method="post" action="/gallery/edit-gallery-images/{{$gallery['folder_id']}}" role="form" id="galleryEditImageForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="control-label">Select Images :</label>
                                    <input id="imageupload" type="file" class="btn blue" multiple />
                                    <br />
                                    <div class="row">
                                        <div id="preview-image" class="row">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Select Video :
                                        </label>
                                        <input id="videoupload" name="video" type="file" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-wide" id="submit" type="submit">
                                    Create <i class="fa fa-arrow-circle-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                    <img src="" class="enlargeImageModalSource" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="alreadyPresentCount">
                    <input type="hidden" id="alreadyPresentVideoCount">
                    @include('rightSidebar')
                </div>
            </div>
        </div>
        @include('footer')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

    <script>
        $('#galleryEditImageForm').hide();
        jQuery(document).ready(function() {
            Main.init();
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
                        if(countFiles < allowedFiles){
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
                        }
                    } else{
                        alert("It doesn't supports");
                    }
                } else {
                    alert("Select Only images");
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
                }
            });
        });
        $('#remove').hide();
    </script>
    <script>
        $(".imageCheck").on('click', function(){
            var id=this.value;
            if($(this).is(':checked') == true) {
                $('#edit').hide();
                $('#remove').show();
                $('#remove').attr("href","/gallery/remove-images/"+id)
            }else{
                $('#remove').hide();
            }
            })
        $("#checkVideo").on('click', function(){
            var id=this.value;
            if($(this).is(':checked') == true) {
                $('#edit').hide();
                $('#remove').show();
                $('#remove').attr("href","/gallery/remove-images/"+id)
            }else{
                $('#remove').hide();
            }
        })
        $(function() {
            $('img').on('click', function() {
                $('.enlargeImageModalSource').attr('src', $(this).attr('src'));
                $('#enlargeImageModal').modal('show');
            });
        });
    </script>
    <script>
        $("#edit").on('click', function(){
            var folder_id = this.value;
            $.ajax(
                {
                    url: "/gallery/check-image-count",
                    method : "post",
                    data:{folder_id : folder_id},
                    success: function(data,textStatus,xhr){
                        $('#alreadyPresentCount').val(data.image);
                        $('#alreadyPresentVideoCount').val(data.video);
                        $('#galleryEditImageForm').show();
                    }});
        })
    </script>
@stop


