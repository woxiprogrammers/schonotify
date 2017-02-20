<?php

namespace App\Http\Controllers;

use App\category_types;
use App\Classes;
use App\ConcessionTypes;
use App\fee_installments;
use App\fee_particulars;
use App\Installments;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Batch;

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
}
