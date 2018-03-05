<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryManagement extends Model
{
    protected $table = "gallery_management";

    protected $fillable = ['folder_id','name','type'];
}
