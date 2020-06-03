<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfStyleAttrMapping extends Model
{

	  protected $table = "manf_style_attr_mapping";
      protected $primaryKey	= 'entity_id';
      protected $fillable 	= ['style_no','style_entity_id','attribute_id','attribute_val','attribute_val_id','created_by'];


   public static function getStyleAttr($style_no){
   	 return array(1,23,3);
   }
   public function attributes(){
      return $this->hasMany('App\Model\ManfAttributeMaster', 'entity_id', 'attribute_id');
   }
}