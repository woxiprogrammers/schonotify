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
            <!-- start: DASHBOARD TITLE -->
            @include('alerts.errors')
            <div id="message-error-div"></div>
            <section id="page-title" class="padding-top-15 padding-bottom-15">
                <div class="row">
                    <div class="col-sm-7">
                        <h1 class="mainTitle">Notice Board</h1>
                    </div>
                    <ul class="mini-stats col-sm-2 pull-right">

                        <li>
                            <div class="values">
                                <a href="/create-notice-board" class="btn btn-primary"><i class="ti-plus"></i></a> Create New
                            </div>
                        </li>

                    </ul>

                </div>
            </section>
            <!-- end: DASHBOARD TITLE -->
            <div class="container-fluid container-fullw bg-white">

                <div class="row">
                    <div class="col-md-12">
                        <div id="detail">

                            <div class="col-sm-12">
                                <div class="panel panel-white load1" id="panel6">
                                    <div class="panel-heading">

                                        <div class="timeline_title">
                                            <i class="fa fa-trophy fa-2x pull-left fa-border"></i>
                                            @foreach($achievements as $achievement)
                                                <h4 class="panel-title no-margin text-primary" style="padding: 14px;">{{ $achievement['title'] }}</h4>
                                            @endforeach
                                        </div>
                                        <div class="panel-tools">

                                            Created By
                                            @if($achievements[0]['gender'] == 'M')
                                            Mr.
                                            @else
                                            Mrs.
                                            @endif

                                            {{ $achievements[0]['first_name'] }} {{ $achievements[0]['last_name'] }} ({{ $achievements[0]['username'] }})

                                            <small>
                                                <i>
                                                    @if($achievements[0]['role_id'] == 2)
                                                    Teacher
                                                    @else
                                                    Admin
                                                    @endif
                                                </i>
                                            </small>

                                            Created On <i class="fa fa-clock-o"></i> {{ $achievements[0]['created_at'] }}

                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-sm-5">
                                            <div id="imgDiv">

                                                <div class="col-sm-12">

                                                    <img class="thumbnail" src="/uploads/achievement/events/{{ $achievements[0]['id'] }}/{{ $imageArray[0] }}" width="300" height="200" id="default-image" onError="this.onerror=null;this.width='300';this.src='/assets/images/your-logo-here.png'; ">

                                                </div>
                                                <div class="col-sm-12" id="clients">

                                                    <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 809px; height: 150px; overflow: hidden; visibility: hidden;">
                                                        <!-- Loading Screen -->
                                                        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                                                            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                                                            <div style="position:absolute;display:block;background:url('/assets/images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                                                        </div>

                                                        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 809px; height: 150px; overflow: hidden;">

                                                            @foreach($imageArray as $image)
                                                            <div style="display: none;">

                                                                <img data-u="image" class="thumbnail pull-left thumb-image" style="margin-right:2px;" src="/uploads/achievement/events/{{ $achievements[0]['id'] }}/{{ $image }}" onError="this.onerror=null;this.width='80';this.src='/assets/images/your-logo-here.png'; ">
                                                            </div>
                                                            @endforeach

                                                        </div>

                                                        <!-- Arrow Navigator -->
                                                        <span data-u="arrowleft" class="jssora03l" style="top:0px;left:8px;width:55px;height:55px; border:1px solid #666; background-color:#fff;" data-autocenter="2"></span>
                                                        <span data-u="arrowright" class="jssora03r" style="top:0px;right:8px;width:55px;height:55px; border:1px solid #666; background-color:#fff; " data-autocenter="2"></span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                        <div class="panel-scroll height-180 margin-bottom-10 ps-container ps-active-y">
                                            <p>
                                                @foreach($achievements as $achievement)
                                                {{ $achievement['detail'] }}
                                                @endforeach
                                            </p>
                                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 82px;"></div></div>
                                        </div>

                                        </div>

                                    </div>
                                    <div class="panel-footer col-sm-12">

                                        @foreach($achievements as $achievement)
                                        <h4>
                                            @if($achievement['status'] == 2)
                                            <div class="col-md-12" >
                                                <h5> Status :<i class="fa fa-flag"></i> <i>Published</i></h5>
                                            </div>
                                            @elseif($achievement['status'] == 1)
                                            <div class="col-md-12" >
                                                <h5> Status :<i class="fa fa-flag"></i> <i>Pending</i></h5>
                                            </div>
                                            @else
                                            <div class="col-md-12" >
                                                <h5> Status :<i class="fa fa-flag"></i> <i>Draft</i></h5>
                                            </div>
                                            @endif

                                            <small class="pull-right">
                                                @if($achievement['status'] == 2)

                                                Published By

                                                @foreach($publishedBy as $row)
                                                @if($row['gender'] == 'M')
                                                    Mr.
                                                @else
                                                    Mrs.
                                                @endif

                                                {{ $row['first_name'] }} {{ $row['last_name'] }} ({{ $row['username'] }})

                                                @if($row['role_id'] == 1)
                                                    <small><i>Admin</i></small>
                                                @else
                                                    <small><i>Teacher</i></small>
                                                @endif
                                                @endforeach

                                                    Published On <i class="fa fa-clock-o"></i> {{ $achievement['updated_at'] }} @endif
                                            </small>
                                        </h4>
                                        @endforeach

                                        @foreach($achievements as $achievement)

                                        <div class="col-md-12" id="btnDiv">

                                            @if($achievement['status'] == 1)
                                                @if(Auth::User()->role_id == 1)
                                                    <button class="btn btn-primary btn-wide pull-left" type="button" id="btnEdit">
                                                        <i class="fa fa-wrench"></i> Update
                                                    </button>
                                                    <a href="/check-publish-achievement/{{ $achievement['id'] }}" class="btn btn-primary btn-wide pull-right " type="button" id="btnPublish">
                                                        <i class="fa fa-cloud-upload"></i> Publish
                                                    </a>
                                                @endif
                                            @elseif($achievement['status'] == 0)
                                                <button class="btn btn-primary btn-wide pull-left" type="button" id="btnEdit">
                                                    <i class="fa fa-wrench"></i> Update
                                                </button>
                                                <a href="/check-publish-achievement/{{ $achievement['id'] }}" class="btn btn-primary btn-wide pull-right " type="button" id="btnPublish">
                                                    <i class="fa fa-cloud-upload"></i> Publish
                                                </a>
                                            @endif

                                        </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="update">
                            <form action="/update-achievement" method="post" role="form" id="editAchievementForm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>
                                    <input type="hidden" id="hiddenEVentId" value="{{ $achievements[0]['id'] }}"/>
                                    <input type="hidden" id="hiddenUserId" value="{{ Auth::User()->id}}"/>
                                    <input type="hidden" id="hiddenEventId" name="hiddenEventId" value="{{ $achievements[0]['id']}}"/>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Title <span class="symbol required"></span>
                                            </label>
                                            <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title" value="{{ $achievements[0]['title'] }}">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Type Description <span class="symbol required"></span>
                                            </label>
                                            <textarea class="form-control col-sm-8" id="achievement" name="achievement" style="min-height: 180px;">
                                                {{ $achievements[0]['detail'] }}
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-10" style="margin-top:10px;">
                                        <div id="fileupload" class="col-sm-10">
                                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                                            <noscript>
                                                <input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/">
                                            </noscript>
                                            <h3>Upload Images</h3>

                                            <table role="presentation" class="table table-striped">
                                                <tbody class="files"></tbody>
                                            </table>
                                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                                            <div class="row fileupload-buttonbar">
                                                <div class="col-lg-12">
                                                    <!-- The fileinput-button span is used to style the file input field as button -->
												<span class="btn btn-success fileinput-button"> <i class="glyphicon glyphicon-plus"></i> <span>Add files...</span>
													<input type="file" name="files[]" multiple>
												</span>
                                                    <button type="submit" class="btn btn-primary start">
                                                        <i class="glyphicon glyphicon-upload"></i>
                                                        <span>Start upload</span>
                                                    </button>
                                                    <button type="reset" class="btn btn-warning cancel">
                                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                                        <span>Cancel upload</span>
                                                    </button>
                                                    <button type="button" class="btn btn-danger delete">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                        <span>Delete</span>
                                                    </button>
                                                    <!-- The loading indicator is shown during file processing -->
                                                    <span class="fileupload-loading"></span>
                                                </div>
                                                <!-- The global progress information -->
                                                <div class="col-lg-5 fileupload-progress fade">
                                                    <!-- The global progress bar -->
                                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                    </div>
                                                    <!-- The extended global progress information -->
                                                    <div class="progress-extended">
                                                        &nbsp;
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-wide pull-left" type="button" id="btnCancel">
                                            Cancel <i class="fa fa-times-circle-o"></i>
                                        </button>
                                        <button class="btn btn-primary btn-wide pull-right" type="submit" id="btnUpdate">
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

