<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodySliderImages extends Model
{
    protected $table = 'body_slider_images';

    protected $fillable = ['body_id','name','is_active','message_1','message_2','hyper_name','hyper_link'];
}
