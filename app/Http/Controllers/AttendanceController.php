<?php
    namespace App\Http\Controllers;
    use App\Attendance;
    use App\AttendanceStatus;
    use App\Batch;
    use App\Classes;
    use App\Division;
    use App\Http\Controllers\CustomTraits\PushNotificationTrait;
    use App\Http\Requests\WebRequests\CreateAttendanceRequest;
    use App\Http\Requests\WebRequests\ViewAttendanceRequest;
    use App\Leave;
    use App\PushToken;
    use App\SubjectClassDivision;
    use App\User;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Session;
    class AttendanceController extends Controller
    {
        use PushNotificationTrait;
        public function __construct()
        {
            $this->middleware('db');
            $this->middleware('auth');
        }
        /**
         * Function Name: markAttendance
         * @param CreateAttendanceRequest $request
         * @return $this|array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * Desc:
         * Date: 10/2/2016
         * author manoj chaudahri
        */
        public function markAttendance(CreateAttendanceRequest $request)
        {
            if ($request->authorize() === true)
            {
                $user=Auth::user();
                $dropDownData=array();
                if ($request->ajax()) {
                    $data = Input::all();
                    $division = $data['division'];
                    $date=date('Y-m-d',strtotime($data['value']));
                }else {
                    $date=date('Y-m-d', time());
                }
                if ($user->role_id == 2){
                    $userCheck=Division::where('class_teacher_id',$user->id)->first();
                    if ($userCheck != null) {
                        $count=0;
                        $batchClassData=Classes::where('classes.id',$userCheck->class_id)
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->first();
                        if ($batchClassData != null) {
                            $studentData=User::where('division_id',$userCheck->id)->where('is_active',1)->where('is_lc_generated',0)->select('id','first_name','last_name','roll_number')->get();
                            $dropDownData['division_id'] = $userCheck->id;
                            $dropDownData['division_name'] = $userCheck->division_name;
                            $dropDownData['class_id'] = $batchClassData->class_id;
                            $dropDownData['class_name'] = $batchClassData->class_name;
                            $dropDownData['batch'][$count]['batch_id'] = $batchClassData->batch_id;
                            $dropDownData['batch'][$count]['batch_name'] = $batchClassData->batch_name;
                            $count=0;
                            foreach ($studentData as $student) {
                                $leaveStatus = Leave::where('student_id',$student['id'])->where('from_date',$date)->select('student_id','status')->first();
                                $attendanceStatus = Attendance::where('student_id',$student['id'])->where('date',$date)->select('student_id','status')->first();
                                if ($leaveStatus != null) {
                                    $dropDownData['student_list'][$count]['student_id'] = $student['id'];
                                    $dropDownData['student_list'][$count]['student_leave_status'] = $leaveStatus['status'];
                                    $dropDownData['student_list'][$count]['student_attendance_status'] = $attendanceStatus['status'];
                                    $dropDownData['student_list'][$count]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                    $dropDownData['student_list'][$count]['roll_number'] = $student['roll_number'];
                                } else {
                                    $dropDownData['student_list'][$count]['student_id'] = $student['id'];
                                    $dropDownData['student_list'][$count]['student_leave_status'] = null;
                                    $dropDownData['student_list'][$count]['student_attendance_status'] = $attendanceStatus['status'];;
                                    $dropDownData['student_list'][$count]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                    $dropDownData['student_list'][$count]['roll_number'] = $student['roll_number'];
                                }
                                $count++;
                            }
                            if ($request->ajax()) {
                                return $dropDownData;
                            } else {
                                return view('markAttendance')->with(compact('dropDownData'));
                            }
                        } else {
                            Session::flash('message-success','no record found');
                        }
                    } else {
                        Session::flash('message-success','no record found');
                    }
                }
                elseif ($user->role_id == 1) {
                    if ($request->ajax()) {
                        $data = Input::all();
                        $division=$data['division'];
                        $batchClassDivisionData=Division::where('divisions.id',$division)->
                            join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                            ->first();
                    } else {
                        $batchClassDivisionData=Division::
                            join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                            ->first();
                    }
                    if ($batchClassDivisionData != null) {
                                $studentData=User::where('division_id',$batchClassDivisionData->division_id)->where('is_active',1)->where('is_lc_generated',0)->select('id','first_name','last_name','roll_number')->get();
                                $dropDownData['division_id'] =  $batchClassDivisionData->division_id;
                                $dropDownData['division_name'] = $batchClassDivisionData->division_name;
                                $dropDownData['class_id'] = $batchClassDivisionData->class_id;
                                $dropDownData['class_name'] = $batchClassDivisionData->class_name;
                                $batch=Batch::where('body_id',$user->body_id)->get();
                                $count=0;
                                foreach ($batch as $row) {
                                    $dropDownData['batch'][$count]['batch_id'] = $row['id'];
                                    $dropDownData['batch'][$count]['batch_name'] = $row['name'];
                                    $count++;
                                }
                                $count=0;
                               if($studentData->toArray() != null) {
                                foreach ($studentData as $student) {
                                    $leaveStatus=Leave::where('student_id',$student['id'])->where('from_date',$date)->select('student_id','status')->first();
                                    $attendanceStatus = Attendance::where('student_id',$student['id'])->where('date',$date)->select('student_id','status')->first();
                                    if ($leaveStatus != null) {
                                        $dropDownData['student_list'][$count]['student_id'] = $student['id'];
                                        $dropDownData['student_list'][$count]['student_leave_status'] = $leaveStatus['status'];
                                        $dropDownData['student_list'][$count]['student_attendance_status'] = $attendanceStatus['status'];
                                        $dropDownData['student_list'][$count]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                        $dropDownData['student_list'][$count]['roll_number'] = $student['roll_number'];
                                    } else {
                                        $dropDownData['student_list'][$count]['student_id'] = $student['id'];
                                        $dropDownData['student_list'][$count]['student_leave_status'] = null;
                                        $dropDownData['student_list'][$count]['student_attendance_status'] = $attendanceStatus['status'];
                                        $dropDownData['student_list'][$count]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                        $dropDownData['student_list'][$count]['roll_number'] = $student['roll_number'];
                                    }
                                    $count++;
                                }
                               } else {
                                         $dropDownData['student_list'] = '';
                               }
                    if ($request->ajax()) {
                         return $dropDownData;
                    } else {
                        return view('markAttendance')->with(compact('dropDownData'));
                    }
                 }
                    return view('markAttendance')->with(compact('dropDownData'));
                } else {
             }
                return view('markAttendance');
            } else {
                return Redirect::to('/');
            }
        }
        /**
         * Function Name: attendanceMark
         * @param CreateAttendanceRequest $request
         * @return mixed
         * Desc:
         * Date: 10/2/2016
         * author manoj chaudahri
         */
        public function attendanceMark(CreateAttendanceRequest $request)
        {
            $user = Auth::user();
            $saveData = array();
            $userIds=array();
            $dataList=array();
            $division = array();
            $date=date("Y-m-d",strtotime($request->datePiker));
            if($request->student) {
                $userIds = $request->student;
                $userData = User::whereIn('id',$userIds)->where('division_id',$request['division-select'])->where('is_active',1)->where('is_lc_generated',0)->select('id','division_id')->get();
            } else {
                $userData = User::where('division_id',$request['division-select'])->where('is_active',1)->where('is_lc_generated',0)->select('id','division_id')->get();
            }
            $i=0;
            foreach ($userData as $data) {
                $dataList[] = $data['id'];
                $i++;
            }
            $attendanceCheck = Attendance::where('division_id',$request['division-select'])->where('date',$date)->get()->toArray();
            if (!Empty($attendanceCheck)) {
                 Attendance::where('division_id',$request['division-select'])->where('date',$date)->delete();
            }
                        $i=0;
                       foreach ($userData as $row) {
                        $saveData['teacher_id'] = $user->id;
                        $saveData['date'] =date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->datePiker)));
                        $saveData['student_id'] = $row['id'];
                        $saveData['status'] = 1;
                        $saveData['division_id'] = $row['division_id'];
                        $saveData['created_at'] = Carbon::now();
                        $saveData['updated_at'] = Carbon::now();
                         $att_id=Attendance::insert($saveData);
                        $i++;
                    }
            $attendanceStatus['date'] = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->datePiker)));
            $attendance = AttendanceStatus::where('date','=',$attendanceStatus['date'])->where('division_id','=',$request['division-select'])->get();
            if(count($attendance) == 0){
                $attendanceStatus['division_id'] = $request['division-select'];
                $attendanceStatus['status'] = 1;
                $attendanceStatus['created_at'] = Carbon::now();
                $attendanceStatus['updated_at'] = Carbon::now();
                $result = AttendanceStatus::insertGetId($attendanceStatus);
                $div_id = AttendanceStatus::where('id',$result)->pluck('division_id');
                $users_push = User::where('division_id',$div_id)->lists('parent_id');
                $title="Attendance marked";
                $message="Please check attendance";
                $allUser=0;
                $push_users = PushToken::whereIn('user_id',$users_push)->lists('push_token')->toArray();
                $this -> CreatePushNotification($title,$message,$allUser,$push_users);
                if($result != "null")
                {
                    return "1";
                }else{
                    return "0";
                }
            } else {
                return "0";
            }
        }
        /**
         * Function Name: getAllClasses
         * @param $id
         * @return array
         * Desc:
         * Date: 10/2/2016
         * author manoj chaudahri
         */
        public function getAllClasses($id){
            $data=array();
            $classData=Classes::where('batch_id',$id)->get();
            $i=0;
            foreach ($classData as $row) {
                $data[$i]['class_id'] = $row['id'] ;
                $data[$i]['class_name']= $row['class_name'] ;
                $i++;
            }
            return $data;
        }
        /**
         * Function Name: getAllDivision
         * @param $id
         * @return array
         * Desc:
         * Date: 10/2/2016
         * author manoj chaudahri
         */
        public function getAllDivision($id) {
            $data=array();
            $divisionData=Division::where('class_id',$id)->get();
            $i=0;
            foreach ($divisionData as $row) {
                $data[$i]['division_id'] = $row['id'] ;
                $data[$i]['division_name']= $row['division_name'] ;
                $i++;
            }
            return $data;
        }
        /**
         * Function Name: getAllStudent
         * @param $id
         * @param $dateValue
         * @return array
         * Desc:
         * Date: 10/2/2016
         * author manoj chaudahri
         */
        public function getAllStudent($id,$dateValue) {
            $data=array();
            $studentData=User::where('division_id',$id)->select('id','first_name','last_name','roll_number')->get();
            $i=0;
            foreach ($studentData as $row) {
                $leaveStatus=Leave::where('student_id',$row['id'])->where('from_date',$dateValue)->select('student_id','status')->first();
                $attendanceStatus = Attendance::where('student_id',$row['id'])->where('date',$dateValue)->select('student_id','status')->first();
                if ($leaveStatus != null) {
                    $data['student_list'][$i]['student_id'] = $row['id'];
                    $data['student_list'][$i]['student_leave_status'] = $leaveStatus['status'];
                    $data['student_list'][$i]['student_attendance_status'] = $attendanceStatus['status'];
                    $data['student_list'][$i]['student_name'] = $row['first_name'] ." ".$row['last_name'];;
                    $data['student_list'][$i]['roll_number'] = $row['roll_number'];
                }else {
                    $data['student_list'][$i]['student_id'] = $row['id'];
                    $data['student_list'][$i]['student_leave_status'] = null;
                    $data['student_list'][$i]['student_attendance_status'] = $attendanceStatus['status'];
                    $data['student_list'][$i]['student_name'] = $row['first_name'] ." ".$row['last_name'];;
                    $data['student_list'][$i]['roll_number'] = $row['roll_number'];
                }
                $i++;
            }
            return $data;
        }
        /**
         * Function Name: viewAttendance
         * @param ViewAttendanceRequest $request
         * @return $this|array|int
         * Desc:
         * Date: 3/2/2016
         * author manoj chaudahri
         */
        public function viewAttendance(ViewAttendanceRequest $request)
        {
            if ($request->authorize() === true)
            {
                $dropDownData = array();
                $divisionArray = array();
                $dataArray = array();
                $user = Auth::user();
                    if ($request->ajax()) {
                        $data = Input::all();
                        $division = $data['division'];
                        $date = date('Y-m-d',strtotime($data['date']));
                        $attendanceCount = Attendance::where('date',$date)->where('division_id',$division)->select('student_id')->count();
                        /*$presentStudents = Attendance::where('date',$date)->where('division_id',$division)->lists('student_id');
                        $attendance = User::where('division_id',$division)->whereNotIn('id',$presentStudents)->where('is_active',1)->select('id')->get();*/
                        $attendance = Attendance::where('date',$date)->where('division_id',$division)->select('student_id')->get();
                        $attendanceStatus = AttendanceStatus::where('date',$date)->where('division_id',$division)->count();
                           if($attendanceCount > 0) {
                               $i = 0;
                               foreach($attendance as $row) {
                                        $userData = User::where('id',$row['student_id'])->where('is_active',1)->first();
                                        $leaveStatus = Leave::where('student_id',$row['student_id'])->where('from_date',$date)->first();
                                        if($leaveStatus != null) {
                                            $dataArray[$i]['student_name'] = $userData['first_name'] ." ". $userData['last_name'] ;
                                            $dataArray[$i]['roll_number'] = $userData['roll_number'];
                                            $dataArray[$i]['leave_status'] = $leaveStatus['status'];
                                        } else {
                                            $dataArray[$i]['student_name'] = $userData['first_name'] ." ". $userData['last_name'] ;
                                            $dataArray[$i]['roll_number'] = $userData['roll_number'];
                                            $dataArray[$i]['leave_status'] = null;
                                        }
                               $i++;
                               }
                               return $dataArray;
                            } else {
                               if($attendanceStatus > 0) {
                                   return 2;
                               } else {
                                   return 0;
                               }
                            }
                    }
                if ($user->role_id == 1) {
                    $batchClassDivisionData=Division::
                        join('classes','divisions.class_id','=','classes.id')
                        ->join('batches','classes.batch_id','=','batches.id')
                        ->select('divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                        ->first();
                    if ($batchClassDivisionData != null) {
                        $dropDownData['division_id'] =  $batchClassDivisionData->division_id;
                        $dropDownData['division_name'] = $batchClassDivisionData->division_name;
                        $dropDownData['class_id'] = $batchClassDivisionData->class_id;
                        $dropDownData['class_name'] = $batchClassDivisionData->class_name;
                        $batch=Batch::where('body_id',$user->body_id)->get();
                        $i=0;
                        foreach ($batch as $row) {
                            $dropDownData['batch'][$i]['batch_id'] = $row['id'];
                            $dropDownData['batch'][$i]['batch_name'] = $row['name'];
                            $i++;
                        }
                    }

                        return view('viewAttendance')->with(compact('dropDownData'));
                } elseif ($user->role_id == 2) {
                    $division = array();
                    $divsionsData = array();
                    $divisionCheck = Division::where('class_teacher_id',$user->id)->first();
                       if ($divisionCheck != null) {
                            $divisionData = SubjectClassDivision::where('division_id','=',$divisionCheck['id'])
                                ->select('division_id')
                                ->get()->toArray();
                           $k = 0;
                            if (!Empty($divisionData))
                            {
                                foreach($divisionData as $value){
                                    $division['id'][$k]=$value['division_id'];
                                    $k++;
                                }
                            }
                            $divisionData = SubjectClassDivision::where('teacher_id','=',$user->id)
                                ->select('division_id')
                                ->get()->toArray();
                                $k = 0;
                                if (!Empty($divisionData))
                                {
                                    foreach($divisionData as $value){
                                        $division['id'][$k]=$value['division_id'];
                                        $k++;
                                    }
                                }
                            $divisionArray=array_unique($division['id'],SORT_REGULAR);
                            foreach ($divisionArray as $division_id) {
                                $finalData[]=Division::join('classes','divisions.class_id', '=', 'classes.id')
                                    ->join('batches','classes.batch_id','=','batches.id')
                                    ->where('divisions.id','=',$division_id)
                                    ->select('batches.name as batch_name','batches.id as batch_id')
                                    ->first();
                                $divsionsData[] = Division::join('classes','divisions.class_id', '=', 'classes.id')
                                    ->join('batches','classes.batch_id','=','batches.id')
                                    ->where('divisions.id','=',$division_id)
                                    ->select('batches.name as batch_name','batches.id as batch_id','classes.id as class_id','classes.class_name','divisions.id as division_id','divisions.division_name')
                                    ->first();
                            }
                           $finalData=array_unique($finalData,SORT_REGULAR);
                                if (!Empty($finalData)) {
                                    $i = 0;

                                    foreach ($finalData as $row) {
                                        $dropDownData['batch'][$i]['batch_id'] = $row['batch_id'];
                                        $dropDownData['batch'][$i]['batch_name'] = $row['batch_name'];
                                        $i++;
                                    }
                                    $dropDownData =array_unique($dropDownData,SORT_REGULAR);
                                    foreach ($divsionsData as $row) {
                                        $dropDownData['batch_id'] = $row['batch_id'];
                                        $dropDownData['batch_name'] = $row['batch_name'];
                                        $dropDownData['class_id'] = $row['class_id'];
                                        $dropDownData['class_name'] = $row['class_name'];
                                        $dropDownData['division_id'] =  $row['division_id'];
                                        $dropDownData['division_name'] = $row['division_name'];
                                    }

                                }


                           return view('viewAttendance')->with(compact('dropDownData'));
                        }   else {
                           $divisionData = SubjectClassDivision::where('teacher_id','=',$user->id)
                               ->select('division_id')
                               ->get()->toArray();
                           $k = 0;

                           if (!Empty($divisionData))
                           {
                               foreach($divisionData as $value){
                                   $division['id'][$k]=$value['division_id'];
                                   $k++;
                               }
                           } else {
                               return view('viewAttendance')->with(compact('dropDownData'));
                           }
                           $divisionArray=array_unique($division['id'],SORT_REGULAR);
                           $i=0;
                           foreach ($divisionArray as $division_id) {
                               $finalData[]=Division::join('classes','divisions.class_id', '=', 'classes.id')
                                   ->join('batches','classes.batch_id','=','batches.id')
                                   ->where('divisions.id','=',$division_id)
                                   ->select('batches.name as batch_name','batches.id as batch_id')
                                   ->first();
                               $divsionsData[] = Division::join('classes','divisions.class_id', '=', 'classes.id')
                                   ->join('batches','classes.batch_id','=','batches.id')
                                   ->where('divisions.id','=',$division_id)
                                   ->select('batches.name as batch_name','batches.id as batch_id','classes.id as class_id','classes.class_name','divisions.id as division_id','divisions.division_name')
                                   ->first();
                           }
                           $finalData=array_unique($finalData,SORT_REGULAR);
                           if (!Empty($finalData)) {
                               foreach ($finalData as $row) {
                                   $dropDownData['batch'][$i]['batch_id'] = $row['batch_id'];
                                   $dropDownData['batch'][$i]['batch_name'] = $row['batch_name'];
                                   $i++;
                               }
                               $dropDownData=array_unique($dropDownData,SORT_REGULAR);
                               foreach ($divsionsData as $row) {
                                   $dropDownData['batch_id'] = $row['batch_id'];
                                   $dropDownData['batch_name'] = $row['batch_name'];
                                   $dropDownData['class_id'] = $row['class_id'];
                                   $dropDownData['class_name'] = $row['class_name'];
                                   $dropDownData['division_id'] =  $row['division_id'];
                                   $dropDownData['division_name'] = $row['division_name'];
                               }
                           }
                           return view('viewAttendance')->with(compact('dropDownData'));
                        }
                } else {
                    Session::flash('message-success','no data found');
                }
            } else {
                return Redirect::to('/');
            }
        }

        /**
         * Function Name: markAttendanceAccess
         * @param:
         * @return int
         * Desc:
         * Date: 3/2/2016
         * author manoj chaudahri
         */
        public function markAttendanceAccess()
        {
            $user=Auth::user();
            if ($user->role_id == 2) {
            $divisionChceck = Division::where('class_teacher_id',$user->id)->count();
                if ($divisionChceck != 0) {
                   return 1;
                } else {
                    return 0;
                }
            } else {
                return 1;
            }
        }

        /**
         * Function Name: getAttendanceClasses
         * @param: $id
         * @return array
         * Desc:
         * Date: 10/2/2016
         * author manoj chaudahri
         */
        public function getAttendanceClasses($id) {
            $data = array();
            $division=array();
            $user = Auth::user();
            if ($user->role_id == 1) {
                $classData=Classes::where('batch_id',$id)->get();
                $i=0;
                foreach ($classData as $row) {
                    $data[$i]['class_id'] = $row['id'] ;
                    $data[$i]['class_name']= $row['class_name'] ;
                    $i++;
                }
                return $data;
            } elseif($user->role_id == 2) {
                $divisionCheck = Division::where('class_teacher_id',$user->id)->first();
                $k = 0;
                if ($divisionCheck != null) {
                    // data for class teacher
                    $divisionData=SubjectClassDivision::where('division_id','=',$divisionCheck['id'])
                        ->select('division_id')
                        ->get()->toArray();
                    if (!Empty($divisionData))
                    {
                        foreach($divisionData as $value){
                            $division['id'][$k]=$value['division_id'];
                            $k++;
                        }
                    }
                    // data for subject teacher
                    $divisionData=SubjectClassDivision::
                        where('teacher_id','=',$user->id)
                        ->select('division_id')
                        ->get()->toArray();
                    $k=0;
                    if (!Empty($divisionData))
                    {
                        foreach($divisionData as $value){
                            $division['id'][$k]=$value['division_id'];
                            $k++;
                        }
                    }
                    $divisionArray=array_unique($division['id'],SORT_REGULAR);
                    $i=0;
                        foreach ($divisionArray  as $value) {
                            $class_id=Division::where('id','=',$value)->select('divisions.class_id as class_id')->first();
                            $className=Classes::where('id','=',$class_id['class_id'])
                                ->where('batch_id','=',$id)
                                ->select('id','class_name as class_name')->first();
                            if(!Empty($class_id)&&!Empty($className)){
                                $data[$i]['class_id']=$class_id['class_id'];
                                $data[$i]['class_name']=$className['class_name'];
                                $i++;
                            }
                        }
                        $data=array_unique($data,SORT_REGULAR);
                        return $data;

                } else {

                    $divisionData=SubjectClassDivision::
                        where('teacher_id','=',$user->id)
                        ->select('division_id')
                        ->get()->toArray();
                    $k=0;
                    if (!Empty($divisionData))
                    {
                        foreach($divisionData as $value){
                            $division['id'][$k]=$value['division_id'];
                            $k++;
                        }
                    }
                    $divisionArray=array_unique($division['id'],SORT_REGULAR);
                    $i=0;
                    foreach ($divisionArray  as $value) {
                        $class_id=Division::where('id','=',$value)->select('divisions.class_id as class_id')->first();
                        $className=Classes::where('id','=',$class_id['class_id'])
                            ->where('batch_id','=',$id)
                            ->select('id','class_name as class_name')->first();
                        if (!Empty($class_id)&&!Empty($className)) {
                            $data[$i]['class_id']=$class_id['class_id'];
                            $data[$i]['class_name']=$className['class_name'];
                            $i++;
                        }
                    }
                    $data=array_unique($data,SORT_REGULAR);
                    return $data;
                }
            }

        }

        /**
         * Function Name: getAttendanceDivision
         * @param: $id,$batch_id
         * @return array
         * Desc:
         * Date: 10/2/2016
         * author manoj chaudahri
         */
        public function getAttendanceDivision($id,$batch_id) {
            $data=array();
            $user = Auth::user();
            $division=array();
            $finalData = array();
            if ($user->role_id == 1) {
                $divisionData=Division::where('class_id',$id)->get();
                $i=0;
                foreach ($divisionData as $row) {
                    $data[$i]['division_id'] = $row['id'] ;
                    $data[$i]['division_name']= $row['division_name'] ;
                    $i++;
                }
                return $data;
            } elseif($user->role_id == 2) {
                $divisionCheck = Division::where('class_teacher_id',$user->id)->first();
                if ($divisionCheck != null) {
                    //data for class teacher
                    $divisionData=SubjectClassDivision::where('division_id','=',$divisionCheck['id'])
                        ->select('division_id')
                        ->get()->toArray();
                    $divisionData=array_unique($divisionData,SORT_REGULAR);
                    $k = 0;
                    if (!Empty($divisionData))
                    {
                        foreach($divisionData as $value){
                            $division['id'][$k]=$value['division_id'];
                            $k++;
                        }
                    }
                    $divisionArray=array_unique($division['id'],SORT_REGULAR);
                    //data for subject teacher
                    $divisionData=SubjectClassDivision::
                        where('teacher_id','=',$user->id)
                        ->select('division_id')
                        ->get()->toArray();
                        $divisionData=array_unique($divisionData,SORT_REGULAR);
                        if (!Empty($divisionData))
                        {
                            foreach($divisionData as $value){
                                $division['id'][$k]=$value['division_id'];
                                $k++;
                            }
                        }
                        $divisionArray=array_unique($division['id'],SORT_REGULAR);
                        $i=0;
                        foreach($divisionArray as $division_id) {
                            $finalData[] = Division::join('classes','divisions.class_id', '=', 'classes.id')
                                ->where('divisions.class_id','=',$id)
                                ->where('classes.batch_id','=',$batch_id)
                                ->where('divisions.id','=',$division_id)
                                ->select('divisions.id as div_id','divisions.division_name')
                                ->first();
                            $i++;
                        }
                        $finalData = array_filter($finalData);
                        $i = 0;
                             foreach ($finalData as $row) {

                                 $data[$i]['division_id'] = $row['div_id'] ;
                                 $data[$i]['division_name']= $row['division_name'] ;
                                 $i++;
                             }
                    $data=array_unique($data,SORT_REGULAR);
                    return $data;

                } else {
                    $divisionData=SubjectClassDivision::
                        where('teacher_id','=',$user->id)
                        ->select('division_id')
                        ->get()->toArray();
                    $k=0;
                    if (!Empty($divisionData))
                    {
                        foreach($divisionData as $value){
                            $division['id'][$k]=$value['division_id'];
                            $k++;
                        }
                    }
                    $divisionArray=array_unique($division['id'],SORT_REGULAR);
                    $i=0;
                    foreach($divisionArray as $division_id) {
                        $finalData[] = Division::join('classes','divisions.class_id', '=', 'classes.id')
                            ->where('divisions.class_id','=',$id)
                            ->where('classes.batch_id','=',$batch_id)
                            ->where('divisions.id','=',$division_id)
                            ->select('divisions.id as div_id','divisions.division_name')
                            ->first();
                    }
                    $finalData = array_filter($finalData);
                        if (!Empty($finalData)) {
                            foreach ($finalData as $row) {
                                $data[$i]['division_id'] = $row['div_id'] ;
                                $data[$i]['division_name']= $row['division_name'] ;
                                $i++;
                            }
                        }

                    $data=array_unique($data,SORT_REGULAR);
                    return $data;
                }
            }
        }
    }
