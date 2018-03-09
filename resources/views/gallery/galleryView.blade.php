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
                                <h1 class="mainTitle">Gallery</h1>
                                <span class="mainDescription">Images & Video</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <div class="form-group">
                            <label class="control-label">Images</label>
                            <div class="row">
                                <div id="preview-image" class="row">
                                    @foreach($gallery['image'] as  $image)
                                        <div class="col-md-2">
                                            <input type="checkbox" id="checkImage[]"  class="imageCheck" value="{{$image['id']}}">
                                            <img class="fancybox" src="{{$image['image']}}"/>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Video</label>
                            <div class="row">
                                <div id="preview-video" class="row">
                                    @foreach($gallery['video'] as $video)
                                            <iframe width="420" height="315"
                                        src="{{$video['video']}}">
                                            </iframe>
                                        <input type="checkbox" id="checkVideo[]" class="videoCheck" value="{{$video['id']}}">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" id="remove" class="btn btn-blue"> remove</a>
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
    <script>
        jQuery(document).ready(function() {
            Main.init();
        });
        $('#remove').hide();
    </script>
    <script>
        $(".imageCheck").on('click', function(){
            if($(this).is(':checked') == true) {
           var id = $(this).val();
                $('#remove').show();
                $('#remove').attr("href","/gallery/remove-images/"+id)
            }else{
                $('#remove').hide();
            }
            })
    </script>
@stop


