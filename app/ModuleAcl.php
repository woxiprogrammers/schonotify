<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleAcl extends Model
{
    protected $table = "module_acls";

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
