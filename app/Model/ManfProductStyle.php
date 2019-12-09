<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfProductStyle extends Model
{
    protected $table = "manf_product_style";

    // static function getStyle()
    // {
    //   $style = ManfProductStyle::select('entity_id','style_id')
    //     ->get();
    //     $data = array();
    
    //     if (!empty($style)) {
    //         foreach ($style as $value) {
    //             //$data['entity_id'][] = $value['entity_id'];
    //             $data['style_number'][$value['entity_id']] = $value['style_id'];
    //         }
    //     }

    //     return $data;
    // } 
}
