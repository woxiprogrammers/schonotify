<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventTypes;
use App\FeeConcessionAmount;
use App\FeeInstallments;
use App\Fees;
use App\Homework;
use App\StudentFee;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Route;
use Illuminate\Support\Facades\Redirect;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Message;
use App\User;
use DateTime;
class FrontController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
        $this->middleware('db');

    }

    public function index(Request $request)
    {
        if(isset(Auth::user()->email))
        {
            $userInfo= User::Join('module_acls', 'users.id', '=', 'module_acls.user_id')
                ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
                ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
                ->where('users.id','=',Auth::user()->id)
                ->select('users.id','users.email','users.username as username','users.first_name as firstname','users.last_name as lastname','acl_master.slug as acl','modules.title as module','modules.slug as module_slug')
                ->get();
            $resultArr=array();
            foreach($userInfo as $user) {
                array_push($resultArr,$user->acl.'_'.$user->module_slug);
            }
            $userId = Auth::user();
            $date = new Carbon();
            $date->subDays(2);
            //homework
            $homeworkData = Homework::join('homework_teacher','homework_teacher.homework_id','=','homeworks.id')
                                    ->join('homework_types','homework_types.id','=','homeworks.homework_type_id')
                                    ->join('divisions','divisions.id','=','homework_teacher.division_id')
                                    ->join('classes','classes.id','=','divisions.class_id')
                                    ->join('users','users.id','=','homework_teacher.teacher_id')
                                    ->where('homeworks.is_active',1)
                                    ->where('users.body_id',$userId->body_id)
                                    ->where('homeworks.created_at', '>=', $date->toDateTimeString())
                                    ->distinct('homeworks.id')
                                    ->select('homeworks.title','homeworks.description','homework_types.title as homework_type','divisions.division_name','classes.class_name','homeworks.created_at','users.first_name','users.last_name')
                                    ->orderBy('homeworks.created_at','desc')->get()->toArray();
            //Events
            $achievementsId = EventTypes::where('slug','achievement')->pluck('id');
            $announcementId = EventTypes::where('slug','announcement')->pluck('id');
            $eventId = EventTypes::where('slug','event')->pluck('id');
            $achievementsData = Event::where('event_type_id',$achievementsId)->where('body_id',$userId->body_id)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $announcementData = Event::where('event_type_id',$announcementId)->where('body_id',$userId->body_id)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $eventData = Event::where('event_type_id',$eventId)->where('body_id',$userId->body_id)->orderBy('created_at','desc')->take(15)->skip(0)->get()->toArray();
            $unreadMsgCount = Message::where('to_id',$userId->id)->where('read_status',0)->count();
            Session::put('functionArr',$resultArr);

            $fees = Fees::join('fee_classes','fee_classes.fee_id','=','fees.id')
                         ->join('classes','classes.id','=','fee_classes.class_id')
                         ->where('classes.body_id','=',$userId->body_id)
                         ->where('fees.year','=','2019-2020')
                         ->distinct('fees.id')
                         ->select('fees.id','fees.fee_name','fees.total_amount')
                         ->get()->toArray();
            $i = 0;
            foreach ($fees as $fee){
                $feeData[$i]['paidFee'] = 0;
                $feeData[$i]['total'] = 0;
                $feeData[$i]['name'] = $fee['fee_name'];
                $userIds = User::join('divisions','divisions.id','=','users.division_id')
                                ->join('classes','classes.id','=','divisions.class_id')
                                ->join('fee_classes','fee_classes.class_id','=','classes.id')
                                ->where('fee_classes.fee_id','=',$fee['id'])
                                ->where('users.is_active','=',true)
                                ->lists('users.id');
                $feeData[$i]['total'] = $fee['total_amount'] * count($userIds);
                $studentsAssignFeeStructure = StudentFee::whereIn('student_id',$userIds)->lists('student_id');
                $students = User::join('students_extra_info', 'users.id','=','students_extra_info.student_id')
                    ->join('transaction_details','transaction_details.student_id','=','users.id')
                    ->join('fees','fees.id','=','transaction_details.fee_id')
                    ->whereIn('users.id', $studentsAssignFeeStructure)
                    ->where('users.is_active',1)
                    ->select('transaction_details.id as transaction_id','transaction_details.student_id as id','transaction_details.date as date','fees.fee_name as name','users.first_name as first_name','users.last_name as last_name','transaction_details.transaction_amount','students_extra_info.grn as grn','fees.id as fee_id','transaction_details.installment_id as Installment','transaction_details.id as amount_id')
                    ->get()->toArray();
                $jIterator = 0;
                foreach ($students as $studentId){
                    $feeData[$i]['paidFee'] += $studentId['transaction_amount'];
                    /*$studentFee = StudentFee::where('student_id',$studentId['id'])->where('fee_id',$studentId['fee_id'])->select('fee_id','year','fee_concession_type','caste_concession')->get()->toarray();
                    $iterator = 0;
                    $students[$jIterator]['total'] = 0;
                    foreach ($studentFee as $key => $fee_id){
                        $installment_info = FeeInstallments::where('fee_id',$fee_id['fee_id'])->select('fee_id','installment_id','particulars_id','amount')->get()->toarray();
                        $installments = array();
                        if(!empty($installment_info)){
                            foreach($installment_info as $installment){
                                if(!array_key_exists($installment['installment_id'],$installments)){
                                    $installments[$installment['installment_id']] = array();
                                    $installments[$installment['installment_id']]['subTotal'] = 0;
                                }
                                $installments[$installment['installment_id']]['subTotal'] += $installment['amount'];
                            }
                            $totalYearsFeeAmount = array_sum(array_column($installments,'subTotal'));
                            foreach($installments as $installmentId => $installmentArray){
                                $percentage = ($installments[$installmentId]['subTotal'] / $totalYearsFeeAmount) * 100;
                                $installments[$installmentId]['installment_percentage'] = ($installments[$installmentId]['subTotal'] / $totalYearsFeeAmount) * 100;
                                $discount = 0;
                                if($fee_id['caste_concession'] != null){
                                    $casteConcessionAmount = StudentFee::join('caste_concession','caste_concession.id','=','student_fee.caste_concession')->where('student_fee.fee_id',$fee_id['fee_id'])->pluck('caste_concession.concession_amount');
                                    $discount += ($casteConcessionAmount/100) * $percentage;
                                }
                                if($fee_id['fee_concession_type'] != null){
                                    $feeConcessionTypeAmount = FeeConcessionAmount::where('fee_id',$fee_id['fee_id'])->where('concession_type',$fee_id['fee_concession_type'])->pluck('amount');
                                    $discount += ($feeConcessionTypeAmount/100) * $percentage;
                                }
                                $students[$jIterator]['total'] += $installments[$installmentId]['subTotal'] - $discount;
                            }
                        }
                        $iterator++;
                    }*/
                    $jIterator++;
                }
                $feeData[$i]['balance'] = $feeData[$i]['total'] - $feeData[$i]['paidFee'];
                $i++;
            }
            return view('admin.dashboard', compact('unreadMsgCount','homeworkData','achievementsData','announcementData','eventData','feeData'));

        }else{

            return view('login_signin');
        }
    }
}
