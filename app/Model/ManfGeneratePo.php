<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ManfGeneratePo extends Model
{
    protected $table = "manf_purchase_order";

    static function getPoId(){
 
	   $id = DB::getPdo()->lastInsertId();
 	   return $id;
	}
}
