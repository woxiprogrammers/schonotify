<?php

    namespace App\Http\Controllers;

    use App\Batch;
    use App\Classes;
    use App\Division;
    use App\Event;
    use App\EventUserRoles;
    use App\Http\Requests\WebRequests\CreateAnnouncementRequest;
    use App\Http\Requests\WebRequests\NoticeBoardRequest;
    use App\SubjectClassDivision;
    use App\User;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Session;

    class NoticeBoardController extends Controller
    {
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

            $latestEventDate = date('Y-m-d');
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

                        if(strtotime($lastDateAnnouncement) > strtotime($lastDateAchievement))
                        {
                            $lastDate = $lastDateAchievement;
                        } else {
                            $lastDate = $lastDateAnnouncement;
                        }

                        $result = array_merge($adminAnnouncementArray,$adminAchievementArray);

                        $temp_array = array();

                        foreach ($result as $key=>$value) {

                            if (isset($temp_array))

                                $temp_array[$value['id']] = $value;

                        }

                        $uniqueResult[$lastDate] = array_values($temp_array);


                    } else {

                        $result = array_merge($adminAchievement,$adminAnnouncement);

                        $temp_array = array();

                        foreach ($result as $key=>$value) {

                            if (isset($temp_array))

                                $temp_array[$value['id']] = $value;

                        }

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

                        if(strtotime($lastDateAnnouncement) > strtotime($lastDateAchievement))
                        {
                            $lastDate = $lastDateAchievement;
                        } else {
                            $lastDate = $lastDateAnnouncement;
                        }

                        $result = array_merge($teacherAnnouncementArray,$teacherAchievementArray);

                        $temp_array = array();

                        foreach ($result as $key=>$value) {

                            if (isset($temp_array))

                                $temp_array[$value['id']] = $value;

                        }

                        $uniqueResult[$lastDate] = array_values($temp_array);


                    } else {
                        $result = array_merge($teacherAnnouncement,$teacherAchievement);

                        $temp_array = array();

                        foreach ($result as $key=>$value) {

                            if (isset($temp_array))

                                $temp_array[$value['id']] = $value;

                        }

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

            $adminAnnouncementSelfCreatedAndPending = Event::where('event_type_id','=',1)
                ->where('created_by','=',$user->id)
                ->wherein('status',[0,1,2])
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                ->orderby('events.created_at','desc')
                ->get()->toArray();

            $adminAnnouncementAssignedPublished = Event::join('event_user_roles','event_user_roles.event_id','=','events.id')
                ->where('event_type_id','=',1)
                ->where('events.status','=',2)
                ->where('event_user_roles.user_id','=',$user->id)
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                ->orderby('events.created_at','desc')
                ->get()->toArray();

            $adminAnnouncementOthersPending = Event::where('status','=',1)
                ->where('published_by','=',$user->id)
                ->where('event_type_id','=',1)
                ->whereraw('YEAR(created_at) ='.date($year))
                ->whereraw('MONTH(created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                ->orderby('created_at','desc')
                ->get()->toArray();


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

                $dummyArray = array();

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

                $mergedArray = array_merge($adminAnnouncementSelfCreatedAndPending,$adminAnnouncementAssignedPublished);

                $mergedArrayWithLastDate = array_merge($mergedArray,$adminAnnouncementOthersPending);

                $adminAnnouncement[$lastDate] = $mergedArrayWithLastDate;

            } else {

                $mergedArray = array_merge($adminAnnouncementSelfCreatedAndPending,$adminAnnouncementAssignedPublished);

                $adminAnnouncement = array_merge($mergedArray,$adminAnnouncementOthersPending);

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

            $adminAchievementSelfCreatedAndPending = Event::join('event_images','event_images.event_id','=','events.id')
                ->where('event_type_id','=',2)
                ->where('events.created_by','=',$user->id)
                ->wherein('status',[0,1,2])
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority')
                ->orderby('events.created_at','desc')
                ->get()->toArray();

            $adminAchievementOthersPending = Event::join('event_images','event_images.event_id','=','events.id')
                ->where('event_type_id','=',2)
                ->where('published_by','=',$user->id)
                ->where('status','=',1)
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority')
                ->orderby('events.created_at','desc')
                ->get()->toArray();

            $adminAllPublished = Event::join('event_images','event_images.event_id','=','events.id')
                ->where('event_type_id','=',2)
                ->where('status','=',2)
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority')
                ->orderby('events.created_at','desc')
                ->get()->toArray();

            if($id == 0 ) {

                $adminAchievementSelfCreatedAndPendingLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('events.created_by','=',$user->id)
                    ->wherein('status',[0,1,2])
                    ->min('events.created_at');

                $adminAchievementOthersPendingLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('published_by','=',$user->id)
                    ->where('status','=',1)
                    ->min('events.created_at');

                $adminAllPublishedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('status','=',2)
                    ->min('events.created_at');

                $arrayMergedForLastDate = array_merge(array($adminAchievementSelfCreatedAndPendingLastDate),array($adminAchievementOthersPendingLastDate));

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

                    $mergedArray = array_merge($adminAchievementSelfCreatedAndPending,$adminAchievementOthersPending);

                    $mergedArrayWithLastDate = array_merge($mergedArray,$adminAllPublished);

                    $adminAchievement[$lastDate] = $mergedArrayWithLastDate;


            } else {

                $mergedArray = array_merge($adminAchievementSelfCreatedAndPending,$adminAchievementOthersPending);

                $adminAchievement = array_merge($mergedArray,$adminAllPublished);

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

            $teacherAnnouncementSelfCreatedAndPendingAndPublished = Event::where('event_type_id','=',1)
                ->wherein('status',[0,1,2])
                ->where('created_by','=',$user->id)
                ->whereraw('YEAR(created_at) ='.date($year))
                ->whereraw('MONTH(created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                ->orderby('created_at','desc')
                ->get()
                ->toArray();

            $teacherAnnouncementAssignedPublished = Event::join('event_user_roles','event_user_roles.event_id','=','events.id')
                ->where('event_type_id','=',1)
                ->where('status','=',2)
                ->where('event_user_roles.user_id','=',$user->id)
                ->whereraw('YEAR(events.created_at) ='.date($year))
                ->whereraw('MONTH(events.created_at) ='.date($month))
                ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','published_by','created_by','priority')
                ->orderby('events.created_at','desc')
                ->get()
                ->toArray();

            if($id == 0)
            {
                $teacherAnnouncementSelfCreatedAndPendingAndPublishedLastDate = Event::where('event_type_id','=',1)
                    ->wherein('status',[0,1,2])
                    ->where('created_by','=',$user->id)
                    ->max('events.created_at');

                $teacherAnnouncementAssignedPublishedLastDate = Event::join('event_user_roles','event_user_roles.event_id','=','events.id')
                    ->where('event_type_id','=',1)
                    ->where('status','=',2)
                    ->where('event_user_roles.user_id','=',$user->id)
                    ->max('events.created_at');

                $arrayMergedForLastDate = array_merge(array($teacherAnnouncementSelfCreatedAndPendingAndPublishedLastDate),array($teacherAnnouncementAssignedPublishedLastDate));

                $dummyArray = array();

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

                $teacherAnnouncement[$lastDate] = array_merge($teacherAnnouncementSelfCreatedAndPendingAndPublished,$teacherAnnouncementAssignedPublished);

            } else {
                $teacherAnnouncement = array_merge($teacherAnnouncementSelfCreatedAndPendingAndPublished,$teacherAnnouncementAssignedPublished);

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

            $teacherAchievementSelfPendingAndCreated = Event::join('event_images','event_images.event_id','=','events.id')
                        ->where('event_type_id','=',2)
                        ->where('created_by','=',$user->id)
                        ->wherein('status',[0,1])
                        ->whereraw('YEAR(events.created_at) ='.date($year))
                        ->whereraw('MONTH(events.created_at) ='.date($month))
                        ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority')
                        ->orderby('events.created_at','desc')
                        ->get()->toArray();

            $teacherAchievementAllPublished = Event::join('event_images','event_images.event_id','=','events.id')
                        ->where('event_type_id','=',2)
                        ->where('status','=',2)
                        ->whereraw('YEAR(events.created_at) ='.date($year))
                        ->whereraw('MONTH(events.created_at) ='.date($month))
                        ->select('events.created_at','events.updated_at','events.id','title','detail','event_type_id','status','image','published_by','created_by','priority')
                        ->orderby('events.created_at','desc')
                        ->get()->toArray();

            //oldest date of event

            if($id == 0)
            {
                $teacherAchievementSelfPendingAndCreatedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('created_by','=',$user->id)
                    ->wherein('status',[0,1])
                    ->min('events.created_at');

                $teacherAchievementAllPublishedLastDate = Event::join('event_images','event_images.event_id','=','events.id')
                    ->where('event_type_id','=',2)
                    ->where('status','=',2)
                    ->min('events.created_at');

                $arrayMergedForLastDate = array_merge(array($teacherAchievementSelfPendingAndCreatedLastDate),array($teacherAchievementAllPublishedLastDate));

                $dummyArray = array();

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

                $teacherAchievement[$lastDate] = array_merge($teacherAchievementSelfPendingAndCreated,$teacherAchievementAllPublished);

            } else {

                $teacherAchievement = array_merge($teacherAchievementSelfPendingAndCreated,$teacherAchievementAllPublished);

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
            } elseif ($user->role_id == 2 ) {
                $userCheck = Division::where('class_teacher_id',$user->id)->first();
                if ($userCheck != null) {
                    $count=0;
                    if ($request->ajax()) {
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
                    }
                } else {
                    if ($request->ajax()) {
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
            $adminList = User::where('role_id',1)->where('is_active',1)->where('body_id',$user->body_id)->whereNotIn('id',[$user->id])->select('id','first_name','last_name')->get();
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
            $teacherList = User::where('role_id',2)->where('is_active',1)->where('body_id',$user->body_id)->whereNotIn('id',[$user->id])->select('id','first_name','last_name')->get();
            return $teacherList;

        }


        public function createNoticeBoard(CreateAnnouncementRequest $request)
        {
            if ($request->authorize() === true)
            {    $annoucement =array();
                $userEntry = array();
                $user = Auth::user();
                $annoucement['event_type_id'] = 1;
                $annoucement['title'] = $request->title;
                $annoucement['priority'] = $request->priority;
                $annoucement['detail'] = $request->announcement;
                $annoucement['created_at'] = Carbon::now();
                $annoucement['updated_at'] = Carbon::now();

                if($request->buttons == 'publish') {
                    if($user->role_id == 1) {
                        $annoucement['created_by'] = $user->id;
                        $annoucement['published_by'] = $user->id;
                        $annoucement['status'] = 2;
                    } elseif($user->role_id == 2){
                        $annoucement['created_by'] = $user->id;
                        $annoucement['status'] = 1;
                    }
                } elseif($request->buttons == 'save'){
                    $annoucement['created_by'] = $user->id;
                    $annoucement['status'] = 0;
                }
                $eventId = Event::insertGetId($annoucement);
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
                    if($request->FirstDiv){
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
                Session::flash('message-success','announcement created successfully');
                return view('noticeBoard');
            } else {
                return Redirect::back();
            }


        }

        public function detailAnnouncement()
        {
            return view('detailAnnouncement');
        }
        public function detailAchievement($id)
        {


            return view('detailAchievement');
        }
    }
