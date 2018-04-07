<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentLateFee extends Model
{
    protected $table = "student_late_fee";

    protected $fillable = ['student_id','fee_id','installment_id','late_fee_amount'];
}
