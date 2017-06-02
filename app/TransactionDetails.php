<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetails extends Model
{
    protected $table="transaction_details";
    protected $fillable = ['id','fee_id','student_id','transaction_type','transaction_detail','transaction_amount','date','installment_id'];
}
