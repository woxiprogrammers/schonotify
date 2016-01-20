<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function leaveListing(Requests\WebRequests\LeaveRequest $request)
    {
        if($request->authorize()===true)
        {
            return view('leaveListing');
        }else{
            return Redirect::to('/');
        }

    }

    public function detailedLeave(Requests\WebRequests\LeaveRequest $request)
    {
        if($request->authorize()===true)
        {
            return view('detailedLeave');
        }else{
            return Redirect::to('/');
        }
    }
}
