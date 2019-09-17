<?php

namespace App\model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use DB;

class manfVendorMaster extends Model
{
	protected $table = 'manf_vendor_master';

	static function getvendorid(){
 
	   $id = DB::getPdo()->lastInsertId();
 	   return $id;
	}
	  public function detail()
    {
        return $this->hasOne('App\model\manfVendorDetails', 'vendor_id', 'entity_id');
    }
      public function bankdetail()
    {
        return $this->hasOne('App\model\manfVendorBankDetails', 'vendor_id', 'entity_id');
    }
       public function docs()
    {
        return $this->hasOne('App\model\manfVendorDocs', 'vendor_id', 'entity_id');
    }
     public function opParameter()
    {
        return $this->belongsTo('App\model\manfVendorDetails', 'vendor_id', 'entity_id');
    }
}
