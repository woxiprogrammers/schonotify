<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyContactUsUserForm extends Model
{
    protected $table = "body_contact_us_user_form";

    protected $fillable = ['body_id','name','slug','is_active'];
}
