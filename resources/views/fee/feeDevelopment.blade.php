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
                                <h1 class="mainTitle">Development Fee</h1>
                            </div>
                        </div>
                    </section>
                    <br><br>
                    <section>
                        <div class="form-group" id="create-form">
                            <button class="btn btn-primary"> Create New </button>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                    <form method="post"  action="/fees/create-fee-development" role="form" id="fee_developments">
                        <div id="development" hidden>
                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Student Name<span class="symbol required"></span>
                                            </label>
                                            <input type="text" class="form-control" name="student_name" id="student-name" placeholder="Enter Student Name" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Class<span class="symbol required"></span>
                                            </label>
                                            <input type="text" class="form-control" name="class" id="class" placeholder="Enter Class" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Parent Name<span class="symbol required"></span>
                                            </label>
                                            <input type="text" class="form-control" name="parent_name" id="parent-name" placeholder="Enter Parent's Name" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Sum Of Rupees<span class="symbol required"></span>
                                            </label>
                                            <input type="text" class="form-control" name="sum_rupee" id="sum-rupee" placeholder="Enter Sum of Rupee" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Cash/Cheque/D.D.No. <span class="symbol required"></span>
                                            </label>
                                            <input type="text" class="form-control" name="dd_number" id="dd-number" placeholder="Enter Cash/Cheque/D.D.No" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Date<span class="symbol required"></span>
                                            </label>
                                            <input type="date" class="form-control" name="date" id="date" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                Bank Name<span class="symbol required"></span>
                                            </label>
                                            <input type="text" class="form-control" name="bank_name" id="bank-name" placeholder="Enter Bank name" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">
                                                On Account Of<span class="symbol required"></span>
                                            </label>
                                            <input type="text" class="form-control" name="account_holder_name" id="account-holder-name" placeholder="Account holder name" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label">&nbsp;
                                        </label>
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-wide" type="submit">
                                                Create <i class="fa fa-arrow-circle-right"></i>
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" >
                            <fieldset>
                                <div id="feetable">
                                </div>
                            </fieldset>
                        </div>
                    </div>
               </div>
                @include('rightSidebar')
            </div>
        </div>
        @include('footer')
    </div>
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
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
    <script src="/vendor/DataTables/jquery.dataTables.min.js"></script>
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/form-elements.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script src="/assets/js/table-data.js"></script>
    <script src="/assets/js/form-validation.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormValidator.init();
            TableData.init();
            event.stopPropagation();
            callAllFess()
        });
        $("#create-form").click(function(){
            $("#development").show()
        })
        function callAllFess()
        {
            var strrr=0;
            $.ajax({
                url: "/fees/feeDevelopmentTable",
                data:{str1 : strrr},
                success: function(response)
                {
                    $("#feetable").html(response);
                    var switcheryHandler = function() {

                        var elements = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

                        elements.forEach(function(html) {
                            var switchery = new Switchery(html);
                        });
                    };
                    switcheryHandler();
                    TableData.init();
                }
            });
        }
      </script>
@stop
