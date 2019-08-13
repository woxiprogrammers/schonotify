<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherView extends Model
{
    protected $table="teacher_views";

    protected $fillable = ['user_id','mobile_view','web_view'];
}
