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
                $createData['division_id'] = User::where('id','=',$data['student_id'])->pluck('division_id');
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
    public function getFeesStudent ($id){
        try{
            $message = "Successfully Listed";
            $status = 200;
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
                $installment_info = FeeInstallments::where('fee_id',$a['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
            }
            $installment_data = array();
            foreach($student_fee as $key => $a)
            {
                $fee_deta=Fees::where('id',$a['fee_id'])->select('total_amount','year','fee_name')->get();
                $concessionType_data=ConcessionTypes::where('id',$a['fee_concession_type'])->get()->toArray();
            }
            $fee_ids =StudentFee::where('student_id',$id)->select('fee_id')->distinct('fee_id')->get()->toArray();
            $fee_due_date = FeeDueDate::join('fees','fees.id','=','fee_due_date.fee_id')
                ->whereIn('fee_due_date.fee_id',$fee_ids)
                ->select('fee_due_date.fee_id','fee_due_date.installment_id as installment_id','fee_due_date.due_date as due_date','fees.fee_name as fee_name')
                ->get();
            $fee_due_date=($fee_due_date->groupBy('fee_id')->toArray());
            $total_installment_amount =array();
            foreach ($fee_ids as $key => $feeId){
                $installment_ids = fee_installments::join('fees','fees.id','=','fee_installments.fee_id')
                    ->where('fee_installments.fee_id',$feeId['fee_id'])
                    ->select('fee_installments.installment_id as installment_id','fees.id as fee_id')
                    ->distinct('fee_installments.installment_id')
                    ->get()->toArray();
                foreach ($installment_ids as $installmentId){
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
            $caste_concn_amnt = array();
            $fee_assign_student = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                ->where('student_fee.student_id',$id)
                ->select('student_fee.fee_concession_type','student_fee.fee_id as fee_id')
                ->whereNotNull('student_fee.fee_concession_type')->get();
            $fee_assign_student = ($fee_assign_student->groupBy('fee_id')->toArray());
            foreach ($fee_assign_student as $fees_name => $student_fees){
                foreach($student_fees as $fees_concession){
                    $concession_For_structure[$fees_name] = FeeConcessionAmount::where('fee_id',$fees_concession['fee_id'])->where('concession_type',$fees_concession['fee_concession_type'])->select('amount as concession_amount')->first();
                }
            }
            $caste_concession_type = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                ->where('student_fee.student_id',$id)
                ->select('fees.id','student_fee.caste_concession')
                ->whereNotNull('student_fee.caste_concession')->get();
            $caste_concession_type = ($caste_concession_type->groupBy('id')->toArray());
            foreach ($caste_concession_type as $key => $casteConcession){
                foreach ($casteConcession as $caste_amount){
                    $caste_concn_amnt[$key]= CASTECONCESSION::where('caste_id', $caste_amount['caste_concession'])->where('fee_id',$key)->select('concession_amount')->first();
                }
            }
            $concession_amount = array_replace($concession_For_structure,$caste_concn_amnt);
            ksort($concession_amount);
            $concession_amount_array = array();
            foreach($installment_percent_amount as $key => $percent_discout_collection){
                foreach ($percent_discout_collection as $key2=> $discount){
                    $discounted_amount_for_installment = ($discount / 100) * ($concession_amount[$key]['concession_amount']);
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
                        $fee_due_date[$key][$iterator]['discount'] = $final_discounted_amounts[$key][$fee_id[$iterator]['installment_id']];
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
            $total_fee_for_current_year = array();
            foreach($fee_due_date as $fee_name => $val){
                $total_fee_for_current_year[$val[0]['fee_name']]['discount'] = 0;
                foreach($val as $discount){
                    $total_fee_for_current_year[$val[0]['fee_name']]['discount'] += $discount['discount'];
                }
            }

            $total_due_fee_for_current_year = 0;

            $assigned_fee = StudentFee::where('student_id',$id)->lists('fee_id');
            $caste_concession_type_edit = StudentFee::where('student_id',$id)->lists('fee_concession_type');
            $final_paid_fee_for_current_year=array_sum($new_array);
            foreach ($total_fee_for_current_year as $total_fee){
                $total_due_fee_for_current_year = $total_fee['discount'] - $final_paid_fee_for_current_year;
            }
            $assigned_fee=StudentFee::where('student_id',$id)->pluck('fee_id');
            $caste_concession_type_edit=StudentFee::where('student_id',$id)->pluck('fee_concession_type');
            $final_paid_fee_for_current_year=array_sum($new_array);
            foreach ($total_fee_for_current_year as $total_fee){
                $total_due_fee_for_current_year = $total_fee['discount'] - $final_paid_fee_for_current_year;
            }
            $queryn=category_types::select('caste_category','id')->get()->toArray();
            $querym=StudentFee::where('student_id',$id)->pluck('caste_concession');
            $chkstatus=StudentFeeConcessions::where('student_id',$id)->select('fee_concession_type')->first();
        } catch (\Exception $e) {
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $fee_due_date
        ];
        return response ($response,$status);
    }
    public function getFeesDetails($id){
        try{
            $message = "Successfully Listed";
            $status = 200;
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
                $installment_info = FeeInstallments::where('fee_id',$a['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
            }
            $installment_data = array();
            foreach($student_fee as $key => $a)
            {
                $fee_deta=Fees::where('id',$a['fee_id'])->select('total_amount','year','fee_name')->get();
                $concessionType_data=ConcessionTypes::where('id',$a['fee_concession_type'])->get()->toArray();
            }
            $fee_ids =StudentFee::where('student_id',$id)->select('fee_id')->distinct('fee_id')->get()->toArray();
            $fee_due_date = FeeDueDate::join('fees','fees.id','=','fee_due_date.fee_id')
                ->whereIn('fee_due_date.fee_id',$fee_ids)
                ->select('fee_due_date.fee_id','fee_due_date.installment_id as installment_id','fee_due_date.due_date as due_date','fees.fee_name as fee_name')
                ->get();
            $fee_due_date=($fee_due_date->groupBy('fee_id')->toArray());
            $total_installment_amount =array();
            foreach ($fee_ids as $key => $feeId){
                $installment_ids = fee_installments::join('fees','fees.id','=','fee_installments.fee_id')
                    ->where('fee_installments.fee_id',$feeId['fee_id'])
                    ->select('fee_installments.installment_id as installment_id','fees.id as fee_id')
                    ->distinct('fee_installments.installment_id')
                    ->get()->toArray();
                foreach ($installment_ids as $installmentId){
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
            $caste_concn_amnt = array();
            $fee_assign_student = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                ->where('student_fee.student_id',$id)
                ->select('student_fee.fee_concession_type','student_fee.fee_id as fee_id')
                ->whereNotNull('student_fee.fee_concession_type')->get();
            $fee_assign_student = ($fee_assign_student->groupBy('fee_id')->toArray());
            foreach ($fee_assign_student as $fees_name => $student_fees){
                foreach($student_fees as $fees_concession){
                    $concession_For_structure[$fees_name] = FeeConcessionAmount::where('fee_id',$fees_concession['fee_id'])->where('concession_type',$fees_concession['fee_concession_type'])->select('amount as concession_amount')->first();
                }
            }
            $caste_concession_type = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                ->where('student_fee.student_id',$id)
                ->select('fees.id','student_fee.caste_concession')
                ->whereNotNull('student_fee.caste_concession')->get();
            $caste_concession_type = ($caste_concession_type->groupBy('id')->toArray());
            foreach ($caste_concession_type as $key => $casteConcession){
                foreach ($casteConcession as $caste_amount){
                    $caste_concn_amnt[$key]= CASTECONCESSION::where('caste_id', $caste_amount['caste_concession'])->where('fee_id',$key)->select('concession_amount')->first();
                }
            }
            $concession_amount = array_replace($concession_For_structure,$caste_concn_amnt);
            ksort($concession_amount);
            $concession_amount_array = array();
            foreach($installment_percent_amount as $key => $percent_discout_collection){
                foreach ($percent_discout_collection as $key2=> $discount){
                    $discounted_amount_for_installment = ($discount / 100) * ($concession_amount[$key]['concession_amount']);
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
                        $fee_due_date[$key][$iterator]['discount'] = $final_discounted_amounts[$key][$fee_id[$iterator]['installment_id']];
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
            $total_fee_for_current_year = array();
            foreach($fee_due_date as $fee_name => $val){
                $total_fee_for_current_year[$val[0]['fee_name']]['discount'] = 0;
                foreach($val as $discount){
                    $total_fee_for_current_year[$val[0]['fee_name']]['discount'] += $discount['discount'];
                }
            }
            $total_due_fee_for_current_year = 0;

            $assigned_fee = StudentFee::where('student_id',$id)->lists('fee_id');
            $caste_concession_type_edit = StudentFee::where('student_id',$id)->lists('fee_concession_type');
            $final_paid_fee_for_current_year=array_sum($new_array);
            foreach ($total_fee_for_current_year as $total_fee){
                $total_due_fee_for_current_year = $total_fee['discount'] - $final_paid_fee_for_current_year;
            }
            $assigned_fee=StudentFee::where('student_id',$id)->pluck('fee_id');
            $caste_concession_type_edit=StudentFee::where('student_id',$id)->pluck('fee_concession_type');
            $final_paid_fee_for_current_year=array_sum($new_array);
            foreach ($total_fee_for_current_year as $total_fee){
                $total_due_fee_for_current_year = $total_fee['discount'] - $final_paid_fee_for_current_year;
            }
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
        } catch (\Exception $e){
            $status = 500;
            $message = "something went wrong";
        }
        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $responseData
        ];
return response ($response,$status);
    }

}
