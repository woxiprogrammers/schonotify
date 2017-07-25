@extends('master')

@section('content')

<div id="app">
    <div class="sidebar app-aside" id="sidebar" style="top: 0px!important;">
        <img class="img-responsive" src="/assets/images/bodyLogo/sspss.jpg">
    </div>
    <div class="app-content">
        <!-- start: TOP NAVBAR -->


        <!-- end: TOP NAVBAR -->
        <div class="main-content" >
            <div class="wrap-content container" id="container">
                <!-- start: DASHBOARD TITLE -->

                <div id="message-error-div"></div>
                <section id="page-title" class="padding-top-15 padding-bottom-15">
                    <div class="row">
                        <div class="col-sm-7">
                            @if($schoolSlug=='gis')
                            <h1 class="mainTitle">Ganesh International School , Chikhali</h1>
                            @elseif($schoolSlug=='gems')
                            <h1 class="mainTitle">Ganesh English Medium School , Dapodi</h1>
                            @endif

                            <span class="mainDescription">Enquiry Form</span>
                        </div>

                    </div>
                </section>
                <!-- end: DASHBOARD TITLE -->
                <!-- start: DYNAMIC TABLE -->
                @include('alerts.errors')
                <div class="col-md-12">
                    <form method="post" action="/redirect" role="form" id="checkEnquiry">
                        <fieldset>
                            <legend>
                                Enquiry Number
                            </legend>

                        </fieldset>
                        <input type="hidden" name="bodySlug" id="bodySlug" value="{{$schoolSlug}}"/>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label  class="control-label">
                                        Enter Enquiry Number
                                    </label>
                                    <input type="text" placeholder="Enter enquiry number" class="form-control" name="enquiry_number" id="enquiry_number"/>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label  class="control-label"></label>
                                </div>
                                <button class="btn btn-primary btn-wide pull-left" type="submit">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- end: DYNAMIC TABLE -->

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
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="/assets/js/main.js"></script>


<script src="/assets/js/custom-project.js"></script>
<script src="/vendor/ckeditor/ckeditor.js"></script>
<script src="/vendor/ckeditor/adapters/jquery.js"></script>
<script src="/assets/js/form-validation.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/assets/js/enquiry-number.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        var date_input=$('input[name="dob"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
            endDate: '+0d',
        })
    });

    $('#current_class').blur(function() {
        if($(this).val()=="") {
            $('#school_name').attr("disabled", "disabled");
        }else{
            $("#school_name").removeAttr("disabled");
        }
    });
</script>
@stop


