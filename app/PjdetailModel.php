<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PjdetailModel extends Model
{
    protected $table = 'tb_pjdetail';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'codename', 'pjname', 'cusname', 'pjtype', 'status', 'sort', 'created', 'updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}


