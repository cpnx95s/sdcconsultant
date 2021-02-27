<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactModel extends Model
{
    protected $table = 'tb_contact';
    protected $primaryKey = 'id';
    protected $fillable = ['id','company_name','address','tel','fax','facebook','twitter','email','line','map','sort','image','created','updated'];
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';
    public $timedtamp = false;
}
