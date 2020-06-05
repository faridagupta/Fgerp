<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ManfStyleMaster extends Model
{
        use SoftDeletes;

  	protected $table = "manf_style_master";
    protected $primaryKey = 'entity_id';
    protected $fillable = ['style_no', 'style_type','created_by'];
    protected $softDelete = true;


     static function getStyle()
    {
      $style = ManfStyleMaster::select('entity_id','style_no','style_type')
        ->get();
        $data = array();
    
        if (!empty($style)) {
            foreach ($style as $value) {
                //$data['entity_id'][] = $value['entity_id'];
                $data[]=array('style_entity_id'=>$value['entity_id'],'style_no' => $value['style_no'],'style_type'=>$value['style_type']);
            }
        }

        return $data;
    } 

    public function children()
	{
	    return $this->hasOne('App\Model\ManfProductStyle', 'style_entity_id', 'entity_id');
	}
	public function parent()
	{
	    return $this->belongsTo('App\Model\ManfStyleMaster', 'entity_id');
	}

    public function production_plan()
    {
        return $this->hasMany('App\Model\ManfStyleProductionDetails', 'style_entity_id', 'entity_id');
    }
}
