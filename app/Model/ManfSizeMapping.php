<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfSizeMapping extends Model
{
    protected $table = 'manf_style_sizes_maping';
    protected $primaryKey = 'entity_id';
    protected $fillable = ['style_no', 'state_entity_id','size_id','size','planned_qty','planned_ratio','sku','created_by','updated_by'];

    public static function getStylesSize($style_no=""){
      $size = ManfSizeMapping::select('size_id','size','planned_qty')->where('style_no',$style_no)->get();
      $data = array();
      foreach ($size as $key => $value) {
      	 $data[] = $value;
      }
      return $data;
    }
}
