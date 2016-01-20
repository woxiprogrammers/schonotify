<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function markAttendance(Requests\WebRequests\CreateAttendanceRequest $request)
    {
        if($request->authorize()===true)
        {
            return view('markAttendance');
        }else{
            return Redirect::to('/');
        }

    }
    public function viewAttendance(Requests\WebRequests\ViewAttendanceRequest $request)
    {
        if($request->authorize()===true)
        {
            return view('viewAttendance');
        }else{
            return Redirect::to('/');
        }

    }

}
