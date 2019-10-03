<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class ManfProductStyleBom extends Model
{
    //
    protected $table = "manf_product_style_bom";
    static function getBomId(){
 
	   $id = DB::getPdo()->lastInsertId();
 	   return $id;
	}
}
