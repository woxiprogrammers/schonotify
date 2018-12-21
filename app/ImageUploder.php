<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageUploder extends Model
{
   protected $table = "image_uploder";

   protected $fillable =['body_id','image_name'];
}
