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
       // $user=User::where('id','=',$id)->first();
        $studentResult=Result::where('student_id','=',$id)->get();
        $studentResultArray=$studentResult->toArray();
        $i=0;
        foreach($studentResultArray as $value){
            $exam_subject=ExamSubjects::where('id','=',$value['exam_subject_id'])->first();
            dd($exam_subject);
            $examName=Exams::where('id','=',$exam_subject['exam_id'])->first();
            $data[$i]['exam_name']=$examName['exam_name'];
            $data[$i]['marks']=$value['student_marks'];
            $subjectName=Subject::where('id','=',$exam_subject['subject_id'])->first();
            $data[$i]['subject']=$subjectName['subject_name'];
                $i++;
        }
        dd($data);
    }
}
