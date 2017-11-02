<?php

namespace App\Http\Controllers\api;

use App\Division;
use App\ExamClassStructureRelation;
use App\ExamSubSubjectStructure;
use App\ExamTermDetails;
use App\ExamTerms;
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
              $sub_structure = ExamClassStructureRelation::where('class_id',$class_id)->lists('exam_subject_id');
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
             $student_exam_details_id = StudentExamDetails::where('student_id',$user_id)->pluck('id');
            $termData =  DB::table('student_exam_marks')->join('exam_term_details','exam_term_details.id','=','student_exam_marks.exam_term_details_id')->
                                     where('exam_term_details.term_id',$id)->
                                     where('student_exam_marks.term_id',$id)->
                                     where('student_exam_marks.student_exam_details_id',$student_exam_details_id)->
                                     select('exam_term_details.exam_type','exam_term_details.out_of_marks','student_exam_marks.marks_obtained')->
                                     get();

             $obtained_marks = StudentExamMarks::where('student_exam_details_id',$student_exam_details_id)->where('term_id',$id)->lists('marks_obtained')->toArray();
             $totalMarks_obtained = array_sum($obtained_marks);
             $totalMarks = ExamTermDetails::where('term_id',$id)->lists('out_of_marks')->toArray();
             $examTermDetails['term_data'] = $termData;
             $examTermDetails['total'] = array_sum($totalMarks);
             $examTermDetails['total_marks_obtained'] = $totalMarks_obtained;
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
}