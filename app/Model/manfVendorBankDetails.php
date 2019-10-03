<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class manfVendorBankDetails extends Model
{
     protected $table = 'manf_vendor_bank_details';

	static function addBankDetails($data){
 	   DB::table('manf_vendor_bank_details')->insert($data);
 	   return true;
	}
}
