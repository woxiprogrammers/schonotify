<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Classes;
use App\Division;
use App\Homework;
use App\HomeworkTeacher;
use App\HomeworkType;
use App\Subject;
use App\SubjectClassDivision;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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

        return view('createHomework')->with(compact('homework','homeworkTypes','subjectClass'));
    }

    public function homeworkCreate(Requests\WebRequests\CreateHomeworkRequest $request)
    {
            $homeworkData= $request->all();
            //dd($homeworkData);
            $homework=array();
            $homeworkTeacher=array();
            $i=0;
            $homework['subject_id']=$homeworkData['subjectsDropdown'];
            $homework['homework_type_id']=$homeworkData['homeworkType'];
            $homework['title']=$homeworkData['title'];
            $homework['description']=$homeworkData['description'];
            $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $homeworkData['dueDate'])));
            $homework['due_date']=$date;
            if(Input::hasFile('pdfFile')){
                    $pdfs = $request->file('pdfFile');
                    $name = $request->file('pdfFile')->getClientOriginalName();
                    $filename = time()."_".$name;
                    $path = public_path('uploads/homework/');
                    if (! file_exists($path)) {
                        File::makeDirectory('uploads/homework/', $mode = 0777, true, true);
                    }
                    $pdfs->move($path,$filename);
            }
            else{
                    $filename = null;
            }
            $homework['attachment_file']=$filename;
            $homework['homework_timestamp']=Carbon::now();
            $homework['created_at'] = Carbon::now();
            $homework['updated_at'] = Carbon::now();
            $homework['is_active'] = 1;
            if($homeworkData['buttons'] =='save')
            {
                $homework['status'] = 0;
            }elseif($homeworkData['buttons'] =='publish'){
                $homework['status'] = 1;
            }
        $homeworkId=Homework::insertGetId($homework);
            $user=Auth::user();
            foreach($homeworkData['studentinfo'] as $row)
            {
                $division = User::where('id',$row)->select('id','division_id')->first();
                $HomeworkTeacher['student_id'] = $division->id;
                $HomeworkTeacher['teacher_id'] = $user->id;
                $HomeworkTeacher['homework_id'] = $homeworkId;
                $HomeworkTeacher['division_id'] = $division->division_id;
                $HomeworkTeacher['created_at']= Carbon::now();
                $HomeworkTeacher['updated_at']= Carbon::now();
                HomeworkTeacher::insert($HomeworkTeacher);
            }
        Session::flash('message-success','homework created successfully');
        return Redirect::to('/homeworkListing');

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

    public function getSubjectClass($id,$subject_id){
        $classInfo=array();
        $classSubject=array();
        $subjectClassId=Subject::where('id',$subject_id)->get();
       foreach($subjectClassId as $row)
       {
          $classSubject['class_id'] = $row['class_id'];
       }
       $class=Classes::where('batch_id',$id)->
                       where('id',$classSubject['class_id'])
                       ->get();
        $i=0;
       foreach($class as $row)
       {
           $classInfo[$i]['class_id']=$row['id'];
           $classInfo[$i]['class_slug']=$row['slug'];
           $i++;
       }
        return $classInfo;
    }

    public function getSubjectDiv($id,$subject_id){
        $user=Auth::user();
        $i=0;
        $division=Division::where('class_teacher_id',$user->id)->first();
            if($division != null){
                $divisionInfo=Division::where('class_id',$id)->where('class_teacher_id',$user->id)->first();
                $divisionArray[0]['division_id']=$divisionInfo->id;
                $divisionArray[0]['division_slug']=$divisionInfo->slug;
                $divSubjects=SubjectClassDivision::where('teacher_id',$user->id)
                                                  ->where('subject_id',$subject_id)->get();
                foreach($divSubjects as $row)
                {
                    $divArray[$i]=$row['division_id'];
                    $i++;
                }
                    $divs=Division::wherein('id',$divArray)->get();
                    foreach($divs as $row)
                    {
                        $divisionArray[$i]['division_id']=$row['id'];
                        $divisionArray[$i]['division_slug']=$row['slug'];
                        $i++;
                    }
                $divisionArray = array_unique($divisionArray, SORT_REGULAR);
                return $divisionArray;
            }else{
                $divSubjects=SubjectClassDivision::where('teacher_id',$user->id)
                    ->where('subject_id',$subject_id)->get();
                foreach($divSubjects as $row)
                {
                    $divArray[$i]=$row['division_id'];
                    $i++;
                }
                $divs=Division::wherein('id',$divArray)->get();
                foreach($divs as $row)
                {
                    $divisionArray[$i]['division_id']=$row['id'];
                    $divisionArray[$i]['division_slug']=$row['slug'];
                    $i++;
                }
                $divisionArray = array_unique($divisionArray, SORT_REGULAR);
                return $divisionArray;
            }

    }

    public function getStudentData(Request $request)
    {
        $students = User::wherein('division_id',$request->id)
                          ->join('divisions','users.division_id','=','divisions.id')
                          ->select('users.roll_number','users.id as user_id','users.first_name','users.last_name','divisions.slug')
                          ->get();
        $studentList = $students->toArray();
        return $studentList;
    }

}
