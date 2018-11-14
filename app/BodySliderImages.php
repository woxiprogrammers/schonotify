<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodySliderImages extends Model
{
    protected $table = 'body_slider_images';

    protected $fillable = ['body_id','name','is_active'];
}
