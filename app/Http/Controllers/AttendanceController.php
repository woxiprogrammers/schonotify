<?php

    namespace App\Http\Controllers;

    use App\Attendance;
    use App\Batch;
    use App\Classes;
    use App\Division;
    use App\Http\Requests\WebRequests\CreateAttendanceRequest;
    use App\Leave;
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
        public function __construct()
        {
            $this->middleware('db');
            $this->middleware('auth');
        }

       /**
       * @param CreateAttendanceRequest $request
       *
       * @return $this|array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
       * Author:manoj chaudhari
       */

        public function markAttendance(CreateAttendanceRequest $request)
        {
            if ($request->authorize() === true)
            {
                $user=Auth::user();
                $dropDownData=array();
                if ($request->ajax()) {
                    $data = Input::all();
                    $division=$data['division'];
                    $date=date('Y-m-d',strtotime($data['value']));
                } else {
                    $date=date('Y-m-d', time());
                }
                if ($user->role_id == 2){
                    $userCheck=Division::where('class_teacher_id',$user->id)->first();
                    if ($userCheck != null) {
                        $i=0;
                        $batchClassData=Classes::where('classes.id',$userCheck->class_id)
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->first();
                        if($batchClassData != null){
                            $studentData=User::where('division_id',$userCheck->id)->where('is_active',1)->select('id','first_name','last_name','roll_number')->get();
                            $dropDownData['division_id'] = $userCheck->id;
                            $dropDownData['division_name'] = $userCheck->division_name;
                            $dropDownData['class_id'] = $batchClassData->class_id;
                            $dropDownData['class_name'] = $batchClassData->class_name;
                            $dropDownData['batch'][$i]['batch_id'] = $batchClassData->batch_id;
                            $dropDownData['batch'][$i]['batch_name'] = $batchClassData->batch_name;
                            $i=0;
                            foreach ($studentData as $student) {
                                $leaveStatus = Leave::where('student_id',$student['id'])->where('from_date',$date)->select('student_id','status')->first();
                                $attendanceStatus = Attendance::where('student_id',$student['id'])->where('date',$date)->select('student_id','status')->first();
                                if ($leaveStatus != null) {
                                    $dropDownData['student_list'][$i]['student_id'] = $student['id'];
                                    $dropDownData['student_list'][$i]['student_leave_status'] = $leaveStatus['status'];
                                    $dropDownData['student_list'][$i]['student_attendance_status'] = $attendanceStatus['status'];
                                    $dropDownData['student_list'][$i]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                    $dropDownData['student_list'][$i]['roll_number'] = $student['roll_number'];
                                } else {
                                    $dropDownData['student_list'][$i]['student_id'] = $student['id'];
                                    $dropDownData['student_list'][$i]['student_leave_status'] = null;
                                    $dropDownData['student_list'][$i]['student_attendance_status'] = $attendanceStatus['status'];;
                                    $dropDownData['student_list'][$i]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                    $dropDownData['student_list'][$i]['roll_number'] = $student['roll_number'];
                                }
                                $i++;
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
                    if($request->ajax()) {
                        $data = Input::all();
                        $division=$data['division'];
                        $batchClassDivisionData=Division::where('divisions.id',$division)->
                            join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                            ->first();
                    }else {
                        $batchClassDivisionData=Division::
                            join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                            ->first();
                    }
                            if ($batchClassDivisionData != null) {
                                $studentData=User::where('division_id',$batchClassDivisionData->division_id)->where('is_active',1)->select('id','first_name','last_name','roll_number')->get();
                                $dropDownData['division_id'] =  $batchClassDivisionData->division_id;
                                $dropDownData['division_name'] = $batchClassDivisionData->division_name;
                                $dropDownData['class_id'] = $batchClassDivisionData->class_id;
                                $dropDownData['class_name'] = $batchClassDivisionData->class_name;
                                $batch=Batch::get();
                                $i=0;
                                foreach ($batch as $row){
                                    $dropDownData['batch'][$i]['batch_id'] = $row['id'];
                                    $dropDownData['batch'][$i]['batch_name'] = $row['name'];
                                    $i++;
                                }
                                $i=0;
                                foreach ($studentData as $student) {
                                    $leaveStatus=Leave::where('student_id',$student['id'])->where('from_date',$date)->select('student_id','status')->first();
                                    $attendanceStatus = Attendance::where('student_id',$student['id'])->where('date',$date)->select('student_id','status')->first();
                                    if ($leaveStatus != null) {
                                        $dropDownData['student_list'][$i]['student_id'] = $student['id'];
                                        $dropDownData['student_list'][$i]['student_leave_status'] = $leaveStatus['status'];
                                        $dropDownData['student_list'][$i]['student_attendance_status'] = $attendanceStatus['status'];
                                        $dropDownData['student_list'][$i]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                        $dropDownData['student_list'][$i]['roll_number'] = $student['roll_number'];

                                    } else {
                                        $dropDownData['student_list'][$i]['student_id'] = $student['id'];
                                        $dropDownData['student_list'][$i]['student_leave_status'] = null;
                                        $dropDownData['student_list'][$i]['student_attendance_status'] = $attendanceStatus['status'];
                                        $dropDownData['student_list'][$i]['student_name'] = $student['first_name'] ." ".$student['last_name'];;
                                        $dropDownData['student_list'][$i]['roll_number'] = $student['roll_number'];
                                    }
                                    $i++;
                             }
                    if ($request->ajax()) {
                         return $dropDownData;
                    } else {
                         return view('markAttendance')->with(compact('dropDownData'));
                    }
                 }

                } else{
                }
                return view('markAttendance');
            } else {
                return Redirect::to('/');
            }
        }

        /**
         * @param CreateAttendanceRequest $request
         * Author:manoj chaudhari
         * @return mixed
         */
        public function attendanceMark(CreateAttendanceRequest $request){

            $user = Auth::user();
            $saveData = array();
            $userIds=array();
            $dataList=array();
            $userIds = $request->student;
            $date=date("Y-m-d",strtotime($request->datePiker));
            $userData = User::whereNotIn('id',$userIds)->where('division_id',$request['division-select'])->select('id')->get();
            $i=0;
            foreach ($userData as $data){
                $dataList[]=$data['id'];
                $i++;
            }
            $attendanceCheck=Attendance::whereIn('student_id',$dataList)->where('date',$date)->get();
                if ($attendanceCheck != null){
                    Attendance::whereIn('student_id',$request['student'])->where('date',$date)->delete();
                }
                    $i=0;
                    foreach ($userData as $row) {
                        $saveData['teacher_id'] = $user->id;
                        $saveData['date'] =date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $request->datePiker)));;
                        $saveData['student_id'] = $row['id'];
                        $saveData['status'] = 1;
                        $saveData['created_at'] = Carbon::now();
                        $saveData['updated_at'] = Carbon::now();
                        $i++;
                        Attendance::insert($saveData);
                    }
            Session::flash('message-success','attendance saved successfully');
            return Redirect::to('/mark-attendance');
        }


        /**
         * @param $id
         * Author:manoj chaudhari
         * @return array
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
         * @param $id
         * Author:manoj chaudhari
         * @return array
         */

        public function getAllDivision($id){

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
         * @param $id
         * @param $dateValue
         * Author:manoj chaudhari
         * @return array
         */

        public function getAllStudent($id,$dateValue){

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
                }else{
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
         * @param Requests\WebRequests\ViewAttendanceRequest $request
         * Author:manoj chaudhari
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */

        public function viewAttendance(Requests\WebRequests\ViewAttendanceRequest $request)
        {
            if($request->authorize()===true)
            {
                return view('viewAttendance');
            }else{
                return Redirect::to('/');
            }

        }

    }
