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
                                <h1 class="mainTitle">Edit</h1>
                                <span class="mainDescription">Structure</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="" role="form" id="examStructureEditForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Batch <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="batchDrpdn" style="-webkit-appearance: menulist;">
                                            <option></option>
                                            @foreach($batches as $bat)
                                                @if($bat['body_id'] == $batch)
                                                    <option value="{!! $bat['id'] !!}" selected>{!! $bat['name'] !!}</option>
                                                @else
                                                    <option value="{!! $bat['id'] !!}">{!! $bat['name'] !!}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Class <span class="symbol required"></span>
                                        </label>
                                        @foreach($classes as $examclass)
                                            @if(in_array($examclass['id'],$class))
                                            <div class="checkbox clip-check check-primary">
                                                <input type="checkbox" value="{{$examclass['id']}}" id="{{$examclass['id']}}" name="classes[]" checked="checked">
                                                <label for={{$examclass['id']}} >{{$examclass['class_name']}} </label>
                                            </div>
                                            @else
                                            <div class="checkbox clip-check check-primary">
                                                <input type="checkbox" value="{{$examclass['id']}}" id="{{$examclass['id']}}" name="classes[]">
                                                <label for={{$examclass['id']}} >{{$examclass['class_name']}} </label>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Subject <span class="symbol required"></span>
                                        </label>
                                        <select class="form-control" id="subjectDrpdn" name="edit_subject" style="-webkit-appearance: menulist;">
                                            @foreach($examSubjects as $examSubject)
                                                @if($examSubject['id'] == $subjects['id'])
                                                <option value="{!! $examSubject['id'] !!}" selected>{!! $examSubject['subject_name'] !!}</option>
                                               @else
                                                <option value="{{$examSubject['subject_name']}} {{$examSubject['id']}}">{!! $examSubject['subject_name'] !!}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Sub Subject <span class="symbol required"></span>
                                        </label>
                                        @foreach($examSubSubject as $subSubject)
                                            <input type="text" id="sub_subject" value= " {!! $subSubject['sub_subject_name'] !!}" name="edit_sub_subject" class="form-control" placeholder="Sub Subject" readonly>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Start Year <span class="symbol required"></span>
                                        </label>
                                        @foreach($examStartYear as $Startyear)
                                        <input type="hidden" name="Startyear" id="Startyear" value="{!! $Startyear['start_year'] !!}">
                                        @endforeach
                                        <select class="form-control" id="startYear" name="start_Year" style="-webkit-appearance: menulist;" required="required">
                                            <option value=""></option>
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
                                        @foreach($examEndYear as $Endyear)
                                            <input type="hidden" name="Endyear" id="Endyear" value="{!! $Endyear['end_year'] !!}">
                                        @endforeach
                                        <select class="form-control" id="endYear" name="end_Year" style="-webkit-appearance: menulist;" required="required">
                                            <option value=""></option>
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
                                    <div class="col-sm-7">
                                        <fieldset style="margin-bottom: -50%">
                                            <legend>Edit Term</legend>
                                        </fieldset>
                                    </div>
                                </div>
                            </section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Number of Term<span class="symbol required"></span>
                                        </label>
                                        {{--<input type="checkbox" id="term-check" value="checked">--}}
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
                                            Number of columns: <span class="symbol required"></span>
                                        </label>
                                        {{--<input type="checkbox" id="column-check" value="checked">--}}
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
                            <div style="overflow: scroll">
                                <table border=1 id="table1" width="100%">
                                    <?php foreach($detail as $key => $value) { ?>
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td>
                                        <table border=1 width="100%" cellspacing="10px" cellpadding="10px">
                                            <tr>
                                                <td style="padding: 10px;">Exam Type</td>
                                            <?php foreach($value as $data) {  ?>
                                                <td style="padding: 10px;">{{$data['exam_type']}}</td>
                                            <?php }?>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px;">Out Of Marks</td>
                                                <?php foreach($value as $data) {  ?>
                                                <td style="padding: 10px;">{{$data['out_of_marks']}}</td>
                                                <?php }?>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>
                                    <?php } ?>

                                </table>
                            </div>
                            <button class="btn btn-primary btn-wide" type="submit" value="submit" >
                                Update <i class="fa fa-arrow-circle-right"></i>
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
            var Startyear = $('#Startyear').val();
            var Endyear = $('#Endyear').val();
            $("#startYear option[value='"+Startyear+"']").prop('selected',true);
            $("#endYear option[value='"+Endyear+"']").prop('selected',true);
            $('#extra').hide();
            $('#abc').hide();
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
                    termString += "<th><input type='text' style='width: 100%;' name='exam_types["+(j-2)+"]["+'edit_head'+"]' required></th>";
                }
            }
            termString += "</tr>";
            for (var i = 0; i < a; i++) {
                var termNumber = i + 1;
                termString += "<tr><td rowspan='2' style='width: 15%'><input type='text' placeholder='Term"+termNumber+"' name='edit_terms_id[]' required>" + "</td><td style='width: 15%'>Marks</td>";
                for (var j = 0; j < b; j++) {
                    termString += "<td><input type='number' style='width: 100%;' name='marks[]' readonly></td>";
                }
                termString += "</tr><tr><td> Out of <span class='symbol required'></td>";
                for (var j = 0; j < b; j++) {
                    termString += "<td><input type='number' style='width: 100%;' name='exam_types["+(j)+"]["+'edit_out_of_marks'+"][]' required></td>";
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
        });
    </script>
@stop