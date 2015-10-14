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

Route::get('searchClasses','SearchController@searchClasses');

Route::get('searchSubjects','SearchController@searchSubjects');

Route::get('active/{id}','UsersController@activeUser');

Route::get('deactive/{id}','UsersController@deactiveUser');

Route::get('createClass','ClassController@create');

