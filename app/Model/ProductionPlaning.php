<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductionPlaning extends Model
{
    protected $table = 'manf_style_production_details';
    protected $primaryKey = 'entity_id';
    protected $fillable = ['style_no', 'state_entity_id','style_type','planned_qty','launched_date','production_month','remark','created_by'];

}
