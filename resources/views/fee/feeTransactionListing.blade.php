@extends('master')
@section('content')
    <div id="app">
        @include('sidebar')
        <div class="app-content">
        @include('header')
        <!-- end: TOP NAVBAR -->
            <div class="main-content" >
                <div class="wrap-content container" id="container">
                    @include('alerts.errors')
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <h1 class="mainTitle">Fee Transaction Listing</h1>
                                <span class="mainDescription">Listing</span>
                            </div>
                        </div>
                    </section>
                    <fieldset>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    Batch <span class="symbol required"></span>
                                </label>
                                <select name="batch" class="form-control" id="batchDropdown" style="-webkit-appearance: menulist;">
                                    <option selected>Select Batch...</option>
                                    @foreach($batches as $batch)
                                        <option value='{{$batch['id']}}'>{{$batch['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="class-select-div" >
                            <div class="form-group">
                                <label class="control-label">
                                    Select Class <span class="symbol required"></span>
                                </label>
                                <select class="form-control" id="class-select" name="class_select" style="-webkit-appearance: menulist;">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="select-div" >
                            <div class="form-group">
                                <label class="control-label">
                                    Select Div <span class="symbol required"></span>
                                </label>
                                <select class="form-control" id="div-select" name="div_select" style="-webkit-appearance: menulist;">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="select-year" >
                            <div class="form-group">
                                <label class="control-label">
                                    Select Year <span class="symbol required"></span>
                                </label>
                                <select class="form-control" id="year-select" name="year_select" style="-webkit-appearance: menulist;">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="select-grn" >
                            <div class="form-group">
                                <label class="control-label">
                                    Select GRN number <span class="symbol required"></span>
                                </label>
                                <select class="form-control" id="grn-select" name="year_select" style="-webkit-appearance: menulist;">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" >
                                <fieldset>
                                    <div id="feetable">
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </fieldset>
                </div>
                @include('rightSidebar')
            </div>
        </div>
        @include('footer')
    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>4a
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/bootstrap-fileinput/jasny-bootstrap.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/ckeditor/adapters/jquery.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="/vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="/vendor/autosize/autosize.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/select2/select2.min.js"></script>
    <script src="/vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <!-- start: JavaScript Event Handlers for this page -->
    <script src="/assets/js/form-validation-edit.js"></script>
    <script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/form-elements.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script src="/assets/js/table-data.js"></script>
    <script src="/assets/js/form-validation.js"></script>
    <script>
        jQuery(document).ready(function(){
            Main.init();
            FormValidator.init();
            FormElements.init();
            TableData.init();
            event.stopPropagation();
            callAllFess();
        })
    </script>
    <script>
        function callAllFess()
        {
            var strrr=0;
            $.ajax({
                url: "/fees/feeTransactionListingTable",
                data:{str1 : strrr},
                success: function(response)
                {
                    $("#feetable").html(response);
                }
            });
        }
    </script>
    <script>
        $( "#batchDropdown" ).change(function () {
            var id=this.value;
            var route='/exam/get-all-classes/'+id;
            $('#loadmoreajaxloaderClass').show();
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#class-select').html("no record found");
                    $('#loadmoreajaxloaderClass').hide();
                } else {
                    var str='<option value="">Please select class</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['class_id']+'">'+res[i]['class_name']+'</option>';
                    }
                    $('#class-select').html(str);
                    $('#loadmoreajaxloaderClass').hide();
                }
             });
            })
        $('#class-select').change(function(){
            var id=this.value;
            var route='/exam/get-all-div/'+id;
            $('#loadmoreajaxloaderClass').show();
            $.get(route,function(res){
                if (res.length == 0)
                {
                    $('#div-select').html("no record found");
                    $('#loadmoreajaxloaderClass').hide();
                } else {
                    var str='<option value="">Please select division</option>';
                    for(var i=0; i<res.length; i++)
                    {
                        str+='<option value="'+res[i]['id']+'">'+res[i]['division_name']+'</option>';
                    }
                    $('#div-select').html(str);
                    $('#loadmoreajaxloaderClass').hide();
                }
            });
        });
    </script>
@stop
