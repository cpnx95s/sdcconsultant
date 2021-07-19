<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PjtypeModel extends Model
{
    protected $table = 'tb_pjtype';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','sort','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}


