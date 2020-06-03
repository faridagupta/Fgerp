<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
class ManfProductStyleBom extends Model
{
    //
    protected $table = "manf_bom_master";
    static function getBomId(){
 
	   $id = DB::getPdo()->lastInsertId();
 	   return $id;
	}
	static function getBomName(){

		$bom = ManfProductStyleBom::select('entity_id','bom')
        ->get();
        $data = array();
        if (!empty($bom)) {
            foreach ($bom as $value) {
                //$data['entity_id'][] = $value['entity_id'];
                $data[$value['entity_id']] = $value['bom'];
            }
        }

        return $data;
	}
}
