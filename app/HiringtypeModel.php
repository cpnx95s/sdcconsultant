<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HiringtypeModel extends Model
{
    protected $table = 'tb_hiringtype';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','sort','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}


