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

    public function viewHomeWork(Requests\HomeworkRequest $request)
    {
        $user =User::where('remember_token',$request->token)->first();

        $homeworkTeacher=HomeworkTeacher::where('teacher_id',$user->id)->get();
        $homeworkTeacherArray=$homeworkTeacher->toArray();
        //dd($homeworkTeacherArray);
        foreach($homeworkTeacherArray as $val)
        {
            $homeworkIdArray[]=$val['homework_id'];
            $div[]=$val['division_id'];
        }
        $homework=Homework::wherein('id',$homeworkIdArray)->get();
        $division=Division::wherein('id',$div)->get();
        foreach($homework as $value)
        {
            $homeworkType[]=$value['homework_type_id'];
            $subject[]=$value['subject_id'];
        }
        $subjectData=Subject::wherein('id',$subject)->get();
        $homeworkTypeData=HomeworkType::wherein('id',$homeworkType)->get();

        $data['division']=$division['division_id'];
        dd($data);
    }

}
