<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ManfStoryMaster extends Model
{
    //
    protected $table = "manf_story_master";

    static function getStoryName(){

		$story = ManfStoryMaster::select('entity_id','story_name')
        ->get();
        $data = array();
        if (!empty($story)) {
            foreach ($story as $value) {
                $data['story_name'][$value['entity_id']] = $value['story_name'];
            }
        }

        return $data;
    }
}
