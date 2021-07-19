<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GchartModel extends Model
{
    protected $table = 'tb_gchart';
    protected $primaryKey = 'id';
    protected $fillable = ['id','created','on_process','full_fill'] ;
    public $timestamp = false;
}

