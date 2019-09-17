<?php

namespace App;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;
class vendor extends Model
{

	/*protected $table = 'manf_vendor_master';
	public $timestamps = false;
    */
    static function addVendor($request){
    	    print_r($request->input());exit;
    	 // DB::table('manf_vendor_master')->insert($request->input());
    	  return true;
    }
}
