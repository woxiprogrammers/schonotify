<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = "modules";

    public function moduleAcl()
    {
        return $this->belongsTo('App\ModuleAcl','id');

    }
}
