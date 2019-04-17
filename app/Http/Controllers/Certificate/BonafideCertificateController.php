<?php

namespace App\Http\Controllers\certificate;

use App\Body;
use App\BonafideCertificateTable;
use App\Helper\NumberHelper;
use App\LivingCertificate;
use App\ParentExtraInfo;
use App\StudentExtraInfo;
use App\StudentFamily;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class BonafideCertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }

    public function getManageView(Request $request){
        try{
            $StudentData = BonafideCertificateTable::join('students_extra_info','students_extra_info.grn','=','bonafide_certificate_table.grn')
                            ->join('users','users.id','=','students_extra_info.student_id')
                            ->select('bonafide_certificate_table.id','users.first_name','users.last_name','bonafide_certificate_table.grn','bonafide_certificate_table.created_at')->get()->toArray();
            return view('certificate.bonafide.manage')->with(compact('StudentData'));
        }catch (\Exception $e){
            $data = [
                'action' => 'Get Manage bonafide view',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }

    public function getCreateView(Request $request){
        try{
            return view('certificate.bonafide.create');
        }catch (\Exception $e){
            $data = [
                'action' => 'Get Create bonafide view',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }

    public function createBonafideForm(Request $request){
        try{
            $data['grn'] = $request->grn;
            $data['taluka'] = $request->taluka;
            $data['district'] = $request->district;
            $data['from_date'] = $request->from_date;
            $data['to_date'] = $request->to_date;
            $query = BonafideCertificateTable::create($data);
            $message = 'Success .';
            $status = 200;
            if($query){
                Session::flash('message-success','data created successfully');
            }else{
                Session::flash('message-error','something went wrong');
            }
        }catch (\Exception $e){
            $data = [
                'action' => 'Get Bonafide view',
                'GRN' => $request->grn,
                'exception' => $e->getMessage()
            ];
            $message = 'Something went wrong .';
            $status = 500;
            Log::critical(json_encode($data));
        }
        return response()->json(['message' => $message], $status);
    }

    public function downloadBonafide(Request $request,$grn){
        try{
            $user = Auth::user();
            $data = array();
            $data = StudentExtraInfo::join('bonafide_certificate_table','bonafide_certificate_table.grn','=','students_extra_info.grn')
                ->join('users','users.id','=','students_extra_info.student_id')
                ->where('bonafide_certificate_table.grn',$grn)
                ->select('students_extra_info.grn as grn','users.first_name','users.last_name','bonafide_certificate_table.to_date','bonafide_certificate_table.from_date','students_extra_info.caste','students_extra_info.birth_place','users.birth_date','bonafide_certificate_table.taluka','bonafide_certificate_table.district','users.parent_id','users.id','users.body_id')
                ->get()->first();
            $data['parent'] = ParentExtraInfo::where('parent_id',$data['parent_id'])->select('mother_first_name','mother_middle_name','mother_last_name')->first();
            $data['class'] = User::join('divisions','divisions.id','=','users.division_id')
                ->join('classes','classes.id','=','divisions.class_id')
                ->where('users.id',$data['id'])
                ->select('divisions.division_name','classes.class_name')->first();
            $data['name'] = Body::where('id',$user['body_id'])->pluck('name');
            $birthday = explode('-', $data['birth_date']);
            $birthYear = NumberHelper::convertInWords($birthday[0]);
            $birthDay = NumberHelper::convertInWords($birthday[2]);
            $birthMonth = date('M',strtotime($data['birth_date']));
            $data['words'] = "$birthDay / $birthMonth / $birthYear";
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML(view('certificate.bonafide.bonafide_pdf')->with(compact('data')));
            return $pdf->download('bonafide.pdf');
        }catch (\Exception $e){
            $data = [
                'action' => 'Download Bonafide Certificate',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500);
        }
    }
    public function studentForm(Request $request){
        try{
            $bonafide = LivingCertificate::where('grn','=',$request->grn)->count();
            if($bonafide == 1){
                $studentData = "lcCreated";
            }else{
                $studentData = StudentExtraInfo::join('users','users.id','=','students_extra_info.student_id')
                    ->where('students_extra_info.grn',$request->grn)
                    ->select('users.first_name','users.last_name','students_extra_info.grn')->first();
            }
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
    public function bonafideView(Request $request,$grn){
        $data = array();
        $user = Auth::user();
        $data = StudentExtraInfo::join('bonafide_certificate_table','bonafide_certificate_table.grn','=','students_extra_info.grn')
                                  ->join('users','users.id','=','students_extra_info.student_id')
                                  ->where('bonafide_certificate_table.grn',$grn)
                                  ->select('students_extra_info.grn as grn','users.first_name','users.last_name','bonafide_certificate_table.to_date','bonafide_certificate_table.from_date','students_extra_info.caste','students_extra_info.birth_place','users.birth_date','bonafide_certificate_table.taluka','bonafide_certificate_table.district','users.parent_id','users.id','users.body_id')
                                  ->get()->first();
        $data['parent'] = ParentExtraInfo::where('parent_id',$data['parent_id'])->select('mother_first_name','mother_middle_name','mother_last_name')->first();
        $data['class'] = User::join('divisions','divisions.id','=','users.division_id')
                               ->join('classes','classes.id','=','divisions.class_id')
                                ->where('users.id',$data['id'])
                                ->select('divisions.division_name','classes.class_name')->first();
        $data['name'] = Body::where('id',$user['body_id'])->pluck('name');
         $birthday = explode('-', $data['birth_date']);
         $birthYear = NumberHelper::convertInWords($birthday[0]);
         $birthDay = NumberHelper::convertInWords($birthday[2]);
         $birthMonth = date('M',strtotime($data['birth_date']));
         $data['words'] = "$birthDay / $birthMonth / $birthYear";
        return view('certificate.bonafide.bonafide_partial')->with(compact('data'));
    }
    public function delete(Request $request,$id){
          try{
            $query = BonafideCertificateTable::where('id',$id)->delete();
            if($query){
                Session::flash('message-success','data deleted successfully');
                return back();
            }else{
                Session::flash('message-error','Something went wrong');
                return back();
            }
          }catch(\Exception $e){
              $data =[
                  'action' => 'deleted',
                  'exception' => $e->getMessage()
              ];
              Log::critical(json_encode($data));
          }
    }
}
