<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeModel extends Model
{
    protected $table = 'tb_home';
    protected $primaryKey = 'id';
    protected $fillable = ['id','type','title_th','titll_en','caption_th','caption_en','detail_th','detail_en','created','updated'];
    protected $timestamp = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
}
