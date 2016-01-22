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
                                            <input class="form-control datepicker" type="text" id="datePiker" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 form-group" id="tableContent2">
                                    <div class="row" style="margin-bottom: 4px;">
                                        <label>Unmark Students Who Are absent:</label>
                                    </div>
                                    <table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" class="allCheckedStud" id="allCheckedStud" checked/> <label for="allCheckedStud" id="allCheckedStud-label"><img class="checkbox-img"/></label></th>
                                            <th>Roll No.</th>
                                            <th>Name</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud" id="1"/><label for="1"><img id="checkedStud1" class="checkbox-img" for="1"/></label></td>
                                            <td>102</td>
                                            <td>Vinit Singh &nbsp; <span class="label label-orange">Leave Approved</span> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud" id="2"/><label for="2"><img id="checkedStud2" class="checkbox-img"/></label></td>
                                            <td>103</td>
                                            <td>Arjun Kale  &nbsp; <span class="label label-orange">Leave Approved</span></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud" id="3"/><label for="3"><img id="checkedStud3" class="checkbox-img"/></label></td>
                                            <td>104</td>
                                            <td>Yash Patil  &nbsp; <span class="label label-yellow">Leave Applied</span> </td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud" id="4"/><label for="4"><img class="checkbox-img" id="checkedStud4"/></label></td>
                                            <td>105</td>
                                            <td>N Yadav</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud" id="5"/><label for="5"><img class="checkbox-img" id="checkedStud5"/></label></td>
                                            <td>106</td>
                                            <td>Sunny Rao</td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class="checkedStud" id="6"/><label for="6"><img class="checkbox-img" id="checkedStud6"/></label></td>
                                            <td>107</td>
                                            <td>Karan Sharma</td>
                                        </tr>

                                        </tbody>

                                    </table>
                                </div>
                                <div class="col-md-12 form-group">
                                    <button class="btn btn-primary btn-wide" type="button" id="btnSubmit">
                                        Cancel
                                    </button>
                                    <button class="btn btn-wide btn-primary ladda-button pull-right" data-style="expand-left" type="button">
                                        <span class="ladda-label">Save</span>
                                        <span class="ladda-spinner"></span><span class="ladda-spinner"></span>
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
<script src="assets/js/main.js"></script>
<script src="assets/js/form-elements.js"></script>
<script src="vendor/ladda-bootstrap/spin.min.js"></script>
<script src="vendor/ladda-bootstrap/ladda.min.js"></script>
<script src="assets/js/ui-buttons.js"></script>
<script src="assets/js/custom-project.js"></script>
<script src="vendor/ckeditor/ckeditor.js"></script>
<script src="vendor/ckeditor/adapters/jquery.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/js/form-validation.js"></script>
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormValidator.init();
        TableData.init();
        FormElements.init();
        UIButtons.init();

        $('#allCheckedStud-label img').css('border','1px solid');
        if($('.allCheckedStud').prop('checked') == true)
        {
            $('#allCheckedStud-label img').prop('src','assets/images/tick.png');
            var i=0;
            $('.checkedStud').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
                i++;
                $('#'+this.className+i).prop('src','assets/images/tick.png');

            });
        }

    });

    $('#btnSubmit').click(function(){
        window.location.href="#";
    });

    $('.allCheckedStud').change(function(){

        if($(this).prop('checked') == true)
        {
            $('#allCheckedStud-label img').prop('src','assets/images/tick.png');
            $('.checkedStud').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
                $('#'+this.className+this.id).prop('src','assets/images/tick.png');
            });
        }else{
            $('.checkedStud').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"
                $('#'+this.className+this.id).prop('src','assets/images/cross.png');

            });
            $('#allCheckedStud-label img').prop('src','assets/images/cross.png');
        }
    });

    $('.checkedStud').change(function(){

        if(this.checked==true)
        {
            $('#'+this.className+this.id).prop('src','assets/images/tick.png');

        }else{
            $('#'+this.className+this.id).prop('src','assets/images/cross.png');
        }
    });

    $('.datepicker').datepicker()
        .on('changeDate', function(ev){

            //write psudo code here for fetching data from controller using ajax

            $('#tableContent2').fadeOut(1000);

            $('#tableContent2').fadeIn(1000);

        });

</script>

@stop
