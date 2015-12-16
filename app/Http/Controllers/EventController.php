<?php

namespace App\Http\Controllers;

use App\Body;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.event');
    }

    public function saveEvent(Request $request)
    {
        $data=Input::all();
        $user=Auth::User();
        $body=Body::find($user->body_id);
        $time=time();
        if(Input::hasFile('image'))
        {
            $fileName=Input::file('image')->getClientOriginalName();

            if($fileName !="")
            {
                Input::file('image')->move('assets/images/'.$body->name.'/events/'.$fileName.'_'.$time);
            }
        }


    }
}
