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

    Route::get('get-msg-count','MessageController@getMessageCount');

    Route::get('get-unread-list','MessageController@getUnreadMessageListing');

    Route::get('get-msg-list','MessageController@getMessageList');

    Route::get('get-detail-message/{id}',array('uses' =>'MessageController@getDetailMessages'));

    Route::post('send-message',array('uses' =>'MessageController@sendMessage'));

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

    Route::put('my-profile/{id}','UsersController@updateUsersProfile');

    Route::get('edit-user/{id}','UsersController@editUser');

    Route::put('edit-teacher/{id}','UsersController@updateTeacher');

    Route::put('edit-admin/{id}','UsersController@updateAdmin');

    Route::put('edit-student/{id}','UsersController@updateStudent');

    Route::put('edit-parent/{id}','UsersController@updateParent');

    Route::post('check-email',array('uses' => 'UsersController@checkEmail'));

    Route::put('change-password','UsersController@changePassword');

    Route::get('searchUsers','SearchController@searchUsers');

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

    Route::get('create-class','ClassController@index');

    Route::post('class-create','ClassController@create');

    Route::get('event','EventController@index');

    Route::get('timetable','TimetableController@index');

    Route::get('timetableShow/{id}','TimetableController@timetableShow');

    Route::get('createTimetable','TimetableController@create');

    Route::post('create-timetable','TimetableController@createTimetable');

    Route::get('noticeBoard','NoticeBoardController@show');

    Route::get('loadMore','NoticeBoardController@loadMore');

    Route::get('createNoticeBoard','NoticeBoardController@createNoticeBoard');

    Route::get('detailAnnouncement','NoticeBoardController@detailAnnouncement');

    Route::get('detailAchievement','NoticeBoardController@detailAchievement');

    Route::get('leaveListing','LeaveController@leaveListing');

    Route::get('detailedLeave','LeaveController@detailedLeave');

    Route::get('homework-listing','HomeworkController@homeworkListing');

    Route::get('detailedHomework/{id}','HomeworkController@detailedHomework');

    Route::get('delete-homework/{id}','HomeworkController@deleteHomework');

    Route::get('createHomework','HomeworkController@createHomework');

    Route::post('create-homework','HomeworkController@homeworkCreate');

    Route::get('edit-homework/{id}','HomeworkController@editHomework');

    Route::post('edit-homework-detail','HomeworkController@updateHomeworkDetail');

    Route::get('get-edit-data/{id}','HomeworkController@editDataDiv');

    Route::get('batch-class-div-homework/{id}','HomeworkController@classBatchDivision');

    Route::get('get-timetable-subjects/{id}','TimetableController@getSubjects');

    Route::get('get-subject-divisions/{id}/{subject_id}/{batch_id}',array('uses' => 'HomeworkController@getSubjectDiv'));

    Route::post('get-division-students',array('uses' => 'HomeworkController@getStudentData'));

    Route::get('download/{file_name}', 'HomeworkController@getDownload');

    Route::get('delete-file/{file_name}/{homework_id}', 'HomeworkController@deleteFile');

    Route::get('results','ResultController@showResults');

    Route::post('get-edit-division-students',array('uses' => 'HomeworkController@getEditStudentData'));

    Route::get('download/{file_name}', 'HomeworkController@getDownload');

    Route::get('exams/{id}','ResultController@examResults');

    Route::get('subjects/{id}','ResultController@subjectResults');

    Route::get('getStudents/{id}','ResultController@getStudents');

    Route::get('mark-attendance','AttendanceController@markAttendance');

    Route::get('get-all-classes/{id}','AttendanceController@getAllClasses');

    Route::get('get-attendance-classes/{id}','AttendanceController@getAttendanceClasses');

    Route::get('get-all-division/{id}','AttendanceController@getAllDivision');

    Route::get('get-attendance-division/{id}/{batchId}','AttendanceController@getAttendanceDivision');

    Route::get('get-all-student/{id}/{dateValue}','AttendanceController@getAllStudent');

    Route::post('mark-attendance','AttendanceController@attendanceMark');

    Route::get('mark-attendance-check','AttendanceController@markAttendanceAccess');

    Route::get('leave-check','LeaveController@leaveAccess');

    Route::get('view-attendance','AttendanceController@viewAttendance');

    Route::get('auto-notification','NotificationController@listNotifications');

    Route::get('students-attendance-history','HistoryController@showAttendance');

    Route::get('students/{id}','HistoryController@getStudents');

    Route::get('get-attendance/{name?}','HistoryController@getAttendance');

    Route::get('students-results-history','HistoryController@showResults');

    Route::post('save-event','EventController@saveEvent');

    Route::get('user-module-acl','UsersController@userModuleAcls');

    Route::post('save-user','UsersController@store');

    Route::get('get-batches','UsersController@getBatches');

    Route::post('acl-update/{id}','UsersController@aclUpdate');

    Route::get('user-module-acl-edit/{id}','UsersController@userModuleAclsEdit');

    Route::get('edit-mychildrens/{id}','UsersController@editMyChildren');

    Route::get('create-batch/{batchName}','ClassController@createBatch');

    Route::get('delete-batch/{id}','ClassController@deleteBatch');

    Route::get('create-division','ClassController@createDivision');

    Route::post('division-create','ClassController@saveDivision');

    Route::get('check-div/{clsDiv}','ClassController@checkDivision');

    Route::get('check-division','ClassController@divisionCheck');

    Route::get('create-subject','SubjectController@createSubjects');

    Route::post('subject-create','SubjectController@create');

    Route::get('subject-teacher','SubjectTeacherController@index');

    Route::get('/get-sub-batches/{id}','SubjectTeacherController@getSubjectBatches');

    Route::get('/get-sub-classes/{id}/{subject}','SubjectTeacherController@getSubjectClasses');

    Route::get('/get-sub-divisions/{id}','SubjectTeacherController@getSubjectDivisions');

    Route::get('/get-sub-teachers/{id}/{subject}','SubjectTeacherController@getDivisionTeachers');

    Route::post('/create-relation','SubjectTeacherController@createRelation');

    Route::get('/delete-relation/{id}','SubjectTeacherController@deleteRelation');

    Route::get('/check-sub-teacher/{subject}/{division}','SubjectTeacherController@checkTeacher');

    Route::get('/check-subject','SubjectController@checkSubject');

    Route::get('loadmore-homework/{id}','HomeworkController@loadMore');

    Route::get('get-classes/{id}',array('uses' => 'UsersController@getClasses'));
    Route::get('get-divisions/{id}',array('uses' => 'UsersController@getDivisions'));
    Route::get('get-parents',array('uses' => 'UsersController@getParents'));
    Route::post('check-user',array('uses' => 'UsersController@checkUser'));
    Route::post('check-email',array('uses' => 'UsersController@checkEmail'));
    Route::get('get-user-roles',array('uses' => 'UsersController@getUserRoles'));
    Route::get('get-admins',array('uses' => 'UsersController@getAdmins'));
    Route::get('get-teachers',array('uses' => 'UsersController@getTeachers'));
    Route::get('get-students/{division}',array('uses' => 'UsersController@getStudentList'));
    Route::post('compose-message',array('uses'=>'MessageController@composeMessage'));
    Route::get('get-batches-teacher','UsersController@getBatchesTeacher');
    Route::get('get-classes-teacher/{id}',array('uses' => 'UsersController@getClassesTeacher'));
    Route::get('get-divisions-teacher/{id}',array('uses' => 'UsersController@getDivisionsTeacher'));
    Route::get('get-subject-batches/{id}','HomeworkController@getSubjectBatches');
