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

<div id="message-error-div"></div>
<section id="page-title" class="padding-top-15 padding-bottom-15">
    <div class="row">
        <div class="col-sm-7">
            <h1 class="mainTitle">Student</h1>
            <span class="mainDescription">Enquiry Form</span>
        </div>

    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<!-- start: DYNAMIC TABLE -->
    @include('alerts.errors')
<div class="col-md-12">
    <form method="post" action="/store-student-enquiry" role="form" id="studentEnquiry">
        <fieldset>
            <legend>
                Name of Father/Mother/Guardian
            </legend>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            First Name <span class="symbol required"></span>
                        </label>
                        <input type="text" placeholder="Enter your First Name" class="form-control" name="guardian_first_name"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            Middle Name
                        </label>
                        <input type="text" placeholder="Enter your Middle Name" class="form-control" name="guardian_middle_name"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            Last Name
                        </label>
                        <input type="text" placeholder="Enter your Last Name" class="form-control" name="guardian_last_name"/>
                    </div>
                </div>
            </div>

        </fieldset>
        <fieldset>
            <legend>
                Name of prospective student
            </legend>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            First Name <span class="symbol required"></span>
                        </label>
                        <input type="text" placeholder="Enter your First Name" class="form-control" name="student_first_name"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            Middle Name
                        </label>
                        <input type="text" placeholder="Enter your Middle Name" class="form-control" name="student_middle_name"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            Last Name
                        </label>
                        <input type="text" placeholder="Enter your Last Name" class="form-control" name="student_last_name"/>
                    </div>
                </div>
            </div>

        </fieldset>
        <fieldset>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label" for="dob">Date Of Birth <span class="symbol required"></span></label>
                        <input class="form-control" id="dob" name="dob" placeholder="MM/DD/YYY" type="text" value="{!! date('d/m/Y', time());!!}"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">Presently studying in class</label>
                        <input class="form-control" id="current_class" name="current_class" placeholder="Enter Current Class" type="text" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">School Name</label>
                        <input class="form-control" id="school_name" name="school_name" placeholder="Enter School Name" type="text" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">Seeking admission to class <span class="symbol required"></span></label>
                        <input class="form-control" id="admission_to_class" name="admission_to_class" placeholder="Seeking admission to class" type="text" />
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>
                Contact details
            </legend>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label">Mobile Number <span class="symbol required"></span></label>
                        <input class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number" type="text" />
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="control-label">
                        Address
                    </label>

                    <div class="form-group">
                        <div class="note-editor">
                            <textarea class="form-control autosize area-animated" name="address" data-autosize-on="true" style="overflow: hidden; resize: horizontal; word-wrap: break-word; height: 100px; cursor: url('/assets/images/pen.png') 0 32, auto;">
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>

        <div class="row">
            <div class="col-md-8">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary btn-wide pull-right" type="submit">
                    Submit
                </button>
            </div>
        </div>
    </form>
</div>

<!-- end: DYNAMIC TABLE -->

<!-- start: FOURTH SECTION -->
@include('rightSidebar')
<!-- end: FOURTH SECTION -->
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
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>


<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>
<script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="assets/js/enquiry-form.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        FormWizard.init();

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
</script>
@stop


