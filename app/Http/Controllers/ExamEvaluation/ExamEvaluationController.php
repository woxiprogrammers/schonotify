<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 27/2/19
 * Time: 3:38 PM
 */

namespace App\Http\Controllers\ExamEvaluation;

use App\AssignStudentsToTeacher;
use App\Batch;
use App\Division;
use App\ExamClassStructureRelation;
use App\ExamQuestionPaper;
use App\ExamSubjectStructure;
use App\ExamSubSubjectStructure;
use App\ExamTermDetails;
use App\ExamTerms;
use App\ExamYear;
use App\Http\Controllers\Controller;
use App\OrQuestions;
use App\PaperCheckerMaster;
use App\QuestionPaperStructure;
use App\StudentAnswerSheet;
use App\StudentExamDetails;
use App\StudentExamMarks;
use App\StudentExtraInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Subject;
use App\SubjectClass;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class ExamEvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function createQuestionPaperView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $exams = ExamTermDetails::all();
            return view('exam_evaluation.createQuestionPaper')->with(compact('batches','user','exams'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function createQuestionPaper(Request $request){
        try{
            $user = Auth::user();
            $data = $request->all();
            $marks = ExamTermDetails::where('id',$data['exam_select'])->value('out_of_marks');
            $subQuestions = array();
            $paperData['question_paper_name'] = $data['paper_name'];
            $paperData['no_of_question'] = $data['paper_questions'];
            $paperData['marks'] = $marks;
            $paperData['set_name'] = $data['paper_set'];
            $paperData['exam_id'] = $data['exam_select'];
            $paperData['class_id'] = $data['class_select'];
            $createQuestionPaper = ExamQuestionPaper::create($paperData);
            if(array_key_exists('question_paper_pdf',$data)){
                $name = $request->question_paper_pdf->getClientOriginalName();
                $ext = explode('.',$name);
                if($ext[1] == 'pdf') {
                    $paperPresent = ExamQuestionPaper::where('id', $createQuestionPaper->id)->first();
                    $folderEncName = sha1($createQuestionPaper->id);
                    $folderPath = public_path() . env('QUESTION_PAPER_UPLOAD') . DIRECTORY_SEPARATOR . $folderEncName;
                    if ($paperPresent['paper_pdf'] != null) {
                        unlink($folderPath . DIRECTORY_SEPARATOR . $paperPresent['paper_pdf']);
                    }
                    if (!file_exists($folderPath)) {
                        File::makeDirectory($folderPath, 0777, true, true);
                    }
                    $filename = mt_rand(1, 10000000000) . sha1(time()) . ".pdf";
                    $request->question_paper_pdf->move($folderPath, $filename);
                    $paperData['paper_pdf'] = $filename;
                    ExamQuestionPaper::where('id', $createQuestionPaper->id)->update($paperData);
                }
            }
            if($request->has('question-id')){
                $questionData['question_paper_id'] = $createQuestionPaper->id;
                foreach ($data['question-id'] as $key=>$value) {
                    $questionData['question_id'] = $value;
                    $questionData['question'] = $data['question-name'][$key];
                    $questionData['marks'] = $data['question-marks'][$key];
                    $createQuestion = QuestionPaperStructure::create($questionData);
                    $questions[$key] = $createQuestion->id;
                }
                if($request->has('or-question')){
                    $orQuestions = $data['or-question'];
                    foreach ($questions as $key=>$value){
                        $orQuestionData['question_id'] =  $questions[$key];
                        if(array_key_exists($key,$orQuestions)){
                            foreach ($orQuestions[$key] as $key1=>$value1){
                                if(array_key_exists($value1,$questions)) {
                                    $orQuestionData['or_question_id'] = $questions[$value1];
                                    OrQuestions::create($orQuestionData);
                                }
                            }
                        }
                    }
                }

                if ($request->has('sub-question-id')){
                    $subQuestionData['question_paper_id'] = $createQuestionPaper->id;
                    foreach ($questions as $key=>$value){
                        $subQuestionData['parent_question_id'] = $value;
                        if(array_key_exists($key,$data['sub-question-id'])){
                            foreach ($data['sub-question-id'][$key] as $key1=>$value1){
                                $subQuestionData['question_id'] = $value1;
                                $subQuestionData['question'] = $data['sub-question-name'][$key][$key1];
                                $subQuestionData['marks'] = $data['sub-question-marks'][$key][$key1];
                                $createSubQuestions = QuestionPaperStructure::create($subQuestionData);
                                $subQuestions[$key][$key1] = $createSubQuestions->id;
                            }
                        }
                    }

                    if($subQuestions != null){
                        foreach ($subQuestions as $key=>$value){
                            if($request->has('sub-or-question')) {
                                if (array_key_exists($key, $data['sub-or-question'])) {
                                    foreach ($data['sub-or-question'][$key] as $key1 => $value1) {
                                        $orSubQuestion['question_id'] = $subQuestions[$key][$key1];
                                        foreach ($value1 as $key2 => $value2) {
                                            if(array_key_exists($value2,$subQuestions[$key])) {
                                                $orSubQuestion['or_question_id'] = $subQuestions[$key][$value2];
                                                OrQuestions::create($orSubQuestion);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            Session::flash('message-success','Question paper structure created successfully');
            return redirect('exam-evaluation/paper-listing');
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function editPaperView(Request $request,$id){
        try{
            $user = Auth::user();
            $paperData = ExamQuestionPaper::where('id',$id)->first();
            $questions = QuestionPaperStructure::where('question_paper_id',$id)->whereNull('parent_question_id')->get()->toArray();
            return view('exam_evaluation.editQuestionPaper')->with(compact('user','paperData','questions'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function editPaper(Request $request,$id){
        try{
            $user = Auth::user();
            $data = $request->all();
            $previousQuestions = QuestionPaperStructure::where('question_paper_id',$id)->lists('id');
            if($request->has('question_id')){
                $questionData['question_paper_id'] = $id;
                foreach ($data['question_id'] as $key=>$value) {
                    $questionData['question_id'] = $value;
                    $questionData['question'] = $data['question_name'][$key];
                    $questionData['marks'] = $data['question_mark'][$key];
                    $createQuestion = QuestionPaperStructure::create($questionData);
                    $questions[$key] = $createQuestion->id;
                }
                if($request->has('or_question')){
                    $orQuestions = $data['or_question'];
                    foreach ($questions as $key=>$value){
                        $orQuestionData['question_id'] =  $questions[$key];
                        if(array_key_exists($key,$orQuestions)){
                            foreach ($orQuestions[$key] as $key1=>$value1){
                                if(array_key_exists($value1,$questions)) {
                                    $orQuestionData['or_question_id'] = $questions[$value1];
                                }
                                OrQuestions::create($orQuestionData);
                            }
                        }
                    }
                }

                if ($request->has('sub_question_id')){
                    $subQuestionData['question_paper_id'] = $id;
                    foreach ($questions as $key=>$value){
                        $subQuestionData['parent_question_id'] = $value;
                        if(array_key_exists($key,$data['sub_question_id'])){
                            foreach ($data['sub_question_id'][$key] as $key1=>$value1){
                                $subQuestionData['question_id'] = $value1;
                                $subQuestionData['question'] = $data['sub_question_name'][$key][$key1];
                                $subQuestionData['marks'] = $data['sub_question_mark'][$key][$key1];
                                $createSubQuestions = QuestionPaperStructure::create($subQuestionData);
                                $subQuestions[$key][$key1] = $createSubQuestions->id;
                            }
                        }
                    }
                    if($subQuestions != null){
                        foreach ($subQuestions as $key=>$value){
                            if($request->has('sub_or_question')) {
                                if (array_key_exists($key, $data['sub_or_question'])) {
                                    foreach ($data['sub_or_question'][$key] as $key1 => $value1) {
                                        if(array_key_exists($key1,$subQuestions[$key])){
                                            $orSubQuestion['question_id'] = $subQuestions[$key][$key1];
                                            foreach ($value1 as $key2 => $value2) {
                                                if(array_key_exists($value2,$subQuestions[$key])) {
                                                    $orSubQuestion['or_question_id'] = $subQuestions[$key][$value2];
                                                    OrQuestions::create($orSubQuestion);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($request->has('paper_set')) {
                $paperData['set_name'] = $request->paper_set;
            }
            if($request->has('paper_name')) {
                $paperData['question_paper_name'] = $request->paper_name;
            }
            if($request->has('paper_marks')) {
                $paperData['marks'] = $request->paper_marks;
            }
            ExamQuestionPaper::where('id',$id)->update($paperData);
            QuestionPaperStructure::whereIn('id',$previousQuestions)->delete();
            return redirect('exam-evaluation/paper-listing');
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function questionPaperListingView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.questionPaperListing')->with(compact('batches','user'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function uploadQuestionPaper(Request $request){
        try{
            $questionPapers = $request->question_paper;
            $size = 0;
            foreach ($questionPapers as $paperId => $paperPdf){
                if($paperPdf != null) {
                    if ($paperPdf->getSize() != false){
                        if ($paperPdf->getSize() / 1024 > 2048) {
                            Session::flash('message-error', 'Uploaded file exceeds max size upload limit');
                            return Redirect::back();
                        } else {
                            $size += $paperPdf->getSize() / 1024;
                            if ($size > 30720) {
                                Session::flash('message-error', 'Upload files size limit exceed');
                                return Redirect::back();
                            }
                        }
                    }  else {
                        Session::flash('message-error', 'Upload file size limit exceed');
                        return Redirect::back();
                    }
                }
            }
            foreach ($questionPapers as $paperId => $paperPdf){
                if($paperPdf != null) {
                    $name = $paperPdf->getClientOriginalName();
                    $ext = explode('.',$name);
                    if($ext[1] == 'pdf') {
                        $paperPresent = ExamQuestionPaper::where('id', $paperId)->first();
                        $folderEncName = sha1($paperId);
                        $folderPath = public_path() . env('QUESTION_PAPER_UPLOAD') . DIRECTORY_SEPARATOR . $folderEncName;
                        if ($paperPresent['paper_pdf'] != null) {
                            unlink($folderPath . DIRECTORY_SEPARATOR . $paperPresent['paper_pdf']);
                        }
                        if (!file_exists($folderPath)) {
                            File::makeDirectory($folderPath, 0777, true, true);
                        }
                        $filename = mt_rand(1, 10000000000) . sha1(time()) . ".pdf";
                        $paperPdf->move($folderPath, $filename);
                        $paperData['paper_pdf'] = $filename;
                        ExamQuestionPaper::where('id', $paperId)->update($paperData);
                    } else {
                        Session::flash('message-error','Please select only pdf files');
                        return Redirect::back();
                    }
                }
            }
            Session::flash('message-success','Question paper pdf uploaded successfully');
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function uploadAnswerSheetView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.uploadAnswerSheet')->with(compact('batches','user'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function uploadAnswerSheet(Request $request){
        try{
            $answerSheetData['exam_id'] = $request->exam_select;
            $answerSheets = $request->answer_sheet;
            $size = 0;
            if($answerSheets != null) {
                foreach ($answerSheets as $stdId => $answerSheetPdf) {
                    if ($answerSheetPdf != null) {
                        if ($answerSheetPdf->getSize() != false) {
                            if ($answerSheetPdf->getSize() / 1024 > 2048) {
                                Session::flash('message-error', 'Uploaded file exceeds max size upload limit');
                                return Redirect::back();
                            } else {
                                $size += $answerSheetPdf->getSize() / 1024;
                                if ($size > 30720) {
                                    Session::flash('message-error', 'Upload files size limit exceed');
                                    return Redirect::back();
                                }
                            }
                        } else {
                            Session::flash('message-error', 'Upload file size limit exceed');
                            return Redirect::back();
                        }
                    }
                }
            }
            if($answerSheets != null) {
                foreach ($answerSheets as $stdId => $answerSheetPdf) {
                    if ($answerSheetPdf != null) {
                        $name = $answerSheetPdf->getClientOriginalName();
                        $ext = explode('.', $name);
                        if ($ext[1] == 'pdf' || $ext[1] == 'PDF') {
                            $answerSheetPresent = StudentAnswerSheet::where('exam_id', $request->exam_select)->where('student_id', $stdId)->first();
                            $folderEncName = sha1($request->exam_select);
                            $folderPath = public_path() . env('ANSWER_SHEET_UPLOAD') . DIRECTORY_SEPARATOR . $folderEncName;
                            if ($answerSheetPresent['pdf_name'] != null) {
                                unlink($folderPath . DIRECTORY_SEPARATOR . $answerSheetPresent['pdf_name']);
                            }
                            if (!file_exists($folderPath)) {
                                File::makeDirectory($folderPath, 0777, true, true);
                            }
                            $filename = mt_rand(1, 10000000000) . sha1(time()) . ".pdf";
                            $answerSheetPdf->move($folderPath, $filename);
                            $answerSheetData['pdf_name'] = $filename;
                            if ($answerSheetPresent['pdf_name'] != null) {
                                $answerSheetData['question_paper_id'] = $request->set_select;
                                StudentAnswerSheet::where('id', $answerSheetPresent['id'])->update($answerSheetData);
                            } else {
                                $answerSheetData['question_paper_id'] = $request->set_select;
                                $answerSheetData['student_id'] = $stdId;
                                $answerSheetData['created_at'] = Carbon::now();
                                $answerSheetData['updated_at'] = Carbon::now();
                                StudentAnswerSheet::insert($answerSheetData);
                            }
                        } else {
                            Session::flash('message-error', 'Please select only pdf files');
                            return Redirect::back();
                        }
                    }
                }
            }
            Session::flash('message-success','Student answer sheets uploaded successfully');
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignStudentView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $paperCheckerRoles = PaperCheckerMaster::all();
            return view('exam_evaluation.assignStudentsToTeacher')->with(compact('batches','user','paperCheckerRoles'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignStudents(Request $request){
        try{
            $user = Auth::user();
            $assignStudentData['exam_id'] = $request->exam_select;
            $assignStudentData['teacher_id'] = $request->teacher_select;
            $assignStudentData['role_id'] = $request->role_select;
            if($request->has('assign_student')){
                $students = $request->assign_student;
                foreach ($students as $student){
                    $assignedStudents = AssignStudentsToTeacher::where('exam_id',$request->exam_select)->where('teacher_id',$request->teacher_select)->where('student_id',$student)->where('role_id',$request->role_select)->first();
                    if($assignedStudents == null) {
                        $assignStudentData['student_id'] = $student;
                        AssignStudentsToTeacher::create($assignStudentData);
                    }
                }
            }
            Session::flash('message-success','Students assigned to teacher successfully');
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function studentListingView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $paperCheckerRoles = PaperCheckerMaster::all();
            return view('exam_evaluation.studentListing')->with(compact('batches','user','paperCheckerRoles'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function getEnterMarksView(Request $request,$examId,$stdId){
        try{
            $user = Auth::user();
            $answerSheetPdf = null;
            $questionPaperPdf = null;
            $questions = array();
            $examDetails = ExamTermDetails::where('id',$examId)->first();
            $stdGrn = StudentExtraInfo::where('student_id',$stdId)->value('grn');
            $answerSheetData = StudentAnswerSheet::where('exam_id',$examId)->where('student_id',$stdId)->first();
            if($answerSheetData['pdf_name'] != null) {
                $answerSheetPdf = env('ANSWER_SHEET_UPLOAD') . DIRECTORY_SEPARATOR . sha1($examId) . DIRECTORY_SEPARATOR . $answerSheetData['pdf_name'];
            }
            if($answerSheetData['question_paper_id'] != null) {
                $questionPaper = ExamQuestionPaper::where('id', $answerSheetData['question_paper_id'])->first();
                if ($questionPaper['paper_pdf'] != null) {
                    $questionPaperPdf = env('QUESTION_PAPER_UPLOAD') . DIRECTORY_SEPARATOR . sha1($questionPaper['id']) . DIRECTORY_SEPARATOR . $questionPaper['paper_pdf'];
                }
            }
            if($answerSheetData['question_paper_id'] != null) {

                $questions = QuestionPaperStructure::where('question_paper_id',$answerSheetData['question_paper_id'])->whereNull('parent_question_id')->get()->toArray();
            }
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.enterMarks')->with(compact('batches','answerSheetPdf','user','stdGrn','questions','examDetails','stdId','examId','questionPaperPdf'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function EnterMarks(Request $request){
        try{
            $user = Auth::user();
            $data = $request->all();
            $markObtain = 0;
            if($request->has('marks')) {
                foreach ($data['marks'] as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $key1 => $value1) {
                            if($value1 != null){
                                $markObtain += $value1;
                            }
                        }
                    } else {
                        if($value != null){
                            $markObtain += $value;
                        }
                    }
                }
                $stdTermStructureIds = StudentExamDetails::where('student_id',$data['student_id'])->where('term_id',$data['term_id'])->where('exam_structure_id',$data['exam_structure_id'])->lists('id');
                $isMarksFilled = StudentExamMarks::whereIn('student_exam_details_id',$stdTermStructureIds)->where('term_id',$data['term_id'])->where('exam_structure_id',$data['exam_structure_id'])->where('exam_term_details_id',$data['exam_term_details_id'])->value('id');
                if($isMarksFilled == null) {
                    $examDetailsData['student_id'] = $data['student_id'];
                    $examDetailsData['term_id'] = $data['term_id'];
                    $examDetailsData['exam_structure_id'] = $data['exam_structure_id'];
                    $examDetails = StudentExamDetails::create($examDetailsData);
                    $examMarksData['student_exam_details_id'] = $examDetails['id'];
                    $examMarksData['term_id'] = $data['term_id'];
                    $examMarksData['exam_structure_id'] = $data['exam_structure_id'];
                    $examMarksData['marks_obtained'] = $markObtain;
                    $examMarksData['exam_term_details_id'] = $data['exam_term_details_id'];
                    StudentExamMarks::create($examMarksData);
                    Session::flash('message-success','Student marks stored successfully');
                } else {
                    $examMarksData['marks_obtained'] = $markObtain;
                    StudentExamMarks::where('id',$isMarksFilled)->update($examMarksData);
                    Session::flash('message-success','Student marks updated successfully');
                }
            }
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function getOrQuestions(Request $request, $queId){
        $data=array();
        $orQuestion = OrQuestions::where('question_id',$queId)->lists('or_question_id');
        $orQuestions = OrQuestions::where('question_id',$queId)->orWhereIn('question_id',$orQuestion)->where('or_question_id','!=',$queId)->get()->toArray();
        $i=0;
        foreach ($orQuestions as $row) {
            $data[$i]['or_que_id'] = $row['or_question_id'] ;
            $i++;
        }
        return $data;
    }

    public function getClassSubject($id){
        $data=array();
        $subjectIds = SubjectClass::where('class_id',$id)->lists('subject_id');
        $subjects = Subject::whereIn('id',$subjectIds)->get()->toArray();
        $i=0;
        foreach ($subjects as $row) {
            $data[$i]['subject_id'] = $row['id'] ;
            $data[$i]['subject_name']= $row['subject_name'] ;
            $i++;
        }
        return $data;
    }

    public function getExamSubjects($year){
        $data=array();
        $academicYear = explode('-',$year);
        $structureId = ExamYear::where('start_year',$academicYear[0])->where('end_year',$academicYear[1])->lists('exam_structure_id');
        $subjectIds = ExamSubSubjectStructure::whereIn('id',$structureId)->distinct('subject_id')->lists('subject_id');
        $subjects = ExamSubjectStructure::whereIn('id',$subjectIds)->get()->toArray();
        $i=0;
        foreach ($subjects as $row) {
            $data['subject'][$i]['subject_id'] = $row['id'] ;
            $data['subject'][$i]['subject_name']= $row['subject_name'] ;
            $i++;
        }
        return $data;
    }

    public function getExamTerms($year,$subId){
        $data=array();
        $academicYear = explode('-',$year);
        $structureId = ExamYear::where('start_year',$academicYear[0])->where('end_year',$academicYear[1])->lists('exam_structure_id');
        $structureIds = ExamSubSubjectStructure::whereIn('id',$structureId)->where('subject_id',$subId)->distinct('subject_id')->lists('id');
        $terms = ExamTerms::whereIn('exam_structure_id',$structureIds)->get()->toArray();
        $j=0;
        foreach ($terms as $row) {
            $data['term'][$j]['term_id'] = $row['id'] ;
            $data['term'][$j]['term_name']= $row['term_name'] ;
            $j++;
        }
        return $data;
    }

    public function getExams($termId){
        $data=array();
        $exams = ExamTermDetails::where('term_id',$termId)->where('is_exam_evaluation',true)->get()->toArray();
        $i=0;
        foreach ($exams as $row) {
            $data[$i]['exam_id'] = $row['id'] ;
            $data[$i]['exam_name']= $row['exam_type'] ;
            $i++;
        }
        return $data;
    }

    public function getPaperSets($examId){
        $data=array();
        $paperSets = ExamQuestionPaper::where('exam_id',$examId)->get()->toArray();
        $i=0;
        foreach ($paperSets as $row) {
            $data[$i]['set_id'] = $row['id'] ;
            $data[$i]['set_name']= $row['set_name'] ;
            $i++;
        }
        return $data;
    }

    public function getExamMarks($examId){
        $examsMarks = ExamTermDetails::where('id',$examId)->value('out_of_marks');
        return $examsMarks;
    }

    public function getAcademicYear($classId){
        $data=array();
        $structureId = ExamClassStructureRelation::where('class_id',$classId)->distinct('exam_subject_id')->lists('exam_subject_id');
        $years = ExamYear::whereIn('id',$structureId)->get()->toArray();
        if(!empty($years)){
            foreach ($years as $row) {
                $arr[] = $row['start_year'] .'-'. $row['end_year'];
            }
            $year = array_unique($arr);
            $i=0;
            foreach ($year as $row){
                $data[$i]['year'] = $row;
                $i++;
            }
        }
        return $data;
    }

    public function getTeachers($id){
        $user = Auth::User();
        $data=array();
        //$teacherIds = Division::where('class_id',$id)->whereNotNull('class_teacher_id')->where('class_teacher_id','!=',0)->lists('class_teacher_id');
        $teachers = User::where('role_id',2)->where('body_id',$user->body_id)->where('is_active',true)->get()->toArray();
        $i=0;
        foreach ($teachers as $row) {
            $data[$i]['teacher_id'] = $row['id'] ;
            $data[$i]['name']= $row['first_name'] .' '.$row['last_name'];
            $i++;
        }
        return $data;
    }


    public function filterStudent(Request $request)
    {
        $role_id = 3;
        $user = Auth::user();
                $result = User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                    ->where('division_id', $request->division)
                    ->where('users.body_id', '=', $user->body_id)
                    ->where('users.role_id', '!=', 1)
                    ->where('users.role_id', '=', $role_id)
                    ->where('users.id', '!=', $user->id)
                    ->where('users.is_displayed', '=', '1')
                    ->select('users.id', 'users.roll_number as roll_number','user_roles.slug as user_role',  'users.first_name as firstname', 'users.last_name as lastname', 'students_extra_info.grn as rollno', 'users.is_lc_generated', 'users.is_displayed')
                    ->get();

        $str = "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
        $str .= "<thead><tr>";
        if ($role_id == 3) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Assign: activate to sort column ascending' style='width: 29px;'>Assign  "."<input type='checkbox' id='check_all' onclick='checkAll()'/>"."</th>";
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='PRN No.: activate to sort column ascending' style='width: 29px;'>PRN No.</th>";
        }
        /*$str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Name: activate to sort column ascending' style='width: 29px;'>Name</th><th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Roll No: activate to sort column ascending' style='width: 29px;'>Roll No</th>";*/
        if (sizeof($result->toArray()) != 0) {
            $str .= "</tr></thead><tbody>";
            foreach ($result as $row) {
                if ($row->user_role == 'student') {
                    if ($row->is_lc_generated == 0) {
                        $studentAssigned = AssignStudentsToTeacher::where('exam_id',$request->exam)->where('teacher_id',$request->teacher)->where('role_id',$request->role)->where('student_id',$row->id)->first();
                        if($studentAssigned == null) {
                            $str .= "<tr><td>" . "<input type='checkbox' id='assign_student' name = 'assign_student[]' class='assign-student' value='" . $row->id . "'>" . "</td>";
                        } else {
                            $str .= "<tr><td>" . "<input type='checkbox' id='assign_student' name = 'assign_student[]' class='assign-student' value='" . $row->id . "' checked>" . "</td>";
                        }
                    } else {
                        $str .= "<tr><td></td>";
                    }
                    $str .= "<td>" . $row->rollno . "</td>";
                } else {
                    $str .= "<tr>";
                }
                /*$str .= "<td>" . $row->firstname . " " . $row->lastname . "</td>";
                $str .= "<td>" . $row->roll_number . "</td>";*/
            }
        } else {
            $str1 = "<h5 class='center'>No records found !</h5>";
        }
        $str .= "</tr></tbody>";
        $str .= "</table>";
        if (sizeof($result->toArray()) != 0) {
            return $str;
        } else {
            return $str1;
        }
    }

    public function studentUploadAnswerSheet(Request $request)
    {
        $role_id = 3;
        $user = Auth::user();
        $result = User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
            ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
            ->where('division_id', $request->division)
            ->where('users.body_id', '=', $user->body_id)
            ->where('users.role_id', '!=', 1)
            ->where('users.role_id', '=', $role_id)
            ->where('users.id', '!=', $user->id)
            ->where('users.is_displayed', '=', '1')
            ->select('users.id', 'users.roll_number as roll_number','user_roles.slug as user_role',  'users.first_name as firstname', 'users.last_name as lastname', 'students_extra_info.grn as rollno', 'users.is_lc_generated', 'users.is_displayed')
            ->get();

        $str = "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
        $str .= "<thead><tr>";
        if ($role_id == 3) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Uploaded: activate to sort column ascending' style='width: 29px;'>Uploaded  "."<input type='checkbox' checked>"."</th>";
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='PRN No.: activate to sort column ascending' style='width: 29px;'>PRN No.</th>";
        }
        /*$str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Name: activate to sort column ascending' style='width: 29px;'>Name</th><th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Roll No: activate to sort column ascending' style='width: 29px;'>Roll No</th>";*/
        if (sizeof($result->toArray()) != 0) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Action: activate to sort column ascending' style='width: 29px;'>Action</th>";
            $str .= "</tr></thead><tbody>";
            foreach ($result as $row) {
                if ($row->user_role == 'student') {
                    if ($row->is_lc_generated == 0) {
                        $isAnswerSheetUploaded = StudentAnswerSheet::where('exam_id',$request->exam)/*->where('subject_id',$request->subject)*/->where('student_id',$row->id)->value('pdf_name');
                        if($isAnswerSheetUploaded != null) {
                            $str .= "<tr><td>" . "<input type='checkbox' id='answersheet_student' name = 'answersheet_student[$row->id]' class='assign-student' value='" . $row->id . "' checked>" . "</td>";
                        } else {
                            $str .= "<tr><td>" . "<input type='checkbox' id='answersheet_student' name = 'answersheet_student[$row->id]' class='assign-student' value='" . $row->id . "'>" . "</td>";
                        }
                    } else {
                        $str .= "<tr><td></td>";
                        $str .= "<td></td>";
                    }
                    $str .= "<td>" . $row->rollno . "</td>";
                } else {
                    $str .= "<tr>";
                }
                /*$str .= "<td>" . $row->firstname . " " . $row->lastname . "</td>";
                $str .= "<td>" . $row->roll_number . "</td>";*/
                $str .= "<td>";
                $str .= "<input type='file' id='answer-sheet' accept='application/pdf' class='answer-sheet' name='answer_sheet[$row->id]'>";
                $str .= "</td>";
            }
        } else {
            $str1 = "<h5 class='center'>No records found !</h5>";
        }
        $str .= "</tr></tbody>";
        $str .= "</table>";
        if (sizeof($result->toArray()) != 0) {
            return $str;
        } else {
            return $str1;
        }
    }

    public function studentListing(Request $request)
    {
        $role_id = 3;
        $user = Auth::user();
       // $studentIds = AssignStudentsToTeacher::where('exam_id',$request->exam)->where('subject_id',$request->subject)->where('teacher_id',3745)->where('role_id',$request->role)->lists('student_id');
        $result = User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
            ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
            ->where('division_id', $request->division)
            ->where('users.body_id', '=', $user->body_id)
            ->where('users.role_id', '!=', 1)
            ->where('users.role_id', '=', $role_id)
            ->where('users.id', '!=', $user->id)
            //->whereIn('users.id',$studentIds)
            ->where('users.is_displayed', '=', '1')
            ->select('users.id', 'users.roll_number as roll_number','user_roles.slug as user_role',  'users.first_name as firstname', 'users.last_name as lastname', 'students_extra_info.grn as rollno', 'users.is_lc_generated', 'users.is_displayed')
            ->get();
        $str = "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
        $str .= "<thead><tr>";
        if ($role_id == 3) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Checked: activate to sort column ascending' style='width: 29px;'>Checked  "."</th>";
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='PRN No.: activate to sort column ascending' style='width: 29px;'>PRN No.</th>";
        }
        /*$str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Roll No: activate to sort column ascending' style='width: 29px;'>Roll No</th>";*/
        if (sizeof($result->toArray()) != 0) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Action: activate to sort column ascending' style='width: 29px;'>Action</th>";
            $str .= "</tr></thead><tbody>";
            foreach ($result as $row) {
                if ($row->user_role == 'student') {
                    if ($row->is_lc_generated == 0) {
                        $structureId = ExamTermDetails::where('id',$request->exam)->value('exam_structure_id');
                        $stdExamDeatailId = StudentExamDetails::where('student_id',$row->id)->where('term_id',$request->term)->where('exam_structure_id',$structureId)->value('id');
                        $isMarksFilled = StudentExamMarks::where('student_exam_details_id',$stdExamDeatailId)->where('term_id',$request->term)->where('exam_structure_id',$structureId)->where('exam_term_details_id',$request->exam)->value('id');
                        if($isMarksFilled != null) {
                            $str .= "<tr><td>" . "<input type='checkbox' id='checked_student' name = 'checked_student[]' class='checked-student' value='" . $row->id . "' checked>" . "</td>";
                        } else {
                            $str .= "<tr><td>" . "<input type='checkbox' id='checked_student' name = 'checked_student[]' class='checked-student' value='" . $row->id . "'>" . "</td>";
                        }
                    } else {
                        $str .= "<tr><td></td>";
                    }
                    $str .= "<td>" . $row->rollno . "</td>";
                } else {
                    $str .= "<tr>";
                }
                /*$str .= "<td>" . $row->roll_number . "</td>";*/
                $str .= "<td>";
                $str .= "<a href='enter-marks/$request->exam/$row->id'><button>Enter Marks</button></a>";
                $str .= "</td>";
            }
        } else {
            $str1 = "<h5 class='center'>No records found !</h5>";
        }
        $str .= "</tr></tbody>";
        $str .= "</table>";
        if (sizeof($result->toArray()) != 0) {
            return $str;
        } else {
            return $str1;
        }
    }

    public function questionPaperListing(Request $request,$classId,$examId){
        if($classId == 'null' && $examId == 'null') {
            $result = ExamQuestionPaper::orderBy('id','desc')->get();
        } else {
            $result = ExamQuestionPaper::where('class_id', $classId)->where('exam_id', $examId)->orderBy('id','desc')->get();
        }
        $str = "<h5 class='over-title margin-bottom-15'><h3>Question Paper</h3></h5>";
        $str .= "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
        $str .= "<thead><tr>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Sr.No.: activate to sort column ascending' style='width: 29px;'>Sr.No.</th>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Uploaded: activate to sort column ascending' style='width: 29px;'>Uploaded</th>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Term: activate to sort column ascending' style='width: 29px;'>Term</th>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Exam: activate to sort column ascending' style='width: 29px;'>Exam</th>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Set: activate to sort column ascending' style='width: 29px;'>Set</th>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Name: activate to sort column ascending' style='width: 29px;'>Name</th>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Marks: activate to sort column ascending' style='width: 29px;'>Marks</th>";
        if (sizeof($result->toArray()) != 0) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Action: activate to sort column ascending' style='width: 29px;'>Action</th>";
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Upload: activate to sort column ascending' style='width: 29px;'>Upload</th>";
            $str .= "</tr></thead><tbody>";
            $srNo = 1;
            foreach ($result as $row) {
                $str .="<tr>";
                $str .= "<td>" . $srNo . "</td>";
                if($row['paper_pdf'] != null) {
                    $str .= "<td>" . "<input type='checkbox' checked>" . "</td>";
                } else {
                    $str .= "<td>" . "<input type='checkbox'>" . "</td>";
                }
                $examName = ExamTermDetails::where('id',$row->exam_id)->select('term_id','exam_type')->first();
                $termName = ExamTerms::where('id',$examName['term_id'])->value('term_name');
                $str .= "<td>" . $termName . "</td>";
                $str .= "<td>" . $examName['exam_type'] . "</td>";
                $str .= "<td>" . $row->set_name . "</td>";
                $str .= "<td>" . $row->question_paper_name ."</td>";
                $str .= "<td>" . $row->marks ."</td>";
                $str .= "<td>";
                $str .= "<a href='edit-paper/$row->id'>Edit </a>";
                $str .= "</td>";
                $str .= "<td>";
                $str .= "<input type='file' accept='application/pdf' class='question-paper' name='question_paper[$row->id]'>";
                $str .= "</td>";
                $str .= "</tr>";
                $srNo++;
            }
        } else {
            $str1 = "<h5 class='center'>No records found !</h5>";
        }
        $str .= "</tr></tbody>";
        $str .= "</table>";
        if (sizeof($result->toArray()) != 0) {
            return $str;
        } else {
            return $str1;
        }
    }

}