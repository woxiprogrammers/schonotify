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
                                    <input type="text" id="sub_subject" name="sub_subject" class="form-control" placeholder="Sub Subject">
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
                        <form method="post" action="table-create" role="form" id="termCreateForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Number of Term<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="termDrpdn" name="Term_number" style="-webkit-appearance: menulist;">
                                            <option>select number of terms</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Number of coloums: <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="columnDrpdn" name="batch" style="-webkit-appearance: menulist;">
                                            <option>select number of coloumn</option>
                                            <option >1</option>
                                            <option >2</option>
                                            <option >3</option>
                                            <option >4</option>
                                            <option >5</option>
                                            <option >6</option>
                                            <option >7</option>
                                            <option >8</option>
                                            <option >9</option>
                                            <option >10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="overflow: scroll" hidden>
                                <table border="1" id="table1">

                                </table>
                            </div>
                            <div class="row" id="extra">
                                <input type="text" placeholder="term">
                                <div class="form-control col-lg-2" id="abc">
                                    <input type="text" placeholder="coloumn">
                                </div>
                            </div>
                            <div class="row" id="append"></div>
                            <button class="btn btn-primary btn-wide" type="submit">
                                Create <i class="fa fa-arrow-circle-right"></i>
                            </button>
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
            $('#abc').hide();
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
            $('#columnDrpdn').change(function(){
                var b=  this.value;
                var a=$('#termDrpdn').val();
                generate(a,b);
            });
        });
        function generate(a,b) {
            var termString = '';
            for (var i= 0; i < a; i++) {
                var termNumber = i+1;
                termString += "<tr><td rowspan='2' style='width: 15%'>Term "+termNumber+"</td><td style='width: 15%'>Marks</td>";
                for(var j = 0; j < b; j++){
                    termString += "<td><input class='form-control' type='text' class='form-control' style='width: 95%; mar' name='marks[]'></td>";
                }
                termString += "</tr><tr> <td> Out of </td>";
                for(var j = 0; j < b; j++){
                    termString += "<td><input class='form-control' type='text' name='out_of[]'></td>";
                }
                termString += "</tr>";
            }
            $("#table1").html(termString);
            $("#table1").parent().show();
        }
    </script>
@stop