<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlideModel extends Model
{
    protected $table = 'tb_slide';
    protected $fillable = ['id','name','image','status','sort','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
