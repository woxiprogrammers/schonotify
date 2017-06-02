<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Classes;
use App\Division;
use App\Homework;
use App\HomeworkTeacher;
use App\HomeworkType;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use App\PushToken;
use App\Subject;
use App\SubjectClass;
use App\SubjectClassDivision;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use DateTime;

class HomeworkController extends Controller
{
    use PushNotificationTrait;
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    /*
+   * Function Name: homeworkListing
+   * Param: Requests\WebRequests\HomeworkRequest $requests
+   * Return: Homework Listing
+   * Desc: this method returns to view of homework listing.
+   * Developed By: Suraj Bande
+   * Date: 3/2/2016
+   */
    public function homeworkListing(Requests\WebRequests\HomeworkRequest $request)
    {
        if ($request->authorize() === true){
            return view('homeworkListing');
        }else{
            return Redirect::to('/');
        }
    }
    /*
+   * Function Name: homeworkListing
+   * Param: $id
+   * Return: Homework id
+   * Desc: it returns the detailedd homework of respective homework id.
+   * Developed By: Manoj Choudhary
+   * Date: 3/2/2016
+   */
    public function detailedHomework($id)
    {   $homeworkIdss=array();
        $homeworkdivs=array();
        $homeworkdiv=array();
        $homeworkTypes=array();
        $homework=array();
        $editHomeworkDiv=array();
        $editHomeworkBatch=array();
        $editHomeworkClass=array();
        $row=array();
        $i=0;
        $homeworkData=HomeworkTeacher::where('homework_id',$id)->select('homework_id','division_id','teacher_id','student_id')->get();
        $homeworkInfo=Homework::where('id',$id)->get()->toArray();
        $currentDate = new DateTime(Carbon::now());
            foreach($homeworkInfo as $home)
            {
                $subject_name=Subject::where('id',$home['subject_id'])->first();
                $homework_type=HomeworkType::where('id',$home['homework_type_id'])->first();
                $homeworkIdss[$home['id']]['homework_id']=$home['id'];
                $homeworkIdss[$home['id']]['homework_type']=$homework_type['title'];
                $homeworkIdss[$home['id']]['homework_type_id']=$homework_type['id'];
                $homeworkIdss[$home['id']]['homework_title']=$home['title'];
                $homeworkIdss[$home['id']]['homework_description']=$home['description'];
                $homeworkDate=new DateTime($home['homework_timestamp']);
                $dateDiff = $currentDate->diff($homeworkDate);
                $homeworkIdss[$home['id']]['homework_date']=$home['homework_timestamp'];
                $homeworkIdss[$home['id']]['homework_dateNow'] = $dateDiff->h;
                $homeworkIdss[$home['id']]['homework_due_date']=$home['due_date'];
                $homeworkIdss[$home['id']]['homework_status']=$home['status'];
                $homeworkIdss[$home['id']]['homework_is_active']=$home['is_active'];
                $homeworkIdss[$home['id']]['homework_file']=$home['attachment_file'];
                $homeworkIdss[$home['id']]['homework_subject']=$subject_name['subject_name'];
                $homeworkIdss[$home['id']]['homework_subject_id']=$subject_name['id'];
                $i++;
            }
            $i=0;
            foreach($homeworkData->toArray() as $row)
            {
                $userName=User::where('id',$row['teacher_id'])->select('first_name','last_name')->first()->toArray();
                $student_name=User::where('id',$row['student_id'])->first();
                $division=Division::where('id',$student_name['division_id'])->first();
                $class=Classes::where('id',$division['class_id'])->first();
                $batch=Batch::where('id',$class['batch_id'])->first();
                $editHomeworkDiv[$i]['division_name']=$division['division_name'];
                $editHomeworkDiv[$i]['division_id']=$division['id'];
                $editHomeworkBatch[$i]['batch_name']=$batch['name'];
                $editHomeworkBatch[$i]['batch_id']=$batch['id'];
                $editHomeworkClass[$i]['class_id']=$class['id'];
                $editHomeworkClass[$i]['class_name']=$class['class_name'];
                $homeworkIdss[$row['homework_id']]['homework_teacher']=$row['teacher_id'];
                $homeworkIdss[$row['homework_id']]['homework_teacher_name']=$userName['first_name']." ".$userName['last_name'];
                $homeworkIdss[$row['homework_id']]['homework_student_list'][$student_name['id']]['division']=$division['division_name'];
                $homeworkIdss[$row['homework_id']]['homework_student_list'][$student_name['id']]['name']=$student_name['first_name']." ".$student_name['last_name'];
                $homeworkIdss[$row['homework_id']]['homework_student_list'][$student_name['id']]['stud_id']=$student_name['id'];
                $homeworkIdss[$row['homework_id']]['homework_student_list'][$student_name['id']]['roll_number']=$student_name['roll_number'];
                $homeworkIdss[$row['homework_id']]['homework_student_list'][$student_name['id']]['class']=$class['class_name'];
                $homeworkIdss[$row['homework_id']]['homework_student_list'][$student_name['id']]['batch']=$batch['name'];
                $i++;
            $i=0;
                foreach($homeworkIdss[$row['homework_id']]['homework_student_list'] as $row1){
                $homeworkdiv[$row1['batch']][$row1['class']][$i]=$row1['division'];
                $homeworkdiv['batch']=$row1['batch'];
                $homeworkdiv['class']=$row1['class'];
                $i++;
            }
            $homeworkdivs = array_unique($homeworkdiv[$row1['batch']][$row1['class']], SORT_REGULAR);
            }
            $homeworkdiv['divisions']=$homeworkdivs;
            $homeworkType=HomeworkType::all();
            foreach($homeworkType as $type)
            {
                $homeworkTypes[$i]['type_id'] = $type ['id'] ;
                $homeworkTypes[$i]['type_slug']=$type['slug'];
                $i++;
            }
            $i=0;
        $editHomeworkDiv = array_unique($editHomeworkDiv, SORT_REGULAR);
        $editHomeworkBatch = array_unique($editHomeworkBatch, SORT_REGULAR);
        $editHomeworkClass = array_unique($editHomeworkClass, SORT_REGULAR);
        $user= Auth::user();
        $division=Division::where('class_teacher_id',$user->id)->first();
        if($division != null){
            $subjects=SubjectClass::where('class_id',$division->class_id)->join('subjects','subject_classes.subject_id','=','subjects.id')->get();
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
            return view('detailedHomework')->with(compact('homeworkIdss','homeworkdiv','homeworkTypes','homework','editHomeworkDiv','editHomeworkBatch','editHomeworkClass'));
    }
    public function getDownload($file_name){
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/uploads/homework/$file_name";
        $headers = array(
            'Content-Type: application/pdf',
        );
        return Response::download($file, $file_name, $headers);
    }
    public function createHomework(Requests\WebRequests\CreateHomeworkRequest $request)
    {
        if($request->authorize()===true){
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
            $subjects=SubjectClassDivision::where('division_id',$division->id)
                ->join('subjects','division_subjects.subject_id','=','subjects.id')
                ->select('subjects.id','subjects.slug','division_subjects.division_id')
                ->get();
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
        $homework = array_unique($homework, SORT_REGULAR);
        $subjectId=array();
        foreach($homework as $row)
        {
            array_push($subjectId,$row['subject_id']);
        }
        return view('createHomework')->with(compact('homework','homeworkTypes','subjectClass','batches'));
        }else{
            return Redirect::back();
        }
    }
    public function homeworkCreate(Requests\WebRequests\CreateHomeworkRequest $request)
    {
            $homeworkData= $request->all();
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
        $status=Homework::where('id',$homeworkId)->pluck('status');
        if($status == "1"){
                $title="New Homework Created";
                $message=$homeworkData['title'];
                $homeWork_push_users = HomeworkTeacher::where('homework_id',$homeworkId)->lists('student_id');
                $push_user = User::whereIn('id',$homeWork_push_users)->lists('parent_id');
                $allUser=0;
                $push_users=PushToken::whereIn('user_id',$push_user)->lists('push_token');
                $this -> CreatePushNotification($title,$message,$allUser,$push_users);
            Session::flash('message-success','homework created successfully');
            return Redirect::to('/homework-listing');
        }else{
            Session::flash('message-success','homework created successfully');
            return Redirect::to('/homework-listing');
        }
    }
    public function getSubjectBatches($subjectId)
    {
        $user=Auth::user();
        $division=array();
        $batchInfo=array();
        $Classes=array();
        $divisionData=SubjectClassDivision::where('subject_id','=',$subjectId)
            ->where('teacher_id','=',$user->id)
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
        $divisions=Division::where('class_teacher_id','=',$user->id)->first();
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
            $batchInfo[$i]['batch_id']=$batchName['id'];
            $batchInfo[$i]['batch']=$batchName['name'];
            $i++;
        }
        $batchInfo=array_unique($batchInfo,SORT_REGULAR);
        return $batchInfo;
    }
    public function getSubjectClass($id,$subject_id){
        $division=array();
        $user=Auth::user();
        $classInfo=array();
        $divisionData=SubjectClassDivision::where('subject_id','=',$subject_id)
            ->where('teacher_id','=',$user->id)
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
        $divisions=Division::where('class_teacher_id','=',$user->id)->first();
        if(!Empty($divisions)){
            $divisionData=SubjectClassDivision::where('division_id','=',$divisions['id'])
                ->where('subject_id','=',$subject_id)
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
                ->where('batch_id','=',$id)
                ->select('id','class_name as class_name')->first();
            if(!Empty($class_id)&&!Empty($className)){
                $classInfo[$i]['class_id']=$class_id['class_id'];
                $classInfo[$i]['class_name']=$className['class_name'];
                $i++;
            }
        }
        $classInfo=array_unique($classInfo,SORT_REGULAR);
        return $classInfo;
    }
    public function getSubjectDiv($id,$subject_id,$batch_id){
        $user=Auth::user();
        $i=0;
        $division=array();
        $finalDivisions=array();
        $divisionData=SubjectClassDivision::where('subject_id','=',$subject_id)
            ->where('teacher_id','=',$user->id)
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
        $divisions=Division::where('class_teacher_id','=',$user->id)->first();
        if(!Empty($divisions)){
            $divisionData=SubjectClassDivision::where('division_id','=',$divisions['id'])
                ->where('subject_id','=',$subject_id)
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
                ->where('divisions.class_id','=',$id)
                ->where('classes.batch_id','=',$batch_id)
                ->where('divisions.id','=',$division_id)
                ->select('divisions.id as div_id','divisions.division_name')
                ->first();
            if(!Empty($finalData)){
                $finalDivisions[$i]=$finalData;
                $i++;
            }
        }
        $finalDivisions=array_unique($finalDivisions,SORT_REGULAR);
        return $finalDivisions;
    }
    public function getStudentData(Request $request)
    {
        $students = User::wherein('division_id',$request->id)->where('is_active',1)
                          ->join('divisions','users.division_id','=','divisions.id')
                          ->select('users.roll_number','users.id as user_id','users.first_name','users.last_name','divisions.division_name')
                          ->get();
        $studentList = $students->toArray();
        return $studentList;
    }
    public function getEditStudentData(Request $request)
    {
        $students = HomeworkTeacher::wherein('homework_teacher.division_id',$request->id)->where('homework_id',$request->homework_id)
            ->join('users','homework_teacher.student_id','=','users.id')
            ->join('divisions','users.division_id','=','divisions.id')
            ->select('users.roll_number','users.id as user_id','users.first_name','users.last_name','divisions.division_name')
            ->get();
        $studentList = $students->toArray();
        return $studentList;
    }
    public function editHomework($id){
        $homeworkUpdate=array();

               $homeworkUpdate['status']=1;
              $homeworkStatus= Homework::where('id',$id)->update($homeworkUpdate);
                    if($homeworkStatus ==1)
                    {
                        Session::flash('message-success','homework published successfully');
                        return Redirect::to('/homework-listing');
                    }

    }
    public function deleteHomework(Request $request,$id){
            $homeworkUpdate=array();
            $homeworkUpdate['is_active']=0;

            $homeworkStatus= Homework::where('id',$id)->update($homeworkUpdate);
            if($homeworkStatus ==1)
            {
                Session::flash('message-success','homework deleted successfully');
                return Redirect::to('/homework-listing');
            }


    }



