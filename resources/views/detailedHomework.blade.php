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
<div class="col-md-11 col-md-offset-1">
<div id="detail">
    <div class="col-sm-12">
        <div class="panel panel-white load1" id="panel6">
            <div class="panel-heading">
                <div class="timeline_title">
                    <i class="fa fa-book fa-2x pull-left fa-border"></i>
                    <h4 class="panel-title no-margin text-primary" style="padding: 14px;">Assignment</h4>
                    <h5 style=" background-color: rgb(0, 122, 255);color: #fff;padding: 10px;">
                        <strong>Subject: </strong>
                        <small class="label label-sm label-white">Marathi</small>
                        <p class="pull-right">
                            <strong>Batch :</strong> <i>Morning</i>
                            <strong>Class :</strong> <i>Fourth </i>
                            <strong>Div : </strong> <i> A</i>
                        </p>
                    </h5>
                </div>
                <div class="panel-tools">
                    <i class="fa fa-clock-o"></i> Wednesday 12 Nov, 2015 12:00 PM
                    <a data-original-title="Refresh" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-refresh" href="#"><i class="ti-reload"></i></a>
                </div>
            </div>
            <div class="panel-body">
                <div class="panel-scroll height-280 ps-container ps-active-y">
                    <h4>Complete the all questions mentioned in file. <a href="javascript:void(0);"> Download <i class="fa fa-cloud-download"></i></a></h4>
                    <br>
                    <p>
                        This file contains few multiple choice question on chapter 1 & 3.
                    </p>
                    <br>
                    <br>
                    <address>

                    Due Date:
                         14 Nov, 2015 6:00 PM
                    </address>

                    <div class="col-md-12 form-group" id="tableContent2">
                        <div class="row" style="margin-bottom: 4px;">
                            <label>This Homework assigned to following students:</label>
                        </div>

                        <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                            <thead>
                            <tr>

                                <th>Roll No.</th>
                                <th>Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <td>102</td>
                                <td>Vinit Singh</td>
                            </tr>
                            <tr>

                                <td>103</td>
                                <td>Arjun Kale</td>
                            </tr>
                            <tr>

                                <td>104</td>
                                <td>Yash Patil</td>
                            </tr>
                            <tr>

                                <td>105</td>
                                <td>N Yadav</td>
                            </tr>
                            <tr>

                                <td>106</td>
                                <td>Sunny Rao</td>
                            </tr>
                            <tr>

                                <td>107</td>
                                <td>Karan Sharma</td>
                            </tr>

                            </tbody>

                        </table>

                    </div>

                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 82px;"></div></div></div>
            </div>
            <div class="panel-footer col-sm-12">

                <h4><small>Created By: </small> Mrs. Archana Singh </h4>

                <div class="col-md-12" id="btnDiv">
                    <button class="btn btn-primary btn-wide pull-left" type="button" id="btnEdit">
                        <i class="fa fa-wrench"></i> Update
                    </button>
                    <button class="btn btn-primary btn-wide pull-right panel-refresh" type="button" id="btnPublish">
                        <i class="fa fa-cloud-upload"></i> Publish
                    </button>
                </div>
                <div class="col-md-12" id="btnStatus">
                    <h5> Status :<i class="fa fa-flag"></i> <i>Published</i></h5>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="update">
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
                    <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title" value="Complete the all questions mentioned in file">
                </div>

                <div class="form-group">
                    <label class="control-label">
                        Description <span class="symbol required"></span>
                    </label>
                    <textarea class="form-control col-sm-8" id="announcement" name="announcement" style="min-height: 180px; margin-bottom: 8px;">This file contains few multiple choice question on chapter 1 & 3.</textarea>
                </div>
                <div>
                    <label class="control-label">
                        Upload Document
                    </label>
                    <div id="wrapper">
                        <input id="input" size="1" type="file" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">
                            Due Date <span class="symbol required"></span>
                        </label>
                        <input class="form-control datepicker" type="text" value="2/11/2015">
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
                            <input type="checkbox" value="" class="FirstDiv" id="service6" checked>
                            <label for="service6">
                                A
                            </label>
                        </div>
                        <div class="checkbox clip-check check-primary checkbox-inline" >
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
            <div class="col-md-10 form-group" id="tableContent2">
                <label>Select Students to assign homework</label>
                <table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="allCheckedStud1" checked/><span class="position-absolute padding-left-5"><b>Select all</b></span></th>
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
            <div class="col-md-12">
                <button class="btn btn-primary btn-wide pull-left" type="button" id="btnCancel">
                    Cancel <i class="fa fa-times-circle-o"></i>
                </button>
                <button class="btn btn-primary btn-wide pull-right" type="submit" id="btnUpdate">
                    Update <i class="fa fa-arrow-circle-right"></i>
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
<script src="assets/js/custom-project.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script>
    jQuery(document).ready(function() {
        getMsgCount();
        Main.init();
        FormElements.init();
        TableData.init();

        $('#update').hide();
        $('#btnStatus').hide();
        if($('.allCheckedStud1').prop('checked') == true)
        {
            $('.checkedStud1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
            });
        }
    });

    $('#btnEdit').click(function(){
        $('#detail').hide();
        $('#update').show();
    });

    $('#btnCancel').click(function(){
        $('#update').hide();
        $('#detail').show();

    });

    $('#btnUpdate').click(function(){
        window.location.href="detailedHomework";
    });

    $('#btnPublish').click(function(){
        $('#btnDiv').hide();
        $('#btnStatus').show();
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