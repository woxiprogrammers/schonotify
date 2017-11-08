<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table ='grade';

    protected $fillable = ['class_id','min','max','grade'];
}
