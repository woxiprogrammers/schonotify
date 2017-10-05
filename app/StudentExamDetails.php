<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentExamDetails extends Model
{
    protected $table = "student_exam_details";

    protected $fillable = array('student_id','term_id','exam_structure_id');
}
