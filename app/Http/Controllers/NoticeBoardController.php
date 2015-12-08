<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class NoticeBoardController extends Controller
{
    public function __construct()
    {
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
