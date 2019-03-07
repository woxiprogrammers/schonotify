<?php

/**
 * Created by PhpStorm.
 * User: vaibhav
 * Date: 27/2/19
 * Time: 3:38 PM
 */

namespace App\Http\Controllers\ExamEvaluation;

use App\Batch;
use App\Http\Controllers\Controller;
use App\Subject;
use App\SubjectClass;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


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
            return view('exam_evaluation.createExam')->with(compact('user'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function createExam(Request $request){
        try{
            $user = Auth::user();
            if($request->exam_name != null){
            }
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function createFeeStructureView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.createQuestionPaper')->with(compact('batches','user'));
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

    public function assignStudentView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.assignStudentsToTeacher')->with(compact('batches','user'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignStudents(Request $request){
        try{
            $user = Auth::user();
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignSubjectView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.assignExamSubjects')->with(compact('batches','user'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function assignSubject(Request $request){
        try{
            $user = Auth::user();
            return back();
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function studentListingView(){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.studentListing')->with(compact('batches','user'));
        }catch (\Exception $e){
            abort(500,$e->getMessage());
        }
    }

    public function getEnterMarksView(){
        try{
            $user = Auth::user();
            $file = env('ABOUT_US_IMAGE_UPLOAD').'/'.'sample.pdf';
            $batches = Batch::where('body_id',$user->body_id)->get();
            return view('exam_evaluation.enterMarks')->with(compact('batches','file','user'));
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

    public function filterStudent(Request $request)
    {
        $role_id = 3;
        $user = Auth::user();
        if ($user->role_id == 1) {
            if ($role_id == 3) {
                $result = User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                    ->where('division_id', $request->division)
                    ->where('users.body_id', '=', $user->body_id)
                    ->where('users.role_id', '!=', 1)
                    ->where('users.role_id', '=', $role_id)
                    ->where('users.id', '!=', $user->id)
                    ->where('users.is_displayed', '=', '1')
                    ->select('users.id', 'users.roll_number as roll_number', 'users.first_name as firstname', 'users.last_name as lastname', 'users.gender as gender', 'students_extra_info.category as category', 'user_roles.slug as user_role', 'students_extra_info.grn as rollno', 'users.parent_id as parent_id', 'users.is_active', 'users.hide_result', 'users.is_lc_generated', 'users.is_displayed')
                    ->get();
            } else {
                $result = User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->where('users.body_id', '=', $user->body_id)
                    ->where('users.role_id', '=', $role_id)
                    ->where('users.is_displayed', '=', '1')
                    ->where('users.id', '!=', $user->id)
                    ->select('users.id', 'users.roll_number as roll_number', 'users.first_name as firstname', 'users.last_name as lastname', 'users.gender as gender', 'students_extra_info.category as category', 'user_roles.slug as user_role', 'users.roll_number as rollno', 'users.parent_id as parent_id', 'users.is_active', 'users.hide_result')
                    ->get();
            }
        } else {
            if ($role_id == 3) {
                $result = User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                    ->where('division_id', $request->division)
                    ->where('users.body_id', '=', $user->body_id)
                    ->where('users.role_id', '!=', 1)
                    ->where('users.role_id', '=', $role_id)
                    ->where('users.id', '!=', $user->id)
                    ->where('users.is_displayed', '=', '1')
                    ->select('users.id', 'users.roll_number as roll_number', 'users.first_name as firstname', 'users.last_name as lastname', 'users.gender as gender', 'students_extra_info.category as category', 'user_roles.slug as user_role', 'students_extra_info.grn as rollno', 'users.parent_id as parent_id', 'users.is_active', 'users.hide_result')
                    ->get();
            } else {
                $result = User::Join('user_roles', 'users.role_id', '=', 'user_roles.id')
                    ->where('users.body_id', '=', $user->body_id)
                    ->where('users.role_id', '!=', 1)
                    ->where('users.role_id', '=', $role_id)
                    ->where('users.id', '!=', $user->id)
                    ->where('users.is_displayed', '=', '1')
                    ->select('users.id', 'users.roll_number as roll_number', 'users.first_name as firstname', 'users.last_name as lastname', 'users.gender as gender', 'users.email', 'user_roles.slug as user_role', 'users.roll_number as rollno', 'users.parent_id as parent_id', 'users.is_active', 'users.hide_result')
                    ->get();
            }
        }
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
                        $str .= "<tr><td>" . "<input type='checkbox' id='assign_student' name = 'assign_student[$row->id]' class='assign-student' value='" . $row->id . "'>" . "</td>";
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