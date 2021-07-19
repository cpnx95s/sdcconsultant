<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class BaseHelper
{

    public static function provinces()
    {
        return DB::table('provinces')->get();
    }

    public static function provinces2()
    {
        return DB::table('provinces')->get();
    }

}