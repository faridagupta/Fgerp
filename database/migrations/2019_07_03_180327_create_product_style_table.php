<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('manf_product_style',function(Blueprint $table){
          $table->increments('entity_id');
          $table->string('style_number');
          $table->integer('qty_to_produce');
          $table->integer('bom_id');
          $table->integer('story_id');
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
        Schema::dropIfExists('manf_product_style');
    }
}
