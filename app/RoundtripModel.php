<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoundtripModel extends Model
{
    protected $table = 'tb_roundtrip';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','sort','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}


