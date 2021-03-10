<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckplanModel extends Model
{
    protected $table = 'tb_truckplan';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'startdate', 'routecode', 'routename', 'trucknumb', 'driver', 'telnumb', 'sbranch', 'dntbranch', 'truckrqtime', 'dpttime', 'dnttime', 'totalhour', 'mntstaff', 'remark', 'statusplan', 'ccremark', 'author', 'editor', 'created', 'updated', 'name', 'sort', 'status', 'trucktype', 'roundtrip', 'cusname', 'splname', 'tsptype', 'pjname'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;

    public function getDateFormat()
    {
         return 'Y-m-d H:i:s.u';
    }
}


