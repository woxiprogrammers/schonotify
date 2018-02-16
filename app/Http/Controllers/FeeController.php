<?php
namespace App\Http\Controllers;
use App\Body;
use App\CASTECONCESSION;
use App\category_types;
use App\Classes;
use App\ConcessionTypes;
use App\Division;
use App\fee_installments;
use App\fee_particulars;
use App\FeeAdmission;
use App\FeeClass;
use App\FeeConcessionAmount;
use App\FeeConcessionTypes;
use App\FeeDevelopment;
use App\FeeDueDate;
use App\FeeInstallments;
use App\Fees;
use App\FormFee;
use App\StudentFee;
use App\StudentFeeConcessions;
use App\TransactionDetails;
use App\User;
use App\PushToken;
use Carbon\Carbon;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use App\Installments;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Batch;
use Elibyy\TCPDF\Facades\TCPDF;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;

class FeeController extends Controller
{
    use PushNotificationTrait;
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth',['except'=>['billiingPageView','getStudentDetails','getFeeStructureInstallments']]);
    }
    public function createFeeStructureView(){
        try{
            $classes=Classes::join('batches','classes.batch_id','=','batches.id')
                ->select('classes.id as id','classes.class_name as class','batches.name as batch')
                ->where('classes.body_id','=',Auth::User()->body_id)
                ->get();
            $batches=array();
            $classArray=array();
            $i=0;
            foreach($classes->toArray() as $row)
            {
                $classArray[$i]=$row['batch'];
                $i++;
            }
            $batches = array_unique($classArray);
            $concession_types = ConcessionTypes::select('id as concession.id','name as concession.name')->get();
            $caste_types = category_types::select('id as caste_id','caste_category')->get();
            $installment_number =Installments::select('id as installment_id','installment_number')->get();
            return view('fee.create')->with(compact('classes','batches','concession_types','caste_types','installment_number'));
        }catch(\Exception $e){
            $data = [
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }
    }
    public function concessionTypes()
    {
        $batchData =ConcessionTypes::select('id','name')->get();
        $batchList = $batchData->toArray();
        return $batchList;
    }
    public function particulars(Request $request)
    {
        $total_no_of_installments=$request->str1;
        $installment_details=Installments::select('id','installment_number')->take($total_no_of_installments)->get();
        $fee_particulars=fee_particulars::select('id','particular_name')->get();
        $fee_installment_amount=fee_installments::select('id','amount')->take($total_no_of_installments)->get();
        return view('fee.installments')->with(compact('installment_details','fee_particulars','fee_installment_amount'));
    }
    public function installmentCount(Request $request)
        {
          return view('fee.installments');
        }

    public function billiingPageView(Request $request,$slug=null){
        try{
            if($slug == null || $slug == 'gis'){
                $slug = 'gis';
                $bodies = Body::where('id',1)->get()->toArray();   // Only for Ganesh International School
                $schoolTitle = 'Ganesh International School , Chikhali';
            }elseif($slug == 'gems'){
                $bodies = Body::where('id',2)->get()->toArray();   // Only for Ganesh English Medium School
                $schoolTitle = 'Ganesh English Medium School';
            }else{
                return redirect()->back();
            }
            return view('fee.FeeBillingPage')->with(compact('bodies','schoolTitle','slug'));
        }catch (\Exception $e){
            $data = [
                'action' => 'Get billing page View',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }

    public function create(Request $request)
    {
        $fee_details['fee_name']=$request->fee_name;
        $fee_details['total_amount']=$request->total_fee;
        $fee_details['year']=$request->myselect;
        $query=Fees::insertGetId($fee_details);
        if($query)
        {
           if($request->rte)
           {
               $rteDetails['fee_id']=$query;
               $rteDetails['concession_type']=1;
               $rteDetails['amount']=$request->rte;
               $rte=FeeConcessionAmount::insert($rteDetails);
           }
           if($request->special)
           {
               $specialDetails['fee_id']=$query;
               $specialDetails['concession_type']=3;
               $specialDetails['amount']=$request->special;
               $special=FeeConcessionAmount::insert($specialDetails);
           }
            if($request->sport)
            {
                $sportDetails['fee_id']=$query;
                $sportDetails['concession_type']=4;
                $sportDetails['amount']=$request->sport;
                $sport=FeeConcessionAmount::insert($sportDetails);
            }
          foreach($request->class as $class)
            {
                $class_details['fee_id']=$query;
                $class_details['class_id']=$class;
                $class_details['amount']=$request->total_fee;
                $query2=FeeClass::create($class_details);
            }
            foreach($request->concessions as $concession)
            {
                $concession_types['fee_id']=$query;
                $concession_types['fee_concession_types']=$concession;
                $query3=FeeConcessionTypes::create($concession_types);
            }
            foreach($request->castes as $key=>$caste)
            {
                $caste_types['fee_id']=$query;
                $caste_types['caste_id']=$key;
                $caste_types['concession_amount']=$caste;
                $query4=CASTECONCESSION::create($caste_types);
            }
            foreach($request->installment as $installment=>$part_id)
            {
                foreach($part_id as $key => $value)
            {
                $installment_details['fee_id']=$query;
                $installment_details['installment_id']=$installment;
                $installment_details['particulars_id']=$key;
                $installment_details['amount']=$value;
                $query5=FeeInstallments::create($installment_details);
            }
            }
            foreach($request->fee_due_date as $key=>$due_date)
            {
                $caste_types['fee_id']=$query;
                $caste_types['installment_id']=$key;
                $caste_types['due_date']=$due_date;
                $query7=FeeDueDate::create($caste_types);
            }
             Session::flash('message-success','Fee structure created successfully');
             return Redirect::back();
        }
    }
    public function feeListingView()
    {
        $user = Auth::user()->toArray();
        $batches=Batch::where('body_id',$user['body_id'])->select('id','name')->get()->toArray();
        return view('fee.feelisting')->with(compact('batches'));
    }
    public function classesView(Request $request)
    {
       $classes=Classes::where('batch_id',$request->str1)->select('id','class_name')->get()->toArray();
        return view('fee.claasses')->with(compact('classes'));
    }
    public function feeListingTableView(Request $request)
    {
       $user = Auth::user()->toarray();
       $batches = Batch::where('body_id',$user['body_id'])->lists('id');
       $classes = Classes::whereIn('batch_id',$batches)->lists('id');
       $fee_classes = FeeClass::whereIn('class_id',$classes)->select('fee_id')->get()->toArray();
       if($request->str1 == 0)
       {
           $fees=Fees::whereIn('id',$fee_classes)->select()->get();
           return view('fee.feetable')->with(compact('fees'));
       }
        else
        {
            $query=FeeClass::where('class_id',$request->str1)->lists('fee_id');
            $fees = Fees::whereIn('id',$query)->select('id','fee_name','total_amount','year')->get()->toArray();
            return view('fee.feetable')->with(compact('fees'));
        }
    }
    /**
     * Function createTransactions()
     * Developed By Shubham Chaudhari
     */
    public function createTransactions(Request $request)
    {
         $transaction_details=array();
         $transaction_details['fee_id']=$request->Structure_type;
         $transaction_details['student_id']=$request->student_id;
         $transaction_details['transaction_type']=$request->transaction_type;
         $transaction_details['transaction_detail']=$request->transaction_detail;
         $transaction_details['transaction_amount']=$request->transaction_amount;
         $transaction_details['date']=$request->date;
         $transaction_details['installment_id']=$request->installment_id;
         $query=TransactionDetails::create($transaction_details);
         if($query){
             Session::flash('message-success','Fee transaction created successfully');
             $title="Fee payment";
             $message="Payment of Rs ".$request->transaction_amount." received by school.";
             $allUser=0;
             $users_push = User::where('id',$request->student_id)->pluck('parent_id');
             $push_users = PushToken::where('user_id',$users_push)->lists('push_token');
             $this->CreatePushNotification($title,$message,$allUser,$push_users);
         }
        return redirect('/edit-user/'.$request->student_id);
    }
    /**
     * Function getStudentDetails()
     * Developed By Ameya Joshi
     * Date: 2/6/17
     */
    public function getStudentDetails(Request $request){
        try{
            $slug = $request->slug;
            $student = User::join('students_extra_info','students_extra_info.student_id','=','users.id')
                        ->where('users.body_id',$request->school)
                        ->where('students_extra_info.grn',$request->grn)
                        ->select('users.id','users.first_name','users.last_name','users.division_id','users.parent_id','users.body_id')
                        ->first();
            if($student == null){
                return response()->json("Enter valid data.",400);
            }else{
                $student = $student->toArray();
            }
            $divisionData = Division::where('id',$student['division_id'])->select('division_name','class_id')->first()->toArray();
            $student['division'] = $divisionData['division_name'];
            $student['standard'] = Classes::where('id',$divisionData['class_id'])->pluck('class_name');
            $student['grn'] = $request->grn;
            $parent = User::where('id',$student['parent_id'])->select('first_name','last_name','email','mobile')->first()->toArray();
            $studentFeeStructures = StudentFee::join('fees','fees.id','=','student_fee.fee_id')
                                ->where('student_id',$student['id'])
                                ->select('student_fee.id as student_fee_id','student_fee.fee_id as fee_id','fees.fee_name as fee_name')
                                ->orderBy('fee_id','desc')
                                ->get()
                                ->groupBy('fee_id')
                                ->toArray();
            return view('fee.installments_details_partial')->with(compact('student','parent'/*,'installments','payableAmount','slug'*/,'studentFeeStructures','slug'));
        }catch(\Exception $e){
            $data = [
                'action' => 'Get Student details for payment',
                'data' => $request->all(),
                'message' => $e->getMessage()
            ];
            Log::info(json_encode($data));
            return response()->json([],500);
        }
    }

    public function getFeeStructureInstallments(Request $request, $studentFeeId){
        try{
            $slug = $request->slug;
            $student_fee = StudentFee::findOrFail($studentFeeId)->toArray();
            $student_fee_detail = StudentFee::where('student_id',$student_fee['student_id'])->where('fee_id',$student_fee['fee_id'])->select('fee_concession_type','caste_concession')->get()->toArray();
            $student = User::join('students_extra_info','students_extra_info.student_id','=','users.id')
                ->where('users.id',$student_fee['student_id'])
                ->select('users.id','users.first_name','users.last_name','users.division_id','users.parent_id','users.body_id')
                ->first();
            if($student == null){
                return response()->json("Enter valid data.",400);
            }else{
                $student = $student->toArray();
            }
            $previousFeeStructures = StudentFee::where('student_id', $student_fee['student_id'])
                                            ->where('fee_id','<',$student_fee['fee_id'])
                                            ->get();
            $isPreviousStructureCleared = true;
            foreach($previousFeeStructures as $previousFeeStructure){
                if($isPreviousStructureCleared == true){
                    $installmentIds = FeeInstallments::where('fee_id', $previousFeeStructure['fee_id'])
                                        ->distinct('installment_id')
                                        ->lists('installment_id');
                    foreach ($installmentIds as $installmentId){
                       $isPaid = TransactionDetails::where('student_id',$student_fee['student_id'])
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
            $divisionData = Division::where('id',$student['division_id'])->select('division_name','class_id')->first()->toArray();
            $student['division'] = $divisionData['division_name'];
            $student['standard'] = Classes::where('id',$divisionData['class_id'])->pluck('class_name');
            $student['grn'] = $request->grn;
            $parent = User::where('id',$student['parent_id'])->select('first_name','last_name','email','mobile')->first()->toArray();
            $student['fee_type'] = $student_fee['fee_id'];
            $student['academic_year'] = $student_fee['year'];
            $installment_info=FeeInstallments::where('fee_id',$student_fee['fee_id'])->select('fee_id','installment_id','particulars_id','amount')->get()->toarray();
            $installments = array();
            $total_fee_amount = 0;
            $total_installment_amount = array();
            if(!empty($installment_info))
            {
                foreach($installment_info as $installment)
                {
                    if(!array_key_exists($installment['installment_id'],$installments)){
                        $installments[$installment['installment_id']] = array();
                        $installments[$installment['installment_id']]['particulars'][$installment['particulars_id']]['amount'] = $installment['amount'];
                        $installments[$installment['installment_id']]['particulars'][$installment['particulars_id']]['particulars_name'] = fee_particulars::where('id',$installment['particulars_id'])->pluck('particular_name');
                        $total_installment_amount[$installment['installment_id']] = $installment['amount'];
                        $total_fee_amount += $installment['amount'];
                    }else{
                        $installments[$installment['installment_id']]['particulars'][$installment['particulars_id']]['amount'] = $installment['amount'];
                        $installments[$installment['installment_id']]['particulars'][$installment['particulars_id']]['particulars_name'] = fee_particulars::where('id',$installment['particulars_id'])->pluck('particular_name');
                        $total_installment_amount[$installment['installment_id']] += $installment['amount'];
                        $total_fee_amount += $installment['amount'];
                    }
                    $installments[$installment['installment_id']]['subTotal'] = $total_installment_amount[$installment['installment_id']];
                    $transactionCount = TransactionDetails::where('fee_id',$student_fee['fee_id'])->where('student_id',$student['id'])->where('installment_id',$installment['installment_id'])->count();
                    if($transactionCount > 0){
                        $installments[$installment['installment_id']]['is_paid'] = true;
                    }else{
                        $installments[$installment['installment_id']]['is_paid'] = false;
                    }
                }
            }
            /*Applying Concessions*/
            $installment_percent_amount=array();
            foreach($total_installment_amount as $key => $installment_amounts)
            {
                $installment_amounts=($installment_amounts/$total_fee_amount)*100;
                $installment_percent_amount[$key]=$installment_amounts;
            }
            foreach ($student_fee_detail as $key => $details){
                $caste_concn_amnt = CASTECONCESSION::where('caste_id', $details['caste_concession'])->where('fee_id',$student_fee['fee_id'])->pluck('concession_amount');
            }
            $collection=collect($installment_percent_amount);
            $concession_amount_array=array();
            foreach($collection as $key => $percent_discout_collection)
            {
                $discounted_amount_for_installment=($percent_discout_collection/100)*$caste_concn_amnt;
                $concession_amount_array[$key] = $discounted_amount_for_installment;
                $installments[$key]['caste_concession_amount'] = $discounted_amount_for_installment;
            }
            $totalFeeConcessionAmount = 0;
            foreach ($student_fee_detail as $key => $details) {
                $feeConcessionAmounts = FeeConcessionAmount::where('fee_id',$student_fee['fee_id'])->where('concession_type',$details['fee_concession_type'])->pluck('amount');
                $totalFeeConcessionAmount += $feeConcessionAmounts;
            }
            foreach($installments as $installmentId => $values ){
                $installments[$installmentId]['fee_concession_amount'] = ($installment_percent_amount[$installmentId]/100) * $totalFeeConcessionAmount;
                $installments[$installmentId]['final_total'] = $installments[$installmentId]['subTotal'] - $installments[$installmentId]['caste_concession_amount'] - $installments[$installmentId]['fee_concession_amount'];
            }
            return view('fee.new-installment-section')->with(compact('student','parent','installments','slug','isPreviousStructureCleared'));
        }catch(\Exception $e){
            $data = [
                'action' => 'Get Fee structurewise installment details',
                'fee_id' => $studentFeeId,
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            return response()->json([],500);
        }
    }
    public function getTransactionListing(Request $request){
        try{
            $user = Auth::user()->toArray();
            $batches=Batch::where('body_id',$user['body_id'])->select('id','name')->get()->toArray();
            return view('fee.feeTransactionListing')->with(compact('batches'));
        }catch(\Exception $e){
            $data = [
                'action' => 'Get Fee structurewise transaction details',
                'params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            return response()->json([],500);
        }
    }
    public function getTransactionListingTable(Request $request){
        return view('fee.feeTransactionTable');
    }
    public function showFeeTransactionListing(Request $request){
        try{
            $user = Auth::user();
            $userIds = User::join('user_roles','user_roles.id','=','users.role_id')
                ->where('users.body_id',$user['body_id'])
                ->where('user_roles.slug','student')
                ->lists('users.id');
            if($request->has('class_id') && $request->class_id != -1 && $request->class_id != '' && $request->class_id != null){
                $userIds = User::join('divisions','users.division_id','=','divisions.id')
                    ->join('classes','classes.id','=','divisions.class_id')
                    ->whereIn('users.id',$userIds)
                    ->where('classes.id',$request->class_id)
                    ->lists('users.id');
            }

            if($request->has('div_id') && $request->div_id != -1 && $request->div_id != '' && $request->div_id != null){
                $userIds = User::whereIn('id',$userIds)->where('division_id', $request->div_id)->lists('id');
            }
            $students = User::join('students_extra_info', 'users.id','=','students_extra_info.student_id')
                ->join('transaction_details','transaction_details.student_id','=','users.id')
                ->join('fees','fees.id','=','transaction_details.fee_id')
                ->whereIn('users.id', $userIds)
                ->select('transaction_details.student_id as id','transaction_details.date as date','fees.fee_name as name','users.first_name as first_name','users.last_name as last_name','transaction_details.transaction_amount','students_extra_info.grn as grn','fees.id as fee_id','transaction_details.installment_id as Installment')
                ->get()->toArray();
            $jIterator = 0;
            foreach ($students as $studentId){
                $studentFee=StudentFee::where('student_id',$studentId['id'])->select('fee_id','year','fee_concession_type','caste_concession')->get()->toarray();
                $iterator = 0;
                $students[$jIterator]['total'] = 0;
                foreach ($studentFee as $key=>$fee_id){
                    $installment_info = FeeInstallments::where('fee_id',$fee_id['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
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
                }
                $jIterator++;
            }
            $str="<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
            $str.="<thead><tr>";
            $str.="<th>Date</th>";
            $str.="<th>Fee Structure Name</th>";
            $str.="<th>Installment ID</th>";
            $str.="<th>Student Name</th>";
            $str.="<th>Amount</th>";
            $str.="<th>Paid Amount</th>";
            $str.="<th>GRN No.</th>";
            $str.="<th>Action</th>";
            $str.="</tr></thead><tbody>";
            foreach ($students as $student){
                $str.="<tr>";
                $str.="<td>".$student['date']."</td>";
                $str.="<td>".$student['name']."</td>";
                $str.="<td>".$student['Installment']."</td>";
                $str.="<td>".$student['first_name']." ".$student['last_name']."</td>";
                $str.="<td>".$student['total']."</td>";
                $str.="<td>".$student['transaction_amount']."</td>";
                $str.="<td>".$student['grn']."</td>";
                $str.="<td>"."<a href='/fees/download-pdf/".$student['id']."/".$student['fee_id']."'>download </a>"."</td>";
                $str.="</tr>";
            }
            $str.="</tbody></table>";
            return $str;
        }catch(\Exception $e){
            $data = [
                'data' => "Transaction List Listed Successfully",
                'params' => $request->all(),
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            return response()->json([],500);
        }
    }
    public function createPDF(Request $request,$id,$fee_id)
    {
        try {
            $user = Auth::user();
            $grn = User::join('students_extra_info', 'users.id', '=', 'students_extra_info.student_id')
                ->where('students_extra_info.student_id', $id)
                ->select('students_extra_info.grn as grn')->first();
            $studentData = User::where('body_id', $user['body_id'])->where('id', $id)->select('parent_id')->first();
            $parent_name = User::where('body_id', $user['body_id'])->where('id', $studentData['parent_id'])->select('first_name', 'last_name')->first();
            $transaction_details = TransactionDetails::where('student_id', $id)->where('fee_id', $fee_id)->get()->first();
            $studentFee = StudentFee::where('student_id', $id)->where('fee_id', $fee_id)->select('fee_id', 'year', 'fee_concession_type', 'caste_concession')->get()->toarray();
            $division = User::join('divisions','divisions.id','=','users.division_id')
                            ->where('users.id',$id)
                            ->select('divisions.id as id','divisions.division_name as division_name')
                            ->get()->first();
            $class = Classes::join('divisions','divisions.class_id','=','classes.id')
                                ->where('divisions.id',$division['id'])
                                ->select('classes.class_name as class_name')
                                ->get()->first();
            $iterator = 0;
            foreach ($studentFee as $key => $a) {
                $installment_info = FeeInstallments::where('fee_id', $fee_id)->select('installment_id', 'particulars_id', 'amount')->get()->toarray();
                $installments = array();
                if (!empty($installment_info)) {
                    foreach ($installment_info as $installment) {
                        if (!array_key_exists($installment['installment_id'], $installments)) {
                            $installments[$installment['installment_id']] = array();
                            $installments[$installment['installment_id']]['subTotal'] = 0;
                        }
                        $installments[$installment['installment_id']]['subTotal'] += $installment['amount'];
                    }
                    $totalYearsFeeAmount = array_sum(array_column($installments, 'subTotal'));
                    foreach ($installments as $installmentId => $installmentArray) {
                        $percentage = ($installments[$installmentId]['subTotal'] / $totalYearsFeeAmount) * 100;
                        $installments[$installmentId]['installment_percentage'] = ($installments[$installmentId]['subTotal'] / $totalYearsFeeAmount) * 100;
                        $discount = 0;
                        if ($a['caste_concession'] != null) {
                            $casteConcessionAmount = StudentFee::join('caste_concession', 'caste_concession.id', '=', 'student_fee.caste_concession')
                                ->where('student_fee.fee_id', $fee_id)
                                ->pluck('caste_concession.concession_amount');
                            $discount += ($casteConcessionAmount / 100) * $percentage;
                        }
                        if ($a['fee_concession_type'] != null) {
                            $feeConcessionTypeAmount = FeeConcessionAmount::where('fee_id', $fee_id)
                                ->where('concession_type', $a['fee_concession_type'])
                                ->pluck('amount');
                            $discount += ($feeConcessionTypeAmount / 100) * $percentage;
                        }
                        $response[$installmentId] = $installments[$installmentId]['subTotal'] - $discount;
                    }
                }
                $iterator++;
            }
            $sum = array_sum($response);
            $new_array = array();
            $total_paid_fees = TransactionDetails::where('student_id', $id)->where('fee_id', $fee_id)->select('transaction_amount')->first();
            foreach ($total_paid_fees as $key => $total_paid_fee) {
                array_push($new_array, $total_paid_fee);
            }
            $final_paid_fee_for_current_year = array_sum($new_array);
            $balance = $sum - $final_paid_fee_for_current_year;
            TCPdf::AddPage();
            TCPdf::writeHTML(view('/fee/feeTransaction-pdf')->with(compact('user', 'balance', 'grn', 'transaction_details', 'parent_name','division','class'))->render());
            TCPdf::Output("Receipt Form" . date('Y-m-d_H-i-s') . ".pdf", 'D');
        } catch (\Exception $e) {
            $data = [
                'action' => "PDF generated",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
            return response()->json([], 500);
        }
    }
    public function feeDevelopmentView(Request $request){
        try{
            return view('fee/feeDevelopment');
        }catch(\Exception $e){
            $data=[
                'action' => "Fee Development View",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
            return response()->json([], 500);
        }
    }
    public function feeAdmissionView(Request $request){
        try{
            return view('fee/feeAdmission');
        }catch(\Exception $e){
            $data=[
                'action' => "Fee Admission View",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
            return response()->json([], 500);
        }
    }
    public function createFeeDevelopment(Request $request){
        try{
            $user = Auth::user();
            $data['body_id'] = $user->body_id;
            $data['student_name'] = $request->student_name;
            $data['class'] = $request->class;
            $data['parent_name'] = $request->parent_name;
            $data['sum_of_rupee'] = $request->sum_rupee;
            $data['transaction_number'] = $request->dd_number;
            $data['date'] = $request->date;
            $data['bank_name'] = $request->bank_name;
            $data['account_holder_name'] = $request->account_holder_name;
            $query = FeeDevelopment::create($data);
            if($query){
                Session::flash('message-success','created successfully .');
                return Redirect::back();
            }else{
                Session::flash('message-error','Something went wrong !');
                return Redirect::back();
            }
        }catch (\Exception $e) {
            $data = [
                'action' => "Created",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
            return response()->json([], 500);
        }
    }
    public function feeDevelopmentListing(Request $request)
    {
        try {
            $dataValue = FeeDevelopment::get()->toArray();
            $str = "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
            $str .= "<thead><tr>";
            $str .= "<th>Student Name</th>";
            $str .= "<th>Class</th>";
            $str .= "<th>Parent Name</th>";
            $str .= "<th>Amount</th>";
            $str .= "<th>Receipt Number</th>";
            $str .= "<th>Date</th>";
            $str .= "<th>Action</th>";
            $str .= "</tr></thead><tbody>";
            $str .= "<tr>";
            foreach ($dataValue as $data) {
                $str .= "<td>" . $data['student_name'] . "</td>";
                $str .= "<td>" . $data['class'] . "</td>";
                $str .= "<td>" . $data['parent_name'] . "</td>";
                $str .= "<td>" . $data['sum_of_rupee'] . "</td>";
                $str .= "<td>" . $data['transaction_number'] . "</td>";
                $str .= "<td>" . $data['date'] . "</td>";
                $str .= "<td>" . "<a href='/fees/downlod-fee-development/" . $data['id'] . "'>download </a>" . "</td>";
                $str .= "</tr>";
            }
            $str .= "</tbody></table>";
            return $str;

        } catch (\Exception $e) {
            $data = [
                'action' => "listed successfuly",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
        }
    }
    public function feeDevelopmentPDF(Request $request,$id){
        try{
            $userData=FeeDevelopment::where('id',$id)->first()->toArray();
            TCPdf::AddPage();
            TCPdf::writeHTML(view('/fee/feeDevelopment-pdf')->with(compact('userData'))->render());
            TCPdf::Output("Receipt Form" . date('Y-m-d_H-i-s') . ".pdf", 'D');
        }catch(\Exception $e){
            $data = [
                'action' => "PDF generated",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
        }
    }
    public function feeAdmissionListing(Request $request){
        try {
            $dataValue = FeeAdmission::get()->toArray();
            $str = "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
            $str .= "<thead><tr>";
            $str .= "<th>Student Name</th>";
            $str .= "<th>Class</th>";
            $str .= "<th>Parent Name</th>";
            $str .= "<th>Amount</th>";
            $str .= "<th>Receipt Number</th>";
            $str .= "<th>Date</th>";
            $str .= "<th>Action</th>";
            $str .= "</tr></thead><tbody>";
            $str .= "<tr>";
            foreach ($dataValue as $data) {
                $str .= "<td>" . $data['student_name'] . "</td>";
                $str .= "<td>" . $data['class'] . "</td>";
                $str .= "<td>" . $data['parent_name'] . "</td>";
                $str .= "<td>" . $data['sum_of_rupee'] . "</td>";
                $str .= "<td>" . $data['transaction_number'] . "</td>";
                $str .= "<td>" . $data['date'] . "</td>";
                $str .= "<td>" . "<a href='/fees/downlod-fee-admission/" . $data['id'] . "'>download </a>" . "</td>";
                $str .= "</tr>";
            }
            $str .= "</tbody></table>";
            return $str;

        } catch (\Exception $e) {
            $data = [
                'action' => "listed successfuly",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
        }
    }
    public function createFeeAdmission(Request $request){
        try{
            $user = Auth::user();
            $data['body_id'] = $user->body_id;
            $data['student_name'] = $request->student_name;
            $data['class'] = $request->class;
            $data['parent_name'] = $request->parent_name;
            $data['sum_of_rupee'] = $request->sum_rupee;
            $data['transaction_number'] = $request->dd_number;
            $data['date'] = $request->date;
            $data['bank_name'] = $request->bank_name;
            $data['branch'] = $request->branch_name;
            $data['account_holder_name'] = $request->account_holder_name;
            $data['rupees'] = $request->amount;
            $data['balance'] = $request->balance;
            $dataInfo = FeeAdmission::where('body_id',$user->body_id)->orderBy('fee_admission_id','desc')->first();
            if($dataInfo['body_id'] == $user->body_id  && $dataInfo['fee_admission_id'] == null && $dataInfo == ""){
                $data['fee_admission_id'] = 1;
            }else{
                $data['fee_admission_id'] = $dataInfo['fee_admission_id'] + 1;
            }
            $query = FeeAdmission::create($data);
            if($query){
                Session::flash('message-success','created successfully .');
                return Redirect::back();
            }else{
                Session::flash('message-error','Something went wrong !');
                return Redirect::back();
            }
        }catch (\Exception $e){
            $data = [
                'action' => "Created",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
            return response()->json([], 500);
        }
    }
    public function feeAdmissionPDF(Request $request,$id){
        try{
            $userData=FeeAdmission::where('id',$id)->first()->toArray();
            TCPdf::AddPage();
            TCPdf::writeHTML(view('/fee/feeAdmission-pdf')->with(compact('userData'))->render());
            TCPdf::Output("Receipt Form" . date('Y-m-d_H-i-s') . ".pdf", 'D');
        }catch(\Exception $e){
            $data = [
                'action' => "PDF generated",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
        }
    }
    public function feeForm(Request $request){
        try{
            return view('fee/formFee');
        }catch(\Exception $e){
            $data=[
                'action' => "Form Fee View",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
            return response()->json([], 500);
        }
    }
    public function createFormFee(Request $request){
        try{
            $user = Auth::user();
            $data['body_id'] = $user->body_id;
            $data['student_name'] = $request->student_name;
            $data['class'] = $request->class;
            $data['parent_name'] = $request->parent_name;
            $data['sum_of_rupee'] = $request->sum_rupee;
            $data['transaction_number'] = $request->dd_number;
            $data['date'] = $request->date;
            $data['bank_name'] = $request->bank_name;
            $data['branch'] = $request->branch_name;
            $data['account_holder_name'] = $request->account_holder_name;
            $data['rupees'] = $request->amount;
            $data['balance'] = $request->balance;
            $dataInfo = FormFee::where('body_id',$user->body_id)->orderBy('form_fee_id','desc')->first();
            if($dataInfo['body_id'] == $user->body_id  && $dataInfo['form_fee_id'] == null && $dataInfo == ""){
                $data['form_fee_id'] = 1;
            }else{
                $data['form_fee_id'] = $dataInfo['form_fee_id'] + 1;
            }
            $query = FormFee::create($data);
            if($query){
                Session::flash('message-success','created successfully .');
                return Redirect::back();
            }else{
                Session::flash('message-error','Something went wrong !');
                return Redirect::back();
            }
        }catch (\Exception $e){
            $data = [
                'action' => "Created",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
            return response()->json([], 500);
        }
    }
    public function formFeeListing(Request $request){
        try {
            $user=Auth::user();
            $dataValue = FormFee::where('body_id',$user->body_id)->get()->toArray();
            $str = "<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>";
            $str .= "<thead><tr>";
            $str .= "<th>Student Name</th>";
            $str .= "<th>Class</th>";
            $str .= "<th>Parent Name</th>";
            $str .= "<th>Amount</th>";
            $str .= "<th>Receipt Number</th>";
            $str .= "<th>Date</th>";
            $str .= "<th>Action</th>";
            $str .= "</tr></thead><tbody>";
            $str .= "<tr>";
            foreach ($dataValue as $data) {
                $str .= "<td>" . $data['student_name'] . "</td>";
                $str .= "<td>" . $data['class'] . "</td>";
                $str .= "<td>" . $data['parent_name'] . "</td>";
                $str .= "<td>" . $data['sum_of_rupee'] . "</td>";
                $str .= "<td>" . $data['transaction_number'] . "</td>";
                $str .= "<td>" . $data['date'] . "</td>";
                $str .= "<td>" . "<a href='/fees/downlod-form-fee/" . $data['id'] . "'>download </a>" . "</td>";
                $str .= "</tr>";
            }
            $str .= "</tbody></table>";
            return $str;

        } catch (\Exception $e) {
            $data = [
                'action' => "listed successfuly",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
        }
    }
    public function formFeePDF(Request $request,$id){
        try{
            $userData = FormFee::where('id',$id)->first()->toArray();
            TCPdf::AddPage();
            TCPdf::writeHTML(view('/fee/formFee-pdf')->with(compact('userData'))->render());
            TCPdf::Output("Receipt Form" . date('Y-m-d_H-i-s') . ".pdf", 'D');
        }catch(\Exception $e){
            $data = [
                'action' => "PDF generated",
                'params' => $request->all(),
                'exception' => $e->getMessage(),
            ];
            Log::critical(json_encode($data));
        }
    }
}
