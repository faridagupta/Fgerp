<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfMaterialEnter extends Model
{
    protected $table = "manf_material_enters";

    static function getMaterialRecived($materialIn){
    	
    	  $rqr_Material = ManfMaterialEnter::selectRaw('sum(qty_recived) as qty_recived, sum(qty_order) as qty_order')-> where('material_id','=', $materialIn) ->get();
         
         $data = array();
        if (!empty($rqr_Material)) {
            foreach ($rqr_Material as $value) {
                $data['qty_recived'] = $value['qty_recived'];
                $data['qty_order'] = $value['qty_order'];
            }
        }

     return $data;
    }
}
