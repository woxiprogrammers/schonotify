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
        <section id="page-title" class="padding-top-15 padding-bottom-15">
            <div class="row">
                <div class="col-sm-7">
                    <h1 class="mainTitle">Homework</h1>

                </div>
                <ul class="mini-stats col-sm-2 pull-right">

                    <li>
                        <div class="values">
                            <a href="/createHomework" class="btn btn-primary"><i class="ti-plus"></i></a> Create New
                        </div>
                    </li>

                </ul>

            </div>
        </section>
        <!-- end: DASHBOARD TITLE -->
        <div class="container-fluid container-fullw bg-white">


            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="panel-body">
                        <ul class="timeline-xs" id="tmln">
                            @foreach($homeworkIdss as $row)
                            @if($row['homework_is_active'] ==1)
                            <li class="timeline-item">
                                <div class="leaveSection">
                                    <div class="text-muted text-small">

                                       {!! $row['homework_dateNow']!!} hr ago

                                    </div>
                                    <div class="col-sm-8" style="margin-top: 4px;">

                                        <h5><small class="label label-sm label-info">{!! $row['homework_teacher_name']!!}</small> {!! $row['homework_title']!!} @if ($row['homework_file'] != null) <i class="fa fa-paperclip"></i> @endif</h5>


                                        <p>Date:<i> {!! date('d M  Y', strtotime(str_replace('-', '/', $row['homework_date'])));!!} </i> <br> Due Date:<i> {!! date('d M  Y', strtotime(str_replace('-', '/', $row['homework_due_date'])));!!}</i></p>
                                    </div>
                                    <a href="/delete-homework/{!! $row['homework_id']!!}" class="btn btn-primary btn-red pull-left"><i class="glyphicon glyphicon-trash"></i></a>

                                    <div class="col-sm-2">

                                        @if($row['homework_status'] == 0 && $row['homework_is_active'] ==1)
                                        <small class="label label-sm label-danger">saved to draft</small>
                                        @elseif($row['homework_status'] == 1 &&  $row['homework_is_active'] ==1 )
                                        <small class="label label-sm label-inverse">Published</small>
                                        @endif
                                        <div style="margin-top:10px;">
                                            <a class="text-info " href="/detailedHomework/{!!$row['homework_id']!!}">View More</a>
                                        </div>

                                    </div>

                                </div>

                                <div class="tmln-div">
                                    <h5 style="padding: 14px 14px 14px 30px;">{!! $row['homework_class_name']!!}       <small>  Div. {!! $row['homework_division_name']!!}</small></h5>
                                </div>

                            </li>
                            @endif
                            @endforeach
                        </ul>
                        <div id="loadmoreajaxloader" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>
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
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>


<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
    });








</script>



<!-- start: MAIN JAVASCRIPTS -->

@stop