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
            <section id="page-title" class="padding-top-15 padding-bottom-15">
                <div class="row">
                    <div class="col-sm-7">
                        <h1 class="mainTitle">Notice Board</h1>
                    </div>
                    <ul class="mini-stats col-sm-2 pull-right">

                        <li>
                            <div class="values">
                                <a href="/createNoticeBoard" class="btn btn-primary"><i class="ti-plus"></i></a> Create New
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
                                            <h4 class="panel-title no-margin text-primary" style="padding: 14px;">PLATINUM JUBILEE OF TRUST</h4>
                                        </div>
                                        <div class="panel-tools">
                                            <a data-original-title="Refresh" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-refresh" href="#"><i class="ti-reload"></i></a>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <div class="col-sm-5">
                                            <div id="imgDiv">
                                                <div class="col-sm-12">
                                                    <img class="thumbnail" src="http://school_mit.schnotify.com/vendor/jquery-file-upload/server/php/files/download%20%281%29.jpg" onError="this.onerror=null;this.width='200';this.src='assets/images/picture.svg'; ">
                                                    <img class="thumbnail pull-left" style="margin-right:2px;" src="http://school_mit.schnotify.com/vendor/jquery-file-upload/server/php/files/thumbnail/download%20%281%29.jpg" onError="this.onerror=null;this.width='80';this.src='assets/images/picture.svg'; ">
                                                    <img class="thumbnail pull-left" style="margin-right:2px;" src="http://school_mit.schnotify.com/vendor/jquery-file-upload/server/php/files/thumbnail/download.jpg" onError="this.onerror=null;this.width='80';this.src='assets/images/picture.svg'; ">
                                                    <img class="thumbnail pull-left" style="margin-right:2px;" src="http://school_mit.schnotify.com/vendor/jquery-file-upload/server/php/files/thumbnail/images.jpg" onError="this.onerror=null;this.width='80';this.src='assets/images/picture.svg'; ">
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-7">
                                        <div class="panel-scroll height-280 ps-container ps-active-y">
                                            Platinum Jubilee : We are feeling proud to announce that we are completing 75 years of trust. so, this is notify you that you will get schedule and agenda of ceremony.
                                            <br>
                                            Venue:
                                            <address>
                                                <strong>MIT School</strong>
                                                <br>
                                                795 Folsom Ave, Suite 600
                                                <br>
                                                San Francisco, CA 94107
                                                <br>
                                                <abbr title="Phone">P:</abbr> (123) 456-7890
                                            </address>

                                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 82px;"></div></div></div>
                                         </div>
                                    </div>
                                    <div class="panel-footer col-sm-12">

                                        <h4>Mr.R Ashwin <small><i>Teacher</i></small><small class="pull-right"><i class="fa fa-clock-o"></i> Wednesday 5 Oct, 2015 5:00 PM</small></h4>

                                        <div class="col-md-12" id="btnDiv">
                                            <button class="btn btn-primary btn-wide pull-left" type="button" id="btnEdit">
                                                <i class="fa fa-wrench"></i> Update
                                            </button>
                                            <button class="btn btn-primary btn-wide pull-right panel-refresh" type="button" id="btnPublish">
                                                <i class="fa fa-cloud-upload"></i> Publish
                                            </button>
                                        </div>
                                        <div class="col-md-12" id="btnStatus">
                                            <h5> Status :<i class="fa fa-flag"></i> <i>Published</i></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="update">
                            <form action="#" role="form" id="form2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Title <span class="symbol required"></span>
                                            </label>
                                            <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title" value="PARENT MEET FOR THIS MONTH">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Type Description <span class="symbol required"></span>
                                            </label>
                                            <textarea class="form-control col-sm-8" id="announcement" name="announcement" style="min-height: 180px;">Parent Meet for this month is scheduled. And everyone should be requested to have their presence. this parent meet will have focused on renovation of school and faculty.
                                                Venue:
                                                MIT School
                                                795 Folsom Ave, Suite 600
                                                San Francisco, CA 94107
                                                P: (123) 456-7890
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

@include('footer')

@include('rightSidebar')


</div>
<!-- start: MAIN JAVASCRIPTS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script>
    jQuery(document).ready(function() {
        Main.init();

        $('#update').hide();
        $('#btnStatus').hide();
    });

    $('#btnEdit').click(function(){
        $('#detail').hide();
        $('#update').show();
    });

    $('#btnCancel').click(function(){
        $('#update').hide();
        $('#detail').show();

    });

    $('#btnUpdate').click(function(){
        window.location.href="detailedAnnouncement";
    });

    $('#btnPublish').click(function(){
        $('#btnDiv').hide();
        $('#btnStatus').show();
    });

    var dir = "/vendor/jquery-file-upload/server/php/files/thumbnail/";

    var fileextension = ".png";

    $.ajax({
        //This will retrieve the contents of the folder if the folder is configured as 'browsable'
        url: dir,
        success: function (data) {
            //List all .png file names in the page
            $(data).find("a:contains(" + fileextension + ")").each(function () {
                var filename = this.href.replace(window.location.host, "").replace("http://", "");
                $("#imgDiv").append("<img src='" + dir + filename + "'>");
            });
        }
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
			{% for (var i=0, file; file=o.files[i]; i++) { %}
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
			<span>{%=file.name%}</span>
			{% } %}
			</p>
			{% if (file.error) { %}
			<div><span class="label label-danger">Error</span> {%=file.error%}</div>
			{% } %}
			</td>
			<td>
			<span class="size">{%=o.formatFileSize(file.size)%}</span>
			</td>
			<td>
			{% if (file.deleteUrl) { %}
			<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
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
<script src="vendor/jquery-file-upload/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="http://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="vendor/javascript-Load-Image/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="http://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="http://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="vendor/jquery-file-upload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="vendor/jquery-file-upload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="vendor/jquery-file-upload/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="vendor/jquery-file-upload/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="vendor/jquery-file-upload/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="vendor/jquery-file-upload/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="vendor/jquery-file-upload/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="vendor/jquery-file-upload/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="vendor/jquery-file-upload/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->



<!-- start: MAIN JAVASCRIPTS -->

@stop