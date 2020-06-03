<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfBomMaterial extends Model
{
    protected $table = 'manf_bom_materials'; 
  	protected $primaryKey = 'entity_id';


    public static function getMaterialDetails($bom = ""){
    	
    }

    public function children()
	{
	    return $this->hasOne('App\Model\ManfMaterialDetail', 'entity_id', 'material_id');
	}
	public function parent()
	{
	    return $this->belongsTo('App\Model\ManfBomMaterial', 'material_id');
	}

}
