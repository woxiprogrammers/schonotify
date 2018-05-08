<?php

namespace App\Http\Controllers\api;

use App\Batch;
use App\CASTECONCESSION;
use App\category_types;
use App\Classes;
use App\ConcessionTypes;
use App\Division;
use App\fee_installments;
use App\fee_particulars;
use App\FeeClass;
use App\FeeConcessionAmount;
use App\FeeDueDate;
use App\FeeInstallments;
use App\Fees;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use App\PushToken;
use App\LeaveRequest;
use App\LeaveType;
use App\StudentFee;
use App\StudentFeeConcessions;
use App\StudentLateFee;
use App\SubjectClassDivision;
use App\TransactionDetails;
use App\TransactionTypes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Leave;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


class LeaveController extends Controller
{
   use PushNotificationTrait;
    public function __construct(Request $request)
    {
        $this->middleware('db');
        $this->middleware('authenticate.user');
    }
    /*
       * Function Name : getLeaveListParent
       * Param : Request $requests $leave_id $student_id
       * Return : Return the array of pending and approved leaves depending upon condition  and status .
       * Desc : if the leave id is 1 the it returns the pending leaves and if leave_id is 2 then
       *        it returns approved leave list to parent of the students only.
       * Developed By : Amol Rokade
       * Date : 20/2/2016
       */

    public function getLeaveListParent(Requests\LeaveRequest $request , $flag , $student_id)
    {
        try {
            $leaveData = array();
            if ( $flag == 1 ) // 1 is for pending leaves
                {
                    $message = 'Successfully Listed';
                    $status = 200;
                    $leaves = LeaveRequest::where('student_id', $student_id)
                        ->where('status', '1') //1 is for pending leaves and 2 for approved leaves.
                        ->orderBy('created_at', 'desc')
                        ->get()->toArray();
                } else if( $flag == 2 ) {
                    $message = 'Successfully Listed';
                    $status = 200;
                    $leaves = Leave::where('student_id', $student_id)
                        ->where('status', '2') //1 is for pending leaves and 2 for approved leaves.
                        ->orderBy('updated_at', 'desc')
                        ->get()->toArray();
                }
                $counter = 0;
                if(!Empty($leaves)) {
                    foreach ($leaves as $leave) {
                        $studentDivision = Division::where('id',$leave['division_id'])->first();
                        $studentClass = Classes::where('id',$studentDivision['class_id'])->first();
                        $studentBatch = Batch::where('id',$studentClass['batch_id'])->first();
                        $studentName = User::where('id',$leave['student_id'])->first();
                        $leaveData[$counter]['roll_number'] = $studentName['roll_number'];
                        $leaveData[$counter]['leave_id'] = $leave['id'];
                        $leaveData[$counter]['student_id'] = $leave['student_id'];
                        $approvedBy = User::where('id','=',$leave['approved_by'])->select('first_name','last_name')->first();
                        $leaveData[$counter]['approved_by'] = $approvedBy['first_name']." ".$approvedBy['last_name'];
                        $leaveData[$counter]['approved_at'] = date("j M Y ",strtotime(date("Y-m-d ",strtotime($leave['updated_at']))));
                        $leaveData[$counter]['leave_type'] = LeaveType::where('id','=',$leave['leave_type'])->pluck('name');
                        $leaveData[$counter]['title'] = $leave['title'];
                        $leaveData[$counter]['reason'] = $leave['reason'];
                        $leaveData[$counter]['applied_on'] = date("j M Y",strtotime(date("Y-m-d ",strtotime($leave['created_at']))));
                        $leaveData[$counter]['form_date'] = date("j M Y",strtotime($leave['from_date']));
                        $leaveData[$counter]['end_date'] = date("j M Y",strtotime($leave['end_date']));
                        $leaveData[$counter]['name'] = $studentName['first_name']." ".$studentName['last_name'];
                        $leaveData[$counter]['batch'] = $studentBatch['name'];
                        $leaveData[$counter]['class'] = $studentClass['class_name'];
                        $leaveData[$counter]['division'] = $studentDivision['division_name'];
                        $counter++;
                    }
                } else {
                    $status = 404;
                    $message = "Sorry ! No leaves found for this instance";
                }
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $leaveData
        ];
        return response($response, $status);
    }

