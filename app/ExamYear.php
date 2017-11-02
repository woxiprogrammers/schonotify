<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamYear extends Model
{
    protected $table = "exam_year";

    protected $fillable = array('start_year','end_year','exam_structure_id');
}
