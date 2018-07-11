<?php

namespace App\Http\Controllers\Certificate;

use App\Helper\NumberHelper;
use App\LivingCertificate;
use App\StudentExtraInfo;
use App\StudentPreviousSchool;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LivingCertificateController extends Controller
{
      public function __construct()
    {
               $this->middleware('db');
               $this->middleware('auth');
           }
public function getManageView(Request $request){
        try{
            $StudentData = LivingCertificate::join('students_extra_info','students_extra_info.grn','=','living_certificate.grn')
                ->join('users','users.id','=','students_extra_info.student_id')
                ->join('divisions','divisions.id','=','users.division_id')
                ->join('classes','classes.id','=','divisions.class_id')
                ->select('living_certificate.id','living_certificate.date_of_leaving','users.first_name','users.last_name','living_certificate.reason','living_certificate.grn','users.division_id','classes.class_name')->get()->toArray();
            return view('certificate.livingCertificate.manage')->with(compact('StudentData'));
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
            $studentID = StudentExtraInfo::where('grn',$request->grn)->pluck('student_id');
            $studentData = StudentExtraInfo::join('users','users.id','=','students_extra_info.student_id')
                ->where('students_extra_info.grn',$request->grn)
                ->select('users.first_name','users.last_name','students_extra_info.grn','students_extra_info.aadhar_number','users.date_of_admission')->first();
            $studentPreviousSchoolData = StudentPreviousSchool::where('student_id',$studentID)->select('school_name','city')->first();
            return view('certificate.livingCertificate.livingCertificateForm')->with(compact('studentData','studentPreviousSchoolData'));
        }catch (\Exception $e){
            $data = [
                'action' => 'student Living Certificate form',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
       }
    }
    public function studentFormCreate(Request $request){
        try{
            $studentID = User::join('students_extra_info','students_extra_info.student_id','=','users.id')
                                ->where('students_extra_info.grn',$request->grn)
                                ->select('users.id')->first();
            $dateOfAdmission = User::where('id',$studentID['id'])->pluck('date_of_admission');
            $data['grn'] = $request->grn;
            $data['aadhar_number'] = $request->aadharCard;
            $data['last_school_attented'] = $request->lastSchool;
            $data['date_of_admission'] = $dateOfAdmission;
            $data['progress'] = $request->progress;
            $data['conduct'] = $request->conduct;
            $data['date_of_leaving'] = Carbon::now();
            $data['standard_in_which_studying'] = $request->standard_studying_from_when;
            $data['reason'] = $request->reason;
            $data['remark'] = $request->remark;
            $query1 = LivingCertificate::create($data);
            $restrictData['is_lc_generated'] = true;
            $query = User::where('id',$studentID['id'])->update($restrictData);
            if($query1){
                Session::flash('message-success','data created successfully');
            }else{
                Session::flash('message-error','something went wrong');
            }
            $message = "created";
            $status = "200";
        }catch (\Exception $e){
            $data = [
                'action' => 'student data created',
                'exception' => $e->getMessage()
            ];
            $message = 'Something went wrong .';
            $status = 500;
            Log::critical(json_encode($data));
        }
        return response()->json(['message' => $message], $status);

}
    public function livingCretificateView(Request $request,$id){
        try{
            $studentData = LivingCertificate::join('students_extra_info','students_extra_info.grn','=','living_certificate.grn')
                                                ->join('users','users.id','=','students_extra_info.student_id')
                                                ->join('parent_extra_info','parent_extra_info.parent_id','=','users.parent_id')
                                                ->where('living_certificate.id',$id)
                                                ->select('living_certificate.id as id','living_certificate.aadhar_number as aadhar_number','living_certificate.last_school_attented as last_school_attented','living_certificate.date_of_admission as date_of_admission','living_certificate.progress as progress','living_certificate.conduct as conduct','living_certificate.date_of_leaving as date_of_leaving','living_certificate.standard_in_which_studying as standard_in_which_studying','living_certificate.reason as reason','living_certificate.remark as remark','users.birth_date as birth_date','users.first_name as first_name','users.last_name as last_name','users.body_id as body_id','parent_extra_info.mother_first_name as mother_first_name','parent_extra_info.mother_middle_name as mother_middle_name','parent_extra_info.mother_last_name as mother_last_name','parent_extra_info.father_first_name as father_first_name','students_extra_info.birth_place as birth_place','students_extra_info.nationality as nationality','students_extra_info.religion as religion','students_extra_info.caste as caste','students_extra_info.category as category','students_extra_info.mother_tongue as mother_tongue','students_extra_info.grn as grn')
                                                ->first();
            $birthday = explode('-', $studentData['birth_date']);
            $birthYear = NumberHelper::convertInWords($birthday[0]);
            $birthDay = NumberHelper::convertInWords($birthday[2]);
            $birthMonth = date('F',strtotime($studentData['birth_date']));
            $birthDayInWords = "$birthDay  $birthMonth  $birthYear";
                return view('certificate.livingCertificate.livingCertificateView')->with(compact('studentData','birthDayInWords'));
        }catch(\Exception $e){
            $data = [
                'action' => 'student data View',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }

    }
    public function livingCretificateEdit(Request $request,$id){
        try{
            $livingCertificateData = LivingCertificate::where('id',$id)->first();
            return view('certificate.livingCertificate.livingCertificateEdit')->with(compact('livingCertificateData'));
        }catch(\Exception $e){
            $data = [
                'action' => 'student data Edit',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function livingCretificateDownload(Request $request,$id){
        try{
            $studentData = LivingCertificate::join('students_extra_info','students_extra_info.grn','=','living_certificate.grn')
                ->join('users','users.id','=','students_extra_info.student_id')
                ->join('parent_extra_info','parent_extra_info.parent_id','=','users.parent_id')
                ->where('living_certificate.id',$id)
                ->select('living_certificate.id as id','living_certificate.aadhar_number as aadhar_number','living_certificate.last_school_attented as last_school_attented','living_certificate.date_of_admission as date_of_admission','living_certificate.progress as progress','living_certificate.conduct as conduct','living_certificate.date_of_leaving as date_of_leaving','living_certificate.standard_in_which_studying as standard_in_which_studying','living_certificate.reason as reason','living_certificate.remark as remark','users.birth_date as birth_date','users.first_name as first_name','users.last_name as last_name','users.body_id as body_id','parent_extra_info.mother_first_name as mother_first_name','parent_extra_info.mother_middle_name as mother_middle_name','parent_extra_info.mother_last_name as mother_last_name','students_extra_info.birth_place as birth_place','parent_extra_info.father_first_name as father_first_name','students_extra_info.nationality as nationality','students_extra_info.religion as religion','students_extra_info.caste as caste','students_extra_info.category as category','students_extra_info.mother_tongue as mother_tongue','students_extra_info.grn as grn')
                ->first();
            $birthday = explode('-', $studentData['birth_date']);
            $birthYear = NumberHelper::convertInWords($birthday[0]);
            $birthDay = NumberHelper::convertInWords($birthday[2]);
            $birthMonth = date('F',strtotime($studentData['birth_date']));
            $birthDayInWords = "$birthDay  $birthMonth  $birthYear";
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML(view('certificate.livingCertificate.livingCertificatePDF')->with(compact('studentData','birthDayInWords')));
            return $pdf->download('livingCertificate.pdf');
        }catch(\Exception $e){
            $data = [
                'action' => 'student data Download',
                'exception' => $e->getMessage()
            ];
          Log::critical(json_encode($data));
        }
    }
    public function livingCretificateEditForm(Request $request,$id,$grn){
        try{
            $dateOfAdmission = date('Y/d/m',strtotime($request->admissionDate));
            $data['aadhar_number'] = $request->aadharCard;
            $data['last_school_attented'] = $request->lastSchool;
            $data['date_of_admission'] = $dateOfAdmission;
            $data['progress'] = $request->progress;
            $data['conduct'] = $request->conduct;
            $data['date_of_leaving'] = date('Y/d/m',strtotime($request->livingSchoolDate));
            $data['standard_in_which_studying'] = $request->standard_studying_from_when;
            $data['reason'] = $request->reason;
            $data['remark'] = $request->remark;
            $query = LivingCertificate::where('id',$id)->where('grn',$grn)->update($data);
            if($query){
                Session::flash('message-success','data Update successfully');
                return redirect('/certificates/livingCertificate/manage');
            }else{
                Session::flash('message-error','Something went wrong');
            }
        }catch(\Exception $exception){
            $data=[
                'action' => 'living Certificate Edit',
                'exception' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}