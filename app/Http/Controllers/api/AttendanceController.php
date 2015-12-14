<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\Classes;
use App\Division;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
        public function markAttendance(Request $request)
        {
            $batch=Batch::where('id',$request->batch_id)->first();
            $class=Classes::where('id',$request->class_id)->first();
            $division=Division::where('id',$request->division_id)->first();
            $student_list=User::where('division_id',$division->id)->get();
            dd($student_list);
        }
}
