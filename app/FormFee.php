<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormFee extends Model
{
    protected $table = "form_fee";

    protected $fillable = ['body_id','student_name','class','parent_name','sum_of_rupee','transaction_number','date','bank_name','account_holder_name','branch','rupees','balance','form_fee_id'];
}
