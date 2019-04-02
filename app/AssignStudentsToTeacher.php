<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignStudentsToTeacher extends Model
{
    protected $table = 'exam_students_to_teacher';

    protected $fillable = ['exam_id','teacher_id','student_id','role_id'];
}
