<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfStyleAttrValues extends Model
{

  protected $table = "manf_style_attr_values";
  protected $primaryKey = 'entity_id';

   public function parent(){

      return $this->belongsTo('App\Model\ManfStyleAttrValues', 'attribute_entity_id');

  }

  

 }