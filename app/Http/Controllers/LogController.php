<?php

namespace App\Http\Controllers;
use App\TeacherView;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Session;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {

    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function logout(){
        Auth::logout();
        return Redirect::to('/');
    }

    public function forgot()
    {
        return view('login_forgot');
    }

    public function lockScreen()
    {
        return view('lockScreen');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {

        if(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']]))
        {
            $role_id=Auth::user()->role_id;

            $id=Auth::user()->id;

            if(Auth::user()->is_active == 1)
            {
                if($role_id == 1)
                {
                    return Redirect::to('/');

                }elseif($role_id == 2){

                    $view= TeacherView::select()->where('teacher_id','=',$id)->get();

                    foreach($view as $val)
                    {
                        $web_view=$val['web_view'];
                    }

                    if($web_view == 1)
                    {
                        return Redirect::to('/');
                    }else{
                        Auth::logout();
                        Session::flash('message-error','Sorry...You don`t have web access. Kindly contact to your admin.');
                        return Redirect::to('/');
                    }

                }else{
                    Auth::logout();
                    Session::flash('message-error','You are not valid user');
                    return Redirect::to('/');
                }
            }else{
                Auth::logout();
                Session::flash('message-error','Sorry ... Your account has been not activated');
                return Redirect::to('/');
            }
        }

        Session::flash('message-error','Wrong email or password');

        return Redirect::to('/');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
