<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentFeeConcessions extends Model
{
    protected $table = "student_fee_concession";

    protected $fillable = ['fee_id','student_id','fee_concession_type'];
}
