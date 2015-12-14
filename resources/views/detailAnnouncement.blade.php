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
            <h1 class="mainTitle">Notice Board</h1>
        </div>
        <ul class="mini-stats col-sm-2 pull-right">

            <li>
                <div class="values">
                    <a href="/createNoticeBoard" class="btn btn-primary"><i class="ti-plus"></i></a> Create New
                </div>
            </li>

        </ul>

    </div>
</section>
<!-- end: DASHBOARD TITLE -->
<div class="container-fluid container-fullw bg-white">

    <div class="row">
        <div class="col-md-12">
            <div id="detail">

                    <div class="col-sm-12">
                        <div class="panel panel-white load1" id="panel6">
                            <div class="panel-heading">

                                <div class="timeline_title">
                                    <i class="fa fa-bullhorn fa-2x pull-left fa-border"></i>
                                    <h4 class="panel-title no-margin text-primary padding-15">PARENT MEET FOR THIS MONTH</h4>
                                </div>
                                <div class="panel-tools">
                                    <a data-original-title="Refresh" data-toggle="tooltip" data-placement="top" class="btn btn-transparent btn-sm panel-refresh" href="#"><i class="ti-reload"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="panel-scroll height-280 ps-container ps-active-y">
                                    Parent Meet for this month is scheduled. And everyone should be requested to have their presence. this parent meet will have focused on renovation of school and faculty.
                                    <br>
                                    Venue:
                                    <address>
                                        <strong>MIT School</strong>
                                        <br>
                                        795 Folsom Ave, Suite 600
                                        <br>
                                        San Francisco, CA 94107
                                        <br>
                                        <abbr title="Phone">P:</abbr> (123) 456-7890
                                    </address>

                                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 180px; right: 3px;"><div class="ps-scrollbar-y" style="top: 0px; height: 82px;"></div></div></div>
                            </div>
                            <div class="panel-footer col-sm-12">

                                    <h4>Mrs. Archana Singh <small><i>Admin</i></small><small class="pull-right"><i class="fa fa-clock-o"></i> Wednesday 2 Oct, 2015 1:00 PM</small></h4>

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
                                <label class="control-label">
                                    Title <span class="symbol required"></span>
                                </label>
                                <input type="text" placeholder="Insert Title" class="form-control" id="title" name="title" value="PARENT MEET FOR THIS MONTH">
                            </div>
                            <div class="form-group">
                                <label class="control-label">
                                    Description <span class="symbol required"></span>
                                </label>
                                <textarea class="form-control col-sm-8" id="announcement" name="announcement" style="min-height: 180px;">Parent Meet for this month is scheduled. And everyone should be requested to have their presence. this parent meet will have focused on renovation of school and faculty.
                                    Venue:
                                    MIT School
                                    795 Folsom Ave, Suite 600
                                    San Francisco, CA 94107
                                    P: (123) 456-7890
                                </textarea>
                            </div>
                        </div>


                        <div class="col-md-12 margin-top-10">

                            <div class="form-group col-sm-3">
                                <label class="control-label">
                                    User Roles <em>(select at least one)</em> <span class="symbol required"></span>
                                </label>
                                <div class="checkbox clip-check check-primary">
                                    <input type="checkbox" value="" class="teacherChk" name="userrole" id="service1" checked>
                                    <label for="service1">
                                        Teacher
                                    </label>
                                </div>
                                <div class="checkbox clip-check check-primary">
                                    <input type="checkbox" value=""  class="parentChk" name="userrole" id="service2" checked>
                                    <label for="service2">
                                        Parent
                                    </label>
                                </div>

                                <div class="checkbox clip-check check-primary">
                                    <input type="checkbox" value="" name="userrole" id="service4">
                                    <label for="service4">
                                        Admin
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-4 panel panel-white" id="parentClass">
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
                                        Class <em>(select at least one)</em> <span class="symbol required"></span>
                                    </label>

                                    <div class="checkbox clip-check check-primary">
                                        <input type="checkbox" value="" class="classFirst" id="service5">
                                        <label for="service5">
                                            First
                                        </label>
                                    </div>
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
                                <div class="form-group">
                                    <div class="checkbox clip-check check-primary">
                                        <input type="checkbox" value="" class="classSecond" id="service9">
                                        <label for="service9">
                                            Second
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                        <input type="checkbox" value="" class="SecondDiv" id="service10" >
                                        <label for="service10">
                                            A
                                        </label>
                                    </div>
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                        <input type="checkbox" value="" class="SecondDiv"  id="service11" >
                                        <label for="service11">
                                            B
                                        </label>
                                    </div>
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                        <input type="checkbox" value="" class="SecondDiv"  id="service12">
                                        <label for="service12">
                                            C
                                        </label>
                                    </div>
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                        <input type="checkbox" value="" class="SecondDiv"  id="service13">
                                        <label for="service13">
                                            D
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-4 panel panel-white" id="teacherClass">
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
                                        Class <em>(select at least one)</em> <span class="symbol required"></span>
                                    </label>

                                    <div class="checkbox clip-check check-primary">
                                        <input type="checkbox" value="" class="classFirst" id="service5">
                                        <label for="service5">
                                            First
                                        </label>
                                    </div>
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
                                <div class="form-group">
                                    <div class="checkbox clip-check check-primary">
                                        <input type="checkbox" value="" class="classSecond" id="service9">
                                        <label for="service9">
                                            Second
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                        <input type="checkbox" value="" class="SecondDiv" id="service10" >
                                        <label for="service10">
                                            A
                                        </label>
                                    </div>
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                        <input type="checkbox" value="" class="SecondDiv"  id="service11" >
                                        <label for="service11">
                                            B
                                        </label>
                                    </div>
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                        <input type="checkbox" value="" class="SecondDiv"  id="service12">
                                        <label for="service12">
                                            C
                                        </label>
                                    </div>
                                    <div class="checkbox clip-check check-primary checkbox-inline">
                                        <input type="checkbox" value="" class="SecondDiv"  id="service13">
                                        <label for="service13">
                                            D
                                        </label>
                                    </div>
                                </div>

                            </div>
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
<!-- end: MAIN JAVASCRIPTS -->
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
<script>
    jQuery(document).ready(function() {
        Main.init();

        $('#update').hide();
        $('#btnStatus').hide();
        $('#parentClass').hide();
        $('#teacherClass').hide();

        if($('.parentChk').prop('checked') == true)
        {
            $('#parentClass').show();
        }
        if($('.teacherChk').prop('checked') == true)
        {
            $('#teacherClass').show();
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
        window.location.href="detailedAnnouncement";
    });

    $('#btnPublish').click(function(){
        $('#btnDiv').hide();
        $('#btnStatus').show();
    });

    $('.parentChk').change(function(){
        if($(this).prop('checked') == true)
        {
            $('#parentClass').show();
        }else{
            $('#parentClass').hide();
        }
    });

    $('.teacherChk').change(function(){
        if($(this).prop('checked') == true)
        {
            $('#teacherClass').show();
        }else{
            $('#teacherClass').hide();
        }
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


</script>


<!-- start: MAIN JAVASCRIPTS -->

@stop