// Password reset link request routes...
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');

    Route::get('/home','FrontController@index');

// Send email and verification routes...
    Route::post('send-email','UsersController@sendMail');
    Route::get('verify/{confirmationCode}',array('uses' => 'UsersController@verifyUser'));

    Route::get('get-subject-classes/{id}/{subject_id}','HomeworkController@getSubjectClass');

//check class teacher
    Route::get('check-class-teacher/{id}',array('uses'=>'UsersController@checkClassTeacher'));


//check email for edit user
    Route::post('check-email-edit',array('uses' => 'UsersController@checkEmailEdit'));
//check roll number exists or not
    Route::post('check-roll-number',array('uses' => 'UsersController@checkRollNumber'));
//check class name
    Route::get('check-class',array('uses' => 'ClassController@checkClass'));
    Route::post('check-parent',array('uses' => 'UsersController@checkParent'));

    /* API Routes */
    Route::group(['prefix' => 'api/v1/user/'], function () {

    Route::post('auth','api\UserController@login');

    //leave Related
    Route::get('approvedleaves',array('uses' => 'api\LeaveController@getApprovedLeaveList'));
    Route::get('pendingleaves',array('uses' => 'api\LeaveController@getPendingLeaveList'));
    Route::put('approveleaves',array('uses' => 'api\LeaveController@approveLeave'));
    Route::post('deatil-leaveinformation',array('uses' => 'api\LeaveController@getDetailLeaveInformation'));

    //Attendance Related
    Route::get('attendance-batches','api\AttendanceController@getAttendanceBatches');
    Route::get('attendance-classes/{batchId}','api\AttendanceController@getAttendanceClasses');
    Route::get('get-attendance-divisions/{classId}','api\AttendanceController@getAttendanceDivisions');
    Route::post('markAttendance','api\AttendanceController@markAttendance');
    Route::post('previousAttendance','api\AttendanceController@markPreviousAttendance');
    Route::post('submitAttendance','api\AttendanceController@submitAttendance');
    Route::post('view-attendance-teacher','api\AttendanceController@viewAttendance');

    //Message Related
    Route::post('get-detail-message',array('uses' => 'api\MessageController@getDetailMessages'));//teacher & parent(of students) gets details messages (conversation)
    Route::get('get-messages',array('uses' => 'api\MessageController@getMessages'));//teacher gets message listing
    Route::get('get-messages-parent/{student_id}',array('uses' => 'api\MessageController@getMessagesParent'));//parent gets message listing
    Route::put('delete-messages',array('uses' => 'api\MessageController@deleteMessages'));
    Route::get('userroles',array('uses' => 'api\MessageController@getUserRoles'));
    Route::get('getteachers',array('uses' => 'api\MessageController@getTeachers'));
    Route::get('gettadmins',array('uses' => 'api\MessageController@getAdmins'));
    Route::get('get-batches-teacher',array('uses' => 'api\UserController@getBatchesTeacher'));
    Route::get('getclasses/{batch_id}',array('uses' => 'api\UserController@getClassesTeacher'));
    Route::get('getdivisions/{class_id}',array('uses' => 'api\UserController@getDivisions'));
    Route::get('get-students-list/{division_id}',array('uses' => 'api\MessageController@getStudentList'));
    Route::post('send-message',array('uses' => 'api\MessageController@sendMessage'));
    Route::get('get-teachers-list/{id}','api\UserController@getTeachersList');
    Route::get('get-message-count/{id}','api\MessageController@getMessageCount');
    Route::get('get-acl-details','api\MessageController@getAclDetails');

    Route::get('get-switching-details','api\UserController@getSwitchingDetails');


 //Homework related
    Route::get('get-homework-types','api\HomeworkController@getHomeworkType');

    Route::post('homework-create','api\HomeworkController@createHomework');

    Route::put('update-homework',array('uses' => 'api\HomeworkController@updateHomework'));

    Route::put('publish-homework/',array('uses' => 'api\HomeworkController@publishHomeWork'));

    Route::put('deleteHomework',array('uses' => 'api\HomeworkController@deleteHomework'));

    Route::get('get-teachers-subjects','api\HomeworkController@getTeacherSubject');

    Route::get('get-subjects-batches/{subject_id}','api\HomeworkController@getSubjectBatches');

    Route::get('get-batches-classes/{subject_id}/{batch_id}','api\HomeworkController@getBatchesClasses');

    Route::get('get-classes-division/{subject_id}/{batch_id}/{class_id}','api\HomeworkController@getClassesDivision');

    Route::post('get-divisions-students','api\HomeworkController@getDivisionsStudents');

    Route::get('view-homework-parent/{student_id}','api\HomeworkController@viewHomeworkParent');

    Route::get('view-homework','api\HomeworkController@viewHomeWork');

    Route::get('view-unpublished-homework',array('uses' => 'api\HomeworkController@viewUnpublishedHomeWork'));
   
    Route::get('view-detail-homework/{homework_id}',array('uses' => 'api\HomeworkController@viewDetailHomeWork'));


        //Timetable
        Route::get('view-timetable-parent/{studentId}/{day_id}','api\TimetableController@viewTimetableParent');
        Route::get('view-timetable-teacher/{div_id}/{day_id}','api\TimetableController@viewTimetableTeacher');
        Route::get('get-batches','api\TimetableController@getBatches');
        Route::get('get-classes/{batchId}','api\TimetableController@getClasses');
        Route::get('get-divisions/{classId}','api\TimetableController@getDivisions');

        //Announcement
        Route::post('create-announcement','api\NoticeBoardController@createAnnouncement');
        Route::post('edit-announcement/{id}','api\NoticeBoardController@editAnnouncement');
        Route::get('view-announcement','api\NoticeBoardController@viewAnnouncement');

        //Result
        Route::get('view-result/{id}','api\ResultController@viewResult');
        Route::get('view-test-chart/{uid}/{tid}','api\ResultController@viewTestGraph');
        Route::get('view-subject-chart/{uid}/{tid}','api\ResultController@viewSubjectGraph');
        Route::post('create-achievement','api\NoticeBoardController@createAchievement');
        Route::get('view-achievement','api\NoticeBoardController@viewAchievement');

    });
