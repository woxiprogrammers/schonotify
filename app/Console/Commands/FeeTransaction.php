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
        $users = User::where('body_id',1)->whereNotIn('id',[692,1093,1085,3,609,329,94,1099,887,983,141,173,1118,586,133,919])->lists('id');
        foreach ($users as $key => $value){
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
        }
    }
}
