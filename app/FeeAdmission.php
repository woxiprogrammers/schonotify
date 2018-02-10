<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeAdmission extends Model
{
    protected $table = "fee_admission";

    protected $fillable = ['body_id','student_name','class','parent_name','sum_of_rupee','transaction_number','date','bank_name','account_holder_name','branch','rupees','balance'];

}
