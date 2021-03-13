<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckplanModel extends Model
{
    protected $table = 'tb_truckplan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'startdate', 'routecode', 'routename', 'trucknumb', 'driver', 'telnumb', 'sbranch', 'dntbranch', 'truckrqtime', 'dpttime', 'dnttime', 'totalhour', 'mntstaff', 'remark', 'statusplan', 'ccremark', 'author', 'editor', 'created', 'updated', 'sort', 'status', 'trucktype', 'roundtrip', 'cusname', 'splname', 'tsptype', 'pjname', 'worktype', 'hiringtype'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;

    public function getDateFormat()
    {
         return 'Y-m-d H:i:s.u';
    }

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

    public function showtsptypename(){
        return $this->hasOne(TsptypeModel::class,'id','tsptype');
        //return $this->belongsTo(PjnameModel::class, 'id');
    }

    public function showtrucktypename(){
        return $this->hasOne(TrucktypeModel::class,'id','trucktype');
        //return $this->belongsTo(PjnameModel::class, 'id');
    }

    public function showroundtripname(){
        return $this->hasOne(RoundtripModel::class,'id','roundtrip');
        //return $this->belongsTo(PjnameModel::class, 'id');
    }

    public function showhiringtypename(){
        return $this->hasOne(HiringtypeModel::class,'id','hiringtype');
        //return $this->belongsTo(PjnameModel::class, 'id');
    }

    public function showsplname(){
        return $this->hasOne(SplnameModel::class,'id','splname');
        //return $this->belongsTo(PjnameModel::class, 'id');
    }
}