    /*
     * Function Name : getLeaveListTeacher
     * Param : Request $requests $leave_id
     * Return : Return the array of pending and approved leaves depending upon condition  and status .
     * Desc : if the leave id is 1 the it returns the pending leaves and if leave_id is 2 then
     *        it returns approved leave list to class teacher only.
     * Developed By : Amol Rokade
     *Date : 18/2/2016
      */
    public function getLeaveListTeacher(Requests\LeaveRequest $request , $flag)
    {
        try {
            $data = $request->all();
            $leaveData = array();
            $division = Division::where('class_teacher_id','=',$data['teacher']['id'])->first();
            if(!Empty($division)) {
                if ( $flag == 1 ) // 1 is for pending leaves
                {
                    $message = 'Successfully Listed';
                    $status = 200;
                    $leaves = LeaveRequest::where('division_id', $division['id'])
                        ->where('status', 1) //1 is for pending leaves and 2 for approved leaves.
                        ->orderBy('created_at', 'desc')
                        ->get()->toArray();
                } else if( $flag == 2 ) {
                    $message = 'Successfully Listed';
                    $status = 200;
                    $leaves = LeaveRequest::where('division_id', $division['id'])
                        ->where('status', '2') //1 is for pending leaves and 2 for approved leaves.
                        ->orderBy('updated_at', 'desc')
                        ->get()->toArray();
                }
                $counter = 0;
                if(!Empty($leaves)) {
                    foreach($leaves as $leave){
                        $studentDivision = Division::where('id',$leave['division_id'])->first();
                        $studentClass = Classes::where('id',$studentDivision['class_id'])->first();
                        $studentBatch = Batch::where('id',$studentClass['batch_id'])->first();
                        $studentName = User::where('id',$leave['student_id'])->first();
                        $leaveData[$counter]['roll_number'] = $studentName['roll_number'];
                        $leaveData[$counter]['leave_id'] = $leave['id'];
                        $leaveData[$counter]['student_id'] = $leave['student_id'];
                        $approvedBy = User::where('id','=',$leave['approved_by'])->select('first_name','last_name')->first();
                        $leaveData[$counter]['approved_by'] = $approvedBy['first_name']." ".$approvedBy['last_name'];
                        $leaveData[$counter]['approved_at'] =date("j M Y",strtotime(date("Y-m-d ",strtotime($leave['updated_at']))));
                        $leaveData[$counter]['leave_type'] = LeaveType::where('id','=',$leave['leave_type'])->pluck('name');
                        $leaveData[$counter]['title'] = $leave['title'];
                        $leaveData[$counter]['reason'] = $leave['reason'];
                        $leaveData[$counter]['applied_on'] = date("j M Y",strtotime(date("Y-m-d ",strtotime($leave['created_at']))));
                        $leaveData[$counter]['form_date'] = date("j M Y",strtotime($leave['from_date']));
                        $leaveData[$counter]['end_date'] = date("j M Y",strtotime($leave['end_date']));
                        $leaveData[$counter]['name'] = $studentName['first_name']." ".$studentName['last_name'];
                        $leaveData[$counter]['batch'] = $studentBatch['name'];
                        $leaveData[$counter]['class'] = $studentClass['class_name'];
                        $leaveData[$counter]['division'] = $studentDivision['division_name'];
                        $counter++;
                    }
                } else {
                    $status = 404;
                    $message = "Sorry ! No leaves found for this instance";
                }
            } else {
                $message = 'Sorry ! Only class teacher can access this functionality';
                $status = 406;
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "message" => $message,
            "status" => $status,
            "data" => $leaveData
        ];
        return response($response, $status);
    }

    /*
    * Function Name : approveLeave
    * Param : Request $requests
    * Return : message and status .
    * Desc : a class teacher can approve leaves of student.
    * Developed By : Amol Rokade
    * Date : 17 /2/2016
     */

    public function approveLeave(Requests\LeaveRequest $request){
        try{
            $data = $request->all();
            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            if(LeaveRequest::where('id', $data['leave_id'])->first()!=null) {
                $status = LeaveRequest::where('id', $data['leave_id'])->pluck('status');
                if ( $status == 1 ) {
                    LeaveRequest::where('id', $data['leave_id'])->update(['status' => 2,'approved_by' => $data['teacher']['id'],'updated_at'=>Carbon::now()]);
                    $message = 'Leave Approved Successfully';
                    $status = 200;
                    $title="Leave Approved";
                    $message="Please Check Leave !";
                    $allUser=0;
                    $students = LeaveRequest::where('id',$data['leave_id']) -> lists($student_id);
                    $parents = User::where('id',$students)->lists('parent_id');
                    $push_users = PushToken::whereIn('user_id',$parents)->lists('push_token');
                    $this -> CreatePushNotification($title,$message,$allUser,$push_users);
                } else {
                    $message = 'Operation Not allowed.';
                    $status = 406;
                }
            } else {
                $message = 'Leave Not Found';
                $status = 406;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message
        ];
        return response($response, $status);
    }

    /*
     * Function Name : createLeave
     * Param : Request $requests
     * Return : message and status .
     * Desc : parent can create a leave for studenta and by default it will be in pending status.
     * Developed By : Amol Rokade
     * Date : 17 /2/2016
      */

    public function createLeave(Requests\LeaveRequest $request){
        try{
            $data = $request->all();
            $data['teacher']['id'] = User::where('remember_token','=',$data['token'])->pluck('id');
            $currentDate = date('Y-m-d');
            $strToTimeCurrentDate = strtotime($currentDate);
            $fromDate = strtotime($data['from_date']);
            $endDate = strtotime($data['end_date']);
            if ( $fromDate > $endDate) {
                $status = 406;
                $message = 'Sorry ! end date should be greater than start date';
            } elseif ($strToTimeCurrentDate > $fromDate ) {
                $status = 406;
                $message = 'Sorry ! from date should be greater that current date';
            }  else {
                $status = 200;
                $message = 'Leave Applied Successfully.';
                $createData['student_id'] = $data['student_id'];
                $createData['division_id'] = User::where('id','=',$data['student_id'])->where('is_lc_generated')->pluck('division_id');
                $createData['status'] = 1;
                $createData['title'] = $data['title'];
                $createData['leave_type'] = $data['leave_type_id'];
                $createData['reason'] = $data['reason'];
                $createData['from_date'] = $data['from_date'];
                $createData['end_date'] = $data['end_date'];
                $createData['created_at'] = $currentDate ;
                $createData['updated_at'] = $currentDate ;
                LeaveRequest::insert($createData);
            }
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message
        ];
        return response($response, $status);
    }

    /*
   * Function Name : leaveTypes
   * Param : Request $requests
   * Return : message , status and JSON array of Leaves Types  .
   * Desc :  Parent will get leaves types to apply i.e. full day or half day
   * Developed By : Amol Rokade
   * Date : 22 /2/2016
    */

    public function leaveTypes(Request $request){
        try{
            $message = "Successfully Listed";
            $status = 200;
            $leaveTypes = array();
            $leaveTypes = LeaveType::select('id','name')->get()->toArray();
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $leaveTypes
        ];
        return response($response, $status);
    }
    public function getFees($id){
        try{
            $status = 200;
            $student_fee = StudentFee::where('student_id',$id)->select('fee_id','year','fee_concession_type','caste_concession')->distinct('fee_id')->get();
            $student_fee = ($student_fee->groupBy('fee_id')->toArray());
            $response = [
                'status' => 200,
                'message' => 'Successfully listed !',
                'data' => array()
            ];
            $iterator = 0;
            foreach($student_fee as $key => $studentData)
            {
                foreach ($studentData as $a){
                    $response['data'][$iterator] = Fees::where('id',$a['fee_id'])->select('id as fee_id','fee_name as fee_name','year')->first()->toArray();
                    $previousFeeStructures = StudentFee::where('student_id',$id)
                        ->where('fee_id','<',$a['fee_id'])
                        ->get();
                    $isPreviousStructureCleared = true;
                    foreach($previousFeeStructures as $previousFeeStructure){
                        if($isPreviousStructureCleared == true){
                            $installmentIds = FeeInstallments::where('fee_id', $previousFeeStructure['fee_id'])
                                ->distinct('installment_id')
                                ->lists('installment_id');
                            foreach ($installmentIds as $installmentId){
                                $isPaid = TransactionDetails::where('student_id',$previousFeeStructure['student_id'])
                                    ->where('fee_id',$previousFeeStructure['fee_id'])
                                    ->where('installment_id', $installmentId)
                                    ->first();
                                if($isPaid == null){
                                    $isPreviousStructureCleared = false;
                                    break;
                                }
                            }
                        }
                    }
                    $response['data'][$iterator]['show_payment'] = $isPreviousStructureCleared;
                    $response['data'][$iterator]['installments'] = array();
                    $installment_info = FeeInstallments::where('fee_id',$a['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
                    $installments = array();
                    if(!empty($installment_info)) {
                        foreach ($installment_info as $installment) {
                            if (!array_key_exists($installment['installment_id'], $installments)) {
                                $installments[$installment['installment_id']] = array();
                                $installments[$installment['installment_id']]['subTotal'] = 0;
                                $response['data'][$iterator]['installments'][$installment['installment_id']]['installment_id'] = $installment['installment_id'];
                                $response['data'][$iterator]['installments'][$installment['installment_id']]['due_date'] = FeeDueDate::where('fee_id', $a['fee_id'])
                                    ->where('installment_id', $installment['installment_id'])
                                    ->pluck('due_date');
                                $assignment_late_fee= StudentLateFee::where('student_id',$id)->first();
                                if($assignment_late_fee == null && $assignment_late_fee = " "){
                                    $response['data'][$iterator]['installments'][$installment['installment_id']]['late_fee'] = FeeDueDate::where('fee_id', $a['fee_id'])
                                        ->where('installment_id', $installment['installment_id'])
                                        ->pluck('late_fee_amount');
                                }else{
                                    $response['data'][$iterator]['installments'][$installment['installment_id']]['late_fee'] = StudentLateFee::where('fee_id', $a['fee_id'])
                                        ->where('installment_id', $installment['installment_id'])
                                        ->pluck('late_fee_amount');
                                }
                            }
                            $transactionCount = TransactionDetails::where('fee_id',$a['fee_id'])->where('student_id',$id)->where('installment_id',$installment['installment_id'])->count();
                            if($transactionCount > 0 && $isPreviousStructureCleared == true){
                                $response['data'][$iterator]['show_payment'] = false;
                            }else{
                                $response['data'][$iterator]['show_payment'] = true;
                            }
                            $installments[$installment['installment_id']]['subTotal'] += $installment['amount'];
                        }
                        $totalYearsFeeAmount = array_sum(array_column($installments, 'subTotal'));
                        foreach ($installments as $key_1 => $amount) {
                            $percentage[$key_1] = ($amount['subTotal'] / $totalYearsFeeAmount) * 100;
                        }
                        $concession_For_structure = array();
                        $fee_assign_student = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                            ->where('student_fee.student_id',$id)
                            ->select('student_fee.fee_concession_type','student_fee.fee_id as fee_id')
                            ->get();
                        $fee_assign_student = ($fee_assign_student->groupBy('fee_id')->toArray());
                        foreach ($fee_assign_student as $fees_name => $student_fees){
                            foreach($student_fees as $key=> $fees_concession){
                                if($fees_concession['fee_concession_type'] != 2){
                                    $concession_For_structure[$fees_name][$key] = FeeConcessionAmount::where('fee_id',$fees_concession['fee_id'])->where('concession_type',$fees_concession['fee_concession_type'])->pluck('amount');
                                }
                            }
                        }
                        $caste_concn_amnt = array();
                        $caste_concession_type = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                            ->where('student_fee.student_id',$id)
                            ->whereNotNull('student_fee.caste_concession')
                            ->select('fees.id','student_fee.caste_concession')
                            ->get();
                        $caste_concession_type = ($caste_concession_type->groupBy('id')->toArray());

                        if($caste_concession_type != "" && $caste_concession_type != null){
                            foreach ($caste_concession_type as $key => $casteConcession){
                                foreach ($casteConcession as $key_1=> $caste_amount){
                                    $caste_concn_amnt[$key][$key_1]= CASTECONCESSION::where('caste_id', $caste_amount['caste_concession'])->where('fee_id',$key)->pluck('concession_amount');
                                }
                            }
                        }
                        $amountArray = array(); // key is fee id
                        if(count($caste_concn_amnt) > count($concession_For_structure)){
                            foreach($caste_concn_amnt as $feeId => $casteConcnAmount){
                                if(!array_key_exists($feeId, $amountArray)){
                                    $amountArray[$feeId]['amount'] = 0;
                                }
                                $amountArray[$feeId]['amount'] += array_sum($casteConcnAmount);
                                if(array_key_exists($feeId,$concession_For_structure)){
                                    $amountArray[$feeId]['amount'] += array_sum($concession_For_structure[$feeId]);
                                }
                            }
                        }else{
                            foreach($concession_For_structure as $feeId => $concessionStructure){
                                if(!array_key_exists($feeId, $amountArray)){
                                    $amountArray[$feeId]['amount'] = 0;
                                }
                                $amountArray[$feeId]['amount'] += array_sum($concessionStructure);
                                if(array_key_exists($feeId,$caste_concn_amnt)){
                                    $amountArray[$feeId]['amount'] += array_sum($caste_concn_amnt[$feeId]);
                                }
                            }
                        }
                        foreach ($percentage as $key_id=> $final_percentage){
                            foreach ($amountArray as $fee => $val){
                                if($fee == $a['fee_id']){
                                        $final_amount[$key_id] = ($final_percentage/100)*$val['amount'];
                                }
                            }
                        }
                        if(count($installments) == count($final_amount))
                        {
                           foreach ($installments as $key_2 => $discounted){
                                $final_discounted_amount[$key_2] = $discounted['subTotal']-$final_amount[$key_2];
                               $response['data'][$iterator]['installments'][$key_2]['total'] = $final_discounted_amount[$key_2];
                           }
                        }
                    }
                }
                $response['data'][$iterator]['installments'] = array_values($response['data'][$iterator]['installments']);
                $iterator++;
            }
        } catch (\Exception $e) {
            $status = 500;
            $response = array();
            Log::critical(json_encode($e->getMessage()));
        }
        return response()->json($response,$status);
    }
    public function getStudentFeesDetails($id){
        try{
            $message = "Successfully Listed";
            $status = 200;
            $student_fee=StudentFee::where('student_id',$id)->select('fee_id','year','fee_concession_type','caste_concession')->get()->toarray();
            foreach($student_fee as $key => $a)
            {
                $installment_info = FeeInstallments::where('fee_id',$a['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
            }
            $installment_data = array();
            $fee_ids =StudentFee::where('student_id',$id)->select('fee_id')->distinct('fee_id')->get()->toArray();
            $total_installment_amount =array();
            foreach ($fee_ids as $key => $feeId){
                $installment_ids = fee_installments::join('fees','fees.id','=','fee_installments.fee_id')
                    ->where('fee_installments.fee_id',$feeId['fee_id'])
                    ->select('fee_installments.installment_id as installment_id','fees.id as fee_id')
                    ->distinct('fee_installments.installment_id')
                    ->orderBy('installment_id')
                    ->get()->toArray();
                $iterator=0;
                foreach ($installment_ids as $installmentId){
                    $assigned_late_fee = StudentLateFee::where('student_id',$id)->where('fee_id',$feeId['fee_id'])->where('installment_id',$installmentId['installment_id'])->first();
                    if($assigned_late_fee == null && $assigned_late_fee == ""){
                        $fee_due_date[$installmentId['fee_id']][$iterator] = FeeDueDate::join('fees','fees.id','=','fee_due_date.fee_id')
                            ->where('fees.id',$installmentId['fee_id'])
                            ->where('fee_due_date.fee_id',$installmentId['fee_id'])
                            ->where('fee_due_date.installment_id',$installmentId['installment_id'])
                            ->select('fee_due_date.fee_id','fee_due_date.installment_id as installment_id','fee_due_date.due_date as due_date','fees.fee_name as fee_name','fee_due_date.late_fee_amount','fee_due_date.number_of_days')
                            ->get();
                        $iterator++;
                    }else{
                        $fee_due_date[$installmentId['fee_id']][$iterator] = StudentLateFee::join('fees','fees.id','=','student_late_fee.fee_id')
                            ->join('fee_due_date','fee_due_date.fee_id','=','fees.id')
                            ->where('fees.id',$installmentId['fee_id'])
                            ->where('student_late_fee.student_id',$id)
                            ->where('student_late_fee.installment_id',$installmentId['installment_id'])
                            ->where('student_late_fee.fee_id',$installmentId['fee_id'])
                            ->where('fee_due_date.installment_id',$installmentId['installment_id'])
                            ->where('fee_due_date.fee_id',$installmentId['fee_id'])
                            ->select('fee_due_date.fee_id','fee_due_date.installment_id as installment_id','fee_due_date.due_date as due_date','fees.fee_name as fee_name','student_late_fee.late_fee_amount','fee_due_date.number_of_days')
                            ->get();
                        $iterator++;
                    }
                    $total_installment_amount[$installmentId['fee_id']][$installmentId['installment_id']] = fee_installments::where('fee_id',$feeId['fee_id'])->where('installment_id',$installmentId['installment_id'])->sum('amount');
                }
            }
            foreach ($total_installment_amount as $key=> $amount){
                $total_fee_amount[$key]['total'] = array_sum($amount);
            }
            $installment_percent_amount=array();
            foreach($total_installment_amount as $key => $installment_amounts)
            {
                foreach ($installment_amounts as $installmentId => $amount1){
                    $installment_amounts=($amount1/$total_fee_amount[$key]['total'])*100;
                    $installment_percent_amount[$key][$installmentId]=$installment_amounts;
                }
            }
            $concession_For_structure = array();
            $fee_assign_student = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                ->where('student_fee.student_id',$id)
                ->select('student_fee.fee_concession_type','student_fee.fee_id as fee_id')
                ->get();
            $fee_assign_student = ($fee_assign_student->groupBy('fee_id')->toArray());
            foreach ($fee_assign_student as $fees_name => $student_fees) {
                foreach ($student_fees as $key => $fees_concession) {
                    if ($fees_concession['fee_concession_type'] != 2) {
                        $concession_For_structure[$fees_name][$key] = FeeConcessionAmount::where('fee_id', $fees_concession['fee_id'])->where('concession_type', $fees_concession['fee_concession_type'])->pluck('amount');
                    }
                }
            }
            $caste_concn_amnt = array();
            $caste_concession_type = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                ->where('student_fee.student_id',$id)
                ->whereNotNull('student_fee.caste_concession')
                ->select('fees.id','student_fee.caste_concession')
                ->get();
            $caste_concession_type = ($caste_concession_type->groupBy('id')->toArray());

            if($caste_concession_type != "" && $caste_concession_type != null){
                foreach ($caste_concession_type as $key => $casteConcession){
                    foreach ($casteConcession as $key_1=> $caste_amount){
                        $caste_concn_amnt[$key][$key_1]= CASTECONCESSION::where('caste_id', $caste_amount['caste_concession'])->where('fee_id',$key)->pluck('concession_amount');
                    }
                }
            }
            $amountArray = array(); // key is fee id
            if(count($caste_concn_amnt) > count($concession_For_structure)){
                foreach($caste_concn_amnt as $feeId => $casteConcnAmount){
                    if(!array_key_exists($feeId, $amountArray)){
                        $amountArray[$feeId]['amount'] = 0;
                    }
                    $amountArray[$feeId]['amount'] += array_sum($casteConcnAmount);
                    if(array_key_exists($feeId,$concession_For_structure)){
                        $amountArray[$feeId]['amount'] += array_sum($concession_For_structure[$feeId]);
                    }
                }
            }else{
                foreach($concession_For_structure as $feeId => $concessionStructure){
                    if(!array_key_exists($feeId, $amountArray)){
                        $amountArray[$feeId]['amount'] = 0;
                    }
                    $amountArray[$feeId]['amount'] += array_sum($concessionStructure);
                    if(array_key_exists($feeId,$caste_concn_amnt)){
                        $amountArray[$feeId]['amount'] += array_sum($caste_concn_amnt[$feeId]);
                    }
                }
            }
            $concession_amount_array = array();
            foreach($installment_percent_amount as $key => $percent_discout_collection){
                foreach ($percent_discout_collection as $key2=> $discount){
                    $discounted_amount_for_installment = (($discount / 100) * ($amountArray[$key]['amount']));
                    $concession_amount_array[$key][$key2] = $discounted_amount_for_installment;
                }
            }
            $final_discounted_amounts = array();
            if(count($concession_amount_array) == count($total_installment_amount))
            {
                foreach($concession_amount_array as $key => $value){
                    foreach ($value as $key3 => $discount_amount){
                        $final_discounted_amounts[$key][$key3] = $total_installment_amount[$key][$key3] - $discount_amount;
                    }
                }
            }
            if(!empty($fee_due_date) && !empty($final_discounted_amounts)){
                foreach($fee_due_date as $key => $fee_id){
                    for($iterator = 0; $iterator < count($fee_id) ; $iterator++){
                        $fee_due_date[$key][$iterator][0]['discount'] = $final_discounted_amounts[$key][$fee_id[$iterator][0]['installment_id']];
                    }
                }
            }
            if(!empty($installment_info))
            {
                $iterator = 0;
                foreach($installment_info as $i)
                {
                    $installment_info[$iterator]['particulars_name'] = fee_particulars::where('id',$i['particulars_id'])->pluck('particular_name');
                    $iterator++;
                }
                $installment_data[] = $installment_info;
            }
            $transaction=TransactionDetails::join('fees','fees.id','=','transaction_details.fee_id')
                ->where('transaction_details.student_id',$id)
                ->select('fees.fee_name as fee_name','transaction_details.id as id','transaction_details.transaction_type as transaction_type','transaction_details.transaction_detail as transaction_detail','transaction_details.transaction_amount as transaction_amount','transaction_details.date as date')
                ->get()->groupBy('fee_name')->toarray();
            $new_array=array();
            $total_paid_fees=array();
            foreach ($transaction as $feeName => $trans){
                $total_paid_fees[$feeName] = TransactionDetails::join('fees','fees.id','=','transaction_details.fee_id')
                    ->where('transaction_details.student_id',$id)
                    ->where('fees.fee_name',$feeName)
                    ->select('transaction_details.transaction_amount','transaction_details.installment_id')
                    ->get()->groupBy('installment_id')->toarray();
            }
            foreach ($total_paid_fees as $key => $paid_fees){
                foreach ($paid_fees as $installmentIds=>$data){
                    $new_array[$key][$installmentIds] = array_sum(array_column($data,'transaction_amount'));
                }
            }
            $date=date('Y-m-d');
            $currentDate= date_create($date);
            $total_fee_for_current_year = array();
            foreach($fee_due_date as $fee_name => $val){
                foreach($val as $key=> $data){
                    $data = $data->groupBy('installment_id')->toArray();
                    foreach ($data as $key3=>$new){
                        $total_fee_for_current_year[$new[0]['fee_name']][$new[0]['installment_id']]['discount'] = 0;
                        foreach($new as $discount){
                            $storedDate = date_create($discount['due_date']);
                            if($currentDate > $storedDate){
                                $difference = date_diff( $storedDate,$currentDate);
                                $dateDifference = $difference->format("%a");
                                $calculate = floor($dateDifference/($discount['number_of_days'] + 1)) * $discount['late_fee_amount'];
                                $total_fee_for_current_year[$new[0]['fee_name']][$new[0]['installment_id']]['discount'] += ( $discount['discount']+ $calculate );
                            }else{
                                $total_fee_for_current_year[$new[0]['fee_name']][$new[0]['installment_id']]['discount'] += $discount['discount'];
                            }
                        }
                    }
                }
            }
            $total_due_fee_for_current_year = array();
            foreach ($total_fee_for_current_year as $key=> $total_fee){
                foreach ($total_fee as $instalId => $data){
                    if(array_key_exists($key,$new_array) && array_key_exists($instalId, $new_array[$key])){
                        $total_due_fee_for_current_year[$key][$instalId] = $data['discount'] - $new_array[$key][$instalId];
                    }else{
                        $total_due_fee_for_current_year[$key][$instalId] = $data['discount'] - 0;
                    }
                }
            }
            $student_new_pending_fees = array();
            foreach($fee_due_date as $key1 => $val){
                foreach ($val as $key4 => $new){
                    $new = $new->groupBy('installment_id')->toArray();
                    foreach($new as $insall_id=> $data){
                        if($total_due_fee_for_current_year[$data[0]['fee_name']][$data[0]['installment_id']] > 0){
                            $student_new_pending_fees[$data[0]['fee_name']][$data[0]['installment_id']] = $total_due_fee_for_current_year[$data[0]['fee_name']][$data[0]['installment_id']];
                        }else{
                            $student_new_pending_fees[$data[0]['fee_name']][$data[0]['installment_id']] = 0;
                        }
                    }
                }
            }
            $total_fees_for_current_year = array();
            foreach ($fee_due_date as $key => $due_date){
                $total_fees_for_current_year[$due_date[0][0]['fee_name']]['discount'] = 0;
                foreach ($due_date as $item => $value){
                    foreach ($value as $key3=>$val){
                        $total_fees_for_current_year[$due_date[0][0]['fee_name']]['discount'] +=  $val['discount'];
                    }
                }
            }
            foreach ($student_new_pending_fees as $key => $data){
                $total_fees_for_current_year[$key]['pending'] =array_sum(array_values($data));
            }
            $transactions = TransactionDetails::join('fees','fees.id','=','transaction_details.fee_id')
                            ->where('transaction_details.student_id',$id)
                            ->select('fees.fee_name as structure_name','transaction_details.id as id','transaction_details.transaction_type as transaction_type','transaction_details.transaction_detail as transaction_detail','transaction_details.transaction_amount as transaction_amount','transaction_details.date as date' )
                            ->get();
            $responseData=array();
            $iterator=0;
            $responseData['transaction'] = $transactions->toArray();
            foreach ($total_fees_for_current_year as $key => $total_fee){
                    $responseData['structures'][$iterator]['structure_name'] = $key;
                    $responseData['structures'][$iterator]['discount'] = $total_fee['discount'];
                    $responseData['structures'][$iterator]['pending_fee'] = $total_fee['pending'];
                    $iterator++;
            }
        } catch (\Exception $e){
            $status = 500;
            $message = $e->getMessage();
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $responseData
        ];
        Log::critical(json_encode($response));
        return response()->json($response,$status);
    }

    public function getFeesStudent ($id){
        $concessions=StudentFeeConcessions::where('student_id',$id)->select('fee_id')->first();
        if(!empty($concessions)){
            $fee_id=$concessions->fee_id;
            $concession_list=json_decode($concessions->fee_concession_type);
        }
        $division=User::where('id',$id)->pluck('division_id');
        $class=Division::where('id',$division)->pluck('class_id');
        $assigned_fee_for_class=FeeClass::where('class_id',$class)->pluck('fee_id');
        $feedata=StudentFee::where('student_id',$id)->pluck('fee_id');
        $fees=Fees::where('id',$assigned_fee_for_class)->select('id','fee_name','year')->get();
        $student_fee=StudentFee::where('student_id',$id)->select('fee_id','year','fee_concession_type','caste_concession')->get()->toarray();
        foreach($student_fee as $key => $a)
        {
            $installment_info=FeeInstallments::where('fee_id',$a['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
        }
        $installment_data = array();
        foreach($student_fee as $key => $a)
        {
            $fee_deta=Fees::where('id',$a['fee_id'])->select('total_amount','year','fee_name')->get();
            $concessionType_data=ConcessionTypes::where('id',$a['fee_concession_type'])->get()->toArray();
        }
        $fee_id=StudentFee::where('student_id',$id)->pluck('fee_id');
        $fee_due_date=FeeDueDate::where('fee_id',$fee_id)->select('installment_id','due_date')->get()->toArray();
        $installment_amount=fee_installments::where('fee_id',$fee_id)->select('installment_id','amount')->get()->toArray();
        $total_installment_amount = array();
        foreach($installment_amount as  $amount )
        {
            if(array_key_exists($amount['installment_id'],$total_installment_amount))
            {
                $total_installment_amount[$amount['installment_id']] += $amount['amount'];
            }
            else
            {
                $total_installment_amount[$amount['installment_id']] = $amount['amount'];
            }
        }
        $total_fee_amount=array_sum ($total_installment_amount );
        $installment_percent_amount=array();
        foreach($total_installment_amount as $key => $installment_amounts)
        {
            $installment_amounts=($installment_amounts/$total_fee_amount)*100;
            $installment_percent_amount[$key]=$installment_amounts;
        }
        $caste_concession_type=StudentFee::where('student_id',$id)->pluck('caste_concession');
        $caste_concn_amnt= CASTECONCESSION::where('caste_id', $caste_concession_type)->where('fee_id',$feedata)->pluck('concession_amount');
        $collection=collect($installment_percent_amount);
        $concession_amount_array=array();
        foreach($collection as $key => $percent_discout_collection)
        {
            $discounted_amount_for_installment=($percent_discout_collection/100)*$caste_concn_amnt;
            $concession_amount_array[$key] = $discounted_amount_for_installment;
        }
        $final_discounted_amounts = array();
        if(count($concession_amount_array) == count($total_installment_amount))
        {
            foreach($concession_amount_array as $key => $value)
            {
                $final_discounted_amounts[$key] = $total_installment_amount[$key] - $value;
            }
        }
        if(!empty($fee_due_date) && !empty($final_discounted_amounts))
        {
            for($i=1;$i<=count($final_discounted_amounts);$i++)
            {
                for($j=0;$j<count($fee_due_date);$j++)
                {
                    if($fee_due_date[$j]['installment_id'] == $i)
                    {
                        $fee_due_date[$j]['discount']=$final_discounted_amounts[$i];
                    }
                }
            }
        }
        $fee_pert=fee_particulars::select('particular_name')->get()->toArray();
        if(!empty($installment_info))
        {
            $iterator = 0;
            foreach($installment_info as $i)
            {
                $installment_info[$iterator]['particulars_name'] = fee_particulars::where('id',$i['particulars_id'])->pluck('particular_name');
                $iterator++;
            }
            $installment_data[] = $installment_info;
        }
        $concession_types=ConcessionTypes::select('id','name')->get()->toarray();
        $transaction_types=TransactionTypes::select('id','transaction_type')->get()->toArray();
        $transactions=TransactionDetails::where('student_id',$id)->get();
        $new_array=array();
        $total_paid_fees=TransactionDetails::where('student_id',$id)->select('transaction_amount')->get()->toarray();
        foreach($total_paid_fees as $key => $total_paid_fee )
        {
            foreach($total_paid_fee as $fee)
            {
                array_push($new_array,$fee);
            }
        }
        $division_for_updation=User::where('id',$id)->pluck('division_id');
        if($division_for_updation != null)
        {
            $division_status="";
        }
        else
        {
            $division_status="Division Not Assigned !";
        }
        $query1=StudentFee::where('student_id',$id)->pluck('caste_concession');
        $g=StudentFeeConcessions::where('fee_id',$feedata)->where('student_id',$id)->select('fee_concession_type')->first();
        if(!empty($g)){
            $assigned_fee_concessions=json_decode($g->fee_concession_type);
        }
        if(!empty($assigned_fee_concessions))
        {
            $concn_amnts=FeeConcessionAmount::where('fee_id',$feedata)->whereIn('concession_type',$assigned_fee_concessions)->select('amount')->get()->toArray();
            for($i=0;$i<count($concn_amnts);$i++)
            {
                for($j=0;$j<count($fee_due_date);$j++)
                {
                    $fee_due_date[$j]['discount']=  $fee_due_date[$j]['discount']-(($concn_amnts[$i]['amount'])/count($fee_due_date));
                }
            }
        }
        $total_fee_for_current_year=0;
        foreach($fee_due_date as $key => $val)
        {
            $total_fee_for_current_year=$total_fee_for_current_year+$val['discount'];
        }
        $assigned_fee=StudentFee::where('student_id',$id)->pluck('fee_id');
        $caste_concession_type_edit=StudentFee::where('student_id',$id)->pluck('fee_concession_type');
        $final_paid_fee_for_current_year=array_sum($new_array);
        $total_due_fee_for_current_year=$total_fee_for_current_year-$final_paid_fee_for_current_year;
        $queryn=category_types::select('caste_category','id')->get()->toArray();
        $querym=StudentFee::where('student_id',$id)->pluck('caste_concession');
        $chkstatus=StudentFeeConcessions::where('student_id',$id)->select('fee_concession_type')->first();
        return response ($fee_due_date);
    }
    public function getFeesDetails($id){
        $concessions=StudentFeeConcessions::where('student_id',$id)->select('fee_id')->first();
        if(!empty($concessions)){
            $fee_id=$concessions->fee_id;
            $concession_list=json_decode($concessions->fee_concession_type);
        }
        $division=User::where('id',$id)->pluck('division_id');
        $class=Division::where('id',$division)->pluck('class_id');
        $assigned_fee_for_class=FeeClass::where('class_id',$class)->pluck('fee_id');
        $feedata=StudentFee::where('student_id',$id)->pluck('fee_id');
        $fees=Fees::where('id',$assigned_fee_for_class)->select('id','fee_name','year')->get();
        $student_fee=StudentFee::where('student_id',$id)->select('fee_id','year','fee_concession_type','caste_concession')->get()->toarray();
        foreach($student_fee as $key => $a)
        {
            $installment_info=FeeInstallments::where('fee_id',$a['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
        }
        $installment_data = array();
        foreach($student_fee as $key => $a)
        {
            $fee_deta=Fees::where('id',$a['fee_id'])->select('total_amount','year','fee_name')->get();
            $concessionType_data=ConcessionTypes::where('id',$a['fee_concession_type'])->get()->toArray();
        }
        $fee_id=StudentFee::where('student_id',$id)->pluck('fee_id');
        $fee_due_date=FeeDueDate::where('fee_id',$fee_id)->select('installment_id','due_date')->get()->toArray();
        $installment_amount=fee_installments::where('fee_id',$fee_id)->select('installment_id','amount')->get()->toArray();
        $total_installment_amount = array();
        foreach($installment_amount as  $amount )
        {
            if(array_key_exists($amount['installment_id'],$total_installment_amount))
            {
                $total_installment_amount[$amount['installment_id']] += $amount['amount'];
            }
            else
            {
                $total_installment_amount[$amount['installment_id']] = $amount['amount'];
            }
        }
        $total_fee_amount=array_sum ($total_installment_amount );
        $installment_percent_amount=array();
        foreach($total_installment_amount as $key => $installment_amounts)
        {
            $installment_amounts=($installment_amounts/$total_fee_amount)*100;
            $installment_percent_amount[$key]=$installment_amounts;
        }
        $caste_concession_type=StudentFee::where('student_id',$id)->pluck('caste_concession');
        $caste_concn_amnt= CASTECONCESSION::where('caste_id', $caste_concession_type)->where('fee_id',$feedata)->pluck('concession_amount');
        $collection=collect($installment_percent_amount);
        $concession_amount_array=array();
        foreach($collection as $key => $percent_discout_collection)
        {
            $discounted_amount_for_installment=($percent_discout_collection/100)*$caste_concn_amnt;
            $concession_amount_array[$key] = $discounted_amount_for_installment;
        }
        $final_discounted_amounts = array();
        if(count($concession_amount_array) == count($total_installment_amount))
        {
            foreach($concession_amount_array as $key => $value)
            {
                $final_discounted_amounts[$key] = $total_installment_amount[$key] - $value;
            }
        }
        if(!empty($fee_due_date) && !empty($final_discounted_amounts))
        {
            for($i=1;$i<=count($final_discounted_amounts);$i++)
            {
                for($j=0;$j<count($fee_due_date);$j++)
                {
                    if($fee_due_date[$j]['installment_id'] == $i)
                    {
                        $fee_due_date[$j]['discount']=$final_discounted_amounts[$i];
                    }
                }
            }
        }
        $fee_pert=fee_particulars::select('particular_name')->get()->toArray();
        if(!empty($installment_info))
        {
            $iterator = 0;
            foreach($installment_info as $i)
            {
                $installment_info[$iterator]['particulars_name'] = fee_particulars::where('id',$i['particulars_id'])->pluck('particular_name');
                $iterator++;
            }
            $installment_data[] = $installment_info;
        }
        $concession_types=ConcessionTypes::select('id','name')->get()->toarray();
        $transaction_types=TransactionTypes::select('id','transaction_type')->get()->toArray();
        $transactions=TransactionDetails::where('student_id',$id)->get();
        $new_array=array();
        $total_paid_fees=TransactionDetails::where('student_id',$id)->select('transaction_amount')->get()->toarray();
        foreach($total_paid_fees as $key => $total_paid_fee )
        {
            foreach($total_paid_fee as $fee)
            {
                array_push($new_array,$fee);
            }
        }
        $division_for_updation=User::where('id',$id)->pluck('division_id');
        if($division_for_updation != null)
        {
            $division_status="";
        }
        else
        {
            $division_status="Division Not Assigned !";
        }
        $query1=StudentFee::where('student_id',$id)->pluck('caste_concession');
        $g=StudentFeeConcessions::where('fee_id',$feedata)->where('student_id',$id)->select('fee_concession_type')->first();
        if(!empty($g)){
            $assigned_fee_concessions=json_decode($g->fee_concession_type);
        }
        if(!empty($assigned_fee_concessions))
        {
            $concn_amnts=FeeConcessionAmount::where('fee_id',$feedata)->whereIn('concession_type',$assigned_fee_concessions)->select('amount')->get()->toArray();
            for($i=0;$i<count($concn_amnts);$i++)
            {
                for($j=0;$j<count($fee_due_date);$j++)
                {
                    $fee_due_date[$j]['discount']=  $fee_due_date[$j]['discount']-(($concn_amnts[$i]['amount'])/count($fee_due_date));
                }
            }
        }
        $total_fee_for_current_year=0;
        foreach($fee_due_date as $key => $val)
        {
            $total_fee_for_current_year=$total_fee_for_current_year+$val['discount'];
        }
        $assigned_fee=StudentFee::where('student_id',$id)->pluck('fee_id');
        $caste_concession_type_edit=StudentFee::where('student_id',$id)->pluck('fee_concession_type');
        $final_paid_fee_for_current_year=array_sum($new_array);
        $total_due_fee_for_current_year=$total_fee_for_current_year-$final_paid_fee_for_current_year;
        $queryn=category_types::select('caste_category','id')->get()->toArray();
        $querym=StudentFee::where('student_id',$id)->pluck('caste_concession');
        $chkstatus=StudentFeeConcessions::where('student_id',$id)->select('fee_concession_type')->first();
        $student_pending_fee=array();
        $student_pending_fee['pending_fee']=$total_due_fee_for_current_year;
        $total_student_fee_for_current_year=array();
        $total_student_fee_for_current_year['fee']=$total_fee_for_current_year;
        $responseData['transactions'] = $transactions->toArray();
        $responseData['pending_fees']=$student_pending_fee;
        $responseData['fees']=$total_student_fee_for_current_year;
        return response ($responseData);
    }
}
