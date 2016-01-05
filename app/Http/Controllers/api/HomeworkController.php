<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\Division;
use App\Homework;
use App\HomeworkTeacher;
use App\HomeworkType;
use App\Subject;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeworkController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    public function createHomework(Requests\HomeworkRequest $request)
    {
      try{
            $data=array();
            $HomeworkTeacher=array();
            $batch=Batch::where('id',$request->batch_id)->first();
            $class=Classes::where('id',$request->class_id)->first();
            $division=Division::where('id',$request->division_id)->first();
            $techer_id =User::where('remember_token',$request->token)->first();
            $homework_type=HomeworkType::where('id',$request->homework_type)->first();
            $subject =Subject::where('id',$request->subject_id)->first();
            $data['title']=$request->title;
            $data['description']=$request->description;
            $data['homework_type_id']= $homework_type['id'];
            $data['due_date']=$request->due_date;
            $data['subject_id']=$subject['id'];
            $data['attachment_file']=$request->attachment_file;
            $data['created_at']= Carbon::now();
            $data['updated_at']= Carbon::now();

            $homework_id=Homework::insertGetId($data);

            if($homework_id != null)
            {
                foreach($request->student as $val)
                {
                    $HomeworkTeacher['student_id'] = $val;
                    $HomeworkTeacher['teacher_id'] = $techer_id['id'];
                    $HomeworkTeacher['homework_id'] = $homework_id;
                    $HomeworkTeacher['division_id'] = $division['id'];
                    $HomeworkTeacher['created_at']= Carbon::now();
                    $HomeworkTeacher['updated_at']= Carbon::now();
                    HomeworkTeacher::insert($HomeworkTeacher);

                }
                $status = 200;
                $message = "saved successfully";
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
        $response = ["message" => $message];

        return response($response, $status);
    }

    public function updateHomework(Requests\HomeworkRequest $request)
    {
        try{
            $data=array();
            $HomeworkTeacher=array();
            $batch=Batch::where('id',$request->batch_id)->first();
            $class=Classes::where('id',$request->class_id)->first();
            $division=Division::where('id',$request->division_id)->first();
            $techer_id =User::where('remember_token',$request->token)->first();
            $homework_type=HomeworkType::where('id',$request->homework_type)->first();
            $subject =Subject::where('id',$request->subject_id)->first();
            unset($request->_method);
            $data['title']=$request->title;
            $data['description']=$request->description;
            $data['homework_type_id']= $homework_type['id'];
            $data['due_date']=$request->due_date;
            $data['subject_id']=$subject['id'];
            $data['attachment_file']=$request->attachment_file;
            $data['created_at']= Carbon::now();
            $data['updated_at']= Carbon::now();

            $homework_id= Homework::where('id',$request->homework_id)->
                                    where('status',0)->update($data);
            if($homework_id != null)
            {
                HomeworkTeacher::where('homework_id',$request->homework_id)->delete();
                foreach($request->student as $val)
                {
                    $HomeworkTeacher['student_id'] = $val;
                    $HomeworkTeacher['teacher_id'] = $techer_id['id'];
                    $HomeworkTeacher['homework_id'] = $request->homework_id;
                    $HomeworkTeacher['division_id'] = $division['id'];
                    $HomeworkTeacher['created_at']= Carbon::now();
                    $HomeworkTeacher['updated_at']= Carbon::now();
                    HomeworkTeacher::insert($HomeworkTeacher);
                }
                $status = 200;
                $message = "saved successfully";
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
        $response = ["message" => $message];

        return response($response, $status);
    }

    public function viewHomeWork(Requests\HomeworkRequest $request,$page_id)
    {   $str=array();
        $data=array();
        try
        {
            $messageCount = $page_id * 2;
            $user =User::where('remember_token',$request->token)->first();
            $val1=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                ->where('homework_teacher.teacher_id','=',$user->id)
                ->where('homeworks.status','=',0)
                ->orWhere('homeworks.status', '=', 1)
                ->select('homeworks.title as homeworkTitle','description','due_date','attachment_file','homework_types.slug as homeworkType','first_name','last_name','users.id as userId','subjects.slug as subjectName','homeworks.status','divisions.division_name','classes.class_name')
                ->skip($messageCount)->take(2)
                ->get();

            $i=0;
        if($val1 != null){
            foreach($val1 as $value)
            {
                $title=$value['homeworkTitle'];
                $userId=$value['userId'];
                $str[$title]['description']=$value['description'];
                $str[$title]['status']=$value['status'];
                $str[$title]['due_date']=$value['due_date'];
                $str[$title]['attachment_file']=$value['attachment_file'];
                $str[$title]['homeworkType']=$value['homeworkType'];
                $str[$title]['subjectName']=$value['subjectName'];
                $str[$title]['division_name']=$value['division_name'];
                $str[$title]['class_name']=$value['class_name'];
                $str[$title]['studentList'][$userId]=$value['first_name'].''.$value['last_name'];
                $i++;
            }
            $data=$str;
            $status = 200;
            $message = "successfully";
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
        $response = ["message" => $message,"data" =>$data];

        return response($response, $status);

    }

    public function viewPublishHomeWork(Requests\HomeworkRequest $request,$page_id)
    {   $str=array();
        $data=array();
        $strArr=array();
        try{
            $messageCount = $page_id * 2;
            $status = 200;
            $message = "successfully";
            $user =User::where('remember_token',$request->token)->first();
            $homeworkTeacher=HomeworkTeacher::where('teacher_id',$user->id)->get();
            $homeworkTeacherArray=$homeworkTeacher->toArray();
            foreach($homeworkTeacherArray as $val)
            {
                $div[]=$val['division_id'];
            }
            $division=Division::wherein('id',$div)->get();

        foreach($division as $value)
            {
                $divArray[]=$value['class_teacher_id'];

            }

        if(in_array($user->id, $divArray))
        {

                $val2=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                ->where('divisions.class_teacher_id','=',$user->id)
                ->where('homeworks.status','=',2)
                ->select('homeworks.title as homeworkTitle','description','due_date','attachment_file','homework_types.slug as homeworkType','first_name','last_name','users.id as userId','subjects.slug as subjectName','homeworks.status','divisions.division_name','classes.class_name')
                ->skip($messageCount)->take(2)
                ->get();
            $i=0;
            if($val2 != null){
                foreach($val2 as $value)
                {

                    $title=$value['homeworkTitle'];
                    $userId=$value['userId'];
                    $strArr[$title]['description']=$value['description'];
                    $strArr[$title]['status']=$value['status'];
                    $strArr[$title]['due_date']=$value['due_date'];
                    $strArr[$title]['attachment_file']=$value['attachment_file'];
                    $strArr[$title]['homeworkType']=$value['homeworkType'];
                    $strArr[$title]['subjectName']=$value['subjectName'];
                    $strArr[$title]['division_name']=$value['division_name'];
                    $strArr[$title]['class_name']=$value['class_name'];
                    $strArr[$title]['studentList'][$userId]=$value['first_name'].''.$value['last_name'];
                    $i++;
                }
                $data=$strArr;
            }
            else{
                $status = 202;
                $message = "homework not found";
            }
        }
        else{
            $val1=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                ->where('homework_teacher.teacher_id','=',$user->id)
                ->where('homeworks.status','=',2)
                ->select('homeworks.title as homeworkTitle','description','due_date','attachment_file','homework_types.slug as homeworkType','first_name','last_name','users.id as userId','subjects.slug as subjectName','homeworks.status','divisions.division_name','classes.class_name')
                ->skip($messageCount)->take(2)
                ->get();
            $i=0;
            if($val1 != null){
                foreach($val1 as $value)
                {
                    $title=$value['homeworkTitle'];
                    $userId=$value['userId'];
                    $str[$title]['description']=$value['description'];
                    $str[$title]['status']=$value['status'];
                    $str[$title]['due_date']=$value['due_date'];
                    $str[$title]['attachment_file']=$value['attachment_file'];
                    $str[$title]['homeworkType']=$value['homeworkType'];
                    $str[$title]['subjectName']=$value['subjectName'];
                    $str[$title]['division_name']=$value['division_name'];
                    $str[$title]['class_name']=$value['class_name'];
                    $str[$title]['studentList'][$userId]=$value['first_name'].''.$value['last_name'];
                    $i++;
                }
                $data=$str;
            }
            else{
                $status = 202;
                $message = "homework not found";
            }
        }
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"data" =>$data];

        return response($response, $status);
    }

    public function viewDetailHomeWork(Requests\HomeworkRequest $request,$homeWork_id)
    {   $data=array();
       try{
           $status = 200;
           $message = "successfully";
              $val1=HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
               ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
               ->Join('classes', 'divisions.class_id', '=', 'classes.id')
               ->Join('batches', 'classes.batch_id', '=', 'batches.id')
               ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
               ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
               ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
               ->where('homework_teacher.homework_id','=',$homeWork_id)
               ->where('homeworks.status','=',2)
               ->select('homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','homework_types.slug as homeworkType','first_name','last_name','users.id as userId','subjects.slug as subjectName','homeworks.status','divisions.division_name','classes.class_name','batches.name as batch')
               ->get();
                $i=0;
                if($val1 != null){
                    foreach($val1 as $value)
                    {
                        $title=$value['homeworkTitle'];
                        $userId=$value['userId'];
                        $str[$title]['description']=$value['description'];
                        $str[$title]['status']=$value['status'];
                        $str[$title]['due_date']=$value['due_date'];
                        $str[$title]['attachment_file']=$value['attachment_file'];
                        $str[$title]['homeworkType']=$value['homeworkType'];
                        $str[$title]['teacher']=$value['teacher'];
                        $str[$title]['subjectName']=$value['subjectName'];
                        $str[$title]['division_name']=$value['division_name'];
                        $str[$title]['batch']=$value['batch'];
                        $str[$title]['class_name']=$value['class_name'];
                        $str[$title]['studentList'][$userId]=$value['first_name'].''.$value['last_name'];
                        $i++;
                    }
                    $data=$str;
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
        $response = ["message" => $message,"data" =>$data];

        return response($response, $status);


    }

    public function publishHomeWork(Requests\PublishRequest $request)
    {
     try{
        $data=array();
        $userToken=$request->all();
        $userId='';
        foreach($userToken as $userData)
        {
            $userId=$userData;
        }
        $val1=User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
            ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
            ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
            ->where('users.remember_token','=',$userId)
            ->select('users.id','acl_master.title as acl','modules.slug as module_slug')
            ->get();
        $resultArr=array();
        foreach($val1 as $val)
        {
            array_push($resultArr,$val->acl.'_'.$val->module_slug);

        }
        unset($request->_method);

        if(in_array('Publish_homework',$resultArr) ){

            $homework_id= Homework::where('id',$request->homework_id)->update(array('status'=>2));
            $status = 200;
            $message = "homework published";
        }
        elseif (in_array('Create_homework',$resultArr)){
            $homework_id= Homework::where('id',$request->homework_id)->update(array('status'=>1));
            $status = 200;
            $message = "homework request for publish";
        }
        else{
            $status = 401;
            $message = "unauthorised ";
        }
     }
     catch (\Exception $e) {
         $status = 500;
         $message = "Something went wrong";
     }
        $response = ["message" => $message];
        return response($response, $status);
    }


  public function deleteHomework(Requests\deleteHomeworkRequest $request,$homework_id)
  {
     try{
         Homework::where('id',$homework_id)->where('status',0)->update(array('is_active'=>0));
         $status = 200;
         $message = "homework deleted";
     }catch (\Exception $e) {
        $status = 500;
        $message = "Something went wrong";
    }
        $response = ["message" => $message];
        return response($response, $status);
  }
  public function viewHomeworkParent(Requests\HomeworkRequest $request,$student_id)
  {
      $data=array();
    try{
        $status = 200;
        $message = "homework successfully";
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
                  ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                  ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                  ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                  ->where('homework_teacher.student_id','=',$student_id)
                  ->where('homework_teacher.student_id','=',$student_id)
                  ->where('homeworks.status','=',2)
                  ->select('homeworks.title as homeworkTitle','description','due_date','attachment_file','homework_types.slug as homeworkType','first_name','last_name','users.id as userId','subjects.slug as subjectName','homeworks.status','divisions.division_name','classes.class_name')
                  ->get();
            $i=0;
            if($studentHomework != null){
                foreach($studentHomework as $value)
                {
                    $title=$value['homeworkTitle'];
                    $userId=$value['userId'];
                    $data[$title]['description']=$value['description'];
                    $data[$title]['status']=$value['status'];
                    $data[$title]['due_date']=$value['due_date'];
                    $data[$title]['attachment_file']=$value['attachment_file'];
                    $data[$title]['homeworkType']=$value['homeworkType'];
                    $data[$title]['teacher']=$value['teacher'];
                    $data[$title]['subjectName']=$value['subjectName'];
                    $data[$title]['division_name']=$value['division_name'];
                    $data[$title]['batch']=$value['batch'];
                    $data[$title]['class_name']=$value['class_name'];
                    $data[$title]['student'][$userId]=$value['first_name'].''.$value['last_name'];
                    $i++;
                }

            }
            else{
                $status = 202;
                $message = "homework not found";
            }
        }
        else{
            $status = 202;
            $message = "student not found";
        }
    }catch (\Exception $e) {
        $status = 500;
        $message = "Something went wrong";
    }
      $response = ["message" => $message,"status" =>$status,"data" =>$data];
      return response($response, $status);
  }

}
