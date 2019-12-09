<?php

namespace App\Model\Manufacturing;

use Illuminate\Database\Eloquent\Model;

class ManfStyleMaster extends Model
{
    protected $table = "manf_style_master";

     static function getStyle()
    {
      $style = ManfStyleMaster::select('entity_id','style_number')
        ->get();
        $data = array();
    
        if (!empty($style)) {
            foreach ($style as $value) {
                //$data['entity_id'][] = $value['entity_id'];
                $data['style_number'][$value['entity_id']] = $value['style_number'];
            }
        }

        return $data;
    } 
}
