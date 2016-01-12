<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Classes;
use App\Division;
use App\HomeworkType;
use App\Subject;
use App\SubjectClassDivision;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }



    public function homeworkListing()
    {

        return view('homeworkListing');
    }

    public function detailedHomework()
    {
        return view('detailedHomework');
    }

    public function createHomework(Request $request)
    {
        $user= Auth::user();
        $i=0;
        $homework=array();
        $homeworkType=HomeworkType::all();
        foreach($homeworkType as $type)
        {
            $homeworkTypes[$i]['type_id'] = $type ['id'] ;
            $homeworkTypes[$i]['type_slug']=$type['slug'];
            $i++;
        }

        $division=Division::where('class_teacher_id',$user->id)->first();
        if($division != null){
                $subjects=Subject::where('class_id',$division->class_id)->get();
                foreach($subjects as $row)
                {
                    $homework[$i]['subjects'] = $row ['slug'] ;
                    $homework[$i]['subject_id']=$row['id'];
                    $i++;
                }
                $divisionSubjects=SubjectClassDivision::where('teacher_id',$user->id)
                                                      ->join('subjects','division_subjects.subject_id','=','subjects.id')
                                                      ->select('subjects.id','subjects.slug','division_subjects.division_id')
                                                      ->get();
                $divisionId=array();
                foreach($divisionSubjects as $row)
                {
                    $homework[$i]['subjects'] = $row ['slug'] ;
                    $homework[$i]['subject_id']=$row['id'];
                    $divisionId['division_id'][$i]=$row['division_id'];
                    $i++;
                }
                $homework = array_unique($homework, SORT_REGULAR);


        }else{
                $divisionSubjects=SubjectClassDivision::where('teacher_id',$user->id)
                    ->join('subjects','division_subjects.subject_id','=','subjects.id')
                    ->select('subjects.id','subjects.slug')
                    ->get();
                foreach($divisionSubjects as $row)
                {
                    $homework[$i]['subjects'] = $row ['slug'] ;
                    $homework[$i]['subject_id']=$row['id'];
                    $i++;
                }


        }
        $subjectId=array();
        foreach($homework as $row)
        {
            array_push($subjectId,$row['subject_id']);
        }
//        $class_id=Subject::wherein('id',$subjectId)->get()->toArray();
//        foreach($class_id as $row)
//        {
//            $classes[]=$row['class_id'];
//        }
//        $batch=Classes::wherein('id',$classes)->get()->toArray();
//        foreach($batch as $row)
//        {
//            $batches[]=$row['batch_id'];
//            $subjectClass[$i]['class_id']=$row['id'];
//            $subjectClass[$i]['class_slug']=$row['slug'];
//            $i++;
//        }
//        $batchName=Batch::wherein('id',$batches)->get()->toArray();
//        foreach($batchName as $row)
//        {
//            $batchInfo[$i]['batch_id']=$row['id'];
//            $batchInfo[$i]['batch_slug']=$row['slug'];
//            $i++;
//        }


//        return view('createHomework')->with(compact('homework','homeworkTypes','batchInfo','subjectClass'));
        return view('createHomework')->with(compact('homework','homeworkTypes','subjectClass'));
    }

    public function homeworkCreate(Request $request)
    {
            dd(1);
    }

    public function getSubjectBatches($subjectId)
    {

        $class_id=Subject::where('id',$subjectId)->get()->toArray();

        foreach($class_id as $row)
        {
            $classes[]=$row['class_id'];
        }
        $batch=Classes::wherein('id',$classes)->get()->toArray();
        $i=0;
        foreach($batch as $row)
        {
            $batches[]=$row['batch_id'];
            $subjectClass[$i]['class_id']=$row['id'];
            $subjectClass[$i]['class_slug']=$row['slug'];
            $i++;
        }
        $batchName=Batch::wherein('id',$batches)->get()->toArray();
        foreach($batchName as $row)
        {
            $batchInfo[$i]['batch_id']=$row['id'];
            $batchInfo[$i]['batch_slug']=$row['slug'];
            $i++;
        }

        return $batchInfo;


    }


    public function getSubjectDiv($id){
        $divisionData = Division::where('class_id', $id)->select('id','division_name')->get();
        $divisionList = $divisionData->toArray();
        return $divisionList;
    }

    public function getStudentData($id)
    {
        $students = User::where('division_id',$id)->get();
        $studentList = $students->toArray();
        return $studentList;
    }

}
