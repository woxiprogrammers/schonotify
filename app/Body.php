<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Body extends Model
{
    protected $table = 'bodies';

    protected $fillable = ['name'];
}