    public function updateHomeworkDetail(Requests\WebRequests\EditHomeworkRequest $request)
    {
        if ($request->authorize() === true)
        {
                $homeworkData= $request->all();
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
                    $homework['attachment_file']=$filename;

                }
                $homework['homework_timestamp']=Carbon::now();
                $homework['created_at'] = Carbon::now();
                $homework['updated_at'] = Carbon::now();
                $homework['is_active'] = 1;
                $homeworkId=Homework::where('id',$homeworkData['homework_id'])->update($homework);
                $user=Auth::user();
                if($homeworkId == 1)
                {
                    HomeworkTeacher::where('homework_id',$homeworkData['homework_id'])->delete();

                }
                foreach($homeworkData['studentinfo'] as $row)
                {
                    $division = User::where('id',$row)->select('id','division_id')->first();
                    $HomeworkTeacher['student_id'] = $division->id;
                    $HomeworkTeacher['teacher_id'] = $user->id;
                    $HomeworkTeacher['homework_id'] = $homeworkData['homework_id'];
                    $HomeworkTeacher['division_id'] = $division->division_id;
                    $HomeworkTeacher['created_at']= Carbon::now();
                    $HomeworkTeacher['updated_at']= Carbon::now();
                    HomeworkTeacher::insert($HomeworkTeacher);

                }
                Session::flash('message-success','homework updated successfully');
                return Redirect::to('/homework-listing');
        }else{
            return Redirect::back();
         }
    }

    public function editDataDiv($id)
    {
        $homeworkData=HomeworkTeacher::where('homework_id',$id)->select('division_id')->distinct()->get();
        return $homeworkData->toArray();
    }


    /*
+   * Function Name: loadMore
+   * Param: Requests\WebRequests\HomeworkRequest $request,$id
+   * Return: Listing of homeworks on ajax call
+   * Desc: this function called initially when page load and when page scroll of listing. it returns records with limit provided by $id variable.
+   * Developed By: Suraj Bande
+   * Date: 3/2/2016
+   */

    public function loadMore(Requests\WebRequests\HomeworkRequest $request,$id)
    {
        if ( $request->authorize() === true )
        {

            $user=Auth::user();
            $isClassTeacher=Division::where('class_teacher_id',$user->id)->first();

            if($isClassTeacher){

                $ownHomeworks=DB::table('homework_teacher')->join('homeworks','homeworks.id','=','homework_teacher.homework_id')
                    ->join('subjects','homeworks.subject_id','=','subjects.id')
                    ->join('users','users.id','=','homework_teacher.teacher_id')
                    ->select('homework_id','teacher_id','homeworks.created_at','homeworks.updated_at','homeworks.title','homeworks.homework_type_id','homeworks.homework_timestamp','homeworks.description','homeworks.due_date','subjects.subject_name','homeworks.attachment_file','homeworks.status','homeworks.is_active','users.first_name','users.last_name')
                    ->where('homework_teacher.teacher_id','=',$user->id)
                    ->where('users.id','=',$user->id)
                    ->where('homeworks.is_active','=',1)
                    ->distinct('homeworks.id');

                $ClassTeacherAllSubjects=DB::table('homework_teacher')->join('homeworks','homeworks.id','=','homework_teacher.homework_id')
                    ->join('users','users.id','=','homework_teacher.teacher_id')
                    ->join('subjects','homeworks.subject_id','=','subjects.id')
                    ->select('homework_id','teacher_id','homeworks.created_at','homeworks.updated_at','homeworks.title','homeworks.homework_type_id','homeworks.homework_timestamp','homeworks.description','homeworks.due_date','subjects.subject_name','homeworks.attachment_file','homeworks.status','homeworks.is_active','users.first_name','users.last_name')
                    ->where('homeworks.status','=',1)
                    ->Where('homework_teacher.division_id','=',$isClassTeacher->id)
                    ->where('homeworks.is_active','=',1)
                    ->union($ownHomeworks)
                    ->distinct('homeworks.id')
                    ->orderBy('status','asc')
                    ->skip($id*4)->take(4)
                    ->get();

                if($ClassTeacherAllSubjects){
                    return $ClassTeacherAllSubjects;
                }else{
                    return [];
                }

            }else{
                $ownHomeworks=DB::table('homework_teacher')->join('homeworks','homeworks.id','=','homework_teacher.homework_id')
                    ->join('subjects','homeworks.subject_id','=','subjects.id')
                    ->join('users','users.id','=','homework_teacher.teacher_id')
                    ->select('homework_id','teacher_id','homeworks.created_at','homeworks.updated_at','homeworks.title','homeworks.homework_type_id','homeworks.homework_timestamp','homeworks.description','homeworks.due_date','subjects.subject_name','homeworks.attachment_file','homeworks.status','homeworks.is_active','users.first_name','users.last_name')
                    ->where('homework_teacher.teacher_id','=',$user->id)
                    ->where('users.id','=',$user->id)
                    ->where('homeworks.is_active','=',1)
                    ->distinct('homeworks.id')
                    ->skip($id*4)->take(4)
                    ->orderBy('status','asc')
                    ->get();

                if($ownHomeworks){
                    return $ownHomeworks;
                }else{
                    return [];
                }

            }

            return $ownHomeworks;

        }else{
            return Redirect::to('/');
        }
    }

    public function deleteFile(Requests\WebRequests\EditHomeworkRequest $request,$file_name,$homework_id)
    {

        if( $request->authorize() === true )
        {
            $homework=array();
            unlink('../public/uploads/homework/' . $file_name);
            $homework['attachment_file']=null;
            $delete=Homework::where('id',$homework_id)->update($homework);
            if($delete)
            {
                return "true";
            }
        }else{
            return Redirect::back();
        }

    }

    /*
+   * Function Name: classBatchDivision
+   * Param: $id
+   * Return: returns batch class and divisions to which respective homework is assigned
+   * Desc: it returns batch class divisions and it will appeared on click of subject block in listing.
+   * Developed By: Suraj Bande
+   * Date: 3/2/2016
+   */

    public function classBatchDivision($id)
    {
        $divisions=HomeworkTeacher::join('divisions','divisions.id','=','homework_teacher.division_id')
                ->join('classes','classes.id','=','divisions.class_id')
                ->join('batches','batches.id','=','classes.batch_id')
                ->select('divisions.division_name','classes.class_name','batches..name as batch_name')
                ->where('homework_teacher.homework_id','=',$id)
                ->distinct()
                ->get();

        return $divisions;
    }

}
