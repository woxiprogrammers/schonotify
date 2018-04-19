<?php

namespace App\Http\Controllers\Certificate;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class LivingCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function getManageView(Request $request){
        try{

            return view('certificate.livingCertificate.manage');
        }catch (\Exception $e){
            $data = [
                'action' => 'Get Manage living certificate view',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function getCreateView(Request $request){
        try{
            return view('certificate.livingCertificate.create');
        }catch (\Exception $e){
            $data = [
                'action' => 'Get Create living Certificate view',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
    public function studentForm(Request $request){
        try{
            dd($request->all());
            $studentData = StudentExtraInfo::join('users','users.id','=','students_extra_info.student_id')
                ->where('students_extra_info.grn',$request->grn)
                ->select('users.first_name','users.last_name','students_extra_info.grn')->first();
            return view('certificate.bonafide.bonafide_student_form')->with(compact('studentData'));
        }catch (\Exception $e){
            $data = [
                'action' => 'student bonafide form',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
}
