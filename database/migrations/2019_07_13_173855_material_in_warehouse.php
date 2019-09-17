<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MaterialInWarehouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('manf_material_in_warehouse', function (Blueprint $table) {
            $table->increments('entity_id');
            $table->string('po_id');
            $table->string('invoice_no');
            $table->string('challan_no');
            $table->integer('received_date');
            $table->string('attach_invoce');
            $table->string('other');
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
            Schema::dropIfExists('manf_material_in_warehouse');

    }
}
