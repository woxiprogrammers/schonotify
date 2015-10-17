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
                            <h1 class="mainTitle">Create</h1>
                            <span class="mainDescription">Class</span>
                        </div>

                    </div>
                </section>

                    <div class="container-fluid container-fullw">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">

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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">
                                                    Batch <span class="symbol required"></span>
                                                </label>
                                                <select class="form-control" id="dropdown" name="dropdown">
                                                    <option value="">Select Batch</option>
                                                    <option value="Category 1">Category 1</option>
                                                    <option value="Category 2">Category 2</option>
                                                    <option value="Category 3">Category 5</option>
                                                    <option value="Category 4">Category 4</option>
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
                                            <button type="button" class="btn btn-wide btn-primary " data-toggle="modal" data-target=".bs-example-modal-lg"><i class="ti-plus"></i></button>
                                        </div>

                                </form>
                            </div>
                        </div>

                        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                            <form action="#" role="form" id="form">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="errorHandler alert alert-danger no-display">
                                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                                        </div>
                                                        <div class="successHandler alert alert-success no-display">
                                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                                        </div>
                                                        <div class="col-md-10 col-md-offset-2">

                                                        <div class="col-md-8">
                                                            <div class="form-group">
                                                                <input type="text" placeholder="Insert new batch name" class="form-control" id="batch" name="batch">
                                                            </div>
                                                        </div>
                                                            <div class="col-md-4 ">
                                                                <button type="button" class="btn btn-primary" id="addBatch"><i class="ti-plus"></i></button>
                                                                <button type="button" class="btn btn-primary btn-red pull-right hideDelete" id="removeBatch"><i class="glyphicon glyphicon-trash"></i></button>
                                                            </div>
                                                        <div class="col-md-8" id="checkHeight">
                                                            <div id="batchDiv"></div>
                                                        </div>


                                                        </div>
                                                    </div>
                                                 </div>
                                                <div class="modal-footer">
                                                    <button type="button" id="resetBatch1" class="btn btn-primary btn-o" data-dismiss="modal" >
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>

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

<script>
    jQuery(document).ready(function() {
        Main.init();
        FormWizard.init();
        FormValidator.init();
    });
</script>
<script type="text/javascript">


    $('#option-select').on('change',function(){

        var par=this.value;

        if(isNaN(par)==false)
        {
            var route= "/createUsers/"+par;

            //console.log(route);
            //debugger;
            window.location.replace(route);


        }

    });

</script>
<script>
    $(document).ready(function(){

        var i = $('#form input[type="text"]').size() + 1;



        $('.hideDelete').hide();



        $('#addBatch').click(function() {
            $('<div class="form-group"><input type="text" class="field form-control" name="batch[]" /></div>').fadeIn('slow').appendTo('form #batchDiv');
            i++;

            if(i<2)
            {
                $('.hideDelete').hide();
            }else{
                $('.hideDelete').show();

            }

            if(i<6)
            {
                $('#checkHeight').removeClass('flexcroll1');
            }else{
                $('#checkHeight').addClass('flexcroll1');
            }

        });

        $('#removeBatch').click(function() {
            if(i > 1) {
                $('.field:last').remove();
                i--;

                if(i<=2)
                {
                    $('.hideDelete').hide();
                }

                if(i<6)
                {
                    $('#checkHeight').removeClass('flexcroll1');
                }

            }
        });

        $('#resetBatch').click(function() {
            while(i > 2) {
                $('.field:last').remove();
                i--;
            }
        });

        $('#resetBatch1').click(function() {
            while(i > 2) {
                $('.field:last').remove();
                i--;
            }
        });


        $('.submit').click(function(){

            var answers = [];
            $.each($('.field'), function() {
                answers.push($(this).val());
            });

            if(answers.length == 0) {
                answers = "none";
            }

            return false;

        });

    });




</script>

@stop


