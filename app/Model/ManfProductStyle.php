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

    static function getStyleLists($style =""){
      //if($style=="")
        $style = ManfProductStyle::select('entity_id','style_id','qty_to_produce', 'started_at', 'bom_id', 'story_id')
        ->get();
         $data = array();
    
        if (!empty($style)) {
            foreach ($style as $value) {
                //$data['entity_id'][] = $value['entity_id'];
                $styleID = $value['entity_id'];
                $data[$styleID]['style_number']   = $value['style_id'];
                $data[$styleID]['qty_to_produce'] = $value['qty_to_produce'];
                $data[$styleID]['bom_id']         = $value['bom_id'];
                $data[$styleID]['story_id']       = $value['story_id'];
                $data[$styleID]['status']         = "Planned";
            }
        }

        return $data;
    } 
    
}
