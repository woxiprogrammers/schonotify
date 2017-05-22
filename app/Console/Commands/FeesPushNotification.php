<?php

namespace App\Console\Commands;

use App\FeeDueDate;
use App\Http\Controllers\CustomTraits\PushNotificationTrait;
use App\PushToken;
use App\StudentFee;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FeesPushNotification extends Command
{
    use PushNotificationTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'custom:pushFees';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

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
        $dateOfPushNotification=date('d-m-Y', strtotime('+45 days'));
        $days=45;
        $this->setNotification($days,$dateOfPushNotification);
        $dateOfPushNotification=date('d-m-Y', strtotime('+30 days'));
        $days=30;
        $this->setNotification($days,$dateOfPushNotification);
        $dateOfPushNotification=date('d-m-Y', strtotime('+6 days'));
        $days=6;
        $this->setNotification($days,$dateOfPushNotification);
        $dateOfPushNotification=date('d-m-Y', strtotime('+5 days'));
        $days=5;
        $this->setNotification($days,$dateOfPushNotification);
        $dateOfPushNotification=date('d-m-Y', strtotime('+4 days'));
        $days=4;
        $this->setNotification($days,$dateOfPushNotification);
        $dateOfPushNotification=date('d-m-Y', strtotime('+3 days'));
        $days=3;
        $this->setNotification($days,$dateOfPushNotification);
        $dateOfPushNotification=date('d-m-Y', strtotime('+2 days'));
        $days=2;
        $this->setNotification($days,$dateOfPushNotification);
        $dateOfPushNotification=date('d-m-Y', strtotime('+1 days'));
        $days=1;
        $this->setNotification($days,$dateOfPushNotification);

    }
    public function setNotification($days,$dateOfPushNotification){
        $fee_id=FeeDueDate::where('due_date',$dateOfPushNotification)->lists('fee_id');
        $students=StudentFee::whereIn('fee_id',$fee_id)->lists('student_id');
        $parents=User::whereIn('id',$students)->lists('parent_id');
        $push_users=PushToken::whereIn('user_id',$parents)->lists('push_token');
        $title="Fees Reminder";
        $message="Your due date for next installment is after". $days ."days";
        $allUser=0;
        $push_users=PushToken::whereIn('user_id',$push_users)->lists('push_token');
        $this->CreatePushNotification($title,$message,$allUser,$push_users);
    }
}
