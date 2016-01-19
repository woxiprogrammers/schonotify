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
                            <h1 class="mainTitle">Create</h1>
                            <span class="mainDescription">Class</span>
                        </div>

                    </div>
                </section>

                    <div class="container-fluid container-fullw">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">

                                <form method="post" action="class-create" role="form" id="classCreateForm">
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

                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label">
                                                    Enter class name <span class="symbol required"></span>
                                                </label>
                                                <input type="text" placeholder="Insert new class name" class="form-control" id="class" name="class">
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn-wide pull-right" type="submit">
                                                    Create <i class="fa fa-arrow-circle-right"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <label>Add New Batch</label>
                                            <button type="button" class="btn btn-wide btn-primary " data-toggle="modal" data-target="#batchModal"><i class="ti-plus"></i></button>
                                        </div>

                                </form>
                            </div>
                        </div>

                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="batchModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="resetBatch">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Create New Batch</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                                <div class="row">
                                                    <div class="col-md-11 padding-left-20">
                                                     <form action="#" role="form" id="batch-create">
                                                        <div class="col-md-10 col-md-offset-2">

                                                            <div class="col-md-8">
                                                                <div class="form-group">
                                                                    <input type="text" placeholder="Insert new batch name" class="form-control" id="batchesDefault" name="batchesDefault">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 ">
                                                                <button type="submit" class="btn btn-primary" id="addBatch"><i class="ti-plus"></i></button>
                                                            </div>

                                                        </div>
                                                    </form>
                                                        <div class="col-md-10 col-sm-offset-2 " id="checkHeight">
                                                            <div id="batchDiv"></div>
                                                        </div>
                                                    </div>
                                                 </div>
                                                <div class="modal-footer">
                                                    <div id="access-denied"></div>
                                                    <button type="button" id="resetBatch1" class="btn btn-primary btn-o" data-dismiss="modal" >
                                                        Close
                                                    </button>
                                                </div>


                                        </div>
                                    </div>

                                </div>
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
        getbatches();
    });

    $('#resetBatch').click(function() {
        $('#access-denied').html('');
        var i = $('input[name="batches"]').size();
        while(i > 0) {
            $('#divTxt:last').remove();
            $('#del:last').remove();
            i--;
        }
        $('#checkHeight').removeClass('flexcroll1');
    });

    $('#resetBatch1').click(function() {
        $('#access-denied').html('');
        var i = $('input[name="batches"]').size();

        while(i > 0) {
            $('#divTxt:last').remove();
            $('#del:last').remove();
            i--;
        }
        $('#checkHeight').removeClass('flexcroll1');
    });

    function deleteBatch(val){
        var i = $('input[name="batches"]').size();
        var delDiv='.div'+val;
        var delBtn='.del'+val;

        var route="/delete-batch/"+val;

        $.get(route,function(res){

            if(res==403)
            {
                $('#access-denied').html('<div class="alert-danger col-sm-10 center">You currently do not have permission to access this functionality. Please contact administrator to grant you access</div>');
            }else{
                $(delDiv).remove();
                $(delBtn).remove();

                if(i<5)
                {
                    $('#checkHeight').removeClass('flexcroll1');
                }else{

                    $('#checkHeight').addClass('flexcroll1');
                }
                getbatches();
            }

        });

    }

    function getbatches()
    {
        var route="get-batches";
        $.get(route,function(res){
            var str="<option value=''>Select Batch</option>";
            for(var i=0; i<res.length; i++)
            {
                str+="<option value='"+res[i]['id']+"'>"+res[i]['name']+"</option>"
            }
            $('#dropdown').html(str);
        });
    }


</script>

@stop


