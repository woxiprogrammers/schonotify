<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = "folders";

    protected $fillable = ['name','is_active','body_id'];
}
