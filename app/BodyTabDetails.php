<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyTabDetails extends Model
{
    protected $table = "body_tab_details";

    protected $fillable = ['body_tab_name_id','description'];
}
