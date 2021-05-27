<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SplnameModel extends Model
{
    protected $table = 'tb_splname';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','score','sort','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
    
}


