<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
	protected $table = "delivery_address";
    const created_at = 'creation_date';
    const updated_at = 'last_update';
}
