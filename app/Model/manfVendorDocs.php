<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class manfVendorDocs extends Model
{
     protected $table = 'manf_vendor_docs';

	static function addVendorDocs($data){
 	   DB::table('manf_vendor_docs')->insert($data);
 	   return true;
 	}
}