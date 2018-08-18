<?php

namespace App\Console\Commands;

use App\TransactionDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FeeTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:transaction_description';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::where('body_id',1)->where('role_id',3)->whereNotIn('division_id',[103,104])->whereNotIn('id',[1099,887,983,141,173,1118,586,133,919])->lists('id')->toArray();
        foreach ($users as  $value){
            $transactionDetails = TransactionDetails::where('student_id',$value)->get()->toArray();
            if(!in_array($value, [692,1093,1085,3,609,329,94])){
                if(count($transactionDetails) == 0){
                    $data = array();
                    $data['fee_id'] = 1;
                    $data['student_id'] = $value;
                    $data['transaction_type'] = "Cash";
                    $data['transaction_detail'] = "";
                    $data['transaction_amount'] = 14000;
                    $data['date'] = Carbon::now();
                    $data['installment_id'] = 1;
                    TransactionDetails::create($data);
                    $data1 = array();
                    $data1['fee_id'] = 1;
                    $data1['student_id'] = $value;
                    $data1['transaction_type'] = "Cash";
                    $data1['transaction_detail'] = "";
                    $data1['transaction_amount'] = 7000;
                    $data1['date'] = Carbon::now();
                    $data1['installment_id'] = 2;
                    TransactionDetails::create($data1);
                }else{
                    $installment1 = TransactionDetails::where('student_id',$value)->where('fee_id',1)->where('installment_id',1)->count();
                    $installment2 = TransactionDetails::where('student_id',$value)->where('fee_id',1)->where('installment_id',2)->count();
                    if($installment1 == 0){
                        $newdata = array();
                        $newdata['fee_id'] = 1;
                        $newdata['student_id'] = $value;
                        $newdata['transaction_type'] = "Cash";
                        $newdata['transaction_detail'] = "";
                        $newdata['transaction_amount'] = 14000;
                        $newdata['date'] = Carbon::now();
                        $newdata['installment_id'] = 1;
                        TransactionDetails::create($newdata);
                    }if($installment2 == 0){
                        $newdata1 = array();
                        $newdata1['fee_id'] = 1;
                        $newdata1['student_id'] = $value;
                        $newdata1['transaction_type'] = "Cash";
                        $newdata1['transaction_detail'] = "";
                        $newdata1['transaction_amount'] = 7000;
                        $newdata1['date'] = Carbon::now();
                        $newdata1['installment_id'] = 2;
                        TransactionDetails::create($newdata1);
                    }
                }
            }else{
                $data = array();
                $data['fee_id'] = 1;
                $data['student_id'] = $value;
                $data['transaction_type'] = "Cash";
                $data['transaction_detail'] = "";
                $data['transaction_amount'] = 0;
                $data['date'] = Carbon::now();
                $data['installment_id'] = 1;
                TransactionDetails::create($data);
                $data1 = array();
                $data1['fee_id'] = 1;
                $data1['student_id'] = $value;
                $data1['transaction_type'] = "Cash";
                $data1['transaction_detail'] = "";
                $data1['transaction_amount'] = 0;
                $data1['date'] = Carbon::now();
                $data1['installment_id'] = 2;
                TransactionDetails::create($data1);
            }
        }
    }
}
