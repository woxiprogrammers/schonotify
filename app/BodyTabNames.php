<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyTabNames extends Model
{
    protected $table = 'body_tab_names';

    protected $fillable =['display_name','slug','body_tab_name_id','priority','is_active','body_id','link'];
}
