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


	 static function getPoLists(){
 
	   $poId = ManfGeneratePo::select('po_id')->get();
       $data = array();

       foreach ($poId as $key => $value) {
         $data[] = $value['po_id'];
       }
	   
 	   return $data;
	}
		static function getlatestPoID(){
 
	   $poId = ManfGeneratePo::select('po_id')->orderBy('created_at','DESC')->first();	   
 	   return $poId->po_id;
	}

	

}
