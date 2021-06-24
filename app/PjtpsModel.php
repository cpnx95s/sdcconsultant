<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PjnameModel extends Model
{
    protected $table = 'tb_pjname-pjtype';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'pjname_id ', 'tsptype_id '];
    public $timestamp = false;



}



