<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrQuestions extends Model
{
    protected $table = 'or_questions';

    protected $fillable = ['question_id','or_question_id'];
}
