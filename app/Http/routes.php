<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::group(['domain' => '{account}.schnotify.com'], function () {
    Route::get('/', function ($account) {

        $domain=ucfirst($account);

        Config::set('database.connections.mysql_db1.database',$domain);
        \DB::setDefaultConnection('mysql_db1');

        $check=\DB::connection()->getDatabaseName();

        if(!$check)
        {
            return response('Unauthorized.', 401);
        }else{
            return view('login_signin');
        }

    });
});*/

Route::get('/','FrontController@index');

Route::get('forgot','LogController@forgot');

Route::resource('log','LogController');

Route::resource('log/store','LogController@store');

Route::get('logout','LogController@logout');

Route::get('lockScreen','LogController@lockScreen');

Route::get('createUsers/{id}','UsersController@create');

Route::get('adminCreate','UsersController@adminCreateForm');

Route::get('teacherCreate','UsersController@teacherCreateForm');

Route::get('studentCreate','UsersController@studentCreateForm');

Route::get('parentCreate','UsersController@parentCreateForm');

Route::get('usersCreate','UsersController@usersCreateForm');

Route::get('myProfile','UsersController@usersProfile');

Route::get('searchUsers','SearchController@searchUsers');

Route::get('edit/{id}','UsersController@edit');

Route::get('selectUser/{id}','SearchController@selectRole');

Route::post('searchUsers','SearchController@searchUsers');

Route::post('updateUser','UsersController@update');

Route::get('searchClasses/{id}','SearchController@searchClasses');

Route::get('searchClass','SearchController@searchClass');

Route::get('searchBatch','SearchController@searchBatch');

Route::get('searchDivision','SearchController@searchDivision');

Route::get('searchSubjects','SearchController@searchSubjects');

Route::get('active/{id}','UsersController@activeUser');

Route::get('deactive/{id}','UsersController@deactiveUser');

Route::get('createClass','ClassController@create');

Route::get('event','EventController@index');

Route::get('timetable','TimetableController@index');

Route::get('timetableShow/{id}','TimetableController@timetableShow');

Route::get('createTimetable','TimetableController@create');

Route::get('noticeBoard','NoticeBoardController@show');

Route::get('loadMore','NoticeBoardController@loadMore');

Route::get('createNoticeBoard','NoticeBoardController@createNoticeBoard');

Route::get('detailAnnouncement','NoticeBoardController@detailAnnouncement');

Route::get('detailAchievement','NoticeBoardController@detailAchievement');

Route::get('leaveListing','LeaveController@leaveListing');

Route::get('detailedLeave','LeaveController@detailedLeave');

Route::get('homeworkListing','HomeworkController@homeworkListing');

Route::get('detailedHomework','HomeworkController@detailedHomework');

Route::get('createHomework','HomeworkController@createHomework');

Route::get('results','ResultController@showResults');

Route::get('exams/{id}','ResultController@examResults');

Route::get('subjects/{id}','ResultController@subjectResults');

Route::get('getStudents/{id}','ResultController@getStudents');

Route::get('markAttendance','AttendanceController@markAttendance');

Route::get('view-attendance','AttendanceController@viewAttendance');

Route::get('auto-notification','NotificationController@listNotifications');

Route::get('students-attendance-history','HistoryController@showAttendance');

Route::get('students/{id}','HistoryController@getStudents');

Route::get('get-attendance/{name?}','HistoryController@getAttendance');

Route::get('students-results-history','HistoryController@showResults');

//getAttendance()
/* API Routes */
Route::group(['prefix' => 'api/v1/user/'], function () {
    Route::post('auth','api\UserController@login');
    Route::post('attendance','api\AttendanceController@markAttendance');
    Route::get('approvedleaves',array('uses' => 'api\LeaveController@getApprovedLeaveList'));
    Route::get('pendingleaves',array('uses' => 'api\LeaveController@getPendingLeaveList'));
    Route::put('approveleaves',array('uses' => 'api\LeaveController@approveLeave'));
    
});