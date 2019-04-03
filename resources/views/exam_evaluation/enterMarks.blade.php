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
                                <span class="mainDescription">Enter Marks</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/exam-evaluation/enter-marks" role="form" id="questionPaperCreateForm">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4>Student GRN :- {{$stdGrn}}</h4>
                                <input type="hidden" name="student_id" value="{{$stdId}}">
                                <input type="hidden" name="exam_structure_id" value="{{$examDetails['exam_structure_id']}}">
                                <input type="hidden" name="term_id" value="{{$examDetails['term_id']}}">
                                <input type="hidden" name="exam_term_details_id" value="{{$examId}}">
                            </div>
                            <div class="col-sm-6">
                                <h4>Exam :- {{$examDetails['exam_type']}}</h4>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="panel panel-white" id="panel1">
                                    <div class="panel-heading">
                                        <h4 class="panel-title text-primary">Assign marks (50/100)</h4>
                                        <div class="panel-tools">
                                            <i class="fa fa-book fa-fw collapse-off" id="hide-question-paper"></i>
                                        </div>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        @foreach($questions as $question)
                                            <?php
                                            $subQuestions = \App\QuestionPaperStructure::where('parent_question_id',$question['id'])->get()->toArray();
                                            ?>
                                            <div class="row" id="">
                                                <div class="col-sm-4">
                                                    <span> Q.{{$question['question_id']}}</span>
                                                </div>
                                                @if(!empty($subQuestions))
                                                <div class="col-sm-4">
                                                    <span> marks {{$question['marks']}}</span>
                                                </div>
                                                    @else
                                                    <div class="col-sm-4">
                                                        <span>marks</span>
                                                        <input type="number" class="enter-mark" id="{{$question['id']}}" step="any" min="0" max="{{$question['marks']}}" name="marks[{{$question['id']}}]" placeholder="{{$question['marks']}}" style="width: 80%">
                                                        <input type="hidden" id="{{$question['id']}}marks" value="{{$question['marks']}}">
                                                    </div>
                                                @endif
                                                <div class="col-sm-4">
                                                    <label> Check
                                                        <input type="checkbox" class="is-checked" id="{{$question['id']}}is-checked" value="{{$question['id']}}">
                                                    </label>
                                                </div>
                                            </div>
                                            @if(!empty($subQuestions))
                                                @foreach($subQuestions as $subQuestion)
                                                    <div class="row sub-que {{$question['id']}}sub-questions" id="{{$question['id']}}sub-questions">
                                                        <div class="col-sm-1">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span>Q.{{$subQuestion['question_id']}}</span>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <span> marks</span>
                                                            <input type="number" class="enter-mark {{$question['id']}}sub-questions-marks" id="{{$subQuestion['id']}}" step="any" min="0" max="{{$subQuestion['marks']}}" name="marks[{{$question['id']}}][]" placeholder="{{$subQuestion['marks']}}" style="width: 95%">
                                                            <input type="hidden" id="{{$subQuestion['id']}}marks" value="{{$subQuestion['marks']}}">
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <label> Check
                                                                <input type="checkbox" class="is-checked {{$question['id']}}sub-questions-check" id="{{$subQuestion['id']}}is-checked" value="{{$subQuestion['id']}}">
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @else
                                            @endif
                                                @if($question != end($questions))
                                                <hr style="border-color: black">
                                                @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4" id="question-paper-pdf">
                                <div class="panel panel-white" id="panel2">
                                    <div class="panel-heading">
                                        <h4 class="panel-title text-primary">Question Paper</h4>
                                    </div>
                                    <div class="panel-body" id="hide-paper">
                                        <embed src="{{$questionPaperPdf}}" height="600px" width="100%">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4" id="answer-sheet-pdf">
                                <div class="panel panel-white" id="panel3">
                                    <div class="panel-heading">
                                        <h4 class="panel-title text-primary">Answer Sheet PDF</h4>
                                    </div>
                                    <div class="panel-body" style="display: block;">
                                        <embed src="{{$answerSheetPdf}}" height="600px" width="100%">
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row pull-right">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-wide" id="submit-button" type="submit">
                                        Submit
                                    </button>
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
    {{--<script src="/vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="/vendor/jquery-smart-wizard/jquery.smartWizard.js"></script>--}}
    <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
    <!-- start: CLIP-TWO JAVASCRIPTS -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/custom-project.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            $('#question-paper-pdf').hide();
            $('#answer-sheet-pdf').attr("class", "col-sm-8");
            $('.sub-que').hide();
            $('.enter-mark').prop("disabled",true);
         });
        </script>
    <script>
        $('#hide-question-paper').click(function(){
            if($('#answer-sheet-pdf').attr("class") == 'col-sm-4') {
                $('#answer-sheet-pdf').attr("class", "col-sm-8");
                $('#question-paper-pdf').hide();
            } else {
                $('#answer-sheet-pdf').attr("class", "col-sm-4");
                $('#question-paper-pdf').show();
            }
        });

        $('.is-checked').click(function () {
            var isCheckedQuestion = this.value;
           // $('#'+isCheckedQuestion+'').show();
            var route='/exam-evaluation/get-orQuestions/'+isCheckedQuestion;
            $.get(route,function(res){
                if (res.length > 0)
                {
                    if($('#'+isCheckedQuestion+'is-checked').prop('checked') == true){
                        $('.'+isCheckedQuestion+'sub-questions').show();
                        $('#'+isCheckedQuestion).prop("disabled",false);
                        for(var i=0; i<res.length; i++)
                        {
                            $('#' +res[i]['or_que_id']+ 'is-checked').prop("disabled", true);
                        }
                    }else {
                        $('.'+isCheckedQuestion+'sub-questions').hide();
                        $('.'+isCheckedQuestion+'sub-questions-marks').val('');
                        $('.'+isCheckedQuestion+'sub-questions-check').prop("checked", false);
                        $('.'+isCheckedQuestion+'sub-questions-check').prop("disabled", false);
                        $('#'+isCheckedQuestion).prop("disabled",true);
                        $('#'+isCheckedQuestion+'').val('');
                        for(var i=0; i<res.length; i++)
                        {
                            $('#' +res[i]['or_que_id']+ 'is-checked').prop("disabled", false);
                        }
                    }
                } else {
                    if($('#'+isCheckedQuestion+'is-checked').prop('checked') == true){
                        $('#'+isCheckedQuestion).prop("disabled",false);
                    }else {
                        $('#'+isCheckedQuestion).prop("disabled",true);
                        $('#'+isCheckedQuestion).val('');
                    }
                }
            });
        });

        $('.enter-mark').keyup(function () {
            var enteredMarks = this.value;
            var id = $(this).attr('id');
            marks = $('#'+id+'marks').val();
          /*  if(((parseInt(enteredMarks)*2) %1) != 1){
                alert('Please enter valid marks');
            }*/
           if(parseInt(enteredMarks) > parseInt(marks)){
               alert('Entered marks exceeds question marks');
           }
        });
    </script>
@stop
