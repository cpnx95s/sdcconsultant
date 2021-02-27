<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    protected $table = 'tb_gallery';
    protected $fillable = ['id','_id','type','image','status','sort','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;

    
}
