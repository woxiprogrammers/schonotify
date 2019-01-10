<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PageSliderImages extends Model
{
    protected $table = 'page_slider_images';

    protected $fillable = ['body_tab_name_id','name','message_1','message_2','hyper_name','hyper_link','priority','is_active'];
}
