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
                            <span class="mainDescription">Subject</span>
                        </div>

                    </div>
                </section>

                <div class="container-fluid container-fullw">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">

                            <form method="post" action="subject-create" role="form" id="createSubject">
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
                                                Enter Subject name <span class="symbol required"></span>
                                            </label>
                                            <input type="text" placeholder="Insert new subject name" class="form-control" id="subject_name" name="subject_name">
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Type Description
                                            </label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        </div>
                                        <div class="form-group">

                                            <label class="control-label">
                                                Select Classes <span class="symbol required"></span>
                                            </label>
                                            <div>

                                                @foreach($batches as $batch)
                                                    <div>

                                                    <table class="table table-responsive batchClassTab">
                                                        <tr>
                                                            <th>{!! $batch !!}</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                        <?php $i=0; ?>
                                                    @foreach($classes as $class)

                                                        @if($batch==$class['batch'])
                                                                @if($i%2==0)
                                                                <tr>
                                                                <td>
                                                                @else
                                                                <td>
                                                                @endif
                                                        <div class="checkbox clip-check check-primary checkbox-inline">
                                                            <input type="checkbox"  id="{!! $class['id'] !!}_chk" value="{!! $class['id'] !!}" name="class[]">
                                                            <label for="{!! $class['id'] !!}_chk">{!! $class['class'] !!}</label>
                                                        </div>
                                                                @if($i%2==0)
                                                                </td>

                                                                @else
                                                                </td>
                                                                </tr>
                                                                @endif
                                                        @endif
                                                        <?php $i++;?>

                                                    @endforeach


                                                    </table>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div class="form-group">
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

            @include('rightSidebar')
        </div>
    </div>
</div>
@include('footer')
</div>


<!-- start: MAIN JAVASCRIPTS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>

<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>

<script src="assets/js/form-wizard.js"></script>

<script src="assets/js/form-validation.js"></script>
<script src="assets/js/custom-project.js"></script>

<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormWizard.init();
        FormValidator.init();
    });


</script>

@stop


