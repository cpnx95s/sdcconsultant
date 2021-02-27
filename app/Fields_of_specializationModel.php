<?php

namespace App;
use App\Fields_categoryModel;
use Illuminate\Database\Eloquent\Model;

class Fields_of_specializationModel extends Model
{
    protected $table = 'tb_fields_of_specialization';
    protected $primaryKey = 'id';
    protected $fillable = ['id','_id','type','name','list_detail','status','sort','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timestamp = false;
}


