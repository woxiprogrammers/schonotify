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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewResult(Requests\Result $request , $id)
    {
        $studentResult=Result::where('student_id','=',$id)->get();
        $studentResultArray=$studentResult->toArray();
        $i=0;
        foreach($studentResultArray as $value){
            $exam_subject=ExamSubjects::where('id','=',$value['exam_subject_id'])->first();
            $exam=Exams::where('id','=',$exam_subject['exam_id'])->first();
            $data[$i]['exam_name']=$exam['exam_name'];
            $data[$i]['marks']=$value['student_marks'];
            $subject=Subject::where('id','=',$exam_subject['subject_id'])->first();
            $data[$i]['subject']=$subject['subject_name'];
            $data[$i]['subject_id']=$subject['id'];
            $data[$i]['exam_id']=$exam['id'];
                $i++;
        }
           // dd($data);
        $size=count($data);
        $subjectArray = array();
        for($i=0,$j=0;$i<$size;$i++){
            $result = array(
                'subject_id'=> $data[$i]['subject_id'],
                'subject_name' => $data[$i]['subject'] );
            $subjectArray[$i] = $result;
        }

        $size1=count($subjectArray);
        $dataArraySize=count($data);
        for($i=0;$i<$size1;$i++)
        {
            $examName=$data[$i]['exam_name'];
            $subjectArraySubject_id=$subjectArray[$i]['subject_id'];
            for($j=0;$j<$dataArraySize;$j++){
                $dataArraySubject_id= $data[$j]['subject_id'];
                if($subjectArraySubject_id==$dataArraySubject_id){
                    $result1 = array(
                           'test_id'=> $data[$i]['exam_id'],
                            'marks'=> $data[$i]['marks'],
                            'subject_id' => $data[$i]['subject_id'],
                            'subject_name' => $data[$i]['subject']);
                    $finalExamData[$examName][$j]=$result1;
                }else{
                    $finalExamData[$examName][$j]=[];
                }
            }
        }

        return $finalExamData;
      /*  $size=count($data);
        $finalExamArray = array();
        $examResultArray = $data;
        $examName="";
        for($i=0,$j=1;$i<$size;$i++ && $j++){
            $result = array(
                'Test_id'=> $examResultArray[$i]['exam_id'],
                'marks'=> $examResultArray[$i]['marks'],
                'subject_id' => $examResultArray[$i]['subject_id'],
                'subject_name' => $examResultArray[$i]['subject']);
            $examName=$examResultArray[$i]['exam_name'];
            $finalExamArray[$examName][$j] = $result;
        }


      $size=count($data);
        $finalExamArray = array();
        $examResultArray = $data;
        $examName="";
        for($i=0,$j=0;$i<$size;$i++){
            $result = array(
                'Test_id'=> $examResultArray[$i]['exam_id'],
                'marks'=> $examResultArray[$i]['marks'],
                'subject_id' => $examResultArray[$i]['subject_id'],
                'subject_name' => $examResultArray[$i]['subject']);
            $examName=$examResultArray[$i]['exam_name'];
            $finalExamArray[$examName][$i] = $result;
        }
        return $finalExamArray;


        return $finalExamArray;
*/
       /* $size=count($data);
        $finalExamArray = array();
        $examResultArray = $data;
        $examName="";
        for($i=0,$j=0;$i<$size;$i++){
            if($examName==$examResultArray[$i]['exam_name']){
                $j++;
            }else{
                $j=0;
            }
            $result = array(
                'marks'=> $examResultArray[$i]['marks'],
                'subject' => $examResultArray[$i]['subject'] );
            $examName=$examResultArray[$i]['exam_name'];
            $finalExamArray[$examName][$j] = $result;
        }
        $size=count($data);
        $finaleSubjectArray = array();
        $subjectName="";
        $subjectResultArray = $data;
        for($i=0,$j=0;$i<$size;$i++){
            if($subjectName==$subjectResultArray[$i]['subject']){
                $j++;
            }else{
                $j=0;
            }
            $result = array(
                'exam_name'=> $examResultArray[$i]['exam_name'],
                'marks' => $examResultArray[$i]['marks'] );
            $subjectName=$examResultArray[$i]['subject'];
            $finaleSubjectArray[$subjectName][$j] = $result;
        }
        return $finaleSubjectArray;*/
    }
}
