
@extends('master')

@section('content')

<div id="app">

    @include('sidebar')

    <div class="app-content">

        @include('header')
        <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div class="wrap-content container" id="container">
                @include('alerts.errors')
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            <h1 class="mainTitle">Payment</h1>
                            <span class="mainDescription">Fee</span>
                        </div>
                    </div>
                </section>
                <fieldset>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">
                                Batch <span class="symbol required"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" >
                            <label class="control-label">
                                Class <span class="symbol required"></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" >

                        </div>
                    </div>
                </fieldset>
            </div>
            @include('rightSidebar')
        </div>
    </div>

    @include('footer')
</div>



<script src="/vendor/jquery/jquery.min.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendor/modernizr/modernizr.js"></script>
<script src="/vendor/jquery-cookie/jquery.cookie.js"></script>4a
<script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="/vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="/vendor/autosize/autosize.min.js"></script>
<script src="/vendor/selectFx/classie.js"></script>
<script src="/vendor/selectFx/selectFx.js"></script>
<script src="/vendor/select2/select2.min.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>

<!-- start: JavaScript Event Handlers for this page -->

<script src="/assets/js/form-validation-edit.js"></script>
<script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/form-elements.js"></script>
<script src="/assets/js/custom-project.js"></script>
<script src="/assets/js/table-data.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function()
    {
        Main.init();
        FormValidator.init();
        FormElements.init();
        event.stopPropagation();
    })
</script>
@stop














