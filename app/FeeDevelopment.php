<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeDevelopment extends Model
{
    protected $table = "fee_development";

    protected $fillable = ['body_id','student_name','class','parent_name','sum_of_rupee','transaction_number','date','bank_name','account_holder_name'];
}
