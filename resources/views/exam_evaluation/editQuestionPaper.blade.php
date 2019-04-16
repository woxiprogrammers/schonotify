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
                                <h1 class="mainTitle">Exam</h1>
                                <span class="mainDescription">Edit Exam</span>
                            </div>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw">
                        <form method="post" action="/exam-evaluation/edit-paper/{{$paperData['id']}}" role="form">
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-3" id="set-select-div" >
                                        <label class="control-label">
                                            Enter Paper Set<span class="symbol required"></span>
                                        </label>
                                        <input type="text" name="paper_set" id="paper_set" value="{{$paperData['set_name']}}" placeholder="Enter set" required>
                                    </div>
                                    <div class="col-md-4" id="question-paper-name" >
                                        <label class="control-label">
                                            Enter Question Paper Name <span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="paper_name" name="paper_name" value="{{$paperData['question_paper_name']}}" placeholder="Question paper name" required>
                                        </input>
                                    </div>
                                    <div class="col-md-2" id="total-marks-div" >
                                        <label class="control-label">
                                            Enter Total Marks <span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control" id="paper_marks" name="paper_marks" value="{{$paperData['marks']}}" placeholder="marks" disabled="disabled">
                                        </input>
                                    </div>
                                </div>
                            </fieldset>
                            <?php
                                $counter = 0;
                            ?>
                            @foreach($questions as $question)
                                <?php
                                $subQuestions = \App\QuestionPaperStructure::where('parent_question_id',$question['id'])->get()->toArray();
                                $orQuestions = \App\OrQuestions::where('question_id',$question['id'])->lists('or_question_id')->toArray();
                                $counter++;
                                $count = $counter-1;
                                $counter1 = 0;
                                $orCounter = 0;
                                ?>
                                <div class="row " id="{{$question['id']}}div">
                                    <div class="col-md-1" id="question-id-div">
                                        <label class="control-label">
                                            Id<span class="symbol required"></span>
                                            </label>
                                        <input type="text" class="form-control {{$question['id']}}question_data" id="question-id" name="question_id[{{$count}}]" value="{{$question['question_id']}}" placeholder="{{$question['question_id']}}" required>
                                    </div>
                                    <div class="col-md-5" id="question-id-div">
                                        <label class="control-label">
                                            Enter Question
                                        </label>
                                        <input type="text" class="form-control {{$question['id']}}question_data" id="question-id" name="question_name[{{$count}}]" value="{{$question['question']}}" placeholder="{{$question['question']}}">
                                    </div>
                                    <div class="col-md-1" id="question-id-div">
                                        <label class="control-label">
                                            Marks<span class="symbol required"></span>
                                        </label>
                                        <input type="text" class="form-control {{$question['id']}}question_data" id="question-id" name="question_mark[{{$count}}]" value="{{$question['marks']}}" placeholder="{{$question['marks']}}" required>
                                    </div>
                                    <div class="col-md-2" id="question-id-div">
                                        <label class="control-label">
                                            Or</span>
                                        </label>
                                           <select class="form-control {{$question['id']}}question_data" id="or-question" name="or_question[{{$count}}][]" multiple>
                                            <option>Select or</option>
                                            @foreach($questions as $orQuestion)
                                                <?php
                                                   $orCounter++;
                                                   $orCount = $orCounter - 1;
                                                   ?>
                                                @if($orQuestion['id'] != $question['id'])
                                                    @if(in_array($orQuestion['id'],$orQuestions))
                                                        <option value="{{$orCount}}" selected>{{$orCount+1}}</option>
                                                    @else
                                                        <option value="{{$orCount}}">{{$orCount+1}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-1" id="question-id-div">
                                        <button type="button" class="close" aria-label="Close" value="{{$question['id']}}">
                                            <span aria-hidden="true" style="color: red">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                @if(!empty($subQuestions))
                                    @foreach($subQuestions as $subQuestion)
                                            <?php
                                                $orQuestions = \App\OrQuestions::where('question_id',$subQuestion['id'])->lists('or_question_id')->toArray();
                                                $counter1++;
                                                $count1 = $counter1 -1;
                                                $subOrCounter = 0;
                                                ?>
                                            <div class="row {{$question['id']}}div" id="{{$subQuestion['id']}}div">
                                                <div class="col-md-1" id="question-id-div">
                                                </div>
                                                <div class="col-md-1" id="question-id-div">
                                                    <label class="control-label">
                                                        Id<span class="symbol required"></span>
                                                    </label>
                                                    <input type="text" class="form-control {{$question['id']}}sub_question_data" id="{{$subQuestion['id']}}sub_question_id" name="sub_question_id[{{$count}}][]" value="{{$subQuestion['question_id']}}" placeholder="{{$subQuestion['question_id']}}" required>
                                                </div>
                                                <div class="col-md-5" id="question-id-div">
                                                    <label class="control-label">
                                                        Enter Question
                                                    </label>
                                                    <input type="text" class="form-control {{$question['id']}}sub_question_data" id="{{$subQuestion['id']}}sub_question_name" name="sub_question_name[{{$count}}][]" value="{{$subQuestion['question']}}" placeholder="{{$subQuestion['question']}}">
                                                </div>
                                                <div class="col-md-1" id="question-id-div">
                                                    <label class="control-label">
                                                        Marks<span class="symbol required"></span>
                                                    </label>
                                                    <input type="text" class="form-control {{$question['id']}}sub_question_data" id="{{$subQuestion['id']}}sub_question_mark" name="sub_question_mark[{{$count}}][]" value="{{$subQuestion['marks']}}" placeholder="{{$subQuestion['marks']}}" required>
                                                </div>
                                                <div class="col-md-2" id="question-id-div">
                                                    <label class="control-label">
                                                        Or</span>
                                                    </label>
                                                    <select class="form-control {{$question['id']}}sub_question_data" id="{{$subQuestion['id']}}sub_or_question" name="sub_or_question[{{$count}}][{{$count1}}][]" multiple>
                                                        <option>Select or</option>
                                                        @foreach($subQuestions as $orQuestion)
                                                            <?php
                                                            $subOrCounter++;
                                                            $subOrCount = $subOrCounter - 1;
                                                            ?>
                                                            @if($orQuestion['id'] != $subQuestion['id'])
                                                                @if(in_array($orQuestion['id'],$orQuestions))
                                                                <option value="{{$subOrCount}}" selected>{{$subOrCount+1}}</option>
                                                                @else
                                                                <option value="{{$subOrCount}}">{{$subOrCount+1}}</option>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-1" id="question-id-div">
                                                    <button type="button" class="close" aria-label="Close" value="{{$subQuestion['id']}}">
                                                        <span aria-hidden="true" style="color: red">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                    @endforeach
                                @endif
                            @endforeach
                            <div class="row">
                                <div class="form-group pull-right">
                                    <button class="btn btn-primary btn-wide" type="submit">
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
        });

        $('.close').click(function () {
            var qId = this.value;
            $('#'+qId+'sub_question_id').prop('disabled',true);
            $('#'+qId+'sub_question_name').prop('disabled',true);
            $('#'+qId+'sub_question_mark').prop('disabled',true);
            $('#'+qId+'sub_or_question').prop('disabled',true);
            $('#'+qId+'div').hide();
            $('.'+qId+'div').hide();
            $('.'+qId+'question_data').prop('disabled',true);
            $('.'+qId+'sub_question_data').prop('disabled',true);
        });

    </script>
@stop
