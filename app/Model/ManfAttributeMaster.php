<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfAttributeMaster extends Model
{

  protected $table = "manf_attribute_master";
  protected $primaryKey = 'entity_id';


	public function children()
	{
	    return $this->hasMany('App\Model\ManfStyleAttrValues', 'attribute_entity_id', 'entity_id');
	}
	public function parent()
	{
	    return $this->belongsTo('App\Model\ManfAttributeMaster', 'entity_id');
	}


 }