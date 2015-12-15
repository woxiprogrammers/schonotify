<?php

namespace App\Http\Controllers;
use App\TeacherView;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
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
        $this->middleware('db');
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

        $user=User::select()->where('email','=',$request['email'])->first();

        if($user == NULL || !(\Hash::check($request['password'],$user->password)))
        {
            Session::flash('message-error','Wrong email or password');
            return Redirect::to('/');
        }elseif($user->is_active == 0)
        {
            Session::flash('message-error','Sorry ... Your account is not activated');
            return Redirect::to('/');
        }elseif($user->role_id == 2)
        {
            $view= TeacherView::select()->where('teacher_id','=',$user->id)->get();
            foreach($view as $val)
            {
                $web_view=$val['web_view'];
            }
            if($web_view == 0)
            {
                Session::flash('message-error','Sorry...You don`t have web access. Kindly contact to your admin.');
                return Redirect::to('/');
            }elseif(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']]))
                {
                    return Redirect::to('/');
                }

        }elseif(Auth::attempt(['email'=>$request['email'],'password'=>$request['password']]))
        {
            return Redirect::to('/');
        }else{
            Session::flash('message-error','Wrong email or password');
            return Redirect::to('/');
        }

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
