<?php

namespace App\Http\Controllers;

use App\CASTECONCESSION;
use App\category_types;
use App\Classes;
use App\ConcessionTypes;
use App\fee_installments;
use App\fee_particulars;
use App\FeeClass;
use App\FeeConcessionTypes;
use App\FeeDueDate;
use App\FeeInstallments;
use App\Fees;
use App\StudentFee;
use App\TransactionDetails;
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
        $this->middleware('auth');

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
    public function create(Request $request)
    {
        $fee_details['fee_name']=$request->fee_name;
        $fee_details['total_amount']=$request->total_fee;
        $fee_details['year']=$request->myselect;
        $query=Fees::insertGetId($fee_details);
        if($query)
        {
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
}
