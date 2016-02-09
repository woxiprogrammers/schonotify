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
use Faker\Provider\DateTime;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HomeworkController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }

    /*
     * Function Name: getTeacherSubject
     * Param : Request $request
     * Return :Return the data of subjects as JSON array
     * Desc: Display list of subjects to the teacher
     * Developed By: Amol Rokade
     * Date: 1/2/2016
     */

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
                    $homework[$i]['id']=$row['subject_id'];
                    $homework[$i]['name'] = $subjects ['subject_name'] ;
                    $i++;
                }
                $divisionSubjects=SubjectClassDivision::where('teacher_id',$data['teacher']['id'])
                    ->join('subjects','division_subjects.subject_id','=','subjects.id')
                    ->select('subjects.id','subjects.subject_name')
                    ->get();
                foreach($divisionSubjects as $row)
                {
                    $homework[$i]['id']=$row['id'];
                    $homework[$i]['name'] = $row ['subject_name'] ;
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

    /*
     * Function Name: getSubjectBatches
     * Param : Request $request, $subjectId
     * Return :Return the data of batches as JSON array
     * Desc: Display list of subjects to the teacher
     * Developed By: Amol Rokade
     * Date: 1/2/2016
     */

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

      /*
    * Function Name: getBatchesClasses
    * Param : $subjectId $batch_id Request $requests
    * Return :Return the data of batches as JSON array
    * Desc: Display list of batches to the teacher for homework creation
    * Developed By: Amol Rokade
    * Date: 1/2/2016
    */

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

    /*
    * Function Name: getClassesDivision
    * Param :Request $requests $subjectId $batch_id $class_id
    * Return :Return the data of divisions as JSON array
    * Desc: Display list of divisions to the teacher for homework creation
    * Developed By: Amol Rokade
    * Date: 1/2/2016
    */

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

    /*
    * Function Name: getDivisionsStudents
    * Param :Request $requests , $division as JSON array
    * Return :Return the data of divisions students as JSON array
    * Desc: Display list of divisions students to the teacher for homework creation
    * Developed By: Amol Rokade
    * Date: 1/2/2016
    */

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


    /*
    * Function Name: getHomeworkType
    * Param :Request $requests
    * Return :Return the data of homework type  as JSON array
    * Desc: Display list of homework type to the teacher for homework creation
    * Developed By: Amol Rokade
    *Date: 1/2/2016
    */
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

    /*
    * Function Name: createHomework
    * Param :Request $requests
    * Return :Return the message and status after homework creation.
    * Desc:Create a homework for specific batch, class, division ,Students
    * Developed By: Amol Rokade
    *Date: 1/2/2016
     */
    public function createHomework(Requests\HomeworkRequest $request)
    {
        try{
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

    /*
     * Function Name: updateHomework
     * Param :Request $requests $homeworkId
     * Return :Return the message and status after update homework.
     * Desc:Update a specific homework for specific batch, class, division ,Students
     * Developed By: Amol Rokade
     *Date: 1/2/2016
      */

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

    /*
     * Function Name: publishHomeWork
     * Param :Request $requests $homeworkId
     * Return :Return the message and status after Publish homework.
     * Desc:Publish a specific homework for specific batch, class, division ,Students
     * Developed By: Amol Rokade
     *Date: 1/2/2016
      */
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

    /*
    * Function Name: viewHomeWork
    * Param :Request $requests
    * Return :Homework Array
    * Desc: Teacher can view published homework related to his/her division.
    * Developed By: Amol Rokade
    *Date: 1/2/2016
  */
    public function viewHomeWork(Requests\HomeworkRequest $request)
    {
        try{
            $homeworkListingSubjectTeacher = array();
            $finalHomeworkListingSubjectTeacher = array();
            $data = $request->all();
            $status = 200;
            $message = "Successfully Listed";
            $division = Division::where('class_teacher_id',$data['teacher']['id'])->first();
            if ($division != null) {
                $homeworkListingClassTeacher = DB::table('homework_teacher')->join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
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
                    ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id','teacher.first_name','teacher.last_name');
                $homeworkListingSubjectTeacher = DB::table('homework_teacher')->join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                    ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                    ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                    ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                    ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                    ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                    ->Join('users as teacher' ,'homework_teacher.teacher_id', '=', 'teacher.id')
                    ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                    ->where('homework_teacher.teacher_id','=',$data['teacher']['id'])
                    ->where('homeworks.status','=',1) //0 is for unpublished homework
                    ->where('homeworks.is_active','=',1)//0 is for deleted homework
                    ->union($homeworkListingClassTeacher)
                    ->groupBy('homework_teacher.homework_id')
                    ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id','teacher.first_name','teacher.last_name')
                    ->get();
            } else {
                $divisionSubjects = SubjectClassDivision::where('teacher_id',$data['teacher']['id'])
                    ->join('subjects','division_subjects.subject_id','=','subjects.id')
                    ->select('subjects.id as subject_id','division_id')
                    ->get();
                if ($divisionSubjects != null) {
                    foreach ($divisionSubjects as $value) {
                        $homeworkListingSubjectTeacher = HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
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
                } else {
                    $homeworkListingSubjectTeacher=[];
                }
            }
            $i=0;
            foreach ($homeworkListingSubjectTeacher as $value) {
                $finalHomeworkListingSubjectTeacher[$i]['homework_id'] = $value->homework_id;
                $finalHomeworkListingSubjectTeacher[$i]['homeworkTitle'] = $value->homeworkTitle;
                $finalHomeworkListingSubjectTeacher[$i]['description'] = $value->description;
                $finalHomeworkListingSubjectTeacher[$i]['due_date'] = date("M j, g:i a",strtotime( $value->due_date));
                $finalHomeworkListingSubjectTeacher[$i]['attachment_file'] = $value->attachment_file;
                $teacherName=User::where('id',$value->teacher_id)->select('first_name','last_name')->first();
                $finalHomeworkListingSubjectTeacher[$i]['teacher_id'] = $value->teacher_id;
                $finalHomeworkListingSubjectTeacher[$i]['teacher_name'] = $teacherName->first_name." ".$teacherName->last_name;
                $finalHomeworkListingSubjectTeacher[$i]['homeworkType'] = ucfirst($value->homeworkType);
                $finalHomeworkListingSubjectTeacher[$i]['homeworkTypeId'] = $value->id;
                $finalHomeworkListingSubjectTeacher[$i]['subjectName'] = ucfirst($value->subjectName);
                $finalHomeworkListingSubjectTeacher[$i]['subject_id'] = $value->subject_id;
                $finalHomeworkListingSubjectTeacher[$i]['status'] = $value->status;
                $finalHomeworkListingSubjectTeacher[$i]['class_id'] = $value->class_id;
                $finalHomeworkListingSubjectTeacher[$i]['class_name'] = $value->class_name;
                $finalHomeworkListingSubjectTeacher[$i]['division_id'] = $value->division_id;
                $finalHomeworkListingSubjectTeacher[$i]['division_name'] = $value->division_name;
                $finalHomeworkListingSubjectTeacher[$i]['batch_name'] = $value->batch_name;
                $finalHomeworkListingSubjectTeacher[$i]['batch_id'] = $value->batch_id;
                $finalHomeworkListingSubjectTeacher[$i]['created_at'] = date("M j, g:i a",strtotime( $value->created_at));
                $studentList = HomeworkTeacher::where('homework_id','=',$value->homework_id)->select('student_id')->get();
                $j=0;
                foreach($studentList as $value)
                {
                    $studentsData = User::where('id',$value->student_id)->select('first_name','last_name')->first();
                    $finalHomeworkListingSubjectTeacher[$i]['studentList'][$j]['id'] = $value['student_id'];
                    $finalHomeworkListingSubjectTeacher[$i]['studentList'][$j]['name'] = $studentsData['first_name']." ".$studentsData['last_name'];
                    $j++;
                }
                $i++;
            }
            if ($finalHomeworkListingSubjectTeacher != null) {
                foreach ($finalHomeworkListingSubjectTeacher as $key => $part) {
                    $sort[$key] = strtotime($part['created_at']);
                }
                array_multisort($sort, SORT_DESC, $finalHomeworkListingSubjectTeacher);
            }
            if (Empty($finalHomeworkListingSubjectTeacher)) {
                $status=200;
                $message="Sorry!! No homeworks found";
            }
        }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" =>$finalHomeworkListingSubjectTeacher
        ];
        return response($response, $status);
    }


    /*
    * Function Name: viewDetailHomeWork
    * Param :Request $requests $homeWork_id
    * Return :Detail Homework Array
    * Desc: Teacher can view published/Unpublished homework.
    * Developed By: Amol Rokade
    *Date: 1/2/2016
    */

    public function viewDetailHomeWork(Requests\HomeworkRequest $request,$homeWork_id)
    {
               try{
                $studentList=HomeworkTeacher::where('homework_id','=',$homeWork_id)->select('student_id')->get();
                $j=0;
                foreach($studentList as $value)
                {
                    $studentsData=User::where('id',$value['student_id'])->select('first_name','last_name')->first();
                    $finalHomeworkListing['studentList'][$j]['id']=$value['student_id'];
                    $finalHomeworkListing['studentList'][$j]['name']=$studentsData['first_name']." ".$studentsData['last_name'];
                    $j++;
                }
                   $status=200;
                   $message="Sucessfully listed";
            }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"data" =>$finalHomeworkListing];
        return response($response, $status);
    }

   /*
   * Function Name: viewUnpublishedHomeWork
   * Param :Request $requests
   * Return :Detail Homework Array
   * Desc: Teacher can view Unpublished homework related o his/her class.
   * Developed By: Amol Rokade
   *Date: 1/2/2016
   */
    public function viewUnpublishedHomeWork(Requests\HomeworkRequest $request)
    {
        try
         {
             $finalHomeworkListingSubjectTeacher=array();
             $homeworkListingSubjectTeacher=array();
             $data=$request->all();
             $status=200;
             $message="Successfully Listed";
             $homeworkListingSubjectTeacher = HomeworkTeacher::join('homeworks', 'homework_teacher.homework_id', '=', 'homeworks.id')
                        ->Join('divisions', 'homework_teacher.division_id', '=', 'divisions.id')
                        ->Join('classes', 'divisions.class_id', '=', 'classes.id')
                        ->Join('homework_types', 'homeworks.homework_type_id', '=', 'homework_types.id')
                        ->Join('subjects', 'homeworks.subject_id', '=', 'subjects.id')
                        ->Join('users', 'homework_teacher.student_id', '=', 'users.id')
                        ->Join('batches', 'classes.batch_id', '=', 'batches.id')
                        ->where('homework_teacher.teacher_id','=',$data['teacher']['id'])
                        ->where('homeworks.status','=',0) //0 is for unpublished homework
                        ->where('homeworks.is_active','=',1)//0 is for deleted homework
                        ->groupBy('homework_teacher.homework_id')
                        ->select('homework_teacher.homework_id as homework_id','homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','homework_types.id as id ','users.first_name as first_name','users.last_name as last_name','users.id as userId','subjects.slug as subjectName','subjects.id as subject_id','homeworks.status','divisions.division_name','divisions.id as division_id','classes.class_name','classes.id as class_id','homeworks.created_at','batches.name as batch_name','batches.id as batch_id')
                        ->get()->toArray();
             if (!Empty($homeworkListingSubjectTeacher)) {
                 $status = 200;
                 $message = "Successfully Listed";
                 $i =0;
                 foreach ($homeworkListingSubjectTeacher as $value) {
                     $date = date('Y-m-d',strtotime($value['due_date']));
                     $finalHomeworkListingSubjectTeacher[$i]['homework_id'] = $value['homework_id'];
                     $finalHomeworkListingSubjectTeacher[$i]['homeworkTitle'] = $value['homeworkTitle'];
                     $finalHomeworkListingSubjectTeacher[$i]['description'] = $value['description'];
                     $finalHomeworkListingSubjectTeacher[$i]['date'] = $value['due_date'];
                     $finalHomeworkListingSubjectTeacher[$i]['due_date'] = $date;
                     $finalHomeworkListingSubjectTeacher[$i]['attachment_file'] = $value['attachment_file'];
                     $teacherName = User::where('id',$value['teacher_id'])->select('first_name','last_name')->first();
                     $finalHomeworkListingSubjectTeacher[$i]['teacher_id'] = $value['teacher_id'];
                     $finalHomeworkListingSubjectTeacher[$i]['teacher_name'] = $teacherName['first_name']." ".$teacherName['last_name'];
                     $finalHomeworkListingSubjectTeacher[$i]['homeworkType'] = ucfirst($value['homeworkType']);
                     $finalHomeworkListingSubjectTeacher[$i]['homeworkTypeId'] = $value['id'];
                     $finalHomeworkListingSubjectTeacher[$i]['subjectName'] = ucfirst($value['subjectName']);
                     $finalHomeworkListingSubjectTeacher[$i]['subject_id'] = $value['subject_id'];
                     $finalHomeworkListingSubjectTeacher[$i]['status'] = $value['status'];
                     $finalHomeworkListingSubjectTeacher[$i]['class_id'] = $value['class_id'];
                     $finalHomeworkListingSubjectTeacher[$i]['class_name'] = $value['class_name'];
                     $finalHomeworkListingSubjectTeacher[$i]['division_id'] = $value['division_id'];
                     $finalHomeworkListingSubjectTeacher[$i]['division_name'] = $value['division_name'];
                     $finalHomeworkListingSubjectTeacher[$i]['batch_name'] = $value['batch_name'];
                     $finalHomeworkListingSubjectTeacher[$i]['batch_id'] = $value['batch_id'];
                     $studentList = HomeworkTeacher::where('homework_id','=',$value['homework_id'])->select('student_id')->get();
                     $j=0;
                     foreach ($studentList as $value) {
                         $studentsData = User::where('id',$value['student_id'])->select('first_name','last_name')->first();
                         $finalHomeworkListingSubjectTeacher[$i]['studentList'][$j]['id'] = $value['student_id'];
                         $finalHomeworkListingSubjectTeacher[$i]['studentList'][$j]['name'] = $studentsData['first_name']." ".$studentsData['last_name'];
                         $j++;
                     }
                     $i++;
                 }
                 if ($finalHomeworkListingSubjectTeacher != null) {
                     foreach ($finalHomeworkListingSubjectTeacher as $key => $part) {
                         $sort[$key] = strtotime($part['date']);
                     }
                     array_multisort($sort, SORT_DESC, $finalHomeworkListingSubjectTeacher);
                 }
             }
             if(Empty($finalHomeworkListingSubjectTeacher)){
                 $status=200;
                 $message="Sorry!! No homeworks found";
             }
         }
        catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = [
             "message" => $message,
             "status" => $status,
             "data" =>$finalHomeworkListingSubjectTeacher
              ];
        return response($response, $status);
    }

    /*
    * Function Name: deleteHomework
    * Param :Request $requests $homework_id
    * Return :$message $status
    * Desc: User can delete a homework which is unpublished created by them.
    * Developed By: Amol Rokade
    *Date: 1/2/2016
    */

  public function deleteHomework(Requests\deleteHomeworkRequest $request)
  {
     try{
         $data=$request->all();
         $homework_status=Homework::where('id','=',$data['homework_id'])->select('status')->first();
        if($homework_status['status']==0)
        {
            Homework::where('id',$data['homework_id'])->update(array('is_active'=>0)); // 0 is for deleted
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
    /*
    * Function Name: viewHomeworkParent
    * Param :Request $requests $student_id
    * Return :$message $status
    * Desc: Parent can view homework assigned to his/her student
    * Developed By: Amol Rokade
    *Date: 1/2/2016
    */
    public function viewHomeworkParent(Requests\HomeworkRequest $request,$student_id)
    {
      $data=array();
        try{
            $status = 200;
            $message = "Homework successfully Listed";
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
                ->select('homeworks.title as homeworkTitle','homeworks.description','due_date','attachment_file','teacher_id','homework_types.slug as homeworkType','first_name','last_name','users.id as userId','subjects.slug as subjectName','homeworks.status','divisions.division_name','classes.class_name','batches.name','homeworks.created_at')
                ->get()->toarray();
            $i=0;
            if(!Empty($studentHomework)){
                foreach($studentHomework as $value)
                    {
                        $data[$i]['title']=$value['homeworkTitle'];
                        $data[$i]['description']=$value['description'];
                        $data[$i]['due_date']=date("M j",strtotime($value['due_date']));
                        $data[$i]['created_At']=date("M j",strtotime($value['created_at']));
                        $data[$i]['attachment_file']=$value['attachment_file'];
                        $data[$i]['homeworkType']=$value['homeworkType'];
                        $teacherName=User::where('id','=',$value['teacher_id'])->first();
                        $data[$i]['teacher_name']=$teacherName['first_name']."  ".$teacherName['last_name'];
                        $data[$i]['subject_name']=ucfirst($value['subjectName']);
                        $data[$i]['division_name']=ucfirst($value['division_name']);
                        $data[$i]['batch_name']=ucfirst($value['name']);
                        $data[$i]['class_name']=ucfirst($value['class_name']);
                        $data[$i]['created_at']=$value['created_at'];
                        $i++;
                    }
                if($data !=null){
                    foreach ($data as $key => $part) {
                        $sort[$key] = strtotime($part['created_at']);
                    }
                    array_multisort($sort, SORT_DESC, $data);
                }
            }else{
                $status = 202;
                $message = "Sorry, No Homework found for this user";
            }
        }catch (\Exception $e) {
            $status = 500;
            $message = "Something went wrong";
        }
        $response = ["message" => $message,"status" =>$status,"data" =>$data];
        return response($response, $status);
    }
}