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
                            <span class="mainDescription">Division</span>
                        </div>

                    </div>
                </section>

                <div class="container-fluid container-fullw">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">

                            <form method="post" action="division-create" role="form" id="div-create">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Batch <span class="symbol required"></span>
                                            </label>
                                            <select class="form-control" id="dropdown" name="dropdown" style="-webkit-appearance: menulist;">
                                                <option value="">Select Batch</option>
                                                @foreach($batches as $batch)
                                                <option value="{!! $batch->id !!}">{!! $batch->name !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Class <span class="symbol required"></span>
                                            </label>
                                            <select class="form-control" id="classDropdown" name="classDropdown" style="-webkit-appearance: menulist;">
                                                <option value="">Select Class</option>
                                            </select>
                                            <div id="loadmoreajaxloader" style="display:none;"><center><img src="assets/images/loader1.gif" /></center></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">
                                                Enter division name <span class="symbol required"></span>
                                            </label>
                                            <input type="text" class="form-control" id="division" name="division">
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

    $('#division').css('text-transform','uppercase');

    $('#dropdown').change(function(){
        $('#division').val("");
        $('div#loadmoreajaxloader').show();
        var route="/get-classes/"+this.value;
        $.get(route,function(res){
            var str="";
            for(var i= 0; i<res.length; i++)
            {
                str+='<option value="'+res[i]['id']+'">'+res[i]['class_name']+'</option>';
            }
            $('#classDropdown').html(str);
            $('div#loadmoreajaxloader').hide();
        });
    });

    $('#classDropdown').change(function(){
        $('#division').val("");
    });

</script>

@stop


