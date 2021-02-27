<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Our_experienceModel extends Model
{
    protected $table = 'tb_our_experience';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','detail','location','project_owner','duration_f','duration_s','short_detail','image','status','sort','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}
