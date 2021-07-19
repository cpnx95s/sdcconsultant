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

public function showpjname(){
    return $this->hasOne(PjnameModel::class,'id','pjname');
    //return $this->belongsTo(PjnameModel::class, 'id');
}

public function showcname(){
    return $this->hasOne(CusModel::class,'id','cusname');
    return $this->belongsTo(CusModel::class, 'id');
}

public function showpjtypename(){
    return $this->hasOne(PjtypeModel::class,'id','pjtype');
    //return $this->belongsTo(PjnameModel::class, 'id');
}

}


