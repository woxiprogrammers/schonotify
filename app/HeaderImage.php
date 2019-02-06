<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderImage extends Model
{
    protected $table = 'header_image';

    protected $fillable = ['body_id','image_name','is_active'];
}
