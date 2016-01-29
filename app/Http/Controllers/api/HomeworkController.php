<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\classes_subject;
use App\Division;
use App\Homework;
use App\HomeworkTeacher;
use App\HomeworkType;
use App\Subject;
use App\SubjectClass;
use App\SubjectClassDivision;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class HomeworkController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }


    public function getTeacherSubject(Request $request)
    {
       try{
            $data=$request->all();
            $homework=array();
           $finalSubjectList=array();
            $i=0;
            $division=Division::where('class_teacher_id',$data['teacher']['id'])->first();
            if($division != null){
                $classesSubjects=SubjectClassDivision::where('division_id',$division->id)->get();
                foreach($classesSubjects as $row)
                {
                    $subjects=Subject::where('id','=',$row['subject_id'])->first();
                    $homework[$i]['subject_id']=$row['subject_id'];
                    $homework[$i]['subject'] = $subjects ['subject_name'] ;
                    $i++;
                }
                $divisionSubjects=SubjectClassDivision::where('teacher_id',$data['teacher']['id'])
                    ->join('subjects','division_subjects.subject_id','=','subjects.id')
                    ->select('subjects.id','subjects.subject_name')
                    ->get();
                foreach($divisionSubjects as $row)
                {
                    $homework[$i]['subject_id']=$row['id'];
                    $homework[$i]['subject'] = $row ['subject_name'] ;
                    $i++;
                }
            }else{
                $divisionSubjects=SubjectClassDivision::where('teacher_id',$data['teacher']['id'])
                    ->join('subjects','division_subjects.subject_id','=','subjects.id')
                    ->select('subjects.id','subjects.subject_name','division_subjects.division_id')
                    ->get();
                foreach($divisionSubjects as $row)
                {
                    $homework[$i]['id']=$row['id'];
                    $homework[$i]['name'] = $row ['subject_name'] ;
                    $i++;
                }
            }
           $subjectList = array_unique($homework, SORT_REGULAR);
           $i=0;
           foreach($subjectList as $value){
               $finalSubjectList[$i]=$value;
               $i++;
           }
            $status = 200;
            $message = "Successfully listed";
      } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
             "message" => $message,
             "status" => $status,
             "data"=>$finalSubjectList
        ];
        return response($response, $status);
    }

    public function getSubjectBatches(Request $requests, $subjectId)
    {
        try{
            $data=$requests->all();
            $division=array();
            $batchInfo=array();
            $Classes=array();
            $divisionData=SubjectClassDivision::where('subject_id','=',$subjectId)
                                            ->where('teacher_id','=',$data['teacher']['id'])
                                            ->select('division_id')
                                            ->get()->toArray();
           $k=0;
            if(!Empty($divisionData))
                {
                    foreach($divisionData as $value){
                        $division['id'][$k]=$value['division_id'];
                        $k++;
                 }
               }
            $divisions=Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if(!Empty($divisions)){
              $divisionData=SubjectClassDivision::where('division_id','=',$divisions['id'])
                                                   ->where('subject_id','=',$subjectId)
                                                   ->select('division_id')
                                                   ->get()->toArray();
               if(!Empty($divisionData))
               {
                  foreach($divisionData as $value){
                        $division['id'][$k]=$value['division_id'];
                        $k++;
                       }
               }
            }
            $DivisionArray=array_unique($division['id'],SORT_REGULAR);
            $i=0;
            foreach ($DivisionArray  as $value)
            {
                $class_id=Division::where('id','=',$value)->select('divisions.class_id as class_id')->first();
                $className=Classes::where('id','=',$class_id['class_id'])->select('class_name as class_name', 'batch_id as batch_id')->first();
                if(!Empty($class_id)){
                    $Classes[$i]['id']=$class_id['class_id'];
                    $Classes[$i]['name']=$className['class_name'];
                    $Classes[$i]['batch_id']=$className['batch_id'];
                    $i++;
                }
            }
            $i=0;
            foreach($Classes as $row)
            {
                $batchName=Batch::where('id',$row['batch_id'])->first();
                $batchInfo[$i]['id'] = $batchName['id'];
                $batchInfo[$i]['name'] = $batchName['name'];
                $i++;
            }
            $status = 200;
            $message = "Successfully Listed";
      }catch (\Exception     $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
             "message" => $message,
              "status" => $status,
              "data" => $batchInfo
         ];
        return response($response, $status);
    }

   public function getBatchesClasses(Request $requests, $subjectId , $batch_id)
    {
        try{
            $data=$requests->all();
            $division=array();
            $finalClasses=array();
            $divisionData=SubjectClassDivision::where('subject_id','=',$subjectId)
                ->where('teacher_id','=',$data['teacher']['id'])
                ->select('division_id')
                ->get()->toArray();
            $k=0;
            if(!Empty($divisionData))
            {
                foreach($divisionData as $value){
                    $division['id'][$k]=$value['division_id'];
                    $k++;
                }
            }
            $divisions=Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if(!Empty($divisions)){
                $divisionData=SubjectClassDivision::where('division_id','=',$divisions['id'])
                    ->where('subject_id','=',$subjectId)
                    ->select('division_id')
                    ->get()->toArray();
                if(!Empty($divisionData))
                {
                    foreach($divisionData as $value){
                        $division['id'][$k]=$value['division_id'];
                        $k++;
                    }
                }
            }
            $DivisionArray=array_unique($division['id'],SORT_REGULAR);
            $i=0;
            foreach ($DivisionArray  as $value){
                $class_id=Division::where('id','=',$value)->select('divisions.class_id as class_id')->first();
                $className=Classes::where('id','=',$class_id['class_id'])
                                  ->where('batch_id','=',$batch_id)
                                  ->select('id','class_name as class_name')->first();
                if(!Empty($class_id)&&!Empty($className)){
                    $finalClasses[$i]['id']=$class_id['class_id'];
                    $finalClasses[$i]['name']=$className['class_name'];
                    $i++;
                    }
                }
                $status = 200;
                $message = "Successfully Listed";
       }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
              "message" => $message,
              "status" => $status,
              "data" => $finalClasses
         ];
        return response($response, $status);
    }

    public function getClassesDivision(Request $requests, $subjectId , $batch_id, $class_id)
    {
        try{
            $data=$requests->all();
            $division=array();
            $finalDivisions=array();
            $divisionData=SubjectClassDivision::where('subject_id','=',$subjectId)
                ->where('teacher_id','=',$data['teacher']['id'])
                ->select('division_id')
                ->get()->toArray();
            $k=0;
            if(!Empty($divisionData))
            {
                foreach($divisionData as $value){
                    $division['id'][$k]=$value['division_id'];
                    $k++;
                }
            }
            $divisions=Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if(!Empty($divisions)){
                $divisionData=SubjectClassDivision::where('division_id','=',$divisions['id'])
                    ->where('subject_id','=',$subjectId)
                    ->select('division_id')
                    ->get()->toArray();
                if(!Empty($divisionData))
                {
                    foreach($divisionData as $value){
                        $division['id'][$k]=$value['division_id'];
                        $k++;
                    }
                }
            }
            $DivisionArray=array_unique($division['id'],SORT_REGULAR);
            $i=0;
           foreach($DivisionArray as $division_id){
               $finalData=Division::join('classes','divisions.class_id', '=', 'classes.id')
                     ->where('divisions.class_id','=',$class_id)
                     ->where('classes.batch_id','=',$batch_id)
                     ->where('divisions.id','=',$division_id)
                     ->select('divisions.id as id','divisions.division_name as name')
                      ->first();
               if(!Empty($finalData)){
                   $finalDivisions[$i]=$finalData;
                   $i++;
               }
           }
            $status = 200;
            $message = "Successfully Listed";
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $finalDivisions
        ];
        return response($response, $status);
    }
    public function getDivisionsStudents(Request $request)
    {
        $finalStudentsList=array();
        try{
            $i=0;
            foreach($request->division as $value)
            {
                $student_role = UserRoles::whereIn('slug', ['student'])->pluck('id');
                $student = User::where('role_id',$student_role)->where('division_id',$value)->get()->toArray();
                foreach($student as $value){
                    $finalStudentsList[$value['division_id']][$i]['id'] = $value['id'];
                    $finalStudentsList[$value['division_id']][$i]['name'] = $value['first_name']." ".$value['last_name'];
                    $i++;
                }
                $i=0;
            }
            $status = 200;
            $message = "Successfully listed";
        } catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "data"=>$finalStudentsList
        ];
        return response($response, $status);
    }

    public function getHomeworkType(Request $request)
    {
        try{
        $homework_type = HomeworkType::select('id', 'title')->get()->toArray();
        $status = 200;
        $message = "Successfully Listed";
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
                "message" => $message,
                "status"=>  $status,
                "data"=>$homework_type

        ];
        return response($response, $status);
    }
    public function createHomework(Requests\HomeworkRequest $request)
    {
        try{
            $data=$request->all();
            Log::info('your data.', ['all data' => $data]);
            $data=array();
            $HomeworkTeacher=array();
            $division=Division::where('id',$request->division_id)->first();
            $teacher_id =User::where('remember_token',$request->token)->first();
            $homework_type=HomeworkType::where('id',$request->homework_type)->first();
            $subject =Subject::where('id',$request->subject_id)->first();
            $data['title']=$request->title;
            $data['description']=$request->description;
            $data['homework_type_id']= $homework_type['id'];
            $data['due_date']=$request->due_date;
            $data['subject_id']=$subject['id'];
            $data['homework_timestamp']=Carbon::now();
            if($request->hasFile('attachment_file')){
                $attachment_file = $request->file('attachment_file');
                $name = $request->file('attachment_file')->getClientOriginalName();
                $filename = time()."_".$name;
                $path = public_path('uploads/homework/');
                if (!file_exists($path)) {
                    \Illuminate\Support\Facades\File::makeDirectory('uploads/homework/', $mode = 0777, true,true);
                }
                $attachment_file->move($path,$filename);
            }
            else{
                $filename=null;
            }
            $data['status']=0;//by default homework will be 0 for draft
            $data['is_active']=1;//0 is for delete  so by default Homework is not deleted
            $data['created_at']= Carbon::now();
            $data['updated_at']= Carbon::now();
            $homework_id=Homework::insertGetId($data);
            if($homework_id != null)
            {
                foreach($request->student_id as $val)
                {
                    $HomeworkTeacher['student_id'] = $val;
                    $HomeworkTeacher['teacher_id'] = $teacher_id['id'];
                    $HomeworkTeacher['homework_id'] = $homework_id;
                    $HomeworkTeacher['division_id'] = $division['id'];
                    $HomeworkTeacher['created_at']= Carbon::now();
                    $HomeworkTeacher['updated_at']= Carbon::now();
                    HomeworkTeacher::insert($HomeworkTeacher);
                }
                $status = 200;
                $message = "Homework Created Successfully";
            }
         }
      catch (\Exception $e) {
          $status = 500;
          $message = "Something went wrong";
      }
        $response = [
            "status" =>$status,
            "message" => $message
          ];

        return response($response, $status);
    }

    public function updateHomework(Requests\HomeworkRequest $request)
    {
        try{
            $data=array();
            $HomeworkTeacher=array();
            $homework_id= Homework::where('id',$request->homework_id)->
                                      where('status',0)->first();
            if($homework_id!=null){
                $batch=Batch::where('id',$request->batch_id)->first();
                $class=Classes::where('id',$request->class_id)->first();
                $division=Division::where('id',$request->division_id)->first();
                $teacher_id =User::where('remember_token',$request->token)->first();
                $homework_type=HomeworkType::where('id',$request->homework_type)->first();
                $subject =Subject::where('id',$request->subject_id)->first();
                unset($request->_method);
                $data['title']=$request->title;
                $data['description']=$request->description;
                $data['homework_type_id']= $homework_type['id'];
                $data['due_date']=$request->due_date;
                $data['subject_id']=$subject['id'];
                $data['homework_timestamp']=Carbon::now();
                if($request->hasFile('attachment_file')){
                    $attachment_file = $request->file('attachment_file');
                    $name = $request->file('attachment_file')->getClientOriginalName();
                    $filename = time()."_".$name;
                    $path = public_path('uploads/homework/');
                    if (!file_exists($path)) {
                        \Illuminate\Support\Facades\File::makeDirectory('uploads/homework/', $mode = 0777, true,true);
                    }
                    $attachment_file->move($path,$filename);
                }
                else{
                    $filename=null;
                }
                $data['attachment_file']=$filename;
                $data['created_at']= Carbon::now();
                $data['updated_at']= Carbon::now();
                $homework_id= Homework::where('id',$request->homework_id)->update($data);
                if($homework_id != null)
                {
                    HomeworkTeacher::where('homework_id',$request->homework_id)->delete();
                    foreach($request->student as $val)
                    {
                        $HomeworkTeacher['student_id'] = $val;
                        $HomeworkTeacher['teacher_id'] = $teacher_id['id'];
                        $HomeworkTeacher['homework_id'] = $request->homework_id;
                        $HomeworkTeacher['division_id'] = $division['id'];
                        $HomeworkTeacher['created_at']= Carbon::now();
                        $HomeworkTeacher['updated_at']= Carbon::now();
                        HomeworkTeacher::insert($HomeworkTeacher);
                    }
                    $status = 200;
                    $message = "Homework Updated successfully";
                }
               }
            else{
                $status = 202;
                $message = "Homework not found";
            }
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
                 "message" => $message,
                 "status" =>$status
        ];

        return response($response, $status);
    }

    public function publishHomeWork(Requests\PublishRequest $request)
    {
        try{
            $homework_id= Homework::where('id',$request->homework_id)->update(array('status'=>1));
            $status = 200;
            $message = "Homework Published";
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "status"=>$status,
            "message" => $message
        ];
        return response($response, $status);
    }
    public function viewHomeWork(Requests\HomeworkRequest $request)
    {
        try{
            $finalHomeworkListingSubjectTeacher=array();
             $data=$request->all();
             $division=Division::where('class_teacher_id',$data['teacher']['id'])->first();
             if($division != null){
                $HomeworkListingClassTeacher=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                         ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                         ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                         ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                         ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                         ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                         ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                         ->Join('users as teacher' ,'homework_teacher.teacher_id', '=', 'teacher.id')
                         ->where('homework_teacher.division_id','=',$division['id'])
                         ->where('homeworks.status','=',1)//1 is for published homework
                         ->where('homeworks.is_active','=',1)//0 is for deleted homework
                         ->groupBy('homework_teacher.homework_id')
                         ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id','teacher.first_name as teacher_name')
                         ->get();
                 $divisionSubjects=SubjectClassDivision::where('teacher_id',$data['teacher']['id'])
                     ->join('subjects','division_subjects.subject_id','=','subjects.id')
                     ->select('subjects.id as subject_id','division_id')
                     ->get();
                 if($divisionSubjects!=null){
                     foreach($divisionSubjects as $value){
                         $HomeworkListingSubjectTeacher=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                             ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                             ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                             ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                             ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                             ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                             ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                             ->Join('users as teacher' ,'homework_teacher.teacher_id', '=', 'teacher.id')
                             ->where('homeworks.subject_id','=',$value['subject_id'])
                             ->where('homework_teacher.division_id','=',$value['division_id'])
                             ->where('homeworks.status','=',1)//1 is for published homework
                             ->where('homeworks.is_active','=',1)//0 is for deleted homework
                             ->groupBy('homework_teacher.homework_id')
                             ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id','teacher.first_name as teacher_name')
                             ->get();
                 }
           }
            $flag=0;
          $count=count($HomeworkListingClassTeacher);
              foreach($HomeworkListingClassTeacher as $classTeacherValue){
                  $homework_id=$classTeacherValue['homework_id'];
                        foreach($HomeworkListingSubjectTeacher as $subjectTeacherValue){
                             if($subjectTeacherValue['homework_id']==$homework_id){
                                $flag=1;
                            }
                    }
              if($flag==0)
              {
                  $HomeworkListingSubjectTeacher[$count+1]=$classTeacherValue;
                  $count++;
              }
          }

             $status=200;
             $message = "Successfully Listed";
        }

     else{
            $divisionSubjects=SubjectClassDivision::where('teacher_id',$data['teacher']['id'])
                ->join('subjects','division_subjects.subject_id','=','subjects.id')
                ->select('subjects.id as subject_id','division_id')
                ->get();
            if($divisionSubjects!=null){
                foreach($divisionSubjects as $value){
                    $HomeworkListingSubjectTeacher=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                        ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                        ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                        ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                        ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                        ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                        ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                        ->Join('users as teacher' ,'homework_teacher.teacher_id', '=', 'teacher.id')
                        ->where('homeworks.subject_id','=',$value['subject_id'])
                        ->where('homework_teacher.division_id','=',$value['division_id'])
                        ->where('homeworks.status','=',1)//1 is for published homework
                        ->where('homeworks.is_active','=',1)//0 is for deleted homework
                        ->groupBy('homework_teacher.homework_id')
                        ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id','teacher.first_name as teacher_name')
                        ->get();
                  }
                }else{
                $HomeworkListingSubjectTeacher=[];
              }
             }
            $i=0;
            foreach($HomeworkListingSubjectTeacher as $value){
                $finalHomeworkListingSubjectTeacher[$i]['homework_id']=$value['homework_id'];
                $finalHomeworkListingSubjectTeacher[$i]['homeworkTitle']=$value['homeworkTitle'];
                $finalHomeworkListingSubjectTeacher[$i]['description']=$value['description'];
                $finalHomeworkListingSubjectTeacher[$i]['due_date']=date("M j, g:i a",strtotime( $value['due_date']));
                $finalHomeworkListingSubjectTeacher[$i]['attachment_file']=$value['attachment_file'];
                $teacherName=User::where('id',$value['teacher_id'])->select('first_name','last_name')->first();
                $finalHomeworkListingSubjectTeacher[$i]['teacher_id']=$value['teacher_id'];
                $finalHomeworkListingSubjectTeacher[$i]['teacher_name']=$teacherName['first_name']." ".$teacherName['last_name'];
                $finalHomeworkListingSubjectTeacher[$i]['homeworkType']=ucfirst($value['homeworkType']);
                $finalHomeworkListingSubjectTeacher[$i]['homeworkTypeId']=$value['id'];
                $finalHomeworkListingSubjectTeacher[$i]['subjectName']=ucfirst($value['subjectName']);
                $finalHomeworkListingSubjectTeacher[$i]['subject_id']=$value['subject_id'];
                $finalHomeworkListingSubjectTeacher[$i]['status']=$value['status'];
                $finalHomeworkListingSubjectTeacher[$i]['class_id']=$value['class_id'];
                $finalHomeworkListingSubjectTeacher[$i]['class_name']=$value['class_name'];
                $finalHomeworkListingSubjectTeacher[$i]['division_id']=$value['division_id'];
                $finalHomeworkListingSubjectTeacher[$i]['division_name']=$value['division_name'];
                $finalHomeworkListingSubjectTeacher[$i]['batch_name']=$value['batch_name'];
                $finalHomeworkListingSubjectTeacher[$i]['batch_id']=$value['batch_id'];
                $finalHomeworkListingSubjectTeacher[$i]['created_at']=date("M j, g:i a",strtotime( $value['created_at']));
                $studentList=HomeworkTeacher::where('homework_id','=',$value['homework_id'])->select('student_id')->get();
                $j=0;
                foreach($studentList as $value)
                {
                    $studentsData=User::where('id',$value['student_id'])->select('first_name','last_name')->first();
                    $finalHomeworkListingSubjectTeacher[$i]['studentList'][$j]['id']=$value['student_id'];
                    $finalHomeworkListingSubjectTeacher[$i]['studentList'][$j]['name']=$studentsData['first_name']." ".$studentsData['last_name'];
                    $j++;
                }
                $i++;
            }
             $status=200;
             $message = "Successfully Listed";
         }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong" .  $e->getMessage();
        }
        $response = [
             "message" => $message,
            "status" => $status,
             "data" =>$finalHomeworkListingSubjectTeacher
              ];
        return response($response, $status);
    }
    public function viewDetailHomeWork(Requests\HomeworkRequest $request,$homeWork_id)
    {
        try{
            $finalHomeworkListing=array();
            $status = 200;
            $message = "Successfully Listed";
            $homeworkDetails=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                ->Join('users as teacher' ,'homework_teacher.teacher_id', '=', 'teacher.id')
                ->where('homeworks.id','=',$homeWork_id)
                ->groupBy('homework_teacher.homework_id')
                ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id','teacher.first_name as teacher_name')
                ->first();

            if($homeworkDetails != null){
                $finalHomeworkListing['homework_id']=$homeworkDetails['homework_id'];
                $finalHomeworkListing['homeworkTitle']=$homeworkDetails['homeworkTitle'];
                $finalHomeworkListing['description']=$homeworkDetails['description'];
                $finalHomeworkListing['due_date']=date("M j, g:i a",strtotime( $homeworkDetails['due_date']));
                $finalHomeworkListing['attachment_file']=$homeworkDetails['attachment_file'];
                $teacherName=User::where('id',$homeworkDetails['teacher_id'])->select('first_name','last_name')->first();
                $finalHomeworkListing['teacher_id']=$homeworkDetails['teacher_id'];
                $finalHomeworkListing['teacher_name']=$teacherName['first_name']." ".$teacherName['last_name'];
                $finalHomeworkListing['homeworkType']=ucfirst($homeworkDetails['homeworkType']);
                $finalHomeworkListing['homeworkTypeId']=$homeworkDetails['id'];
                $finalHomeworkListing['subjectName']=ucfirst($homeworkDetails['subjectName']);
                $finalHomeworkListing['subject_id']=$homeworkDetails['subject_id'];
                $finalHomeworkListing['status']=$homeworkDetails['status'];
                $finalHomeworkListing['class_id']=$homeworkDetails['class_id'];
                $finalHomeworkListing['class_name']=$homeworkDetails['class_name'];
                $finalHomeworkListing['division_id']=$homeworkDetails['division_id'];
                $finalHomeworkListing['division_name']=$homeworkDetails['division_name'];
                $finalHomeworkListing['batch_name']=$homeworkDetails['batch_name'];
                $finalHomeworkListing['batch_id']=$homeworkDetails['batch_id'];
                $finalHomeworkListing['created_at']=date("M j, g:i a",strtotime( $homeworkDetails['created_at']));
                $studentList=HomeworkTeacher::where('homework_id','=',$homeworkDetails['homework_id'])->select('student_id')->get();
                $j=0;
                foreach($studentList as $value)
                {
                    $studentsData=User::where('id',$value['student_id'])->select('first_name','last_name')->first();
                    $finalHomeworkListing['studentList'][$j]['id']=$value['student_id'];
                    $finalHomeworkListing['studentList'][$j]['name']=$studentsData['first_name']." ".$studentsData['last_name'];
                    $j++;
                }
            }
            else{
                $status = 202;
                $message = "homework not found";
            }
       }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"data" =>$finalHomeworkListing];
        return response($response, $status);
    }

    public function viewUnpublishedHomeWork(Requests\HomeworkRequest $request)
    {
        try
         {
             $finalHomeworkListingSubjectTeacher=array();
             $HomeworkListingSubjectTeacher=array();
             $data=$request->all();
             $division=Division::where('class_teacher_id',$data['teacher']['id'])->first();
             if($division != null){
                $HomeworkListingClassTeacher=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                         ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                         ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                         ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                         ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                         ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                         ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                         ->where('homework_teacher.division_id','=',$division['id'])
                         ->where('homeworks.status','=',0)
                         ->where('homeworks.is_active','=',1)//0 is for deleted homework
                         ->groupBy('homework_teacher.homework_id')
                         ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id')
                         ->get();
                 $divisionSubjects=SubjectClassDivision::where('teacher_id',$data['teacher']['id'])
                     ->join('subjects','division_subjects.subject_id','=','subjects.id')
                     ->select('subjects.id as subject_id','division_id')
                     ->get();
                 if($divisionSubjects!=null){
                     foreach($divisionSubjects as $value){
                         $HomeworkListingSubjectTeacher=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                             ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                             ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                             ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                             ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                             ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                             ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                             ->where('homeworks.subject_id','=',$value['subject_id'])
                             ->where('homework_teacher.division_id','=',$value['division_id'])
                             ->where('homeworks.status','=',0)//0 is for unpublished homework
                             ->where('homeworks.is_active','=',1)//0 is for deleted homework
                             ->groupBy('homework_teacher.homework_id')
                             ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id')
                             ->get();
                 }
           }
            $flag=0;
          $count=count($HomeworkListingClassTeacher);
              foreach($HomeworkListingClassTeacher as $classTeacherValue){
                  $homework_id=$classTeacherValue['homework_id'];
                        foreach($HomeworkListingSubjectTeacher as $subjectTeacherValue){
                             if($subjectTeacherValue['homework_id']==$homework_id){
                                $flag=1;
                            }
                    }
              if($flag==0)
              {
                  $HomeworkListingSubjectTeacher[$count+1]=$classTeacherValue;
                  $count++;
              }
          }
             $status=200;
             $message = "Successfully Listed";
        }
     else{
            $divisionSubjects=SubjectClassDivision::where('teacher_id',$data['teacher']['id'])
                ->join('subjects','division_subjects.subject_id','=','subjects.id')
                ->select('subjects.id as subject_id','division_id')
                ->get();
            if($divisionSubjects!=null){
                foreach($divisionSubjects as $value){
                    $HomeworkListingSubjectTeacher=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                        ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                        ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                        ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                        ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                        ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                        ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                        ->where('homeworks.subject_id','=',$value['subject_id'])
                        ->where('homework_teacher.division_id','=',$value['division_id'])
                        ->where('homeworks.status','=',0) //0 is for unpublished homework
                        ->where('homeworks.is_active','=',1)//0 is for deleted homework
                        ->groupBy('homework_teacher.homework_id')
                        ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id')
                        ->get();
                  }
                }else{
                $HomeworkListingSubjectTeacher=[];
              }
             }
             $i=0;
             foreach($HomeworkListingSubjectTeacher as $value){
                 $finalHomeworkListingSubjectTeacher[$i]['homework_id']=$value['homework_id'];
                 $finalHomeworkListingSubjectTeacher[$i]['homeworkTitle']=$value['homeworkTitle'];
                 $finalHomeworkListingSubjectTeacher[$i]['description']=$value['description'];
                 $finalHomeworkListingSubjectTeacher[$i]['due_date']=date("M j, g:i a",strtotime( $value['due_date']));
                 $finalHomeworkListingSubjectTeacher[$i]['attachment_file']=$value['attachment_file'];
                 $teacherName=User::where('id',$value['teacher_id'])->select('first_name','last_name')->first();
                 $finalHomeworkListingSubjectTeacher[$i]['teacher_id']=$value['teacher_id'];
                 $finalHomeworkListingSubjectTeacher[$i]['teacher_name']=$teacherName['first_name']." ".$teacherName['last_name'];
                 $finalHomeworkListingSubjectTeacher[$i]['homeworkType']=ucfirst($value['homeworkType']);
                 $finalHomeworkListingSubjectTeacher[$i]['homeworkTypeId']=$value['id'];
                 $finalHomeworkListingSubjectTeacher[$i]['subjectName']=ucfirst($value['subjectName']);
                 $finalHomeworkListingSubjectTeacher[$i]['subject_id']=$value['subject_id'];
                 $finalHomeworkListingSubjectTeacher[$i]['status']=$value['status'];
                 $finalHomeworkListingSubjectTeacher[$i]['class_id']=$value['class_id'];
                 $finalHomeworkListingSubjectTeacher[$i]['class_name']=$value['class_name'];
                 $finalHomeworkListingSubjectTeacher[$i]['division_id']=$value['division_id'];
                 $finalHomeworkListingSubjectTeacher[$i]['division_name']=$value['division_name'];
                 $finalHomeworkListingSubjectTeacher[$i]['batch_name']=$value['batch_name'];
                 $finalHomeworkListingSubjectTeacher[$i]['batch_id']=$value['batch_id'];
                 $finalHomeworkListingSubjectTeacher[$i]['created_at']=date("M j, g:i a",strtotime( $value['created_at']));
                 $studentList=HomeworkTeacher::where('homework_id','=',$value['homework_id'])->select('student_id')->get();
                 $j=0;
                 foreach($studentList as $value)
                 {
                     $studentsData=User::where('id',$value['student_id'])->select('first_name','last_name')->first();
                     $finalHomeworkListingSubjectTeacher[$i]['studentList'][$j]['id']=$value['student_id'];
                     $finalHomeworkListingSubjectTeacher[$i]['studentList'][$j]['name']=$studentsData['first_name']." ".$studentsData['last_name'];
                     $j++;
                 }
                 $i++;
             }
             $status=200;
             $message = "Successfully Listed";
         }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong" .  $e->getMessage();
        }
        $response = [
             "message" => $message,
             "status" => $status,
             "data" =>$finalHomeworkListingSubjectTeacher
              ];
        return response($response, $status);
    }
  public function deleteHomework(Requests\deleteHomeworkRequest $request,$homework_id)
  {
     try{
         $homework_status=Homework::where('id','=',$homework_id)->select('status')->first();
        if($homework_status['status']==0)
        {
            Homework::where('id',$homework_id)->update(array('is_active'=>0)); // 0 is for deleted
            $status = 200;
            $message = "Homework Successfully deleted";
        }else{
            $status = 202;
            $message = "This homework can not delete";
        }
     }catch (\Exception $e) {
        $status = 500;
        $message = "Something went wrong";
    }
        $response = [
            "message" => $message,
            "status" => $status
      ];
        return response($response, $status);
  }
  public function viewHomeworkParent(Requests\HomeworkRequest $request,$student_id)
  {
      $data=array();
    try{
        $status = 200;
        $message = "Homework successfully Listed";
        $userToken=$request->all();
        $userId='';
        foreach($userToken as $userData)
        {
             $userId=$userData;
        }
        $studentData=User::where('parent_id',$userId->id)->get();
        $studentId=array();
        foreach($studentData as $value)
        {
            $studentId[]=$value->id;
        }
        if(in_array($student_id,$studentId))
        {
            $studentHomework=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                ->where('homework_teacher.student_id','=',$student_id)
                ->where('homeworks.status','=',1)//parent ca n see published homework ony
                ->where('homeworks.is_active','=',1)//0 is for deleted homework
                ->select('homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','first_name','last_name','users.id as userId','subjects.slug as subjectName','homeworks.status','divisions.division_name','classes.class_name','batches.name')
                ->get();
            $i=0;
            if($studentHomework != null){
                foreach($studentHomework as $value)
                {
                    $userId=$value['userId'];
                    $data[$i]['title']=$value['homeworkTitle'];
                    $data[$i]['description']=$value['description'];
                    $data[$i]['due_date']=date("M j",strtotime($value['due_date']));
                    $data[$i]['created_At']=date("M j",strtotime($value['created_At']));
                    $data[$i]['attachment_file']=$value['attachment_file'];
                    $data[$i]['homeworkType']=$value['homeworkType'];
                    $teacherName=User::where('id','=',$value['teacher_id'])->first();
                    $data[$i]['teacher_name']=$teacherName['first_name']."  ".$teacherName['last_name'];
                    $data[$i]['subject_name']=ucfirst($value['subjectName']);
                    $data[$i]['division_name']=ucfirst($value['division_name']);
                    $data[$i]['batch_name']=ucfirst($value['name']);
                    $data[$i]['class_name']=ucfirst($value['class_name']);
                    $i++;
                }

            }
            else{
                $status = 202;
                $message = "No Homework not found for this user";
            }
        }
        else{
            $status = 202;
            $message = "Student not found";
        }
    }catch (\Exception $e) {
        $status = 500;
        $message = "Something went wrong";
    }
      $response = ["message" => $message,"status" =>$status,"data" =>$data];
      return response($response, $status);
  }
}