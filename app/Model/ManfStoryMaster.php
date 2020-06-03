<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ManfStoryMaster extends Model
{
    //
        use SoftDeletes;

    protected $table = "manf_story_master";
    protected $softDelete = true;
    

    static function getStoryName(){

		$story = ManfStoryMaster::select('entity_id','story_name')
        ->get();
        $data = array();
        if (!empty($story)) {
            foreach ($story as $value) {
                $data[$value['entity_id']] = $value['story_name'];
            }
        }

        return $data;
    }

    public function styleDetails(){
        return $this->hasMany('App\Model\ManfProductStyle', 'story_id','entity_id');
    }
}
