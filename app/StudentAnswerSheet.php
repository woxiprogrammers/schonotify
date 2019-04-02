<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentAnswerSheet extends Model
{
    protected $table = 'student_answer_sheets';

    protected $fillable = ['exam_id','student_id','pdf_name'];
}
