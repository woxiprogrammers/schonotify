<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FullPaymentConcession extends Model
{
    protected $table = 'full_payment_concession';

    protected $fillable = ['fee_id','concession_type','student_id','label','amount'];
}
