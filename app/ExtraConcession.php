<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraConcession extends Model
{
    protected $table = 'extra_concession';

    protected $fillable = ['fee_id','student_id','installment_id','label','amount'];
}
