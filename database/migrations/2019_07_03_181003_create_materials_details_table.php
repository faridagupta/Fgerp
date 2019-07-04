<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
    {
        //
         Schema::create('manf_materials_details',function(Blueprint $table){
          $table->increments('entity_id');
          $table->string('material_code');
          $table->string('material_type');
          $table->string('composition');
          $table->string('color');
          $table->string('test_report');
          $table->string('material_img');
          $table->string('material_name');
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
        //
        Schema::dropIfExists('manf_materials_details');
    }
}
