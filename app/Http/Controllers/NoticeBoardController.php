<?php

namespace App\Http\Controllers;

use App\Batch;
use App\Classes;
use App\Division;
use App\SubjectClassDivision;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class NoticeBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function show()
    {
        return view('noticeBoard');
    }

    public function loadMore()
    {
        $str='{"august":[
                 { "day":"Monday", "date":"17", "time":" 12:00 PM" , "type":"announcement" , "title":"School Trip"},
                 { "day":"Saturday", "date":"15", "time":" 10:30 AM" , "type":"announcement" , "title":"Amount For School Trip"},
                 { "day":"Saturday", "date":"15", "time":" 10:00 AM" , "type":"acheivement" , "title":"First in state in SSC Results"},
                 { "day":"Friday", "date":"14", "time":" 9:30 AM" , "type":"announcement",  "title":"Parent Meet"},
                 { "day":"Friday", "date":"14", "time":" 9:00 AM" , "type":"acheivement", "title":"Second in Zonal Sport"}

             ],"july":[
                 { "day":"Thursday", "date":"13", "time":" 12:00 PM" , "type":"announcement","title":"Results for last exam published"},
                 { "day":"Thursday", "date":"13", "time":" 10:30 AM" , "type":"announcement", "title":"Zonal Sport timetable" },
                 { "day":"Thursday", "date":"13", "time":" 10:00 AM" , "type":"announcement" , "title":"Zonal Sport teams"}
             ]}';

        return $str;
    }
    /**
     * Function Name: showCreateAnnouncement
     * @param
     * @return mixed
     * Desc: will show all user to create announcement page
     * Date: 03/03/2016
     * author manoj chaudahri
     */
    public function showCreateAnnouncement(Request $request)
    {
        $user = Auth::user();
        $classDivision = array();
        $batchList = array();
        $divisionData2 = array();
        $divisionData1 = array();
        $divisionData = array();
        if ($user->role_id == 1) {
            $user=Auth::user();
            $batchData = Batch::where('body_id',$user->body_id)->select('id','name')->get();
            $batchList = $batchData->toArray();
            if ($request->ajax()) {
                $classData = Classes::where('batch_id',$request->batch_id)->select('id','class_name')->get();
                $classList = $classData->toArray();
            } else {
                $batch = Batch::where('body_id',$user->body_id)->select('id','name')->first();
                $classData = Classes::where('batch_id',$batch->id)->select('id','class_name')->get();
                $classList = $classData->toArray();
            }
            if($request->ajax()) {
                $count = 0;
                foreach($classList as $row) {
                    $classDivision[$count]['class_id'] = $row['id'];
                    $classDivision[$count]['class_name'] = $row['class_name'];
                    $divisionData = Division::where('class_id',$row['id'])->select('id','division_name')->get();
                    $countDivision = 0;
                        foreach($divisionData as $division) {
                                $classDivision[$count]['division'][$countDivision]['division_id'] = $division['id'];
                                $classDivision[$count]['division'][$countDivision]['division_name'] = $division['division_name'];
                                $countDivision++;
                        }
                    $count++;
                }
            } else {
                $count = 0;

                foreach($classList as $row) {
                    $classDivision[$count]['class_id'] = $row['id'];
                    $classDivision[$count]['class_name'] = $row['class_name'];
                    $divisionData = Division::where('class_id',$row['id'])->select('id','division_name')->get();
                    $countDivision = 0;
                    foreach($divisionData as $division) {
                        $classDivision[$count]['division'][$countDivision]['division_id'] = $division['id'];
                        $classDivision[$count]['division'][$countDivision]['division_name'] = $division['division_name'];
                        $countDivision++;
                    }
                    $count++;
                }
            }
        } elseif ($user->role_id == 2 ){
            $userCheck=Division::where('class_teacher_id',$user->id)->first();
            if ($userCheck != null) {
                $count=0;
                $batchClassData=Division::where('divisions.class_teacher_id',$user->id)
                    ->join('classes','divisions.class_id','=','classes.id')
                    ->join('batches','classes.batch_id','=','batches.id')
                    ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                    ->get()->toArray();
                $divisionSubjects=SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                    ->join('classes','divisions.class_id','=','classes.id')
                    ->join('batches','classes.batch_id','=','batches.id')
                    ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                    ->get()->toArray();

                $mergedArray = array_merge($batchClassData,$divisionSubjects);
                $mergedArray = array_unique($mergedArray, SORT_REGULAR);
                foreach($mergedArray as $row) {
                     $batchList[$count]['id'] = $row['batch_id'];
                     $batchList[$count]['name'] = $row['batch_name'];
                     $count++;
                }
                $batchList = array_unique($batchList, SORT_REGULAR);
                $countClass = 0;
                foreach($mergedArray as $row) {
                     $classDivision[$countClass]['class_id'] = $row['class_id'];
                     $classDivision[$countClass]['class_name'] = $row['class_name'];
                    if ($userCheck != null) {
                    $divisionData1[] = Division::where('class_id',$row['class_id'])->where('class_teacher_id',$user->id)->select('id','division_name')->get()->toArray();
                    }
                    $divisionSubject = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get()->toArray();
                    $divisionSubject = array_unique($divisionSubject, SORT_REGULAR);
                    $count = 0;
                     foreach($divisionSubject as $divs ) {
                         $divisionData2[$count] =Division::where('class_id',$row['class_id'])->where('id',$divs['division_id'])
                                                             ->select('id','division_name')->get()->toArray();
                         $count++;
                     }
                     $divisionData2 = array_filter($divisionData2);
                     $divisionData = array_merge ($divisionData1, $divisionData2);
                     $divisionData = array_unique($divisionData, SORT_REGULAR);
                     $countDivision = 0;
                     foreach($divisionData as $division) {
                          foreach($division as $row) {
                            $classDivision[$countClass]['division'][$countDivision]['division_id'] = $row['id'];
                            $classDivision[$countClass]['division'][$countDivision]['division_name'] = $row['division_name'];
                          }
                         $countDivision++;
                     }
                        $countClass++;
                    }
                $classDivision = array_unique($classDivision, SORT_REGULAR);
            } else {
                // subject teacher
            }
        }
        if($request->ajax()) {
            return $classDivision;
        } else {
            return view('createNoticeBoard')->with(compact('batchList','classDivision'));
        }

    }

    /**
     * Function Name: getAllAdmins
     * @param
     * @return mixed
     * Desc: will show all admins of body
     * Date: 03/03/2016
     * author manoj chaudahri
     */

    public function getAllAdmins()
    {
        $user = Auth::user();
        $adminList = User::where('role_id',1)->where('is_active',1)->where('body_id',$user->body_id)->select('id','first_name','last_name')->get();
        return $adminList;

    }

    /**
     * Function Name: getAllTeachers
     * @param
     * @return mixed
     * Desc: will show all teachers of body
     * Date: 03/03/2016
     * author manoj chaudahri
     */

    public function getAllTeachers()
    {
        $user = Auth::user();
        $teacherList = User::where('role_id',2)->where('is_active',1)->where('body_id',$user->body_id)->select('id','first_name','last_name')->get();
        return $teacherList;

    }


    public function createNoticeBoard()
    {
        return view('createNoticeBoard');
    }

    public function detailAnnouncement()
    {
        return view('detailAnnouncement');
    }
    public function detailAchievement()
    {
        return view('detailAchievement');
    }
}