</div>
<div id="loadmoreajaxloader" style="display: block;" class="loader-position-event" ><center><img src="/assets/images/loader1.gif" /></center></div>
@include('footer')

@include('rightSidebar')

</div>

<!-- start: MAIN JAVASCRIPTS -->
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="/assets/js/custom-project.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<script src="/assets/js/form-validation.js"></script>

<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();

        $('#update').hide();
        $('#btnStatus').hide();
    });

    $('#btnEdit').click(function(){

        $('#loadmoreajaxloader').show();

        var route = "/check-edit-achievement";

        $.get(route,function(res){

            if(res == 1)
            {
                $('#detail').hide();
                $('#update').show();
                $('#message-error-div').hide();
                $('#message-error-div').html("");
            } else {
                var str='<div class="alert alert-danger alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" area-lebel="close">'+
                    '<span area-hidden="true">&times;</span>'+
                    '</button>'+
                    "Currently you do not have permission to access this functionality. Please contact administrator to grant you access !"+
                    "</div>";
                $('#message-error-div').show();
                $('#message-error-div').html(str);
            }

            $('#loadmoreajaxloader').hide();

        });

    });

    $(window).load(function() {
        $('#loadmoreajaxloader').hide();
    });

    $('#btnCancel').click(function(){
        $('#update').hide();
        $('#detail').show();

    });


    $('.thumb-image').click(function(){
        var imgSrc = this.src
        $('#default-image').attr('src',imgSrc);
    });


