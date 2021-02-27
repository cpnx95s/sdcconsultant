<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutModel extends Model
{
    protected $table = 'tb_about';
    protected $primaryKey = 'id';
    protected $fillable = ['id','detail','short_detail','word','image','company_name','status','sort','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}


