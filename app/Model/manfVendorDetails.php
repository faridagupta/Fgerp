<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class manfVendorDetails extends Model
{
    protected $table = 'manf_vendor_details';

	static function addVendorDetails($data){
 	   DB::table('manf_vendor_details')->insert($data);
	   $id = DB::getPdo()->lastInsertId();
 	   return $id;
	}

	/*public function op()
    {
        return $this->hasOne('App\model\manfVendorMaster', 'entity_id');
    }*/
}