</script>

<script type="text/javascript" src="/assets/js/jssor.slider.mini.js"></script>
<!-- use jssor.slider.debug.js instead for debug -->
<script>
    jQuery(document).ready(function ($) {

        var jssor_1_options = {
            $AutoPlay: false,
            $AutoPlaySteps: 4,
            $SlideDuration: 160,
            $SlideWidth: 200,
            $SlideSpacing: 3,
            $Cols: 4,
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $Steps: 4
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$,
                $SpacingX: 1,
                $SpacingY: 1
            }
        };

        var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizing
        function ScaleSlider() {
            var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
            if (refSize) {
                refSize = Math.min(refSize, 809);
                jssor_1_slider.$ScaleWidth(refSize);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }
        ScaleSlider();
        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        //responsive code end
    });
</script>


<script id="template-upload" type="text/x-tmpl">
			{% for (var i=0, file; file=o.files[i]; i++) { %}
			<tr class="template-upload fade">
			<td>
			<span class="preview"></span>
			</td>
			<td>
			<p class="name">{%=file.name%}</p>
			<input type="hidden" name="uploadedFiles[]" value="{%=file.name%}"/>
			{% if (file.error) { %}
			<div><span class="label label-danger">Error</span> {%=file.error%}</div>
			{% } %}
			</td>
			<td>
			<p class="size">{%=o.formatFileSize(file.size)%}</p>
			{% if (!o.files.error) { %}
			<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
			{% } %}
			</td>
			<td>
			{% if (!o.files.error && !i && !o.options.autoUpload) { %}
			<button class="btn btn-primary start">
			<i class="glyphicon glyphicon-upload"></i>
			<span>Start</span>
			</button>
			{% } %}
			{% if (!i) { %}
			<button class="btn btn-warning cancel">
			<i class="glyphicon glyphicon-ban-circle"></i>
			<span>Cancel</span>
			</button>
			{% } %}
			</td>
			</tr>
			{% } %}
		</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
			{%for (var i=0, file; file=o.files[i]; i++) { %}
			<tr class="template-download fade">
			<td>
			<span class="preview">
			{% if (file.thumbnailUrl) { %}
			<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
			{% } %}
			</span>
			</td>
			<td>

			<p class="name">
			{% if (file.url) { %}

			<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
			{% } else { %}

			<span>{%=file.name%} </span>
			{% } %}
			</p>
			{% if (file.error) { %}
			<div><span class="label label-danger">Error</span> {%=file.error%}</div>
			{% } else { %}
			<input type="hidden" name="uploadedFiles[]" value="{%=file.name%}"/>
			{% } %}
			</td>
			<td>
			<span class="size">{%=o.formatFileSize(file.size)%}</span>
			</td>
			<td>
			{% if (file.deleteUrl) { %}

			<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}&&id=userId"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
			<i class="glyphicon glyphicon-trash"></i>
			<span>Delete</span>
			</button>

			<input type="checkbox" name="delete" value="1" class="toggle">
			{% } else { %}
			<button class="btn btn-warning cancel">
			<i class="glyphicon glyphicon-ban-circle"></i>
			<span>Cancel</span>
			</button>
			{% } %}
			</td>
			</tr>
			{% } %}
		</script>
<script src="/vendor/jquery-file-upload/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="/vendor/javascript-Load-Image/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/vendor/jquery-file-upload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/vendor/jquery-file-upload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/vendor/jquery-file-upload/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/vendor/jquery-file-upload/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="/vendor/jquery-file-upload/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="/vendor/jquery-file-upload/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="/vendor/jquery-file-upload/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/vendor/jquery-file-upload/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="/vendor/jquery-file-upload/main1.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="/js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->



<!-- start: MAIN JAVASCRIPTS -->

@stop