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
use App\ExamClassSubject;
use App\ExamEvaluation;
use App\Http\Controllers\Controller;
use App\PaperCheckerMaster;
use App\StudentAnswerSheet;
use App\StudentExtraInfo;
use Illuminate\Support\Facades\File;
use App\Subject;
use App\SubjectClass;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;


class ExamEvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function createExamView(){
        try{
            $user = Auth::user();
            $exams = ExamEvaluation::all();
            return view('exam_evaluation.createExam')->with(compact('user','exams'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function createExam(Request $request){
        try{
            $user = Auth::user();
            if($request->exam_name != null){
                $examData['exam_name'] = $request->exam_name;
                ExamEvaluation::create($examData);
            }
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function editExamView(Request $request,$examId){
        try{
            $user = Auth::user();
            $exam = ExamEvaluation::where('id',$examId)->first();
            return view('exam_evaluation.editExam')->with(compact('user','exam'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function editExam(Request $request){
        try{
            $user = Auth::user();
            if($request->exam_name != null){
                $examData['exam_name'] = $request->exam_name;
                ExamEvaluation::where('id',$request->exam_id)->update($examData);
            }
            return redirect('exam-evaluation/create-exam');
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function createQuestionPaperView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $exams = ExamEvaluation::all();
            return view('exam_evaluation.createQuestionPaper')->with(compact('batches','user','exams'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function createQuestionPaper(Request $request){
        try{
            $user = Auth::user();
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function questionPaperListingView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $exams = ExamEvaluation::all();
            return view('exam_evaluation.questionPaperListing')->with(compact('batches','user','exams'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function uploadAnswerSheetView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $exams = ExamEvaluation::all();
            return view('exam_evaluation.uploadAnswerSheet')->with(compact('batches','user','exams'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function uploadAnswerSheet(Request $request){
        try{
            $answerSheetData['exam_id'] = $request->exam_select;
            $answerSheetData['subject_id'] = $request->subject_select;
            $answerSheets = $request->answer_sheet;
            foreach ($answerSheets as $stdId => $answerSheetPdf){
                if($answerSheetPdf != null) {
                    $answerSheetPresent = StudentAnswerSheet::where('exam_id', $request->exam_select)->where('subject_id', $request->subject_select)->where('student_id', $stdId)->first();
                    $folderEncName = sha1($request->exam_select);
                    $folderPath = public_path() . env('ANSWER_SHEET_UPLOAD') . DIRECTORY_SEPARATOR . $folderEncName;
                    if ($answerSheetPresent['pdf_name'] != null) {
                        unlink($folderPath . DIRECTORY_SEPARATOR . $answerSheetPresent['pdf_name']);
                    }
                    if (!file_exists($folderPath)) {
                        File::makeDirectory($folderPath, 0777, true, true);
                    }
                    $filename = mt_rand(1,10000000000).sha1(time()).".pdf";
                    $answerSheetPdf->move($folderPath , $filename);
                    $answerSheetData['pdf_name'] = $filename;
                    if ($answerSheetPresent['pdf_name'] != null) {
                        StudentAnswerSheet::where('id',$answerSheetPresent['id'])->update($answerSheetData);
                    } else {
                        $answerSheetData['student_id'] = $stdId;
                        StudentAnswerSheet::create($answerSheetData);
                    }
                    }
                }
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignStudentView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $exams = ExamEvaluation::all();
            $paperCheckerRoles = PaperCheckerMaster::all();
            return view('exam_evaluation.assignStudentsToTeacher')->with(compact('batches','user','exams','paperCheckerRoles'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignStudents(Request $request){
        try{
            $user = Auth::user();
            $assignStudentData['exam_id'] = $request->exam_select;
            $assignStudentData['subject_id'] = $request->subject_select;
            $assignStudentData['teacher_id'] = $request->teacher_select;
            $assignStudentData['role_id'] = $request->role_select;
            if($request->has('assign_student')){
                $students = $request->assign_student;
                foreach ($students as $student){
                    $assignedStudents = AssignStudentsToTeacher::where('exam_id',$request->exam_select)->where('subject_id',$request->subject_select)->where('teacher_id',$request->teacher_select)->where('student_id',$student)->where('role_id',$request->role_select)->first();
                    if($assignedStudents == null) {
                        $assignStudentData['student_id'] = $student;
                        AssignStudentsToTeacher::create($assignStudentData);
                    }
                }
            }
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignSubjectView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $exams = ExamEvaluation::all();
            return view('exam_evaluation.assignExamSubjects')->with(compact('batches','user','exams'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignSubject(Request $request){
        try{
            $examSubjectData['class_id'] = $request->class_select;
            $examSubjectData['exam_id'] = $request->exam_select;
            if($request->has('subject_select')){
                $subjects = $request->subject_select;
                foreach ($subjects as $subject){
                    $examSubject = ExamClassSubject::where('class_id',$request->class_select)->where('exam_id',$request->exam_select)->where('subject_id',$subject)->first();
                    if ($examSubject == null) {
                        $examSubjectData['subject_id'] = $subject;
                        ExamClassSubject::create($examSubjectData);
                    }
                }
            }
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function removeSubject(Request $request,$subId,$classId,$examId){
        try{
            ExamClassSubject::where('class_id',$classId)->where('exam_id',$examId)->where('subject_id',$subId)->delete();
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function studentListingView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            $exams = ExamEvaluation::all();
            $paperCheckerRoles = PaperCheckerMaster::all();
            return view('exam_evaluation.studentListing')->with(compact('batches','user','exams','paperCheckerRoles'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function getEnterMarksView(Request $request,$examId,$subId,$stdId){
        try{
            $user = Auth::user();
            $answerSheetPdf = null;
            $examName = ExamEvaluation::where('id',$examId)->value('exam_name');
            $stdGrn = StudentExtraInfo::where('student_id',$stdId)->value('grn');
            $answerSheetData = StudentAnswerSheet::where('exam_id',$examId)->where('subject_id',$subId)->where('student_id',$stdId)->value('pdf_name');
            if($answerSheetData != null) {
                $answerSheetPdf = env('ANSWER_SHEET_UPLOAD') . DIRECTORY_SEPARATOR . sha1($examId) . DIRECTORY_SEPARATOR . $answerSheetData;
            }
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.enterMarks')->with(compact('batches','answerSheetPdf','user','examName','stdGrn'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
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

    public function getExamClassSubject($examId,$classId){
        $data=array();
        $subjectIds = ExamClassSubject::where('class_id',$classId)->where('exam_id',$examId)->lists('subject_id');
        $subjects = Subject::whereIn('id',$subjectIds)->get()->toArray();
        $i=0;
        foreach ($subjects as $row) {
            $data[$i]['subject_id'] = $row['id'] ;
            $data[$i]['subject_name']= $row['subject_name'] ;
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
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='GRN No.: activate to sort column ascending' style='width: 29px;'>GRN No.</th>";
        }
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Name: activate to sort column ascending' style='width: 29px;'>Name</th><th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Roll No: activate to sort column ascending' style='width: 29px;'>Roll No</th>";
        if (sizeof($result->toArray()) != 0) {
            $str .= "</tr></thead><tbody>";
            foreach ($result as $row) {
                if ($row->user_role == 'student') {
                    if ($row->is_lc_generated == 0) {
                        $studentAssigned = AssignStudentsToTeacher::where('exam_id',$request->exam)->where('subject_id',$request->subject)->where('teacher_id',$request->teacher)->where('role_id',$request->role)->where('student_id',$row->id)->first();
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
                $str .= "<td>" . $row->firstname . " " . $row->lastname . "</td>";
                $str .= "<td>" . $row->roll_number . "</td>";
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
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Uploaded: activate to sort column ascending' style='width: 29px;'>Uploaded  "."<input type='checkbox' id='check_all' onclick='checkAll()'/>"."</th>";
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='GRN No.: activate to sort column ascending' style='width: 29px;'>GRN No.</th>";
        }
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Name: activate to sort column ascending' style='width: 29px;'>Name</th><th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Roll No: activate to sort column ascending' style='width: 29px;'>Roll No</th>";
        if (sizeof($result->toArray()) != 0) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Action: activate to sort column ascending' style='width: 29px;'>Action</th>";
            $str .= "</tr></thead><tbody>";
            foreach ($result as $row) {
                if ($row->user_role == 'student') {
                    if ($row->is_lc_generated == 0) {
                        $isAnswerSheetUploaded = StudentAnswerSheet::where('exam_id',$request->exam)->where('subject_id',$request->subject)->where('student_id',$row->id)->value('pdf_name');
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
                $str .= "<td>" . $row->firstname . " " . $row->lastname . "</td>";
                $str .= "<td>" . $row->roll_number . "</td>";
                $str .= "<td>";
                $str .= "<input type='file' onchange='extentionValidation()' id='answer-sheet' accept='application/pdf' class='answer-sheet' name='answer_sheet[$row->id]'>";
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
        $studentIds = AssignStudentsToTeacher::where('exam_id',$request->exam)->where('subject_id',$request->subject)->where('teacher_id',3745)->where('role_id',$request->role)->lists('student_id');
        $result = User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
            ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
            ->where('division_id', $request->division)
            ->where('users.body_id', '=', $user->body_id)
            ->where('users.role_id', '!=', 1)
            ->where('users.role_id', '=', $role_id)
            ->where('users.id', '!=', $user->id)
            ->whereIn('users.id',$studentIds)
            ->where('users.is_displayed', '=', '1')
            ->select('users.id', 'users.roll_number as roll_number','user_roles.slug as user_role',  'users.first_name as firstname', 'users.last_name as lastname', 'students_extra_info.grn as rollno', 'users.is_lc_generated', 'users.is_displayed')
            ->get();
        $str = "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
        $str .= "<thead><tr>";
        if ($role_id == 3) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Uploaded: activate to sort column ascending' style='width: 29px;'>Uploaded  "."<input type='checkbox' id='check_all' onclick='checkAll()'/>"."</th>";
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='GRN No.: activate to sort column ascending' style='width: 29px;'>GRN No.</th>";
        }
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Roll No: activate to sort column ascending' style='width: 29px;'>Roll No</th>";
        if (sizeof($result->toArray()) != 0) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Action: activate to sort column ascending' style='width: 29px;'>Action</th>";
            $str .= "</tr></thead><tbody>";
            foreach ($result as $row) {
                if ($row->user_role == 'student') {
                    if ($row->is_lc_generated == 0) {
                        $str .= "<tr><td>" . "<input type='checkbox' id='assign_student' name = 'assign_student[]' class='assign-student' value='" . $row->id . "'>" . "</td>";
                    } else {
                        $str .= "<tr><td></td>";
                    }
                    $str .= "<td>" . $row->rollno . "</td>";
                } else {
                    $str .= "<tr>";
                }
                $str .= "<td>" . $row->roll_number . "</td>";
                $str .= "<td>";
                $str .= "<a href='enter-marks/$request->exam/$request->subject/$row->id'><button>Fill Marks</button></a>";
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

    public function subjectListing(Request $request,$classId,$examId){
        $subjectIds = ExamClassSubject::Where('class_id',$classId)->where('exam_id',$examId)->lists('subject_id');
        $result = Subject::whereIn('id',$subjectIds)->get();
        $str = "<h5 class='over-title margin-bottom-15'><h3>Assigned Subjects</h3></h5>";
        $str .= "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
        $str .= "<thead><tr>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Sr.No.: activate to sort column ascending' style='width: 29px;'>Sr.No.</th>";
        $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Subject: activate to sort column ascending' style='width: 29px;'>Subject</th>";
        if (sizeof($result->toArray()) != 0) {
            $str .= "<th class='sorting' tabindex='0' aria-controls='sample_2' rowspan='1' colspan='1' aria-label='Action: activate to sort column ascending' style='width: 29px;'>Action</th>";
            $str .= "</tr></thead><tbody>";
            $srNo = 1;
            foreach ($result as $row) {
                $str .="<tr>";
                $str .= "<td>" . $srNo . "</td>";
                $str .= "<td>" . $row->subject_name . " " . $row->lastname . "</td>";
                $str .= "<td>";
                $str .= "<button type='submit' onclick='removeSubject($row->id,$classId,$examId)'>".'Remove'."</button>";
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