<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodyAboutUs extends Model
{
    protected $table = 'body_about_us';

    protected $fillable = ['description','image_name','body_id'];
}
