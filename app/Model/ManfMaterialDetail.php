<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ManfBomMaterial;

class ManfMaterialDetail extends Model
{
    //
    protected $table = 'manf_materials_details';

    static function getMaterialNameType(){
		$story = ManfMaterialDetail::select('entity_id','material_code','material_type')
        ->get();
        $data = array();
        $data['material_type'] = array();
        if (!empty($story)) {
            foreach ($story as $value) {
                $data['material_code'][$value['entity_id']] = $value['material_code'];
                if(!in_array($value['material_type'],$data['material_type']))
                $data['material_type'][] = $value['material_type'];
            }
        }

        return $data;
    }

    static function getMaterialNames(){

    	$mtname = ManfMaterialDetail::select('material_name')->distinct()
        ->get();
        $data = array();
        $data['material_name'] = array();
        if (!empty($mtname)) {
            foreach ($mtname as $value) {
                $data['material_name'][] = $value['material_name'];
            }
        }

        return $data;
    }

    static function getMaterialCompositions(){

    	$mtname = ManfMaterialDetail::select('composition')->distinct()
        ->get();
        $data = array();
        $data['composition'] = array();
        if (!empty($mtname)) {
            foreach ($mtname as $value) {
                $data['composition'][] = $value['composition'];
            }
        }

        return $data;
    }

    static function getMaterialQty($materialID){
     $rqr_Material = ManfBomMaterial::selectRaw('sum(material_qty) as total_qty')-> where('material_id','=', $materialID)
     ->get();

        $data = array();
        if (!empty($rqr_Material)) {
            foreach ($rqr_Material as $value) {
                $data = $value['total_qty'];
            }
        }

     return $data;
    }

    static function getMaterialDetail($vendorID){

     	$mtdeatails = ManfMaterialDetail::select('material_id','material_name','material_code','material_type','rate','measuring_type')
     	              ->whereRaw("vendor = $vendorID")->distinct()
                      ->get();
        $data = array();

        if (!empty($mtdeatails)) {
            foreach ($mtdeatails as $value) {
                $data['material_detail'][$value['material_type']][] = array("material_name" => $value['material_name'],
                "material_id" => $value['material_id'], "material_code" => $value['material_code'], "rate" => $value['rate'], "measuring_type" => $value['measuring_type']);
               /* $data['material_code'][]   = $value['material_code'];
                $data['material_type'][]   = $value['material_type'];*/
            }
        }

        return $data;
    }
}
