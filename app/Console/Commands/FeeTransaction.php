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
        $users = User::where('body_id',1)->where('role_id',3)->whereNotIn('id',[1099,887,983,141,173,1118,586,133,919])->get()->toArray();
        foreach ($users as  $value){
            $transactionDetails = TransactionDetails::where('student_id',$value['id'])->get()->toArray();
            if(!in_array($value['id'], [692,1093,1085,3,609,329,94])){
                if(empty($transactionDetails)){
                    $data = array();
                    $data['fee_id'] = 1;
                    $data['student_id'] = $value['id'];
                    $data['transaction_type'] = "Cash";
                    $data['transaction_detail'] = "";
                    $data['transaction_amount'] = 14000;
                    $data['date'] = Carbon::now();
                    $data['installment_id'] = 1;
                    TransactionDetails::create($data);
                    $data1 = array();
                    $data1['fee_id'] = 1;
                    $data1['student_id'] = $value['id'];
                    $data1['transaction_type'] = "Cash";
                    $data1['transaction_detail'] = "";
                    $data1['transaction_amount'] = 7000;
                    $data1['date'] = Carbon::now();
                    $data1['installment_id'] = 2;
                    TransactionDetails::create($data1);
                }else{
                    foreach($transactionDetails as $txnDetail){
                        if(!($txnDetail['fee_id'] == 1 && $txnDetail['installment_id'] == 1)){
                            $data = array();
                            $data['fee_id'] = 1;
                            $data['student_id'] = $value['id'];
                            $data['transaction_type'] = "Cash";
                            $data['transaction_detail'] = "";
                            $data['transaction_amount'] = 14000;
                            $data['date'] = Carbon::now();
                            $data['installment_id'] = 1;
                            TransactionDetails::create($data);
                        }else if(!($txnDetail['fee_id'] == 1 && $txnDetail['installment_id'] == 2)){
                            $data1 = array();
                            $data1['fee_id'] = 1;
                            $data1['student_id'] = $value['id'];
                            $data1['transaction_type'] = "Cash";
                            $data1['transaction_detail'] = "";
                            $data1['transaction_amount'] = 7000;
                            $data1['date'] = Carbon::now();
                            $data1['installment_id'] = 2;
                            TransactionDetails::create($data1);
                        }
                    }
                }
            }else{
                $data = array();
                $data['fee_id'] = 1;
                $data['student_id'] = $value['id'];
                $data['transaction_type'] = "Cash";
                $data['transaction_detail'] = "";
                $data['transaction_amount'] = 0;
                $data['date'] = Carbon::now();
                $data['installment_id'] = 1;
                TransactionDetails::create($data);
                $data1 = array();
                $data1['fee_id'] = 1;
                $data1['student_id'] = $value['id'];
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
