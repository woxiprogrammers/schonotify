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
use App\FeeInstallments;
use App\Fees;
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
             //dd($caste_types);
            return view('fee.create')->with(compact('classes','batches','concession_types','caste_types','installment_number'));
        }catch(\Exception $e){
            $data = [

                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            abort(500,$e->getMessage());
        }

    }

    public function concessionTypes(){
        //$user=Auth::user();
        $batchData =ConcessionTypes::select('id','name')->get();
        $batchList = $batchData->toArray();
        return $batchList;
    }
    public function particulars(Request $request)
    {              $total_no_of_installments=$request->str1;


        $installment_details=Installments::select('id','installment_number')->take($total_no_of_installments)->get();
        $fee_particulars=fee_particulars::select('id','particular_name')->get();
        $fee_installment_amount=fee_installments::select('id','amount')->take($total_no_of_installments)->get();
       // dd($fee_installment_amount);
        return view('fee.installments')->with(compact('installment_details','fee_particulars','fee_installment_amount'));
    }


    public function installmentCount(Request $request)
        {




               return view('fee.installments');




        }
    public function summation(Request $request)
    {
       $request->x;
    }

    public function create(Request $request)
    {
       //dd($request->all());
       // dd($request->castes['caste_id']);
        $fee_details['fee_name']=$request->fee_name;
        $fee_details['total_amount']=$request->total_fee;
        $fee_details['year']=$request->myselect;
      //  $fee_details['created_at']=Carbon::now();
        $query=Fees::insertGetId($fee_details);
        //dd($query);

        if($query)
        {
          //  dd(1234);
            foreach($request->class as $class)
            {
               //dd($query);
               $class_details['fee_id']=$query;
               $class_details['class_id']=$class;
               $class_details['amount']=$request->total_fee;
               //   $class_details['created_at']=Carbon::now();
                $query2=FeeClass::create($class_details);



           }

            foreach($request->concessions as $concession)
            {
                $concession_types['fee_id']=$query;
                $concession_types['fee_concession_types']=$concession;
                //  $concession_types['created_at']=Carbon::now();
                $query3=FeeConcessionTypes::create($concession_types);



            }

            foreach($request->castes as $key=>$caste)
            {
                $caste_types['fee_id']=$query;
                $caste_types['caste_id']=$key;
                $caste_types['concession_amount']=$caste;
                //  $caste_types['created_at']=Carbon::now();
                $query4=CASTECONCESSION::create($caste_types);



            }
         //   dd($request->installment);
            foreach($request->installment as $installment=>$part_id)
            {
                foreach($part_id as $key => $value)
            {
                $installment_details['fee_id']=$query;

                $installment_details['installment_id']=$installment;
                $installment_details['particulars_id']=$key;
                $installment_details['amount']=$value;
//                $installment_details['created_at']=Carbon::now();
              //  dd($installment_details);
                $query5=FeeInstallments::create($installment_details);

            }

            }


            Session::flash('message-success','Fee structure created successfully');
             return Redirect::back();
        }

    }
}
