<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    protected $table = 'tb_setting';
    protected $primaryKey = 'id';
    protected $fillable = ['id','comment','detail','image','sort','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
