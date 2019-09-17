<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManfMaterialStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('manf_material_stocks', function (Blueprint $table) {
            $table->increments('entity_id');
            $table->integer('material_id');
            $table->integer('required_qty');
            $table->string('qty_left_order');
            $table->string('qty_left_stock');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manf_material_stocks');
    }
}
