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


    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<div class="container-fluid container-fullw bg-white">

<div class="row">
<div class="col-md-10 col-md-offset-1">
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
                    <label for="form-field-select-2">
                        Select Subject
                    </label>
                    <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                        <option value="1">Marathi</option>
                        <option value="2">English</option>
                        <option value="3">History</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        Homework Type <span class="symbol required"></span>
                    </label>
                    <select class="form-control" style="-webkit-appearance: menulist;">
                        <option value="1">Assignment</option>
                        <option value="2">Quiz</option>
                        <option value="3">Class Test</option>
                        <option value="4">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">
                        Title <span class="symbol required"></span>
                    </label>
                    <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label class="control-label">
                        Description <span class="symbol required"></span>
                    </label>
                    <textarea class="form-control col-sm-8" id="announcement" name="announcement" style="min-height: 180px; margin-bottom: 8px;"></textarea>
                </div>
                <div>
                    <label class="control-label">
                        Upload Document
                    </label>
                    <div id="wrapper">
                        <input id="input" size="1" type="file" />
                    </div>
                    <br>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">
                            Due Date <span class="symbol required"></span>
                        </label>
                        <input class="form-control datepicker" type="text">
                    </div>
                    <h4>Assign Homework to: </h4>
                    <div class="form-group">
                        <label for="form-field-select-2">
                            Select Batch
                        </label>
                        <select class="form-control" id="batch-select" style="-webkit-appearance: menulist;">
                            <option value="1">morning</option>
                            <option value="2">evening</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">
                            Class <span class="symbol required"></span>
                        </label>
                        <select class="form-control" style="-webkit-appearance: menulist;">
                            <option value="1">First</option>
                            <option value="2">Second</option>
                            <option value="3">Third</option>
                            <option value="4">Fourth</option>
                            <option value="5">Fifth</option>
                            <option value="6">Sixth</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="checkbox clip-check check-primary checkbox-inline">
                            <input type="checkbox" value="" class="FirstDiv" id="service6" >
                            <label for="service6">
                                A
                            </label>
                        </div>
                        <div class="checkbox clip-check check-primary checkbox-inline">
                            <input type="checkbox" value="" class="FirstDiv" id="service7" >
                            <label for="service7">
                                B
                            </label>
                        </div>
                        <div class="checkbox clip-check check-primary checkbox-inline">
                            <input type="checkbox" value="" class="FirstDiv" id="service8">
                            <label for="service8">
                                C
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 form-group" id="tableContent2">
                <div class="row" style="margin-bottom: 4px;">
                    <label>Select Students to assign homework</label>
                </div>
                <table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="allCheckedStud1" checked/> <span class="position-absolute padding-left-5"><b>Select all</b></span></th>
                        <th>Roll No.</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><input type="checkbox" class="checkedStud1"/></td>
                        <td>102</td>
                        <td>Vinit Singh</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="checkedStud1"/></td>
                        <td>103</td>
                        <td>Arjun Kale</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="checkedStud1"/></td>
                        <td>104</td>
                        <td>Yash Patil</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="checkedStud1"/></td>
                        <td>105</td>
                        <td>N Yadav</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="checkedStud1"/></td>
                        <td>106</td>
                        <td>Sunny Rao</td>
                    </tr>
                    <tr>
                        <td><input type="checkbox" class="checkedStud1"/></td>
                        <td>107</td>
                        <td>Karan Sharma</td>
                    </tr>

                    </tbody>

                </table>
            </div>
                <div class="col-md-12 form-group">

                        <button class="btn btn-wide btn-primary ladda-button" data-style="expand-left" type="button">
                            <span class="ladda-label">Save</span>
                            <span class="ladda-spinner"></span><span class="ladda-spinner"></span></button>
                        <button class="btn btn-primary btn-wide pull-right" type="button" id="btnSubmit">
                            Publish
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
<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="vendor/autosize/autosize.min.js"></script>
<script src="vendor/selectFx/selectFx.js"></script>
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
<script src="vendor/selectFx/classie.js"></script>
<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

<script src="vendor/DataTables/jquery.dataTables.min.js"></script>
<script src="assets/js/table-data.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<script src="assets/js/form-elements.js"></script>
<script src="vendor/ladda-bootstrap/spin.min.js"></script>
<script src="vendor/ladda-bootstrap/ladda.min.js"></script>
<script src="assets/js/ui-buttons.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="assets/js/form-validation.js"></script>

<!-- start: JavaScript Event Handlers for this page -->
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        TableData.init();
        FormElements.init();
        UIButtons.init();

        if($('.allCheckedStud1').prop('checked') == true)
        {
            $('.checkedStud1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }

    });



    $('#btnSubmit').click(function(){
        window.location.href="homeworkListing";
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

    $('.allCheckedStud1').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.checkedStud1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }else{
            $('.checkedStud1').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
            });
        }
    });


</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop