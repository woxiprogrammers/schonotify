<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeDueDate extends Model
{
    protected $table = "fee_due_date";

    protected $fillable = ['fee_id','installment_id','due_date','late_fee_amount','number_of_days'];
}
