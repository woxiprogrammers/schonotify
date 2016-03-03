<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
    public function showCreateAnnouncement()
    {
        $user = Auth::user();
        if ($user->role_id == 1) {

        } elseif ($user->role_id == 2 ){

        }
        return view('createNoticeBoard');
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
