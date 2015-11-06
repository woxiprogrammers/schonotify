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
                        <h1 class="mainTitle">Timetable</h1>
                        <span class="mainDescription">Create</span>
                    </div>
                    <div class="col-sm-5">
                        <!-- start: MINI STATS WITH SPARKLINE -->

                        <!-- end: MINI STATS WITH SPARKLINE -->
                    </div>
                </div>
            </section>
            <!-- end: DASHBOARD TITLE -->


            <div class="container-fluid container-fullw bg-white">
                <div class="row">

                    @include('selectClassDivisionDropdown')

                    <div class="row">
                        <div class="col-sm-12">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="errorHandler alert alert-danger no-display">
                                            <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                        </div>
                                        <div class="successHandler alert alert-success no-display">
                                            <i class="fa fa-ok"></i> Your form validation is successful!
                                        </div>
                                    </div>
                                    <form action="#" role="form" id="form2">
                                    <div class="col-md-12">
                                        <div class="form-group col-md-4">
                                            <label class="control-label">
                                                Batch <span class="symbol required"></span>
                                            </label>
                                            <select class="form-control" id="dropdown" name="dropdown" style="-webkit-appearance: menulist;">
                                                <option value="">Select Days</option>
                                                <option value="monday">Monday</option>
                                                <option value="tuesday">Tuesday</option>
                                                <option value="wednesday">Wednesday</option>
                                                <option value="thursday">Thursday</option>
                                                <option value="friday">Friday</option>
                                                <option value="saturday">Saturday</option>
                                                <option value="sunday">Sunday</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="control-label">
                                                Number of periods: <span class="symbol required"></span>
                                            </label>
                                            <input type="number" min="0" max="55" class="form-control" id="periods" name="periods">
                                        </div>

                                        <div class="col-md-3">
                                            <button class="btn" style="margin:22px 0px 0px 0px;" type="submit" id="structure-create">
                                                Create <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>


                                    </div>

                                    </form>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="errorHandler alert alert-danger no-display">
                                        <i class="fa fa-times-sign"></i> You have some form errors. Please check below.
                                    </div>
                                    <div class="successHandler alert alert-success no-display">
                                        <i class="fa fa-ok"></i> Your form validation is successful!
                                    </div>
                                    <div class="col-md-12">

                                        <div class="col-md-12" id="main-div-periods">
                                            <form>
                                                <div class="form-group col-sm-2">
                                                        <h4>Periods</h4>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                        <h4>Subjects</h4>
                                                </div>
                                                <div class="form-group col-sm-4">
                                                        <h4>Description</h4>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                        <h4>Start time</h4>
                                                </div>
                                                <div class="form-group col-sm-2">
                                                    <h4>End time</h4>
                                                </div>
                                                <div id="periods-rows"></div>
                                                <div class="col-md-3" id="periods-structure-save-btn">
                                                    <button class="btn btn-primary" style="margin:22px 0px 0px 0px;" type="button">
                                                        Create <i class="fa fa-arrow-circle-right"></i>
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

            </div>

            <!-- start: FOURTH SECTION -->
            @include('rightSidebar')
            <!-- end: FOURTH SECTION -->
        </div>
    </div>
</div>

@include('footer')

<!-- start: MAIN JAVASCRIPTS -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/modernizr/modernizr.js"></script>
<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="vendor/switchery/switchery.min.js"></script>
<!-- end: MAIN JAVASCRIPTS -->
    <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/autosize/autosize.min.js"></script>
    <script src="vendor/selectFx/classie.js"></script>
    <script src="vendor/selectFx/selectFx.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
<!-- start: CLIP-TWO JAVASCRIPTS -->
<script src="assets/js/main.js"></script>
<!-- start: JavaScript Event Handlers for this page -->
    <script src="vendor/ckeditor/ckeditor.js"></script>
    <script src="vendor/ckeditor/adapters/jquery.js"></script>

    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>

    <script src="assets/js/form-validation.js"></script>
    <script src="assets/js/form-elements.js"></script>



<script>
    $(document).ready(function(){
        Main.init();
        FormValidator.init();


        $('#dropdown').change(function(){
            if(confirm('do you want to create structure for '+$(this).val()) == true)
            {
                $(this).prop('disabled',true);
            }

        });

        $('#form2').on('submit',function(){

            if($('#dropdown').val() !== "")
            {
            if($('#periods').val() !== "")
            {
                $('#periods').prop('disabled',true);
                $('#structure-create').prop('disabled',true);
                $('#periods-structure-save-btn').show();
                $('#main-div-periods').show();


                for(i=0; i< $('#periods').val(); i++)
                {
                    var str='<div class="form-group col-sm-2"><input type="text" class="form-control center" value="Period '+(i+1)+'" disabled>' +
                            '</div>' +
                            '<div class="form-group col-sm-2">' +
                                '<select class="form-control" name="subjects" style="-webkit-appearance: menulist;">' +
                                    '<option value="marathi">Marathi</option>' +
                                    '<option value="hindi">Hindi</option>' +
                                    '<option value="english">English</option>' +
                                    '<option value="history">History</option>' +
                                '</select>' +
                             '</div>' +
                             '<div class="form-group col-sm-4">' +
                                '<input type="text" class="form-control" name="desc[]" />' +
                             '</div>'+
                            '<div class="form-group col-sm-2">' +
                            '<input type="time" class="form-control" />' +
                            '</div>'+
                            '<div class="form-group col-sm-2">' +
                                '<input type="time" class="form-control" />' +
                            '</div>';
                    $(str).fadeIn('slow').appendTo('#periods-rows');

                }

            }

            }

        });

        $('#periods-structure-save-btn').hide();

        $('#main-div-periods').hide();


        });

    $('#batch-select').attr('disabled',true);

    $('#class-select').attr('disabled',true);

    $('#division-select>option:eq(2)').prop('selected',true);

    $('#division-select').attr('disabled',true);

</script>

</div>
@stop

