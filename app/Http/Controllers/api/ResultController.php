<?php

namespace App\Http\Controllers\api;

use App\Exams;
use App\ExamSubjects;
use App\Result;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ResultController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewResult(Requests\Result $request , $id)
    {
        try{
       $user=User::where('id','=',$id)->first();
        if($user!=null){
          $resultData =Result::join('exam_subjects','results.exam_subject_id', '=', 'exam_subjects.id')
              ->join('exams','exam_subjects.exam_id','=','exams.id')
              ->join('subjects','exam_subjects.subject_id','=','subjects.id')
              ->join('users','users.id','=','results.student_id')
              ->select('exams.id as Test_id','exams.exam_name','results.student_marks','subjects.id as Subject_id','subjects.subject_name')
              ->where('results.student_id','=',$id)
              ->get();
          $resultDataArray=$resultData->toArray();
            $resultDataArraySize= count($resultDataArray);
            if($resultDataArraySize!=0){
                $i=0;
                foreach($resultDataArray as $value){
                    $examName=$value['exam_name'];
                    $result = array(
                        'test_id'=> $value['Test_id'],
                        'marks'=> $value['student_marks'],
                        'subject_id' => $value['Subject_id'],
                        'subject_name' => $value['subject_name']);
                    $ExamData[$examName][$i]=$result;
                    $i++;
                }
                $j=0;
                $finalExamData=array();
                foreach($ExamData as $key=>$value){
                    foreach($value as $val){
                        $finalExamData[$key][$j]= $val;
                        $j++;
                    }
                    $j=0;
                }
                $message="success";
                $status=200;
                $data=$finalExamData;
            }else{
                $message="Sorry ! No result found for this user";
                $data="";
                $status=404;
            }
      }else{
            $message="Sorry ! No user Found";
            $data="";
            $status=406;
          }
        }catch (\Exception $e) {
                $status = 500;
                $message = "Something went wrong"  .  $e->getMessage();
            }
        $response = [
            "message" => $message,
            "status" =>$status,
            "data"=>$data
        ];
        return response($response,$status);
      }
}
