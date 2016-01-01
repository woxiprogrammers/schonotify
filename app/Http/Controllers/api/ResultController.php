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
                }
            }
        }
        return $finalExamData;
    }
}
