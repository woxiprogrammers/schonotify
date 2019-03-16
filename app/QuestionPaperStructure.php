<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionPaperStructure extends Model
{
    protected $table = 'question_paper_structure';

    protected $fillable = ['question_paper_id','question_id','question','marks','parent_question_id'];
}
