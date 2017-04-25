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
use App\FeeClass;
use App\FeeConcessionAmount;
use App\FeeConcessionTypes;
use App\FeeDueDate;
use App\FeeInstallments;
use App\Fees;
use App\StudentFee;
use App\StudentFeeConcessions;
use App\TransactionDetails;
use App\User;
use Carbon\Carbon;
use App\Installments;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Batch;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class FeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth',['except'=>['billiingPageView','getStudentDetails']]);

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

    public function billiingPageView(){
        try{
            $bodies = Body::get()->toArray();
            return view('fee.FeeBillingPage')->with(compact('bodies'));
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
                $sportDetails['amount']=$request->special;
                $sport=FeeConcessionAmount::insert($sportDetails);
            }
          foreach($request->class as $class)
            {
                $class_present=FeeClass::where('class_id',$class)->exists();
                if($class_present)
                {
                    $class_details['fee_id']=$query;
                    $class_details['class_id']=$class;
                    $class_details['amount']=$request->total_fee;
                    $query2=FeeClass::where('class_id',$class)->update($class_details);
                }
                else
                {
                    $class_details['fee_id']=$query;
                    $class_details['class_id']=$class;
                    $class_details['amount']=$request->total_fee;
                    $query2=FeeClass::create($class_details);
                }

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

        $batches=Batch::select('id','name')->get()->toArray();

        return view('fee.feelisting')->with(compact('batches'));
    }
    public function classesView(Request $request)
    {
       $classes=Classes::where('batch_id',$request->str1)->select('id','class_name')->get()->toArray();
        return view('fee.claasses')->with(compact('classes'));

    }
    public function feeListingTableView(Request $request)
    {
       if($request->str1 == 0)
       {
           $fees=Fees::select()->get();
           return view('fee.feetable')->with(compact('fees'));
       }
        else
        {
            $query=FeeClass::where('class_id',$request->str1)->pluck('fee_id');
            $fees=Fees::where('id',$query)->select()->get();
            return view('fee.feetable')->with(compact('fees'));
        }
    }
    public function createTransactions(Request $request)
    {    $user=$request->student_id;
         $fee_id=StudentFee::where('student_id',$user)->pluck('fee_id');
         $transaction_details=array();
         $transaction_details['fee_id']=$fee_id;
         $transaction_details['student_id']=$request->student_id;
         $transaction_details['transaction_type']=$request->transaction_type;
         $transaction_details['transaction_detail']=$request->transaction_detail;
         $transaction_details['transaction_amount']=$request->transaction_amount;
         $transaction_details['date']=$request->date;
         $query=TransactionDetails::create($transaction_details);
         if($query)
         {
             Session::flash('message-success','Fee transaction created successfully');
         }

        return redirect('/edit-user/'.$user);
    }

    public function getStudentDetails(Request $request){
        try{
            $student = User::join('students_extra_info','students_extra_info.student_id','=','users.id')
                        ->where('users.body_id',$request->school)
                        ->where('students_extra_info.grn',$request->grn)
                        ->select('users.id','users.first_name','users.last_name','users.division_id','users.parent_id','users.body_id')
                        ->first()->toArray();
            $divisionData = Division::where('id',$student['division_id'])->select('division_name','class_id')->first()->toArray();
            $student['division'] = $divisionData['division_name'];
            $student['standard'] = Classes::where('id',$divisionData['class_id'])->pluck('class_name');
            $student['grn'] = $request->grn;
            $parent = User::where('id',$student['parent_id'])->select('first_name','last_name','email','mobile')->first()->toArray();
            $student_fee=StudentFee::where('student_id',$student['id'])->select('fee_id','year','fee_concession_type','caste_concession')->first()->toarray();
            $student['fee_type'] = $student_fee['fee_id'];
            $student['academic_year'] = $student_fee['year'];
            $installment_info=FeeInstallments::where('fee_id',$student_fee['fee_id'])->select('installment_id','particulars_id','amount')->get()->toarray();
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
                }
            }
            /*Applying Concessions*/
            $installment_percent_amount=array();
            foreach($total_installment_amount as $key => $installment_amounts)
            {
                $installment_amounts=($installment_amounts/$total_fee_amount)*100;
                $installment_percent_amount[$key]=$installment_amounts;
            }
            $caste_concn_amnt= CASTECONCESSION::where('caste_id', $student_fee['caste_concession'])->where('fee_id',$student_fee['fee_id'])->pluck('concession_amount');
            $collection=collect($installment_percent_amount);
            $concession_amount_array=array();
            foreach($collection as $key => $percent_discout_collection)
            {

                $discounted_amount_for_installment=($percent_discout_collection/100)*$caste_concn_amnt;
                $concession_amount_array[$key] = $discounted_amount_for_installment;
                $installments[$key]['caste_concession_amount'] = $discounted_amount_for_installment;
            }
            $feeConcessions = StudentFeeConcessions::where('student_id',$student['id'])->where('fee_id',$student_fee['fee_id'])->pluck('fee_concession_type');
            $feeConcessions = json_decode($feeConcessions);
            if($feeConcessions != 'null' || $feeConcessions != null){
                $feeConcessionAmounts = FeeConcessionAmount::where('fee_id',$student_fee['fee_id'])->whereIn('concession_type',$feeConcessions)->lists('amount')->toArray();
                $totalFeeConcessionAmount = array_sum($feeConcessionAmounts);
            }else{
                $totalFeeConcessionAmount = 0;
            }
            $payableAmount = -1;
            foreach($installments as $installmentId => $values ){
                $installments[$installmentId]['fee_concession_amount'] = ($installment_percent_amount[$installmentId]/100) * $totalFeeConcessionAmount;
                $installments[$installmentId]['final_total'] = $installments[$installmentId]['subTotal'] - $installments[$installmentId]['caste_concession_amount'] - $installments[$installmentId]['fee_concession_amount'];
                $transactionCount = TransactionDetails::where('fee_id',$student_fee['fee_id'])->where('student_id',$student['id'])->where('installment_id',$installmentId)->count();
                if($transactionCount > 0){
                    $installments[$installmentId]['is_paid'] = true;
                }else{
                    if($payableAmount == -1){
                        $payableAmount = $installments[$installmentId]['final_total'];
                    }
                    $installments[$installmentId]['is_paid'] = false;
                }
            }
            return view('fee.installments_details_partial')->with(compact('student','parent','installments','payableAmount'));
        }catch(\Exception $e){
            $data = [
                'action' => 'Get Student details for payment',
                'data' => $request->all(),
                'message' => $e->getMessage()
            ];
            Log::info(json_encode($data));
        }
    }

}
