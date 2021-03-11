<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PjnameModel extends Model
{
    protected $table = 'tb_pjname';
    protected $primaryKey = 'id';
    protected $fillable = ['id','name','pjtype','sort','status','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
    public function showpjtypename(){
        return $this->hasOne(PjtypeModel::class,'id','pjtype');
        //return $this->belongsTo(PjnameModel::class, 'id');
    }

}


