<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfProductStyle extends Model
{
    protected $table        = "manf_product_style";
    protected $primaryKey   = 'entity_id';
    protected $fillable     = ['style_no', 'style_entity_id','style_type','created_by','style_name','bom_id','story_id','story_no','bom_no','updated_by','category','sub_category','description'];
           

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
        $style = ManfProductStyle::select('entity_id','style_entity_id','total_qty', 'started_at', 'bom_id', 'story_id')
        ->get();
         $data = array();
    
        if (!empty($style)) {
            foreach ($style as $value) {
                //$data['entity_id'][] = $value['entity_id'];
                $styleID = $value['entity_id'];
                $data[$styleID]['style_number']   = $value['style_entity_id'];
                $data[$styleID]['total_qty']      = $value['total_qty'];
                $data[$styleID]['bom_id']         = $value['bom_id'];
                $data[$styleID]['story_id']       = $value['story_id'];
                $data[$styleID]['status']         = "Planned";
            }
        }

        return $data;
    } 
    
}
