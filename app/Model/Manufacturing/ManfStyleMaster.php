<?php

namespace App\Model\Manufacturing;

use Illuminate\Database\Eloquent\Model;

class ManfStyleMaster extends Model
{
    protected $table = "manf_style_master";
    protected $primaryKey = 'entity_id';
    protected $fillable = ['style_no', 'style_type','created_by'];


     static function getStyle()
    {
      $style = ManfStyleMaster::select('entity_id','style_no')
        ->get();
        $data = array();
    
        if (!empty($style)) {
            foreach ($style as $value) {
                //$data['entity_id'][] = $value['entity_id'];
                $data['style_no'][$value['entity_id']] = $value['style_no'];
            }
        }

        return $data;
    } 
}
