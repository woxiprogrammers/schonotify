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
                        <h1 class="mainTitle">Attendance</h1>
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
                                <div class="row">
                                    @include('selectClassDivisionDropdown')
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Select Date <span class="symbol required"></span>
                                            </label>
                                            <input class="form-control datepicker" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group" id="tableContent2">
                                    <div class="row" style="margin-bottom: 4px;">
                                        <label>Unmark Students Who Are Ubsent:</label>
                                    </div>
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" class="allCheckedStud" checked/></th>
                                            <th>Roll No.</th>
                                            <th>Name</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud"/></td>
                                            <td>102</td>
                                            <td>Vinit Singh</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud"/></td>
                                            <td>103</td>
                                            <td>Arjun Kale</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud"/></td>
                                            <td>104</td>
                                            <td>Yash Patil</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud"/></td>
                                            <td>105</td>
                                            <td>N Yadav</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud"/></td>
                                            <td>106</td>
                                            <td>Sunny Rao</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud"/></td>
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

<!-- start: JavaScript Event Handlers for this page -->
<script>
    jQuery(document).ready(function() {
        Main.init();
        TableData.init();
        FormElements.init();
        UIButtons.init();

        if($('.allCheckedStud').prop('checked') == true)
        {
            $('.checkedStud').each(function() { //loop through each checkbox
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

    $('.allCheckedStud').change(function(){
        if($(this).prop('checked') == true)
        {
            $('.checkedStud').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
                $(this).toggleClass('image-checkbox');
            });
        }else{
            $('.checkedStud').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
                $(this).toggleClass('image-checkbox-checked');
            });
        }
    });


</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop