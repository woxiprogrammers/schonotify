<?php
    namespace App\Http\Controllers;
    use App\Batch;
    use App\Classes;
    use App\Division;
    use App\Event;
    use App\EventImages;
    use App\PushToken;
    use App\EventUserRoles;
    use App\Http\Controllers\CustomTraits\PushNotificationTrait;
    use App\Http\Requests\WebRequests\CreateAchievementRequest;
    use App\Http\Requests\WebRequests\CreateAnnouncementRequest;
    use App\Http\Requests\WebRequests\DeleteAchievementRequest;
    use App\Http\Requests\WebRequests\DeleteAnnouncementRequest;
    use App\Http\Requests\WebRequests\EditAchievementRequest;
    use App\Http\Requests\WebRequests\EditAnnouncementRequest;
    use App\Http\Requests\WebRequests\NoticeBoardRequest;
    use App\Http\Requests\WebRequests\PublishAchievementRequest;
    use App\Http\Requests\WebRequests\PublishAnnouncementRequest;
    use App\SubjectClassDivision;
    use App\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\Facades\Log;
    class NoticeBoardController extends Controller
    {
        use PushNotificationTrait;
        public function __construct()
        {
            $this->middleware('db');
            $this->middleware('auth');
        }
        /*
        * Function Name : show
        * Param : Request $request
        * Return : view of listing
        * Desc : it will return listing page of noticeboard.
        * Developed By : Suraj Bande
        * Date : 28/3/2016
        */
        public function show(NoticeBoardRequest $request)
        {
            if($request->authorize() == 4) {
                return Redirect::to('/');
            } else {
                return view('noticeBoard');
            }
        }
        /*
        * Function Name : getListing
        * Param : Request $request,$id
        * Return : listing data
        * Desc : it will return listing data of noticeboard.
        * Developed By : Suraj Bande
        * Date : 28/3/2016
        */
        public function getListing(NoticeBoardRequest $request,$id)
        {
            $user = Auth::User();
            $latestEventDate = date('Y-m');
            $month = date('m', strtotime(date($latestEventDate)." -".$id." month"));
            $year = date('Y', strtotime(date($latestEventDate)." -".$id." month"));
            if($request->authorize() === 1) {
                if($user->role_id == 1) {
                    //admin will get self created , assigned for publish, assigned published and self pending announcement / achievement [1,2]
                    $adminAnnouncement = $this::getAdminAnnouncement($month,$year,$id);
                    $adminAchievement = $this::getAdminAchievement($month,$year,$id);
                    if($id == 0) {
                        $adminAnnouncementArray = array();
                        $adminAchievementArray = array();
                        foreach($adminAnnouncement as $key=>$value)
                        {
                            $lastDateAnnouncement = $key;
                            $adminAnnouncementArray = $value;
                        }
                        foreach($adminAchievement as $key=>$value)
                        {
                            $lastDateAchievement = $key;
                            $adminAchievementArray = $value;
                        }
                        if($lastDateAnnouncement != "" && $lastDateAchievement != "")
                        {
                            if(strtotime($lastDateAnnouncement) > strtotime($lastDateAchievement))
                            {
                                $lastDate = $lastDateAchievement;
                            } else {
                                $lastDate = $lastDateAnnouncement;
                            }
                        } else if($lastDateAnnouncement != ""){
                            $lastDate = $lastDateAnnouncement;
                        } else if($lastDateAchievement != "") {
                            $lastDate = $lastDateAchievement;
                        } else {
                            $lastDate = "";
                        }
                        $result = array_merge($adminAnnouncementArray,$adminAchievementArray);
                        $temp_array = array();
                        foreach ($result as $key=>$value) {
                             if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $price = array();
                        foreach ($temp_array as $key => $row)
                        {
                            $price[$key] = $row['created_at'];
                        }
                        array_multisort($price, SORT_DESC, $temp_array);
                        $uniqueResult[$lastDate] = array_values($temp_array);
                    } else {
                        $result = array_merge($adminAchievement,$adminAnnouncement);
                        $temp_array = array();
                        foreach ($result as $key=>$value) {
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $price = array();
                        foreach ($temp_array as $key => $row)
                        {
                            $price[$key] = $row['created_at'];
                        }
                        array_multisort($price, SORT_DESC, $temp_array);
                        $uniqueResult = array_values($temp_array);
                    }
                    return $uniqueResult;
                } elseif ($user->role_id == 2) {
                    //teacher will get self created , self pending and all publish announcement / achievement [1,2]
                    $teacherAnnouncement = $this::getTeacherAnnouncement($month,$year,$id);
                    $teacherAchievement = $this::getTeacherAchievement($month,$year,$id);
                    if($id == 0) {
                        $teacherAnnouncementArray = array();
                        $teacherAchievementArray = array();
                        foreach($teacherAnnouncement as $key=>$value)
                        {
                            $lastDateAnnouncement = $key;
                            $teacherAnnouncementArray = $value;
                        }
                        foreach($teacherAchievement as $key=>$value)
                        {
                            $lastDateAchievement = $key;
                            $teacherAchievementArray = $value;
                        }
                        if($lastDateAnnouncement != "" && $lastDateAchievement != "")
                        {
                            if(strtotime($lastDateAnnouncement) > strtotime($lastDateAchievement))
                            {
                                $lastDate = $lastDateAchievement;
                            } else {
                                $lastDate = $lastDateAnnouncement;
                            }
                        } else if($lastDateAnnouncement != ""){
                            $lastDate = $lastDateAnnouncement;
                        } else if($lastDateAchievement != "") {
                            $lastDate = $lastDateAchievement;
                        } else {
                            $lastDate = "";
                        }
                        $result = array_merge($teacherAnnouncementArray,$teacherAchievementArray);
                        $temp_array = array();
                        foreach ($result as $key=>$value) {
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $price = array();
                        foreach ($temp_array as $key => $row)
                        {
                            $price[$key] = $row['created_at'];
                        }
                        array_multisort($price, SORT_DESC, $temp_array);
                       $uniqueResult[$lastDate] = array_values($temp_array);
                    } else {
                        $result = array_merge($teacherAnnouncement,$teacherAchievement);
                        $temp_array = array();
                        foreach ($result as $key=>$value){
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $price = array();
                        foreach ($temp_array as $key => $row)
                        {
                            $price[$key] = $row['created_at'];
                        }
                        array_multisort($price, SORT_DESC, $temp_array);
                        $uniqueResult = array_values($temp_array);
                    }
                    return $uniqueResult;
                }
            } elseif ( $request->authorize() === 2 ) {
                if($user->role_id == 1) {
                    $adminAnnouncement = $this::getAdminAnnouncement($month,$year,$id);
                    if($id == 0) {
                        $adminAnnouncementArray = array();
                        foreach($adminAnnouncement as $key=>$value)
                        {
                            $lastDateAnnouncement = $key;
                            $adminAnnouncementArray = $value;
                        }
                        $result = $adminAnnouncementArray;
                        $temp_array = array();
                        foreach ($result as $key=>$value) {
                            if (isset($temp_array))
                               $temp_array[$value['id']] = $value;
                        }
                        $uniqueResult[$lastDateAnnouncement] = array_values($temp_array);
                    } else {
                        $temp_array = array();
                        foreach ($adminAnnouncement as $key=>$value) {
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $uniqueResult = array_values($temp_array);
                    }
                    return $uniqueResult;
                } elseif ( $user->role_id == 2 ) {
                    $teacherAnnouncement = $this::getTeacherAnnouncement($month,$year,$id);
                    if($id == 0) {
                        $teacherAnnouncementArray = array();
                        foreach($teacherAnnouncement as $key=>$value)
                        {
                            $lastDateAnnouncement = $key;
                            $teacherAnnouncementArray = $value;
                        }
                        $result = $teacherAnnouncementArray;
                        $temp_array = array();
                        foreach ($result as $key=>$value) {
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $uniqueResult[$lastDateAnnouncement] = array_values($temp_array);
                    } else {
                    $temp_array = array();
                    foreach ($teacherAnnouncement as $key=>$value) {
                        if (isset($temp_array))
                            $temp_array[$value['id']] = $value;
                    }
                    $uniqueResult = array_values($temp_array);
                    }
                   return $uniqueResult;
                }
            } elseif( $request->authorize() === 3 ) {
                if($user->role_id == 1) {
                    $adminAchievement = $this::getAdminAchievement($month,$year,$id);
                    if($id == 0) {
                        $adminAchievementArray = array();
                        foreach($adminAchievement as $key=>$value)
                        {
                            $lastDateAnnouncement = $key;
                            $adminAchievementArray = $value;
                        }
                        $result = $adminAchievementArray;
                        $temp_array = array();
                        foreach ($result as $key=>$value) {
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $uniqueResult[$lastDateAnnouncement] = array_values($temp_array);
                    } else {
                        $temp_array = array();
                        foreach ($adminAchievement as $key=>$value) {
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $uniqueResult = array_values($temp_array);
                    }
                    return $uniqueResult;
                } elseif ($user->role_id == 2) {
                    $teacherAchievement = $this::getTeacherAchievement($month,$year,$id);
                    if($id == 0) {
                        $teacherAchievementArray = array();
                        foreach($teacherAchievement as $key=>$value)
                        {
                            $lastDateAnnouncement = $key;
                            $teacherAchievementArray = $value;
                        }
                        $result = $teacherAchievementArray;
                        $temp_array = array();
                        foreach ($result as $key=>$value) {
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $uniqueResult[$lastDateAnnouncement] = array_values($temp_array);
                    } else {
                        $temp_array = array();
                        foreach ($teacherAchievement as $key=>$value) {
                            if (isset($temp_array))
                                $temp_array[$value['id']] = $value;
                        }
                        $uniqueResult = array_values($temp_array);
                    }
                        return $uniqueResult;
                }
            }
        }
        /*
        * Function Name : getAdminAnnouncement
        * Param : $month,$year,$id
        * Return : admin related announcements
        * Desc : it will return listing data of announcement which belongs to admin.
        * Developed By : Suraj Bande
        * Date : 28/3/2016
        */
        public function getAdminAnnouncement($month,$year,$id)
        {
            $user = Auth::user();
            $user_id=$user->id;
            $adminAnnouncementSelfCreatedAndPending = DB::table('events')->where('event_type_id','=',1)
                ->where('created_by','=',$user->id)
                ->wherein('status',[0,1,2])
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority');
            $adminAnnouncementAssignedPublished = DB::table('events')->join('event_user_roles','event_user_roles.event_id','=','events.id')
                ->where('event_type_id','=',1)
                ->where('events.status','=',1)
                ->where('event_user_roles.user_id','=',$user->id)
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority');
            $adminAnnouncementOthersPending = DB::table('events')->where('status','=',1)
                ->where('published_by','=',$user->id)
                ->where('event_type_id','=',1)
                ->whereraw('YEAR(created_at) ='.date($year))
                ->whereraw('MONTH(created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                ->union($adminAnnouncementSelfCreatedAndPending)
                ->union($adminAnnouncementAssignedPublished)
                ->orderby('created_at','desc')
                ->get();
            if($id == 0)
            {
                $adminAnnouncementSelfCreatedAndPendingLastDate = Event::where('event_type_id','=',1)
                    ->where('created_by','=',$user->id)
                    ->wherein('status',[0,1,2])
                    ->min('events.created_at');
                $adminAnnouncementAssignedPublishedLastDate = Event::join('event_user_roles','event_user_roles.event_id','=','events.id')
                    ->where('event_type_id','=',1)
                    ->where('events.status','=',2)
                    ->where('event_user_roles.user_id','=',$user->id)
                    ->min('events.created_at');
                $adminAnnouncementOthersPendingLastDate = Event::where('status','=',1)
                    ->where('published_by','=',$user->id)
                    ->where('event_type_id','=',1)
                    ->min('events.created_at');
                $arrayMergedForLastDate = array_merge(array($adminAnnouncementSelfCreatedAndPendingLastDate),array($adminAnnouncementAssignedPublishedLastDate));
                $finalMergedLastEvent = array_merge(array($adminAnnouncementOthersPendingLastDate),$arrayMergedForLastDate);
                $lastDate = date('');
                foreach(array_unique($finalMergedLastEvent) as $row)
                {
                    if($row != null)
                    {
                        if(strtotime($lastDate) < strtotime($row))
                        {
                            $lastDate = $row;
                        }
                    }
                }
                $mergedArray = json_decode(json_encode($adminAnnouncementOthersPending),true);
                $adminAnnouncement[$lastDate] = $mergedArray;
            } else {
                $adminAnnouncement = json_decode(json_encode($adminAnnouncementOthersPending),true);
            }
            return $adminAnnouncement;
        }
        /*
        * Function Name : getAdminAchievement
        * Param : $month,$year,$id
        * Return : admin related achievements
        * Desc : it will return listing data of achievement which belongs to admin.
        * Developed By : Suraj Bande
        * Date : 28/3/2016
        */
        public function getAdminAchievement($month,$year,$id)
        {
            $user = Auth::user();
            $adminAchievementSelfCreated = DB::table('events')->join('event_images','event_images.event_id','=','events.id')
                ->where('event_type_id','=',2)
                ->where('events.created_by','=',$user->id)
                ->where('events.body_id','=',$user->body_id)
                ->wherein('status',[0,2])
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority');
            $adminAchievementOthersPending = DB::table('events')->join('event_images','event_images.event_id','=','events.id')
                ->where('event_type_id','=',2)
                ->where('created_by','!=',$user->id)
                ->where('status','=',1)
                ->where('events.body_id','=',$user->body_id)
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority');
            $adminAllPublished = DB::table('events')->join('event_images','event_images.event_id','=','events.id')
                ->where('event_type_id','=',2)
                ->where('status','=',2)
                ->where('events.body_id','=',$user->body_id)
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority')
                ->unionAll($adminAchievementOthersPending)
                ->unionAll($adminAchievementSelfCreated)
                ->orderby('created_at','desc')
                ->get();
            if($id == 0 ) {
                $adminAchievementSelfCreatedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('events.created_by','=',$user->id)
                    ->where('events.body_id','=',$user->body_id)
                    ->wherein('status',[0,2])
                    ->min('events.created_at');
                $adminAchievementOthersPendingLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('published_by','=',$user->id)
                    ->where('events.body_id','=',$user->body_id)
                    ->where('status','=',1)
                    ->min('events.created_at');
                $adminAllPublishedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('status','=',2)
                    ->where('events.body_id','=',$user->body_id)
                    ->min('events.created_at');
                $arrayMergedForLastDate = array_merge(array($adminAchievementSelfCreatedLastDate),array($adminAchievementOthersPendingLastDate));
                $finalMergedLastEvent = array_merge(array($adminAllPublishedLastDate),$arrayMergedForLastDate);
                $lastDate = date('');
                    foreach(array_unique($finalMergedLastEvent) as $row)
                    {
                        if($row != null)
                        {
                            if(strtotime($lastDate) < strtotime($row))
                            {
                                $lastDate = $row;
                            }
                        }
                    }
                    $mergedArray = json_decode(json_encode($adminAllPublished),true);
                    $adminAchievement[$lastDate] = $mergedArray;
            } else {
                $adminAchievement = json_decode(json_encode($adminAllPublished),true);
            }
            return $adminAchievement;
        }
        /*
        * Function Name : getTeacherAnnouncement
        * Param : $month,$year,$id
        * Return : teacher related announcements
        * Desc : it will return listing data of announcement which belongs to teacher.
        * Developed By : Suraj Bande
        * Date : 28/3/2016
        */
        public function getTeacherAnnouncement($month,$year,$id)
        {
            $user = Auth::User();
            $teacherAnnouncementSelfCreatedAndPendingAndPublished = DB::table('events')->where('event_type_id','=',1)
                ->wherein('status',[0,1,2])
                ->where('created_by','=',$user->id)
                ->where('events.body_id','=',$user->body_id)
                ->whereraw('YEAR(created_at) ='.date($year))
                ->whereraw('MONTH(created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority');
            $teacherAnnouncementAssignedPublished = DB::table('events')->join('event_user_roles','event_user_roles.event_id','=','events.id')
                ->where('event_type_id','=',1)
                ->where('status','=',2)
                ->where('event_user_roles.user_id','=',$user->id)
                ->where('events.body_id','=',$user->body_id)
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                ->union($teacherAnnouncementSelfCreatedAndPendingAndPublished)
                ->orderby('created_at','desc')
                ->get();
            if($id == 0)
            {
                $teacherAnnouncementSelfCreatedAndPendingAndPublishedLastDate = Event::where('event_type_id','=',1)
                    ->wherein('status',[0,1,2])
                    ->where('created_by','=',$user->id)
                    ->where('events.body_id','=',$user->body_id)
                    ->max('events.created_at');
                $teacherAnnouncementAssignedPublishedLastDate = Event::join('event_user_roles','event_user_roles.event_id','=','events.id')
                    ->where('event_type_id','=',1)
                    ->where('status','=',2)
                    ->where('events.body_id','=',$user->body_id)
                    ->where('event_user_roles.user_id','=',$user->id)
                    ->max('events.created_at');
                $arrayMergedForLastDate = array_merge(array($teacherAnnouncementSelfCreatedAndPendingAndPublishedLastDate),array($teacherAnnouncementAssignedPublishedLastDate));
                $lastDate = date('');
                foreach(array_unique($arrayMergedForLastDate) as $row)
                {
                    if($row != null)
                    {
                        if(strtotime($lastDate) < strtotime($row))
                        {
                            $lastDate = $row;
                        }
                    }
                }
                $mergedArray = json_decode(json_encode($teacherAnnouncementAssignedPublished),true);
                $teacherAnnouncement[$lastDate] = $mergedArray;
            } else {
                $teacherAnnouncement = json_decode(json_encode($teacherAnnouncementAssignedPublished),true);
            }
            return $teacherAnnouncement;
        }
        /*
        * Function Name : getTeacherAchievement
        * Param : $month,$year,$id
        * Return : teacher related achievements
        * Desc : it will return listing data of achievement which belongs to teacher.
        * Developed By : Suraj Bande
        * Date : 28/3/2016
        */
        public function getTeacherAchievement($month,$year,$id)
        {
            $user = Auth::User();
            $teacherAchievementSelfPendingAndCreated = DB::table('events')->join('event_images','event_images.event_id','=','events.id')
                        ->where('event_type_id','=',2)
                        ->where('created_by','=',$user->id)
                        ->where('events.body_id','=',$user->body_id)
                        ->wherein('status',[0,1])
                        ->whereraw('YEAR(events.created_at) ='.date($year))
                        ->whereraw('MONTH(events.created_at) ='.date($month))
                        ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority');
            $teacherAchievementAllPublished = DB::table('events')->join('event_images','event_images.event_id','=','events.id')
                        ->where('event_type_id','=',2)
                        ->where('status','=',2)
                        ->where('events.body_id','=',$user->body_id)
                        ->whereraw('YEAR(events.created_at) ='.date($year))
                        ->whereraw('MONTH(events.created_at) ='.date($month))
                        ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority')
                        ->union($teacherAchievementSelfPendingAndCreated)
                        ->orderby('created_at','desc')
                        ->get();
            //oldest date of event
            if($id == 0)
            {
                $teacherAchievementSelfPendingAndCreatedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('created_by','=',$user->id)
                    ->where('events.body_id','=',$user->body_id)
                    ->wherein('status',[0,1])
                    ->min('events.created_at');
                $teacherAchievementAllPublishedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('status','=',2)
                    ->where('events.body_id','=',$user->body_id)
                    ->min('events.created_at');
                $arrayMergedForLastDate = array_merge(array($teacherAchievementSelfPendingAndCreatedLastDate),array($teacherAchievementAllPublishedLastDate));
                $lastDate = date('');
                foreach(array_unique($arrayMergedForLastDate) as $row)
                {
                    if($row != null)
                    {
                        if(strtotime($lastDate) < strtotime($row))
                        {
                            $lastDate = $row;
                        }
                    }
                }
                $teacherAchievement[$lastDate] = json_decode(json_encode($teacherAchievementAllPublished),true);
            } else {
                $teacherAchievement = json_decode(json_encode($teacherAchievementAllPublished),true);
            }
            return $teacherAchievement;
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
        public function showCreateNoticeBoard(Request $request)
        {
            /***to unlink uploaded file from temp folder on page load ****/
            $filename = "uploads/achievement/".Auth::User()->id."/";
            $path = public_path($filename);
            foreach(glob($path.'*.*') as $file) {
                if(is_file($file))
                    unlink($file);
            }
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
            } elseif ($user->role_id == 2 ) {
                $userCheck = Division::where('class_teacher_id',$user->id)->first();
                if ($userCheck != null){
                    $count=0;
                        $batchClassData = Division::where('divisions.class_teacher_id',$user->id)
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();
                        $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
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
                } else {
                        $count=0;
                        $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                            ->join('divisions','division_subjects.division_id','=','divisions.id')
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();
                        $divisionSubjects = array_unique($divisionSubjects, SORT_REGULAR);
                        foreach($divisionSubjects as $row) {
                            $batchList[$count]['id'] = $row['batch_id'];
                            $batchList[$count]['name'] = $row['batch_name'];
                            $count++;
                        }
                        $batchList = array_unique($batchList, SORT_REGULAR);
                }
            }
                $adminWithAcl = User::join('module_acls','module_acls.user_id','=','users.id')
                            ->where('module_id','=',13)
                            ->where('acl_id','=',5)
                            ->where('role_id','=',1)
                            ->select('users.id','users.first_name','users.last_name','users.username')
                            ->get()->toArray();
                return view('createNoticeBoard')->with(compact('batchList','adminWithAcl'));
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
            $adminList = User::where('role_id',1)->where('body_id',$user->body_id)->whereNotIn('id',[$user->id])->select('id','first_name','last_name','username')->get();
            return $adminList;
        }
        /*
        * Function Name : getAllAdminsForUpdate
        * Param : --
        * Return : it will return all admins for udate announcement.
        * Desc : it will return all admins for udate announcement.
        * Developed By : Suraj Bande
        * Date : 3/4/2016
        */
        public function getAllAdminsForUpdate()
        {
            $user = Auth::user();
            $adminList = User::where('role_id',1)->where('body_id',$user->body_id)->select('id','first_name','last_name','username')->get();
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
            $teacherList = User::where('role_id',2)->where('body_id',$user->body_id)->whereNotIn('id',[$user->id])->select('id','first_name','last_name','username')->get();
            return $teacherList;
        }
        /*
        * Function Name : createNoticeBoard
        * Param : $request
        * Return : it will create announcement.
        * Desc : it will return created announcement.
        * Developed By : Suraj Bande
        * Date : 3/4/2016
        */
        public function createNoticeBoard(CreateAnnouncementRequest $request){
            if ($request->authorize() === true){
                $annoucement =array();
                $userEntry = array();
                $user = Auth::user();
                $annoucement['event_type_id'] = 1;
                $annoucement['title'] = $request->title;
                $annoucement['priority'] = $request->priority;
                $annoucement['detail'] = $request->announcement;
                $annoucement['created_at'] = Carbon::now();
                $annoucement['updated_at'] = Carbon::now();
                $annoucement['created_by'] = $user->id;
                $annoucement['body_id'] = $user->body_id;
                if($user->role_id == 1) {
                    if($request->buttons == 'publish') {
                        $annoucement['published_by'] = $user->id;
                        $annoucement['status'] = 2;
                    } else {
                        $annoucement['published_by'] = $user->id;
                        $annoucement['status'] = 0;
                    }
                } else {
                    $annoucement['published_by'] = $request->adminToPublish;
                    if($request->buttons == 'publish') {
                        $annoucement['status'] = 1;
                    } else {
                        $annoucement['status'] = 0;
                    }
                }
                $eventId = Event::insertGetId($annoucement);
                $is_published = Event::where('status',$eventId)->pluck('status');
                if($is_published == 2){
                    $title="New Announcement Created";
                    $message=$request->title;
                    $allUser=0;
                    $users_push=EventUserRoles::where('event_id',$eventId)->lists('user_id');
                    $push_users=PushToken::whereIn('user_id',$users_push)->lists('push_token');
                        $this->CreatePushNotification($title,$message,$allUser,$push_users);
                }
                if($eventId != null) {
                    if($request->adminList) {
                        $count = 0;
                        foreach($request->adminList as $row) {
                            $userEntry['event_id'] = $eventId;
                            $userEntry['user_id'] = $row;
                            $userEntry['created_at'] = Carbon::now();
                            $userEntry['updated_at'] = Carbon::now();
                            EventUserRoles::insert($userEntry);
                            $count++;
                        }
                    }
                    if($request->teacherList) {
                        $count = 0;
                        foreach($request->teacherList as $row) {
                            $userEntry['event_id'] = $eventId;
                            $userEntry['user_id'] = $row;
                            $userEntry['created_at'] = Carbon::now();
                            $userEntry['updated_at'] = Carbon::now();
                            EventUserRoles::insert($userEntry);
                            $count++;
                        }
                    }
                    if($request->hidenValue == 1)
                    {
                        if($request->FirstDiv){
                            $count = 0;
                            foreach($request->FirstDiv as $row){
                                $userEntry['event_id'] = $eventId;
                                $userEntry['division_id'] = $row;
                                $userEntry['created_at'] = Carbon::now();
                                $userEntry['updated_at'] = Carbon::now();
                                EventUserRoles::insert($userEntry);
                                $count++;
                            }
                        } elseif(!($request->FirstDiv) && !($request->classFirst) && $request['batch-select'] ) {
                            if($user->role_id == 1) {
                                $divisionData = Classes::join('divisions','classes.id','=','divisions.class_id')
                                    ->where('classes.body_id',$user->body_id)
                                    ->where('classes.batch_id',$request['batch-select'])
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get();
                                $count = 0;
                                foreach($divisionData as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }
                            } elseif ($user->role_id == 2) {
                                $teacherCheck = Division::where('class_teacher_id',$user->id)->first();
                                if($teacherCheck != null) {
                                    $divisionData = Division::where('divisions.class_teacher_id',$user->id)
                                        ->join('classes','divisions.class_id','=','classes.id')
                                        ->where('classes.batch_id',$request['batch-select'])
                                        ->select('divisions.id as division_id','divisions.division_name')
                                        ->get()->toArray();
                                    $divSubjectData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                        ->join('divisions','division_subjects.division_id','=','divisions.id')
                                        ->join('classes','divisions.class_id','=','classes.id')
                                        ->where('classes.batch_id',$request['batch-select'])
                                        ->select('divisions.id as division_id','divisions.division_name')
                                        ->get()->toArray();
                                    $division = array_merge ($divSubjectData, $divisionData);
                                    $division = array_unique($division, SORT_REGULAR);
                                    $count = 0;
                                    foreach($division as $row) {
                                        $userEntry['event_id'] = $eventId;
                                        $userEntry['division_id'] = $row['division_id'];
                                        $userEntry['created_at'] = Carbon::now();
                                        $userEntry['updated_at'] = Carbon::now();
                                        EventUserRoles::insert($userEntry);
                                        $count++;
                                    }
                                } else {
                                    $divisionData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                        ->join('divisions','division_subjects.division_id','=','divisions.id')
                                        ->join('classes','divisions.class_id','=','classes.id')
                                        ->where('classes.batch_id',$request['batch-select'])
                                        ->select('divisions.id as division_id','divisions.division_name')
                                        ->get();
                                    $count = 0;
                                    foreach($divisionData as $row) {
                                        $userEntry['event_id'] = $eventId;
                                        $userEntry['division_id'] = $row['division_id'];
                                        $userEntry['created_at'] = Carbon::now();
                                        $userEntry['updated_at'] = Carbon::now();
                                        EventUserRoles::insert($userEntry);
                                        $count++;
                                    }
                                }
                            }
                        } elseif(!($request->FirstDiv) && $request->classFirst && $request['batch-select'] ) {
                            if($user->role_id == 1) {
                                $divisionData = Division::whereIn('class_id',$request->classFirst)
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get();
                                $count = 0;
                                foreach($divisionData as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }
                            } elseif ($user->role_id == 2) {
                                $teacherCheck = Division::where('class_teacher_id',$user->id)->first();
                                if($teacherCheck != null) {
                                    $divisionData = Division::where('class_teacher_id',$user->id)
                                        ->whereIn('class_id',$request->classFirst)
                                        ->select('divisions.id as division_id','divisions.division_name')
                                        ->get()->toArray();
                                    $divSubjectData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                        ->join('divisions','division_subjects.division_id','=','divisions.id')
                                        ->whereIn('divisions.class_id',$request->classFirst)
                                        ->select('divisions.id as division_id','divisions.division_name')
                                        ->get()->toArray();
                                    $division = array_merge ($divSubjectData, $divisionData);
                                    $division = array_unique($division, SORT_REGULAR);
                                    $count = 0;
                                    foreach($division as $row) {
                                        $userEntry['event_id'] = $eventId;
                                        $userEntry['division_id'] = $row['division_id'];
                                        $userEntry['created_at'] = Carbon::now();
                                        $userEntry['updated_at'] = Carbon::now();
                                        EventUserRoles::insert($userEntry);
                                        $count++;
                                    }
                                } else {
                                    $divisionData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                        ->join('divisions','division_subjects.division_id','=','divisions.id')
                                        ->whereIn('divisions.class_id',$request->classFirst)
                                        ->select('divisions.id as division_id','divisions.division_name')
                                        ->get()->toArray();
                                    $count = 0;
                                    foreach($divisionData as $row) {
                                        $userEntry['event_id'] = $eventId;
                                        $userEntry['division_id'] = $row['division_id'];
                                        $userEntry['created_at'] = Carbon::now();
                                        $userEntry['updated_at'] = Carbon::now();
                                        EventUserRoles::insert($userEntry);
                                        $count++;
                                    }
                                }
                            }
                        } elseif(($request->FirstDiv) && ($request->classFirst) && ($request['batch-select'])) {
                            $count = 0;
                            foreach($request->FirstDiv as $row) {
                                $userEntry['event_id'] = $eventId;
                                $userEntry['division_id'] = $row;
                                $userEntry['created_at'] = Carbon::now();
                                $userEntry['updated_at'] = Carbon::now();
                                EventUserRoles::insert($userEntry);
                                $count++;
                            }
                        }
                    }
                }
                    $title="New Announcement Created";
                    $message=$request->title;
                    $allUser=0;
                    $users_push=EventUserRoles::where('event_id',$eventId)->lists('user_id');
                  Log::info($users_push);   
                 $push_users=PushToken::whereIn('user_id',$users_push)->lists('push_token');
                  Log::info($push_users);               
         $this->CreatePushNotification($title,$message,$allUser,$push_users);
                Session::flash('message-success','Announcement created successfully');
                return redirect('/noticeBoard');
            } else {
                return Redirect::back();
            }
        }
        /*
        * Function Name : getBatchClass
        * Param : $batchId
        * Return : it will return array.
        * Desc : it will return btch class to create announcement.
        * Developed By : Shubham Chaudhari
        * Date : 3-07-2017
        */
        public function getBatchClass($batchId)
        {
            $user = Auth::User();
            if($user->role_id == 1)
            {
                $batch = Batch::where('body_id',$user->body_id)->select('id','name')->first();
                $classData = Classes::where('batch_id',$batchId)->select('id','class_name')->get();
                $classList = $classData->toArray();
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
                $userCheck = Division::where('class_teacher_id',$user->id)->first();
                if ($userCheck != null) {
                    $count=0;
                    $batchClassData = Division::where('divisions.class_teacher_id',$user->id)
                        ->join('classes','divisions.class_id','=','classes.id')
                        ->join('batches','classes.batch_id','=','batches.id')
                        ->where('batches.id','=',$batchId)
                        ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                        ->get()->toArray();
                    $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                        ->join('divisions','division_subjects.division_id','=','divisions.id')
                        ->join('classes','divisions.class_id','=','classes.id')
                        ->join('batches','classes.batch_id','=','batches.id')
                        ->where('batches.id','=',$batchId)
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
                            $divisionData1 = Division::where('class_id',$row['class_id'])->where('class_teacher_id',$user->id)->select('id','division_name')->get()->toArray();
                        }
                        $divisionSubject = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get();
                        $divArr=array();
                        foreach($divisionSubject as $divs)
                        {
                            array_push($divArr,$divs->division_id);
                        }
                        $divArr=array_unique($divArr);
                        $divisionData2 = Division::where('class_id',$row['class_id'])->whereIn('id',$divArr)
                            ->select('id','division_name')->get()->toArray();
                        $divisionData2 = array_filter($divisionData2);
                        $divisionData1 = array_filter($divisionData1);
                        if($divisionData1 != null) {
                            $divisionData = array_merge ($divisionData1, $divisionData2);
                        } else {
                            $divisionData = $divisionData2;
                        }
                        $divisionData = array_unique($divisionData, SORT_REGULAR);
                        $countDivision = 0;
                        foreach($divisionData as $division) {
                            $classDivision[$countClass]['division'][$countDivision]['division_id'] = $division['id'];
                            $classDivision[$countClass]['division'][$countDivision]['division_name'] = $division['division_name'];
                            $countDivision++;
                        }
                        $countClass++;
                    }
                    $classDivision = array_unique($classDivision, SORT_REGULAR);
                } else {
                    $count=0;
                    $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                        ->join('divisions','division_subjects.division_id','=','divisions.id')
                        ->join('classes','divisions.class_id','=','classes.id')
                        ->join('batches','classes.batch_id','=','batches.id')
                        ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                        ->get()->toArray();
                    $divisionSubjects = array_unique($divisionSubjects, SORT_REGULAR);
                    foreach($divisionSubjects as $row) {
                        $batchList[$count]['id'] = $row['batch_id'];
                        $batchList[$count]['name'] = $row['batch_name'];
                        $count++;
                    }
                    $batchList = array_unique($batchList, SORT_REGULAR);
                    $countClass = 0;
                    foreach($divisionSubjects as $row) {
                        $classDivision[$countClass]['class_id'] = $row['class_id'];
                        $classDivision[$countClass]['class_name'] = $row['class_name'];
                        $divisionSubject = SubjectClassDivision::where('teacher_id',$user->id)->select('division_id')->get()->toArray();
                        $divisionSubject = array_unique($divisionSubject, SORT_REGULAR);
                        $count = 0;
                        foreach($divisionSubject as $divs ) {
                            $divisionData2[$count] =Division::where('class_id',$row['class_id'])->where('id',$divs['division_id'])
                                ->select('id','division_name')->get()->toArray();
                            $count++;
                        }
                        $divisionData2 = array_filter($divisionData2);
                        $divisionData = array_unique($divisionData2, SORT_REGULAR);
                        $countDivision = 0;
                        $i = 0;
                        foreach($divisionData as $division) {
                            foreach($division as $row) {
                                $classDivision[$countClass]['division'][$countDivision]['division_id'] = $row['id'];
                                $classDivision[$countClass]['division'][$countDivision]['division_name'] = $row['division_name'];
                                $countDivision++;
                            }
                            $i++;
                        }
                        $countClass++;
                    }
                    $classDivision = array_unique($classDivision, SORT_REGULAR);
                }
            }
            return $classDivision;
        }
        /*
        * Function Name : detailAnnouncement
        * Param : $id
        * Return : it will return array.
        * Desc : it will return details of respective announcement.
        * Developed By : Suraj Bande
        * Date : 13/4/2016
        */
        public function detailAnnouncement($id)
        {
            $events=Event::where('id','=',$id)->get();
            if(sizeOf($events) != 0)
            {
                $announcements = Event::join('users','users.id','=','events.created_by')
                    ->where('events.id','=',$id)
                    ->select('events.id','title','events.status','events.detail','events.created_by','events.published_by','events.priority','events.created_at','events.updated_at','users.username','users.first_name','users.last_name','users.role_id','users.gender')
                    ->get()->toArray();
                $publishedBy = Event::join('users','users.id','=','events.published_by')
                    ->where('events.id','=',$id)
                    ->select('users.username','users.first_name','users.last_name','users.role_id','users.gender')
                    ->get()->toArray();

                $users = EventUserRoles::where('event_id','=',$id)
                    ->get();
                $admins = array();
                $teachers = array();
                $divisions = array();
                $selectedBatches = array();
                $selectedClasses = array();
                $selectedDivisions = array();
                foreach($users as $user)
                {
                    if($user->user_id != null)
                    {
                        $userRole = User::select('role_id','first_name','last_name','username','id')->where('users.id','=',$user->user_id)->first();
                        if($userRole->role_id == 1)
                        {
                            array_push($admins,$userRole);
                        } else {
                            array_push($teachers,$userRole);
                        }
                    }
                    if($user->division_id != null)
                    {
                        $batches = Classes::join('divisions','classes.id','=','divisions.class_id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->where('divisions.id','=',$user->division_id)
                            ->select('divisions.id','divisions.class_id','classes.batch_id','divisions.division_name','classes.class_name','batches.name as batch_name')
                            ->get();
                        array_push($divisions,$batches);
                        $batchesArray = $batches->toArray();
                        array_push($selectedBatches,$batchesArray[0]['batch_id']);
                        array_push($selectedClasses,$batchesArray[0]['class_id']);
                        array_push($selectedDivisions,$batchesArray[0]['id']);
                    }
                }
                $selectedBatches = array_unique($selectedBatches);
                $selectedClasses = array_unique($selectedClasses);
                $selectedDivisions = array_unique($selectedDivisions);
                $admins =  array_unique($admins);
                $teachers =  array_unique($teachers);
                //////////////data to show on update page/////////////
                $user = Auth::user();
                $batchList = array();
                if ($user->role_id == 1) {
                    $user=Auth::user();
                    $batchData = Batch::where('body_id',$user->body_id)->select('id','name')->get();
                    $batchList = $batchData->toArray();

                } elseif ($user->role_id == 2 ) {
                    $userCheck = Division::where('class_teacher_id',$user->id)->first();
                    if ($userCheck != null) {
                        $count=0;
                        $batchClassData = Division::where('divisions.class_teacher_id',$user->id)
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();
                        $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
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
                    } else {
                        $count=0;
                        $divisionSubjects = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                            ->join('divisions','division_subjects.division_id','=','divisions.id')
                            ->join('classes','divisions.class_id','=','classes.id')
                            ->join('batches','classes.batch_id','=','batches.id')
                            ->select('divisions.id as division_id','divisions.division_name','classes.class_name','classes.id as class_id','batches.id as batch_id','batches.name as batch_name')
                            ->get()->toArray();
                        $divisionSubjects = array_unique($divisionSubjects, SORT_REGULAR);
                        foreach($divisionSubjects as $row) {
                            $batchList[$count]['id'] = $row['batch_id'];
                            $batchList[$count]['name'] = $row['batch_name'];
                            $count++;
                        }
                        $batchList = array_unique($batchList, SORT_REGULAR);
                    }
                }
                $adminWithAcl = User::join('module_acls','module_acls.user_id','=','users.id')
                    ->where('module_id','=',13)
                    ->where('acl_id','=',5)
                    ->where('role_id','=',1)
                    ->select('users.id','users.first_name','users.last_name','users.username')
                    ->get()->toArray();
                if($announcements[0]['role_id'] == 2)
                {
                    $allAdmins = $this::getAllAdminsForUpdate();
                } else {
                    $allAdmins = $this::getAllAdmins();
                }
                $allTeachers = $this::getAllTeachers();
                return view('detailAnnouncement')->with(compact('announcements','admins','teachers','divisions','publishedBy','batchList','adminWithAcl','selectedBatches','selectedClasses','selectedDivisions','allAdmins','allTeachers'));
            } else {
                Session::flash('message-error','This announcement is not available !');
                return Redirect::to('noticeBoard');
            }
        }
        /*
        * Function Name : getBatchClassWithSelected
        * Param : $batchId,$id
        * Return : it will return array.
        * Desc : it will return selected batch class divisions for respective announcement.
        * Developed By : Suraj Bande
        * Date : 13/4/2016
        */
        public function getBatchClassWithSelected($batchId,$id)
        {
            $users = EventUserRoles::where('event_id','=',$id)
                ->get();
            $admins = array();
            $teachers = array();
            $divisions = array();
            $selectedBatches = array();
            $selectedClasses = array();
            $selectedDivisions = array();
            foreach($users as $user)
            {
                if($user->user_id != null)
                {
                    $userRole = User::select('role_id','first_name','last_name','username','id')->where('users.id','=',$user->user_id)->first();
                    if($userRole->role_id == 1)
                    {
                        array_push($admins,$userRole);
                    } else {
                        array_push($teachers,$userRole);
                    }
                }
                if($user->division_id != null)
                {
                    $batches = Classes::join('divisions','classes.id','=','divisions.class_id')
                        ->join('batches','classes.batch_id','=','batches.id')
                        ->where('divisions.id','=',$user->division_id)
                        ->select('divisions.id','divisions.class_id','classes.batch_id','divisions.division_name','classes.class_name','batches.name as batch_name')
                        ->get();
                    array_push($divisions,$batches);
                    $batchesArray = $batches->toArray();
                    array_push($selectedBatches,$batchesArray[0]['batch_id']);
                    array_push($selectedClasses,$batchesArray[0]['class_id']);
                    array_push($selectedDivisions,$batchesArray[0]['id']);
                }
            }
            $selectedBatches = array_unique($selectedBatches);
            $selectedClasses = array_unique($selectedClasses);
            $selectedDivisions = array_unique($selectedDivisions);
            $batchClass = $this::getBatchClass($batchId);
            return array($batchClass,$selectedDivisions,$selectedClasses);
        }
        /*
        * Function Name : removeEmptySubFolders
        * Param : $path
        * Return : --
        * Desc : it will delete empty temporary directories after use .
        * Developed By : Suraj Bande
        * Date : 3/4/2016
        */
        public function removeEmptySubFolders($path)
        {
                foreach(scandir($path) as $file) {

                    if ('.' === $file || '..' === $file) continue;
                    if (is_dir("$path/$file")) $this::removeEmptySubFolders("$path/$file");
                    else unlink("$path/$file");
                }
                rmdir($path);
        }
        /*
        * Function Name : detailAchievement
        * Param : $id
        * Return : details of achievement
        * Desc : it will return details achievement .
        * Developed By : Suraj Bande
        * Date : 28/3/2016
        */
        public function detailAchievement($id)
        {
            if(file_exists(public_path("uploads/achievement/".Auth::User()->id)))
            {
                $xx = $this::removeEmptySubFolders(public_path("uploads/achievement/".Auth::User()->id));
            }
            $path = public_path("uploads/achievement/".Auth::User()->id.'/'.$id.'/');
            if (! file_exists($path.'thumbnail/')) {
                File::makeDirectory('uploads/achievement/'.Auth::User()->id.'/'.$id.'/thumbnail/', $mode = 0777, true, true);
            }
            $file = public_path("uploads/achievement/events/".$id.'/');
            if(! count(glob($file)) == 0)
            {
                foreach(glob($file.'*.*') as $files)
                {
                    $file_to_go = str_replace($file,$path,$files);
                    copy($files,$file_to_go);
                    chmod($file_to_go,0777);
                }
                foreach(glob($file.'thumbnail/*.*') as $thumbs)
                {
                    $file_to_go = str_replace($file.'thumbnail/',$path.'thumbnail/',$thumbs);

                    copy($thumbs,$file_to_go);
                    chmod($file_to_go,0777);
                }
            }
            $images = EventImages::where('event_id','=',$id)
                ->select('image')
                ->get()->toArray();
            $imageArray = array();
            foreach($images as $key=>$value)
            {
                array_push($imageArray,$value['image']);
            }
            $achievements = Event::join('users','users.id','=','events.created_by')
                ->where('events.id','=',$id)
                ->select('events.id','title','events.status','events.detail','events.created_at','events.updated_at','users.username','users.first_name','users.last_name','users.role_id','users.gender')
                ->get()->toArray();
            $publishedBy = Event::join('users','users.id','=','events.published_by')
                ->where('events.id','=',$id)
                ->select('users.username','users.first_name','users.last_name','users.role_id','users.gender')
                ->get()->toArray();
            return view('detailAchievement')->with(compact('achievements','imageArray','publishedBy'));
        }
        /*
        * Function Name : createAchievement
        * Param : $request
        * Return : create achievement
        * Desc : it will create achievement.
        * Developed By : Suraj Bande
        * Date : 28/3/2016
        */
        public function createAchievement(CreateAchievementRequest $request)
        {
            if($request->authorize() === true ) {
                $images = array();
                $storeAchievement['title'] = $request->title;
                $storeAchievement['detail'] = $request->achievement;
                if($request->hiddenBtnCheck == 0)
                {
                    if(Auth::User()->role_id == 1)
                    {
                        $storeAchievement['status'] = 2;
                        $storeAchievement['published_by'] = Auth::User()->id;
                    }else{
                        $storeAchievement['status'] = 1;
                        $storeAchievement['published_by'] = 0;
                    }
                }else{
                    $storeAchievement['status'] = 0;
                    $storeAchievement['published_by'] = 0;
                }
                $storeAchievement['event_type_id'] = 2 ;
                $storeAchievement['created_by'] = Auth::User()->id;
                $storeAchievement['created_at'] = Carbon::now();
                $storeAchievement['updated_at'] = Carbon::now();
                $storeAchievement['body_id'] = Auth::User()->body_id;
                $lastInsertId = Event::insertGetId($storeAchievement);
                if(isset($request->uploadedFiles[0]))
                {
                    foreach($request->uploadedFiles as $row)
                    {
                        $filename = "/uploads/achievement/".Auth::User()->id.'/'.$row;
                        $filenameThumb = "uploads/achievement/".Auth::User()->id.'/thumbnail/'.$row;
                        $path = public_path('uploads/achievement/events/'.$lastInsertId.'/');
                        if (! file_exists($path.'thumbnail/')) {
                            File::makeDirectory('uploads/achievement/events/'.$lastInsertId.'/thumbnail/', $mode = 0777, true, true);
                        }
                        $timeImage = time().'_'.$row;
                        $file = $path.$timeImage;
                        if(file_exists(public_path($filename)))
                        {
                            rename(public_path($filename),$file);
                            chmod($file,0777);
                            array_push($images,$timeImage);
                        }
                        if(file_exists(public_path($filenameThumb)))
                        {
                            rename(public_path($filenameThumb),$path.'thumbnail/'.$timeImage);
                            chmod($path.'/thumbnail/'.$timeImage,0777);
                        }
                    }
                }
                if(sizeof($images) == 0) {
                    $storeAchievementImages['event_id'] = $lastInsertId;
                    $storeAchievementImages['image'] = null;
                    $storeAchievementImages['created_at'] = Carbon::now();
                    $storeAchievementImages['updated_at'] = Carbon::now();
                    EventImages::insert($storeAchievementImages);
                } else {
                    foreach($images as $image){
                        $storeAchievementImages['event_id'] = $lastInsertId;
                        $storeAchievementImages['image'] = $image;
                        $storeAchievementImages['created_at'] = Carbon::now();
                        $storeAchievementImages['updated_at'] = Carbon::now();
                        EventImages::insert($storeAchievementImages);
                    }
                }
                if($request->hiddenBtnCheck == 0)
                {
                    if(Auth::User()->role_id == 1){
                        Session::flash('message-success','Achievement created and published successfully !');
                        $title="New Achievement Created";
                        $message=$request->title;
                        $allUser=1;
                        $push_users=null;
                        $this->CreatePushNotification($title,$message,$allUser,$push_users);
                    } else {
                        Session::flash('message-success','Achievement created and sent for publish successfully !');
                    }
                } else {
                    Session::flash('message-success','Achievement created successfully !');
                }
                if(file_exists(public_path("uploads/achievement/".Auth::User()->id)))
                {
                    $xx = $this::removeEmptySubFolders(public_path("uploads/achievement/".Auth::User()->id));
                }
                return Redirect::to('/detail-achievement/'.$lastInsertId);
            } else {
                return Redirect::back();
            }
        }
        /*
        * Function Name : checkUpdateAchievementAcl
        * Param : $request
        * Return : check ACL for update achievement
        * Desc : check ACL for update achievement.
        * Developed By : Suraj Bande
        * Date : 23/3/2016
        */
        public function checkUpdateAchievementAcl(EditAchievementRequest $request)
        {
            if($request->authorize() === true)
            {
                return 1;
            } else {
                return 2;
            }
        }
        /*
        * Function Name : checkUpdateAchievementAcl
        * Param : $request
        * Return : check ACL for update achievement
        * Desc : check ACL for update achievement.
        * Developed By : Suraj Bande
        * Date : 22/3/2016
        */
        public function checkUpdateAnnouncementAcl(EditAnnouncementRequest $request)
        {
            if($request->authorize() === true)
            {
                return 1;
            } else {
                return 2;
            }
        }
        /*
        * Function Name : checkPublishAchievementAcl
        * Param : $request,$id
        * Return : check ACL for publish achievement
        * Desc : check ACL for publish achievement.
        * Developed By : Suraj Bande
        * Date : 22/3/2016
        */
        public function checkPublishAchievementAcl(PublishAchievementRequest $request,$id)
        {
            $event = Event::find($id);
            if($event->created_by == Auth::User()->id) {
                if(Auth::User()->role_id == 1)
                {
                    $achievement = Event::find($id);
                    $achievement->published_by = Auth::User()->id;
                    $achievement->status = 2;
                    $achievement->save();
                    $title="New Achievement";
                    $message="Please check the new achievement";
                    $allUser=1;
                    $push_users=0;
                    $this -> CreatePushNotification($title,$message,$allUser,$push_users);
                    Session::flash('message-success','Achievement published successfully !');
                } else {
                    $achievement = Event::find($id);
                    $achievement->status = 1;
                    $achievement->save();
                    Session::flash('message-success','Achievement sent for publish successfully !');
                }
                return Redirect::to('/detail-announcement/'.$id);
            } else {
                if($request->authorize() === true)
                {
                    if(Auth::User()->role_id == 1)
                    {
                        $achievement = Event::find($id);
                        $achievement->published_by = Auth::User()->id;
                        $achievement->status = 2;
                        $achievement->save();
                        $title="New Achievement";
                        $message="Please check the new achievement";
                        $allUser=1;
                        $push_users=0;
                        $this -> CreatePushNotification($title,$message,$allUser,$push_users);
                        Session::flash('message-success','Achievement published successfully !');
                    } else {
                        $achievement = Event::find($id);
                        $achievement->status = 1;
                        $achievement->save();
                        Session::flash('message-success','Achievement sent for publish successfully !');
                    }
                    return Redirect::to('/detail-announcement/'.$id);
                } else {
                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                    return Redirect::to('/detail-announcement/'.$id);
                }
            }
        }
        /*
        * Function Name : checkPublishAnnouncementAcl
        * Param : $request,$id
        * Return : check ACL for publish announcement
        * Desc : check ACL for publish announcement.
        * Developed By : Suraj Bande
        * Date : 5/4/2016
        */
        public function checkPublishAnnouncementAcl(PublishAnnouncementRequest $request,$id)
        {
            $event = Event::find($id);
            if($event->created_by == Auth::User()->id) {
                if(Auth::User()->role_id == 1)
                {
                    $announcement = Event::find($id);
                    $announcement->status = 2;
                    $announcement->save();
                    $title="New Announcement";
                    $message="Please check the new announcement";
                    $allUser=1;
                    $push_users=0;
                    $this -> CreatePushNotification($title,$message,$allUser,$push_users);
                    Session::flash('message-success','Announcement published successfully !');
                } else {
                    $announcement = Event::find($id);
                    $announcement->status = 1;
                    $announcement->save();
                    Session::flash('message-success','Announcement sent for publish successfully !');
                }
                return Redirect::back();
            } else {
                if($request->authorize() === true)
                {
                    if(Auth::User()->role_id == 1)
                    {
                        $announcement = Event::find($id);
                        $announcement->status = 2;
                        $announcement->save();
                        $title="New Announcement";
                        $message="Please check the new announcement";
                        $allUser=1;
                        $push_users=0;
                        $this -> CreatePushNotification($title,$message,$allUser,$push_users);
                        Session::flash('message-success','Announcement published successfully !');
                    } else {
                        $announcement = Event::find($id);
                        $announcement->status = 1;
                        $announcement->save();
                        Session::flash('message-success','Announcement sent for publish successfully !');
                    }
                    return Redirect::back();
                } else {
                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                    return Redirect::back();
                }
            }
        }
        /*
        * Function Name : updateAchievement
        * Param : $request
        * Return : it will update achievement.
        * Desc : it will update achievement.
        * Developed By : Suraj Bande
        * Date : 5/3/2016
        */
        public function updateAchievement(EditAchievementRequest $request)
        {
            if($request->authorize() === true){
                $images = array();
                $achievement = Event::find($request->hiddenEventId);
                $achievement->title = $request->title;
                $achievement->detail = $request->achievement;
                $achievement->updated_at = Carbon::now();
                $achievement->save();
                EventImages::where('event_id','=',$request->hiddenEventId)
                            ->delete();
                $filename = "uploads/achievement/events/".$request->hiddenEventId."/";
                $path = public_path($filename);
                foreach(glob($path.'*.*') as $file) {
                    if(is_file($file))
                        unlink($file);
                }
                if(isset($request->uploadedFiles[0])){
                    foreach($request->uploadedFiles as $row){
                        $filename = "uploads/achievement/".Auth::User()->id.'/'.$request->hiddenEventId.'/'.$row;
                        $filenameThumb = "uploads/achievement/".Auth::User()->id.'/'.$request->hiddenEventId.'/thumbnail/'.$row;
                        $tempPath = "uploads/achievement/events/".$request->hiddenEventId."/";
                        $path = public_path($tempPath);
                        if (! file_exists($path.'thumbnail/')) {
                            File::makeDirectory('uploads/achievement/events/'.$request->hiddenEventId.'/thumbnail/', $mode = 0777, true, true);
                        }
                        $timeImage = $row;
                        $file = $path.$timeImage;
                        if(file_exists(public_path($filename))){
                            rename(public_path($filename),$file);
                            chmod($file,0777);
                            array_push($images,$timeImage);
                        }
                        if(file_exists(public_path($filenameThumb))){
                            rename(public_path($filenameThumb),$path.'thumbnail/'.$timeImage);
                            chmod($path.'/thumbnail/'.$timeImage,0777);
                        }
                    }
                }
                if(sizeof($images) == 0) {
                    $storeAchievementImages['event_id'] = $request->hiddenEventId;
                    $storeAchievementImages['image'] = null;
                    $storeAchievementImages['created_at'] = Carbon::now();
                    $storeAchievementImages['updated_at'] = Carbon::now();
                    EventImages::insert($storeAchievementImages);
                } else {
                    foreach($images as $image)
                    {
                        $storeAchievementImages['event_id'] = $request->hiddenEventId;
                        $storeAchievementImages['image'] = $image;
                        $storeAchievementImages['created_at'] = Carbon::now();
                        $storeAchievementImages['updated_at'] = Carbon::now();
                        EventImages::insert($storeAchievementImages);
                    }
                }
                if(file_exists(public_path("uploads/achievement/".Auth::User()->id)))
                {
                    $xx = $this::removeEmptySubFolders(public_path("uploads/achievement/".Auth::User()->id));
                }
                Session::flash('message-success','Achievement updated successfully !');
                return Redirect::back();
            } else {
                return Redirect::back();
            }
        }
        /*
        * Function Name : updateAnnouncement
        * Param : $request
        * Return : it will update announcement.
        * Desc : it will update announcement.
        * Developed By : Suraj Bande
        * Date : 13/4/2016
        */
        public function updateAnnouncement(EditAnnouncementRequest $request)
        {
            if($request->authorize() === true) {

                $userEntry = array();
                $user = Auth::user();
                $announcements = Event::where('id','=',$request->hiddenAnnouncementId)->first();
                $announcements->event_type_id = 1;
                $announcements->title = $request->title;
                $announcements->priority = $request->priority;
                $announcements->detail = $request->announcement;
                $announcements->updated_at = Carbon::now();
                if($user->role_id == 2) {
                    $announcements->published_by = $request->adminToPublish;
                }
                $announcements->save();
                EventUserRoles::where('event_id','=',$request->hiddenAnnouncementId)->delete();
                $eventId = $request->hiddenAnnouncementId;
                if($request->adminList) {
                    $count = 0;
                    foreach($request->adminList as $row) {
                        $userEntry['event_id'] = $eventId;
                        $userEntry['user_id'] = $row;
                        $userEntry['created_at'] = Carbon::now();
                        $userEntry['updated_at'] = Carbon::now();
                        EventUserRoles::insert($userEntry);
                        $count++;
                    }
                }
                if($request->teacherList) {
                    $count = 0;
                    foreach($request->teacherList as $row) {
                        $userEntry['event_id'] = $eventId;
                        $userEntry['user_id'] = $row;
                        $userEntry['created_at'] = Carbon::now();
                        $userEntry['updated_at'] = Carbon::now();
                        EventUserRoles::insert($userEntry);
                        $count++;
                    }
                }
                if($request->hidenValue == 1)
                {
                    if(sizeOf($request->FirstDiv) != 0){
                        $count = 0;
                        foreach($request->FirstDiv as $row) {
                            $userEntry['event_id'] = $eventId;
                            $userEntry['division_id'] = $row;
                            $userEntry['created_at'] = Carbon::now();
                            $userEntry['updated_at'] = Carbon::now();
                            EventUserRoles::insert($userEntry);
                            $count++;
                        }
                    } elseif(!($request->FirstDiv) && !($request->classFirst) && $request['batch-select'] ) {

                        if($user->role_id == 1) {
                            $divisionData = Classes::join('divisions','classes.id','=','divisions.class_id')
                                ->where('classes.body_id',$user->body_id)
                                ->where('classes.batch_id',$request['batch-select'])
                                ->select('divisions.id as division_id','divisions.division_name')
                                ->get();
                            $count = 0;
                            foreach($divisionData as $row) {
                                $userEntry['event_id'] = $eventId;
                                $userEntry['division_id'] = $row['division_id'];
                                $userEntry['created_at'] = Carbon::now();
                                $userEntry['updated_at'] = Carbon::now();
                                EventUserRoles::insert($userEntry);
                                $count++;
                            }
                        } elseif ($user->role_id == 2) {
                            $teacherCheck = Division::where('class_teacher_id',$user->id)->first();
                            if($teacherCheck != null) {
                                $divisionData = Division::where('divisions.class_teacher_id',$user->id)
                                    ->join('classes','divisions.class_id','=','classes.id')
                                    ->where('classes.batch_id',$request['batch-select'])
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $divSubjectData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                                    ->join('classes','divisions.class_id','=','classes.id')
                                    ->where('classes.batch_id',$request['batch-select'])
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $division = array_merge ($divSubjectData, $divisionData);
                                $division = array_unique($division, SORT_REGULAR);
                                $count = 0;
                                foreach($division as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }
                            } else {
                                $divisionData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                                    ->join('classes','divisions.class_id','=','classes.id')
                                    ->where('classes.batch_id',$request['batch-select'])
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get();
                                $count = 0;
                                foreach($divisionData as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }
                            }
                        }
                    } elseif(!($request->FirstDiv) && $request->classFirst && $request['batch-select'] ) {
                        if($user->role_id == 1) {
                            $divisionData = Division::whereIn('class_id',$request->classFirst)
                                ->select('divisions.id as division_id','divisions.division_name')
                                ->get();
                            $count = 0;
                            foreach($divisionData as $row) {
                                $userEntry['event_id'] = $eventId;
                                $userEntry['division_id'] = $row['division_id'];
                                $userEntry['created_at'] = Carbon::now();
                                $userEntry['updated_at'] = Carbon::now();
                                EventUserRoles::insert($userEntry);
                                $count++;
                            }
                        } elseif ($user->role_id == 2) {
                            $teacherCheck = Division::where('class_teacher_id',$user->id)->first();
                            if($teacherCheck != null) {
                                $divisionData = Division::where('class_teacher_id',$user->id)
                                    ->whereIn('class_id',$request->classFirst)
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $divSubjectData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                                    ->whereIn('divisions.class_id',$request->classFirst)
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $division = array_merge ($divSubjectData, $divisionData);
                                $division = array_unique($division, SORT_REGULAR);
                                $count = 0;
                                foreach($division as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }
                            } else {
                                $divisionData = SubjectClassDivision::where('division_subjects.teacher_id',$user->id)
                                    ->join('divisions','division_subjects.division_id','=','divisions.id')
                                    ->whereIn('divisions.class_id',$request->classFirst)
                                    ->select('divisions.id as division_id','divisions.division_name')
                                    ->get()->toArray();
                                $count = 0;
                                foreach($divisionData as $row) {
                                    $userEntry['event_id'] = $eventId;
                                    $userEntry['division_id'] = $row['division_id'];
                                    $userEntry['created_at'] = Carbon::now();
                                    $userEntry['updated_at'] = Carbon::now();
                                    EventUserRoles::insert($userEntry);
                                    $count++;
                                }
                            }
                        }
                    } elseif(($request->FirstDiv) && ($request->classFirst) && ($request['batch-select'])) {
                        $count = 0;
                        foreach($request->FirstDiv as $row) {
                            $userEntry['event_id'] = $eventId;
                            $userEntry['division_id'] = $row;
                            $userEntry['created_at'] = Carbon::now();
                            $userEntry['updated_at'] = Carbon::now();
                            EventUserRoles::insert($userEntry);
                            $count++;
                        }
                    }
                }
                Session::flash('message-success','Announcement updated successfully !');
                return Redirect::to('detail-announcement/'.$request->hiddenAnnouncementId);

            } else {
                return Redirect::back();
            }
        }
        /*
        * Function Name : deleteAnnouncement
        * Param : $id
        * Return : it will return delete message.
        * Desc : it will delete announcement.
        * Developed By : Suraj Bande
        * Date : 15/4/2016
        */
        public function deleteAnnouncement(DeleteAnnouncementRequest $request,$id)
        {
            $event = Event::find($id);
            if($event->created_by == Auth::User()->id) {
                EventUserRoles::where('event_id','=',$id)->delete();
                Event::where('id','=',$id)->delete();
                Session::flash('message-success','Announcement deleted successfully !');
                return Redirect::to('noticeBoard');
            } else {
                if($request->authorize() === true) {
                    EventUserRoles::where('event_id','=',$id)->delete();
                    Event::where('id','=',$id)->delete();
                    Session::flash('message-success','Announcement deleted successfully !');
                    return Redirect::to('noticeBoard');
                } else {
                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                    return Redirect::back();
                }
            }
        }
        /*
        * Function Name : deleteAchievement
        * Param : $id
        * Return : it will return delete message.
        * Desc : it will delete achievement.
        * Developed By : Suraj Bande
        * Date : 15/4/2016
        */
        public function deleteAchievement(DeleteAchievementRequest $request,$id)
        {
            $event = Event::find($id);
            if($event->created_by == Auth::User()->id) {
                $filename = "uploads/achievement/events/".$id."/";
                $path = public_path($filename);
                if(file_exists($path))
                {
                    $this::removeEmptySubFolders($path);
                }
                Event::where('id','=',$id)->delete();
                Session::flash('message-success','Achievement deleted successfully !');
                return Redirect::to('noticeBoard');
            } else {
                if($request->authorize() === true) {
                    //EventImages::where('event_id','=',$id)->delete();
                    $filename = "uploads/achievement/events/".$id."/";
                    $path = public_path($filename);
                    if(file_exists($path))
                    {
                        $this::removeEmptySubFolders($path);
                    }
                    Event::where('id','=',$id)->delete();
                    Session::flash('message-success','Achievement deleted successfully !');
                    return Redirect::to('noticeBoard');
                } else {
                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                    return Redirect::back();
                }
            }
        }
    }
