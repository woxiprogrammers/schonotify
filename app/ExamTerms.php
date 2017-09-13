<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTerms extends Model
{
    protected $table = "exam_terms";

    protected $fillable = array('term_name','exam_structure_id');
}
