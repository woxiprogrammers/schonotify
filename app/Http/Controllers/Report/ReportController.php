<?php

namespace App\Http\Controllers\Report;

use App\Attendance;
use App\Classes;
use App\Division;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function dailyReport(Request $request){
        try{
             return view('report.dailyAttendanceReport');
        }catch (\Exception $e){
            $data=[
                'action' => 'Gallery folder view',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function dailyReportDateData(Request $request){
        try{
            $attendanceData = array();
            $attendanceData['ClassDivision'] = Classes::join('divisions','divisions.class_id','=','classes.id')
                ->where('classes.body_id',$request->body_id)
                ->select('classes.class_name','divisions.division_name','divisions.id')
                ->get()->toArray();
            $itrator = 0;
            foreach ($attendanceData['ClassDivision'] as $value){
                $totalPresent = Attendance::where('date',$request->date)->where('division_id',$value['id'])->lists('student_id');
                $attendanceData['ClassDivision'][$itrator]['present']['boys'] = User::whereIn('id',$totalPresent)->where('gender','M')->count();
                $attendanceData['ClassDivision'][$itrator]['present']['girls'] = User::whereIn('id',$totalPresent)->where('gender','F')->count();
                $attendanceData['ClassDivision'][$itrator]['present']['total'] = $attendanceData['ClassDivision'][$itrator]['present']['boys'] + $attendanceData['ClassDivision'][$itrator]['present']['girls'];
                $attendanceData['ClassDivision'][$itrator]['absent']['boys'] = User::where('division_id',$value['id'])->whereNotIn('id',$totalPresent)->where('gender','M')->count();
                $attendanceData['ClassDivision'][$itrator]['absent']['girls'] = User::where('division_id',$value['id'])->whereNotIn('id',$totalPresent)->where('gender','F')->count();
                $attendanceData['ClassDivision'][$itrator]['absent']['total'] = $attendanceData['ClassDivision'][$itrator]['absent']['boys'] + $attendanceData['ClassDivision'][$itrator]['absent']['girls'];
                $attendanceData['ClassDivision'][$itrator]['Total']['boys'] = User::where('division_id',$value['id'])->where('gender','M')->count();
                $attendanceData['ClassDivision'][$itrator]['Total']['girls'] = User::where('division_id',$value['id'])->where('gender','F')->count();
                $attendanceData['ClassDivision'][$itrator]['Total']['total'] = $attendanceData['ClassDivision'][$itrator]['Total']['boys'] + $attendanceData['ClassDivision'][$itrator]['Total']['girls'];
                $itrator++;
            }
            dd($attendanceData);
        }catch (\Exception $e){
            $data=[
                'action' => 'Gallery folder view',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}

