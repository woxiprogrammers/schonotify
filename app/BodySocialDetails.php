<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodySocialDetails extends Model
{
    protected $table = "body_social_details";

    protected $fillable = ['body_id','social_platform_id','name','is_active'];
}
