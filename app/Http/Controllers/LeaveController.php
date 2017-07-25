<?php
namespace App\Http\Controllers;
use App\Batch;
use App\Classes;
use App\Division;
use App\Leave;
use App\LeaveType;
use App\User;
use App\Module;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use Illuminate\Http\Request;
use App\PushToken;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
class LeaveController extends Controller
{
    use PushNotificationTrait;
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    /**
     * Function Name: leaveListing
     * @param:
     * @return leave list
     * Desc:it will return list of approved leave on load ,there will lazy load on scroll of window
     * Date: 18/2/2016
     * author manoj chaudahri
     */
    public function leaveListing(Requests\WebRequests\LeaveRequest $request)
    {
        if ($request->authorize() === true)
        {
            $user = Auth::user();
            $dropDownData = array();
            $leaveArray = array();
            if ($user->role_id == 2) {
                $userCheck = Division::where('class_teacher_id',$user->id)->first();
                if ($userCheck != null) {
                    $batchClassData=Classes::where('classes.id',$userCheck->class_id)
                        ->join('batches','classes.batch_id','=','batches.id')
                        ->select('classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                        ->first();
                    if ($batchClassData != null) {
                        if ($request->ajax()) {
                            $data = Input::all();
                            $status = $data['leave_status'];
                            $pageCount = $data['pageCount'];
                            $leaveStatus = Leave::where('division_id',$userCheck->id)->where('status',$status)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get();
                        } else {
                            $pageCount = 0;
                            $leaveStatus = Leave::where('division_id',$userCheck->id)->where('status',2)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get();
                        }
                            $i = 0;
                            foreach ($leaveStatus as $row) {
                                $studentData = User::where('id',$row['student_id'])->where('is_active',1)->select('id','first_name','last_name','roll_number','avatar','parent_id')->first();
                                $leaveArray[$i]['student_id'] = $row['student_id'];
                                $leaveArray[$i]['parent'] = $studentData['first_name'] ." ".$studentData['last_name'];
                                $leaveArray[$i]['roll_number'] = $studentData['roll_number'];
                                $leaveArray[$i]['avatar'] = $studentData['avatar'];
                                $leaveArray[$i]['title'] = $row['title'];
                                $leaveArray[$i]['leave_id'] = $row['id'];
                                $leaveArray[$i]['leave_type'] = $row['leave_type'];
                                $leaveArray[$i]['reason'] = $row['reason'];
                                $leaveArray[$i]['from_date'] = $row['from_date'];
                                $leaveArray[$i]['end_date'] = $row['end_date'];
                                $leaveArray[$i]['created_date'] = $row['created_at'];
                                $i++;
                            }
                                $leaveArray = array_unique($leaveArray,SORT_REGULAR);
                        if ($request->ajax()) {
                            return $leaveArray;
                        } else {
                            return view('leaveListing')->with(compact('leaveArray'));
                        }
                    } else {
                        Session::flash('message-success','no record found');
                    }
                } else {
                    Session::flash('message-success','no record found');
                }
            } elseif ($user->role_id == 1) {
                    $batchClassDivisionData = Division::
                    join('classes','divisions.class_id','=','classes.id')
                    ->join('batches','classes.batch_id','=','batches.id')
                    ->select('divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                    ->first();
                        if ($batchClassDivisionData != null) {
                            if ($request->ajax()) {
                                $data = Input::all();
                                $pageCount = $data['pageCount'];
                                $status = $data['leave_status'];
                                $division_id = $data['division'];
                                $leaveStatus = Leave::where('division_id',$division_id)->where('status',$status)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get();
                            } else {
                            $pageCount = 0;
                            $leaveStatus = Leave::where('division_id',$batchClassDivisionData['division_id'])->where('status',2)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get();
                            }
                            $i = 0;
                                foreach ($leaveStatus as $row) {
                                    $studentData = User::where('id',$row['student_id'])->where('is_active',1)->select('id','first_name','last_name','roll_number','avatar','parent_id')->first();
                                    $leaveArray[$i]['student_id'] = $row['student_id'];
                                    $leaveArray[$i]['parent'] = $studentData['first_name'] ." ".$studentData['last_name'];
                                    $leaveArray[$i]['roll_number'] = $studentData['roll_number'];
                                    $leaveArray[$i]['avatar'] = $studentData['avatar'];
                                    $leaveArray[$i]['title'] = $row['title'];
                                    $leaveArray[$i]['leave_id'] = $row['id'];
                                    $leaveArray[$i]['leave_type'] = $row['leave_type'];
                                    $leaveArray[$i]['reason'] = $row['reason'];
                                    $leaveArray[$i]['from_date'] = $row['from_date'];
                                    $leaveArray[$i]['end_date'] = $row['end_date'];
                                    $leaveArray[$i]['created_date'] = $row['created_at'];
                                    $i++;
                                }
                                $leaveArray = array_unique($leaveArray,SORT_REGULAR);
                                $dropDownData['division_id'] =  $batchClassDivisionData->division_id;
                                $dropDownData['division_name'] = $batchClassDivisionData->division_name;
                                $dropDownData['class_id'] = $batchClassDivisionData->class_id;
                                $dropDownData['class_name'] = $batchClassDivisionData->class_name;
                                $batch=Batch::get();
                                $i=0;
                            foreach ($batch as $row) {
                                $dropDownData['batch'][$i]['batch_id'] = $row['id'];
                                $dropDownData['batch'][$i]['batch_name'] = $row['name'];
                                $i++;
                            }
                            if ($request->ajax()) {
                                return $leaveArray;

                            } else {
                                return view('leaveListing')->with(compact('leaveArray','dropDownData'));
                            }
                        } else {
                            return view('leaveListing')->with(compact('leaveArray','dropDownData'));
                        }
            }
        } else {
            return Redirect::to('/');
        }
    }
    /**
     * Function Name: detailedLeave
     * @param: leave_id
     * @return detail leave
     * Desc:it will return deatial info. of perticular leave
     * Date: 18/2/2016
     * author manoj chaudahri
     */
    public function detailedLeave(Requests\WebRequests\LeaveRequest $request,$leaveId)
    {
        if($request->authorize()===true)
        {
            $leaveStatus = Leave::where('id',$leaveId)->first();
            $approvePerson = User::where('id',$leaveStatus['approved_by'])->first();
            $leavetype = LeaveType::where('id',$leaveStatus['leave_type'])->first();
            $studentData = User::where('users.id',$leaveStatus->student_id)
                              ->where('users.is_active',1)
                              ->join('divisions','users.division_id','=','divisions.id')
                              ->join('classes','divisions.class_id','=','classes.id')
                              ->join('batches','classes.batch_id','=','batches.id')
                              ->select('users.id as user_id','first_name','last_name','roll_number','avatar','parent_id','divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                              ->first();
                $parentData = User::where('id',$studentData['parent_id'])->select('id','first_name','last_name','roll_number','avatar')->first();
                $leaveArray['student_id'] = $studentData['user_id'];
                $leaveArray['parent'] = $parentData['first_name'] ." ".$parentData['last_name'];
                $leaveArray['student'] = $studentData['first_name'] ." ".$studentData['last_name'];
                $leaveArray['roll_number'] = $studentData['roll_number'];
                $leaveArray['avatar'] = $parentData['avatar'];
                $leaveArray['title'] = $leaveStatus['title'];
                $leaveArray['approved_by'] = $approvePerson['first_name'] ." ".$approvePerson['last_name'];
                $leaveArray['leave_status'] = $leaveStatus['status'];
                $leaveArray['leave_id'] = $leaveStatus['id'];
                $leaveArray['batch_id'] = $studentData['batch_id'];
                $leaveArray['batch_name'] = $studentData['batch_name'];
                $leaveArray['class_id'] = $studentData['class_id'];
                $leaveArray['class_name'] = $studentData['class_name'];
                $leaveArray['division_id'] = $studentData['division_id'];
                $leaveArray['division_name'] = $studentData['division_name'];
                $leaveArray['leave_type'] = $leavetype['name'];
                $leaveArray['reason'] = $leaveStatus['reason'];
                $leaveArray['from_date'] = $leaveStatus['from_date'];
                $leaveArray['end_date'] = $leaveStatus['end_date'];
                $leaveArray['created_date'] = $leaveStatus['created_at'];
                $leaveArray['updated_date'] = $leaveStatus['updated_at'];
                return view('detailedLeave')->with(compact('leaveArray'));
        }else{
            return Redirect::to('/');
        }
    }
    /**
     * Function Name: leaveAccess
     * @param:
     * @return int
     * Desc:it will check wheather leave access available for perticular user
     * Date: 10/2/2016
     * author manoj chaudahri
     */
    public function leaveAccess()
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
     * Function Name: leaveCount
     * @param:
     * @return int
     * Desc:it will return count of all pending leaves for perticular divsion of class teacher
     * Date: 18/2/2016
     * author manoj chaudahri
     */
    public function leaveCount()
    {
        $user=Auth::user();
        if ($user->role_id == 2) {
            $divisionChceck = Division::where('class_teacher_id',$user->id)->first();
            if ($divisionChceck != null) {
                $leaveCount = Leave::where('division_id',$divisionChceck->id)->where('status',1)->count();
                return $leaveCount;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    /**
     * Function Name: publishLeave
     * @param: leave_id
     * @return int
     * Desc:it will publish leave on basis of leave id
     * Date: 18/2/2016
     * author manoj chaudahri
     */
    public function publishLeave(Requests\WebRequests\PublishLeaveRequest $request , $id)
    {   if($request->authorize() === true)
        {
            $leaveUpdate = array();
            $user = Auth::user();
            $leaveUpdate['status'] = 2;
            $leaveUpdate['approved_by'] = $user->id;
            $leaveStatus = Leave::where('id',$id)->update($leaveUpdate);
            if ($leaveStatus == 1)
            {
                $student = Leave::where('id',$id)->pluck('student_id');
                $parent = User::where('id',$student)->lists('parent_id');
                $title = "Leave Approved";
                $message = "Your Leave Is Approved By Faculty";
                $allUser=0;
                $state = Module::where('id',8)->pluck('slug');
                $push_users=PushToken::whereIn('user_id',$parent)->lists('push_token');
                $this -> CreatePushNotification($title,$message,$allUser,$push_users,$state);
                Session::flash('message-success','Leave published successfully');
                return Redirect::back();
            }
        } else {
            return Redirect::back();
        }
    }
    /**
     * Function Name: leaveStatusListing
     * @param:
     * @return int
     * Desc:it will return list of approved or pending leave on chnage of dropdown ,there will lazy load on scroll of window
     * Date: 16/2/2016
     * author manoj chaudahri
     */
    public function leaveStatusListing(Requests\WebRequests\LeaveRequest $request,$leaveStatus,$divisionId)
    {
        if ($request->authorize() === true)
        {
            $user = Auth::user();
            $dropDownData = array();
            $leaveArray = array();
            if ($user->role_id == 2) {
                $userCheck = Division::where('class_teacher_id',$user->id)->first();
                if ($userCheck != null) {
                    $batchClassData=Classes::where('classes.id',$userCheck->class_id)
                        ->join('batches','classes.batch_id','=','batches.id')
                        ->select('classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                        ->first();
                    if ($batchClassData != null) {
                        $pageCount = 0;
                        $leaveStatus = Leave::where('division_id',$userCheck->id)->where('status',$leaveStatus)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get();
                        $i = 0;
                        foreach ($leaveStatus as $row) {
                            $studentData = User::where('id',$row['student_id'])->where('is_active',1)->select('id','first_name','last_name','roll_number','avatar','parent_id')->first();
                            $leaveArray[$i]['student_id'] = $row['student_id'];
                            $leaveArray[$i]['parent'] = $studentData['first_name'] ." ".$studentData['last_name'];
                            $leaveArray[$i]['roll_number'] = $studentData['roll_number'];
                            $leaveArray[$i]['avatar'] = $studentData['avatar'];
                            $leaveArray[$i]['title'] = $row['title'];
                            $leaveArray[$i]['leave_id'] = $row['id'];
                            $leaveArray[$i]['leave_type'] = $row['leave_type'];
                            $leaveArray[$i]['reason'] = $row['reason'];
                            $leaveArray[$i]['from_date'] = $row['from_date'];
                            $leaveArray[$i]['end_date'] = $row['end_date'];
                            $leaveArray[$i]['created_date'] = $row['created_at'];
                            $i++;
                        }
                        $leaveArray = array_unique($leaveArray,SORT_REGULAR);
                        return $leaveArray;
                    } else {
                        Session::flash('message-success','no record found');
                    }
                } else {
                    Session::flash('message-success','no record found');
                }
            } elseif ($user->role_id == 1) {
                $batchClassDivisionData = Division::
                    join('classes','divisions.class_id','=','classes.id')
                    ->join('batches','classes.batch_id','=','batches.id')
                    ->select('divisions.id as division_id','divisions.division_name','classes.id as class_id','classes.class_name','batches.id as batch_id','batches.name as batch_name')
                    ->first();
                if ($batchClassDivisionData != null) {
                    $pageCount = 0;
                    $leaveStatus = Leave::where('division_id',$divisionId)->where('status',$leaveStatus)->skip($pageCount*4)->take(4)->orderBy('created_at', 'desc')->get();
                    $i = 0;
                    foreach ($leaveStatus as $row) {
                        $studentData = User::where('id',$row['student_id'])->where('is_active',1)->select('id','first_name','last_name','roll_number','avatar','parent_id')->first();
                        $leaveArray[$i]['student_id'] = $row['student_id'];
                        $leaveArray[$i]['parent'] = $studentData['first_name'] ." ".$studentData['last_name'];
                        $leaveArray[$i]['roll_number'] = $studentData['roll_number'];
                        $leaveArray[$i]['avatar'] = $studentData['avatar'];
                        $leaveArray[$i]['title'] = $row['title'];
                        $leaveArray[$i]['leave_id'] = $row['id'];
                        $leaveArray[$i]['leave_type'] = $row['leave_type'];
                        $leaveArray[$i]['reason'] = $row['reason'];
                        $leaveArray[$i]['from_date'] = $row['from_date'];
                        $leaveArray[$i]['end_date'] = $row['end_date'];
                        $leaveArray[$i]['created_date'] = $row['created_at'];
                        $i++;
                    }
                    $leaveArray = array_unique($leaveArray,SORT_REGULAR);
                    $dropDownData['division_id'] =  $batchClassDivisionData->division_id;
                    $dropDownData['division_name'] = $batchClassDivisionData->division_name;
                    $dropDownData['class_id'] = $batchClassDivisionData->class_id;
                    $dropDownData['class_name'] = $batchClassDivisionData->class_name;
                    $batch=Batch::get();
                    $i=0;
                    foreach ($batch as $row) {
                        $dropDownData['batch'][$i]['batch_id'] = $row['id'];
                        $dropDownData['batch'][$i]['batch_name'] = $row['name'];
                        $i++;
                    }
                    return $leaveArray;
                } else {
                    return $leaveArray;
                }
            }
        } else {
            return Redirect::to('/');
        }
    }
}
