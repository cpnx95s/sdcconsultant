<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TsptypeModel extends Model
{
    protected $table = 'tb_tsptype';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','status','sort','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}


