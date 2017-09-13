<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTermDetails extends Model
{
    protected $table = "exam_term_details";

    protected $fillable = array('exam_structure_id','term_id','exam_type','out_of_marks');
}
