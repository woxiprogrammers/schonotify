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
use Mockery\CountValidator\Exception;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function index(Requests\WebRequests\EventRequest $request)
    {
        if($request->authorize()===true)
        {
            return view('admin.event');
        }else{
            return Redirect::to('/');
        }

    }

    public function saveEvent(Requests\WebRequests\EventRequest $request)
    {
           return $request;
    }
}
