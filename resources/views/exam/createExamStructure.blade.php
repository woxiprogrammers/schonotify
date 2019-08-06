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
                                <span class="mainDescription">Structure</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="structure-create" role="form" id="examStructureForm">
                        <div class="row">
                             <div class="col-md-6">
                                  <div class="form-group">
                                       <label class="control-label">
                                              Program <span class="symbol required"></span>
                                       </label>
                                       <select class="form-control" id="batchDrpdn" style="-webkit-appearance: menulist;">
                                           <option>Select Program</option>
                                           @foreach($batches as $batch)
                                                  <option value="{!! $batch['id'] !!}">{!! $batch['name'] !!}</option>
                                            @endforeach
                                       </select>
                                  </div>
                             </div>
                             <div class="col-md-6">
                                  <div class="form-group">
                                        <label class="control-label">
                                            Department <span class="symbol required"></span>
                                        </label>
                                        <div id="classesDropdown">

                                        </div>
                                  </div>
                             </div>
                        </div>
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Subject <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="batchDrpdn" name="select_subject" style="-webkit-appearance: menulist;">
                                            <option value="">Select Subject</option>
                                            @foreach($examSubjects as $examSubject)
                                                <option value="{!! $examSubject['id'] !!}">{!! $examSubject['subject_name'] !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Sub Subject <span class="symbol required"></span>
                                    </label>
                                    <input type="text" id="sub_subject" name="sub_subject" class="form-control" placeholder="Sub Subject">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        Start Year <span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="startYear" name="startYear" style="-webkit-appearance: menulist;" required="required">
                                        <option value="" selected="">Start Year</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">
                                        End Year <span class="symbol required"></span>
                                    </label>
                                    <select class="form-control" id="endYear" name="endYear" style="-webkit-appearance: menulist;" required="required">
                                        <option value="" selected="">End Year</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    <section id="page-title">
                        <div class="row">
                            <div class="col-md-7">
                                <fieldset style="margin-bottom: -50%">
                                    <legend>Create Term</legend>
                                </fieldset>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="row">
                            <div class="col-md-6" >
                                <label class="control-label">
                                Co-Scholastic :
                                </label>
                                <input type="checkbox" id="scholastic" class="scholastic">
                            </div>
                        </div>
                    </section>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Number of Term<span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="termDrpdn" name="Term_number" style="-webkit-appearance: menulist;" required>
                                            <option value="" selected="">select number of terms</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Number of coloums: <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="columnDrpdn" name="coloumn_number" style="-webkit-appearance: menulist;" required>
                                            <option value="" selected="">select number of coloumn</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div style="overflow: scroll" hidden>
                                <table border="1" id="table1">

                                </table>
                            </div>
                            <input type="hidden" value="false" name="is_scholastic" id="is_scholastic">
                            <button class="btn btn-primary btn-wide" type="submit" value="submit" >
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
    <script src="/assets/js/exam-form-validation.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormValidator.init();
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
            var termString = '<tr>';
            var terms = parseInt(b)+2;
            for (var j = 0; j < terms; j++) {
                if(j==0 || j==1){
                    termString += "<th><input type='text' style='width: 100%;' readonly></th>";
                } else{
                    termString += "<th><input type='text' style='width: 100%;' name='exam_types["+(j-2)+"]["+'head'+"]' required></th>";
                }
            }
            termString += "</tr>";
                for (var i = 0; i < a; i++) {
                    var termNumber = i + 1;
                    termString += "<tr><td rowspan='2' style='width: 15%'><input type='text' placeholder='Term"+termNumber+"' name='terms_id[]' required>" + "</td><td style='width: 15%'>Is Exam Evaluation</td>";
                    for (var j = 0; j < b; j++) {
                        termString += "<td><input type='number' style='width: 100%;' name='marks[]' readonly><input type='checkbox' id='"+(i)+(j)+"check' onchange='setValueAttr("+(i)+","+(j)+")' name='exam_types["+(j)+"]["+'is_exam_eval'+"][]'><input type='hidden' id='"+(i)+(j)+"check_hidden' value='false' name='exam_types["+(j)+"]["+'is_exam_eval'+"][]'></td>";
                    }
                    termString += "</tr><tr><td>Marks Out of <span class='symbol required'></td>";
                    for (var j = 0; j < b; j++) {
                        termString += "<td><input type='number' style='width: 100%;' name='exam_types["+(j)+"]["+'out_of_marks'+"][]' required></td>";
                    }
                    termString +="</tr>";
                }
            $("#table1").html(termString);
            $("#table1").parent().show();
        }
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
            $('#scholastic').change(function(){
                if($('#scholastic').is(':checked')){
                    $('#is_scholastic').val('true');
                }else{
                    $('#is_scholastic').val('false');
                }
            });
        });
        
        function setValueAttr(i,j) {
            $('#'+i+j+'check_hidden').remove();
            if($('#'+i+j+'check').is(':checked')){
                $('#'+i+j+'check').val('true');
            }else{
                $('#'+i+j+'check').val('false');
            }
        }
    </script>
@stop