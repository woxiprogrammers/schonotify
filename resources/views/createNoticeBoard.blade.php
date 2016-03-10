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
            <h1 class="mainTitle">Create</h1>
            <span class="mainDescription">Notice Board</span>
        </div>

    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<div class="container-fluid container-fullw bg-white">

    <div class="row">
        <div class="col-md-12">
            <div class="col-lg-10">

                <p>
                   *Please select the tab to create Announcement or Achievement
                </p>
                <div class="tabbable">
                    <ul id="myTab2" class="nav nav-tabs nav-justified panel-title">
                        <li class="active">
                            <a href="#myTab2_example1" data-toggle="tab" aria-expanded="true">
                                <i class="fa fa-bullhorn"></i> Announcement
                            </a>
                        </li>
                        <li class="">
                            <a href="#myTab2_example2" data-toggle="tab" aria-expanded="false">
                                <i class="fa fa-trophy"></i> Achievement
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="myTab2_example1">

                            <form action="/createNoticeBoard" role="form" method="post" id="form2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Title <span class="symbol required"></span>
                                            </label>
                                            <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Type Description <span class="symbol required"></span>
                                            </label>
                                            <textarea class="form-control" id="announcement" name="announcement"></textarea>
                                        </div>
                                        <div class="">
                                            <label>
                                                Priority
                                            </label>
                                            <div class="form-group">
                                                <div class="radio clip-radio radio-primary">
                                                        <input type="radio" id="priority1" name="priority" value="1" class="event-categories">
                                                        <label for="priority1">
                                                            <span class="fa fa-circle text-red"></span> High
                                                        </label>
                                                        <input type="radio" id="priority2" name="priority" value="2" class="event-categories">
                                                        <label for="priority2">
                                                            <span class="fa fa-circle text-green"></span> Medium
                                                        </label>
                                                        <input type="radio" id="priority3" name="priority" value="3" class="event-categories">
                                                        <label for="priority3">
                                                            <span class="fa fa-circle text-yellow"></span> Low
                                                        </label>
                                                    </div>
                                                 </div>
                                        </div>
                                     </div>
                                   <div class="col-md-12">
                                        <div class="form-group col-sm-6">
                                            <label class="control-label">
                                                User Roles <em>(select at least one)</em> <span class="symbol required"></span>
                                            </label>
                                            <div class="checkbox clip-check check-primary">
                                                <input type="checkbox" value="1" name="userrole" id="service4" class="adminChk">
                                                <label for="service4">
                                                    Admin
                                                </label>

                                                <div class="form-group">
                                                    <br>
                                                    <div class="adminList">
                                                        <select multiple="multiple" name="adminList[]" id="adminList" class="form-control">
                                                        </select>
                                                        <em>Please Use CTRL Button to select multiple options.</em>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="checkbox clip-check check-primary">
                                                <input type="checkbox" value="" name="userrole" id="service1" class="teacherChk">
                                                <label for="service1">
                                                    Teacher
                                                </label>

                                                <div class="form-group">
                                                    <br>
                                                    <div class="teacherList">
                                                        <select multiple="multiple" name="teacherList[]" id="teacherList" class="form-control">
                                                                                                                                                                              </select>
                                                        <em>Please Use CTRL Button to select multiple options.</em>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="checkbox clip-check check-primary">
                                                <input type="checkbox" value="" name="userrole" class="parentChk" id="service2">
                                                <label for="service2">
                                                    Student
                                                </label>
                                            </div>
                                            <div class="panel panel-white padding-10" id="parentClass">
                                                <div class="form-group">
                                                    <label for="form-field-select-2">
                                                        Select Batch
                                                    </label>
                                                    <select class="form-control"  name="batch-select[]" id="batch-select" style="-webkit-appearance: menulist;">
                                                       @if(isset($batchList))
                                                        @foreach($batchList as $row)
                                                        <option value="{!! $row['id']!!}">{!! $row['name']!!}</option>
                                                        @endforeach
                                                       @endif
                                                    </select>
                                                </div>
                                                <div class="form-group" id="batch-class-div-data">
                                                    <label class="control-label">
                                                        Class <em>(select at least one)</em> <span class="symbol required"></span>
                                                    </label>
                                                    @if(isset($classDivision))
                                                    @foreach($classDivision as $row)
                                                    <div class="checkbox clip-check check-primary">

                                                        <input type="checkbox" value="{!! $row['class_id']!!}" name="classFirst[]" class="classFirst" id="{!! $row['class_id']!!}">
                                                        <label for="{!! $row['class_id']!!}">
                                                            {!! $row['class_name']!!}
                                                        </label>
                                                    </div>
                                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                                        @if(isset($row['division']))
                                                        @foreach($row['division'] as $division)
                                                        <input type="checkbox" value="{!! $division['division_id']!!}"  name = "FirstDiv[]" class="FirstDiv" id="{!! $division['division_id']!!}" >
                                                        <label for="{!! $division['division_id']!!}">
                                                            {!! $division['division_name']!!}
                                                        </label>
                                                        @endforeach
                                                        @endif
                                                    </div> <p>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-md-12">

                                        <button class="btn btn-wide btn-primary " type="submit" name="buttons" value="save">
                                            <span class="">Save</span>
                                        </button>
                                        <button class="btn btn-primary btn-wide pull-right" type="submit" id="btnSubmit" name="buttons" value="publish">
                                            Publish
                                        </button>
                                    </div>
                                 </div>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="myTab2_example2">


                            <form action="#" role="form" id="form">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Title <span class="symbol required"></span>
                                            </label>
                                            <input type="text" placeholder="Insert title" class="form-control" id="title" name="title">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Type Description <span class="symbol required"></span>
                                            </label>
                                            <textarea class="form-control" id="achievement" name="achievement"></textarea>
                                        </div>

                                    </div>

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


                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-wide pull-right" type="submit">
                                            Create <i class="fa fa-arrow-circle-right"></i>
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



