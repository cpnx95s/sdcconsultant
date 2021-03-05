<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SplperfModel extends Model
{
    protected $table = 'tb_splperf';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','performance','status','sort','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}


