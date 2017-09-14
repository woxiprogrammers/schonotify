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
                                <h1 class="mainTitle">Create</h1>
                                <span class="mainDescription">Class</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="class-create" role="form" id="classCreateForm">
                        <div class="row">
                             <div class="col-md-6">
                                  <div class="form-group">
                                       <label class="control-label">
                                              Batch <span class="symbol required"></span>
                                       </label>
                                       <select class="form-control" id="batchDrpdn" name="batch" style="-webkit-appearance: menulist;">
                                           <option value="">Select Batch</option>
                                           @foreach($batches as $batch)
                                                  <option value="{!! $batch['id'] !!}">{!! $batch['name'] !!}</option>
                                            @endforeach
                                       </select>
                                  </div>
                             </div>
                             <div class="col-md-6">
                                  <div class="form-group">
                                        <label class="control-label">
                                            Class <span class="symbol required"></span>
                                        </label>
                                        <div id="classesDropdown"></div>
                                  </div>
                             </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Subject <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="batchDrpdn" name="batch" style="-webkit-appearance: menulist;">
                                            <option value="">Select Subject</option>
                                            @foreach($examSubjects as $examSubject)
                                                <option value="{!! $examSubject['id'] !!}">{!! $examSubject['subject_name'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    Sub Subject
                                    <input type="text" id="sub_subject" class="form-control" placeholder="Sub Subject">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <section id="page-title" class="padding-top-15 padding-bottom-15">
                        <div class="row">
                            <div class="col-sm-7">
                                <fieldset style="margin-bottom: -50%">
                                    <legend>Create Term</legend>
                                </fieldset>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw" style="margin-bottom:400px ">

                        <form method="post" action="class-create" role="form" id="termCreateForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Term Name <span class="symbol required"></span>
                                        </label>
                                        <input type="text" id="term_name" class="form-control" placeholder="Name of Term">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Number of Term<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="termDrpdn" name="Term_number" style="-webkit-appearance: menulist;">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Number of coloums: <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="columnDrpdn" name="batch" style="-webkit-appearance: menulist;">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="extra">
                                  <table border="1" style="width: 100%">
                                      <tr>
                                          <th></th>
                                          <th></th>
                                          <th colspan="8"></th>
                                      </tr>
                                      <tr>
                                      <td rowspan="2">
                                          term1
                                      </td>
                                          <td>marks</td>
                                          <td><input type="text"></td>
                                      </tr>
                                      <tr>
                                          <td>out of</td>
                                      </tr>
                                      <tr>
                                          <td rowspan="2">
                                              term2
                                          </td>
                                          <td>marks</td>
                                      </tr>
                                      <tr>
                                          <td>out of</td>
                                      </tr>
                                  </table>
                                </div>
                            </div>
                            <div class="row">
                                <div id="append">
                                </div>
                            </div>
                        </form>
                    </div>
                @include('rightSidebar')
            </div>
        </div>
    </div>
    @include('footer')
    </div>
    <!-- start: MAIN JAVASCRIPTS -->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="/vendor/modernizr/modernizr.js"></script>
    <script src="/vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="/vendor/switchery/switchery.min.js"></script>
    <script src="/vendor/selectFx/classie.js"></script>
    <script src="/vendor/selectFx/selectFx.js"></script>
    <script src="/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/ckeditor/adapters/jquery.js"></script>
    <!-- end: MAIN JAVASCRIPTS -->
    <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/form-wizard.js"></script>
    <script src="/assets/js/form-validation.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            $('#extra').hide();
        });
    </script>
    <script>
        $('#batchDrpdn').change(function(){
            var str = this.value;
            $.ajax({
                method: "get",
                url: "/exam/get-classes/"+str,
                success: function(response)
                {
                    $("#classesDropdown").html(response);
                }
            });
        });
        $('#termDrpdn').change(function(){
            var a=  this.value;
            generate(a);
        });
        function generate(a) {

            for (i= 0; i < a; i++) {
                ($('#extra').clone()).appendTo('#append');
                $('#extra').show();
            }
        }

    </script>
@stop