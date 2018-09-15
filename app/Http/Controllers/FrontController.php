<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventTypes;
use App\Homework;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Route;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use DateTime;
class FrontController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('db');

    }

    public function index(Request $request)
    {
        if(isset(Auth::user()->email))
        {
            $userInfo= User::Join('module_acls', 'users.id', '=', 'module_acls.user_id')
                ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
                ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
                ->where('users.id','=',Auth::user()->id)
                ->select('users.id','users.email','users.username as username','users.first_name as firstname','users.last_name as lastname','acl_master.slug as acl','modules.title as module','modules.slug as module_slug')
                ->get();
            $resultArr=array();
            foreach($userInfo as $user) {
                array_push($resultArr,$user->acl.'_'.$user->module_slug);
            }
            $userId = Auth::user()->id;
            $date = new Carbon();
            $date->subDays(2);
            //homework
            $homeworkData = Homework::join('homework_teacher','homework_teacher.homework_id','=','homeworks.id')
                                    ->join('homework_types','homework_types.id','=','homeworks.homework_type_id')
                                    ->join('divisions','divisions.id','=','homework_teacher.division_id')
                                    ->join('classes','classes.id','=','divisions.class_id')
                                    ->join('users','users.id','=','homework_teacher.teacher_id')
                                    ->where('homeworks.is_active',1)
                                    ->where('homeworks.created_at', '>=', $date->toDateTimeString())
                                    ->distinct('homeworks.id')
                                    ->select('homeworks.title','homeworks.description','homework_types.title as homework_type','divisions.division_name','classes.class_name','homeworks.created_at','users.first_name','users.last_name')
                                    ->orderBy('homeworks.created_at','desc')->get()->toArray();
            //Events
            $achievementsId = EventTypes::where('slug','achievement')->pluck('id');
            $announcementId = EventTypes::where('slug','announcement')->pluck('id');
            $eventId = EventTypes::where('slug','event')->pluck('id');
            $achievementsData = Event::where('event_type_id',$achievementsId)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $announcementData = Event::where('event_type_id',$announcementId)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $eventData = Event::where('event_type_id',$eventId)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $unreadMsgCount = Message::where('to_id',$userId)->where('read_status',0)->count();
            Session::put('functionArr',$resultArr);
            return view('admin.dashboard', compact('unreadMsgCount','homeworkData','achievementsData','announcementData','eventData'));

        }else{

            return view('login_signin');
        }
    }
}