</div>
</div>

</div>

@include('footer')

@include('rightSidebar')


</div>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script src="assets/js/form-validation.js"></script>
<script src="assets/js/custom-project.js"></script>





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
<script src="assets/js/custom-project.js"></script>






<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();

        $('#parentClass').hide();

        $('.teacherList').hide();

        $('.adminList').hide();

        if($('.parentChk').prop('checked') == true)
        {
            $('#parentClass').show();
        }

        if($('.teacherChk').prop('checked') == true)
        {
            $('.teacherList').show();
        }

        if($('.adminChk').prop('checked') == true)
        {
            $('.adminList').show();
        }
    });


    $('.parentChk').change(function(){
        if($(this).prop('checked') == true)
        {
            $('#parentClass').show();
        }else{
            $('#parentClass').hide();
        }
    });
    $('.teacherChk').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.teacherList').show();
        }else{
            $('.teacherList').hide();
        }
    });
    $('.adminChk').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.adminList').show();
        }else{
            $('.adminList').hide();
        }
    });

    $('.classFirst').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.FirstDiv').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.FirstDiv').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
            });
        }
    });

    $('.classSecond').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.SecondDiv').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.SecondDiv').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
            });
        }
    });

    $('#service4').click(function(){
        var route='get-all-admins/';
        $.get(route,function(data){
            var res= $.map(data,function(value){
                return value;
            });
            if (res.length == 0)
            {
                $('#adminList').html("no record found");
            } else {
                var str = "";
                for(var i=0; i<res.length; i++)
                {
                   str += '<option value="'+res[i]['id']+'">'+res[i]['first_name'] +' '+ res[i]['last_name']+'</option>';
                }
                $('#adminList').html(str);
            }
        });

    });
    $('#service1').click(function(){
        var route='get-all-teachers/';
        $.get(route,function(data){
            var res= $.map(data,function(value){
                return value;
            });
            if (res.length == 0)
            {
                $('#teacherList').html("no record found");
            } else {
                var str = "";
                for(var i=0; i<res.length; i++)
                {
                    str += '<option value="'+res[i]['id']+'">'+res[i]['first_name'] +' '+ res[i]['last_name']+'</option>';
                }
                $('#teacherList').html(str);
            }
        });

    });

    $('#batch-select').change(function(){
        $('#batch-class-div-data').html('');
        var id=this.value;
        batchChange(id);

    });
    function batchChange(batch_id) {

        $.ajax({
            url: 'show-create-announcement',
            type: "get",
            data: {batch_id},
            success: function(data){
                var res= $.map(data,function(value){
                    return value;
                });
                    var str = "";
                    str += '<label class="control-label">'+
                        'Class <em>(select at least one)</em> <span class="symbol required"></span></label>';

                             for(var i=0; i<res.length; i++)
                             {
                               str +='<div class="checkbox clip-check check-primary">' +
                                   '<input type="checkbox" value="'+res[i]['class_id']+'" class="classFirst" id="'+res[i]['class_id']+'">'+
                                         '<label for="'+res[i]['class_id']+'">'
                                            + res[i]['class_name'] +
                                         '</label>'+
                             '</div>';

                                 var res1= $.map(res[i]['division'],function(value){
                                     return value;
                                 });
                               for(var j=0; j<res1.length; j++) {

                                   str += '<div class="checkbox clip-check check-primary checkbox-inline">'+
                                       '<input type="checkbox" value="'+res1[j]['division_id']+'" class="FirstDiv" id="'+res1[j]['division_id']+'" >'+
                                       '<label for="'+res1[j]['division_id']+'">'
                                        +res1[j]['division_name']+
                                       '</label>';
                                   str +='</div> ';
                               }
                               str+="<p></p>"

                             }
                    console.log(str);
                $('#batch-class-div-data').html(str);

                }
        });
    }

</script>




<!-- start: MAIN JAVASCRIPTS -->

@stop