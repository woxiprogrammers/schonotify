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
Route::get('/body',function(){

    $arr=\App\superAdmin\organisation::all();

    return view('SuperAdmin/BodyRegistration')->with('arr',$arr);

});

Route::group(['domain' => '{account}.schnotify.com'], function () {
    Route::get('/', function ($account) {
        if(strpos($account,'_') !== false){
            $str=explode('_',$account);
            $acc=$str[0];
            $newArr=\App\superAdmin\body::where('title','=',$acc)->get();
            $newArr['body']='its body';
            return view('SuperAdmin/BodyView')->with('newArr',$newArr);
        }else{
            $newArr=\App\superAdmin\organisation::where('name','=',$account)->get();
            $newArr['its organisation']='organisation';
            return view('SuperAdmin/BodyView')->with('newArr',$newArr);
        }
    });
});


Route::get('/',function(){

    return view('SuperAdmin/OrganisationRegistration');

});

Route::post('/','SuperAdmin\RegistrationController@createSubDomain');


Route::post('/body','SuperAdmin\RegistrationController@createSubDomainBody');