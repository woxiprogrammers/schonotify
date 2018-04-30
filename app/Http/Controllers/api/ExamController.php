<?php

namespace App\Http\Controllers\api;

use App\Division;
use App\ExamClassStructureRelation;
use App\ExamSubSubjectStructure;
use App\ExamTeacherConfirmation;
use App\ExamTermDetails;
use App\ExamTerms;
use App\Grade;
use App\StudentExamDetails;
use App\StudentExamMarks;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
    }
    public function getExamTerms(Request $request,$id){
        $subjects = array();
        try{
              $division = User::where('id',$id)->pluck('division_id');
              $class_id = Division::where('id',$division)->pluck('class_id');
              $sub_structure = ExamTeacherConfirmation::where('class_id',$class_id)->where('status',1)->lists('exam_structure_id');
              $subjects = ExamSubSubjectStructure::whereIn('id',$sub_structure)->select('id','sub_subject_name')->get();
              $status = 200;
              $message = "success";
        }catch(\Exception $e){
            $status = 500;
            $message = "something went wrong". $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data"   => $subjects

        ];
        return response($response, $status);
    }
    public function getSubjectDetails(Request $request,$id){
        $terms = array();
        try{
            $terms = ExamTerms::where('exam_structure_id',$id)->select('term_name','id')->get()->toArray();
            $status = 200;
            $message = "Success";
        }catch(\Exception $e){
            $status = 500;
            $message = "something went wrong". $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data"   =>  $terms
        ];
        return response($response, $status);
    }
    public function getTermData(Request $request,$id,$user_id){
        $examTermDetails = array();
        try{
            $exam_sub_structure_id = ExamTerms::where('id',$id)->pluck('exam_structure_id');
            $student_exam_details_id = StudentExamDetails::where('student_id',$user_id)->where('term_id',$id)->where('exam_structure_id',$exam_sub_structure_id)->pluck('id');
            $termData =  DB::table('student_exam_marks')->join('exam_term_details','exam_term_details.id','=','student_exam_marks.exam_term_details_id')->
                                     where('exam_term_details.term_id',$id)->
                                     where('student_exam_marks.term_id',$id)->
                                     where('student_exam_marks.student_exam_details_id',$student_exam_details_id)->
                                     select('exam_term_details.exam_type','exam_term_details.out_of_marks','student_exam_marks.marks_obtained')->
                                     get();
             $obtained_marks = StudentExamMarks::where('student_exam_details_id',$student_exam_details_id)->where('term_id',$id)->lists('marks_obtained')->toArray();
             $subSubject_id = StudentExamMarks::where('term_id',$id)->pluck('exam_structure_id');
             $class_id = ExamClassStructureRelation::where('exam_subject_id',$subSubject_id)->pluck('class_id');
             $totalMarks_obtained = array_sum($obtained_marks);
             $totalMarks = ExamTermDetails::where('term_id',$id)->lists('out_of_marks')->toArray();
             $examTermDetails['term_data'] = $termData;
             $examTermDetails['total'] = array_sum($totalMarks);
             $examTermDetails['total_marks_obtained'] = $totalMarks_obtained;
             $examTermDetails['grade'] = Grade::where('min', '<=', $totalMarks_obtained)->where('max', '>=', $totalMarks_obtained)->where('class_id',$class_id)->pluck('grade');
             $status = 200;
             $message = "Success";
        }catch(\Exception $e){
             $status = 500;
             $message = "something went wrong". $e->getMessage();
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data"   =>  $examTermDetails
        ];
        return response($response, $status);
    }
    public function checkFees(Request $request,$id){
        $is_paid = User::where('id',$id)->pluck('hide_result');
        if ($is_paid == null){
            $is_paid = 0;
        }
        return response($is_paid);
    }
}
