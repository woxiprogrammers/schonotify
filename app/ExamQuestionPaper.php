<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamQuestionPaper extends Model
{
    protected $table = 'exam_question_paper';

    protected $fillable = ['question_paper_name','no_of_question','marks','set_name','exam_id','subject_id','class_id'];
}
