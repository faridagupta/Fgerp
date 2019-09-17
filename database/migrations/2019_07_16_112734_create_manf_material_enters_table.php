<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManfMaterialEntersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
        Schema::create('manf_material_enters', function (Blueprint $table) {
            $table->increments('entity_id');
            $table->integer('po_id');
            $table->integer('material_code');
            $table->string('qty_order');
            $table->string('qty_recived');
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
        Schema::dropIfExists('manf_material_enters');
    }
}
