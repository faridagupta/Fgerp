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
	static function getBomName(){

		$bom = ManfProductStyleBom::select('entity_id','bom')
        ->get();
        $data = array();
        if (!empty($bom)) {
            foreach ($bom as $value) {
                //$data['entity_id'][] = $value['entity_id'];
                $data['bom'][$value['entity_id']] = $value['bom'];
            }
        }

        return $data;
	}
}
