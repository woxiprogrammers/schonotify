<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentExamMarks extends Model
{
    protected $table = "student_exam_marks";

    protected $fillable = array('student_exam_details_id','term_id','exam_structure_id','marks_obtained','exam_term_details_id');
}
