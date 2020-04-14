<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfPoDetail extends Model
{
    protected $table = "manf_po_details";


    static function getPoDetails($poID){
        
       $poId = ManfPoDetail::select('material_code','qty')->where('po_master','=', $poID)->get();
       $data = array();

       foreach ($poId as $key => $value) {
         $data[] = array("material_code" => $value['material_code'],
                "qty" => $value['qty']);
       }
       
       return $data;
    }

}
