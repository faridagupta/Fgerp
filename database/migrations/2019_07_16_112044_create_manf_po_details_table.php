<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManfPoDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {      
        Schema::create('manf_po_details', function (Blueprint $table) {
            $table->increments('entity_id');
            $table->integer('po_id');
            $table->string('material_name');
            $table->string('material_code');
            $table->string('qty');
            $table->string('unit_price');
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
        Schema::dropIfExists('manf_po_details');
    }
}
