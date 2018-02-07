<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    protected $table = "student_fee";

    protected $fillable = ['fee_id','student_id','year','fee_concession_type','caste_concession'];

}
