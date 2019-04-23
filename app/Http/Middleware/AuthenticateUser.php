<?php
namespace App\Http\Controllers\api;
use App\Attendance;
use App\AttendanceStatus;
use App\Batch;
use App\Classes;
use App\Division;
use App\Leave;
use App\LeaveRequest;
use App\SubjectClassDivision;
use App\User;
use App\UserRoles;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use App\PushToken;
class AttendanceController extends Controller
{
    use PushNotificationTrait;
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }
    /*
   * Function Name: getAttendanceBatches
   * Param : Request $requests
   * Return :Return the data of batches as JSON array
   * Desc : Display list of batches to the teacher to mark attendance
   * Developed By : shubham chaudhari
   * Date : 6/2/2016
   */
   public function getAttendanceBatches(Request $request){
     $data=$request->all();
     $batches = Batch::where('body_id',$data['teacher']['body_id'])->get()->toArray();
     return response($batches);
   }
    public function getAttendanceClasses(Request $request,$batchId){
     $data=$request->all();
     $classes = Classes::where('batch_id',$batchId)->get()->toArray();
     return response($classes);
    }
    public function getAttendanceDivisions(Request $request,$classId){
     $data=$request->all();
     $Division = Division::where('class_id',$classId)->get()->toArray();
     return response($Division);
    }
}
    /*
    public function g