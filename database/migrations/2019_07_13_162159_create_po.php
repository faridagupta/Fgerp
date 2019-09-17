<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         //
        Schema::create('manf_generate_po',function(Blueprint $table){
          $table->increments('entity_id');
          $table->date('order_date');
          $table->string('payment_term');
          $table->date('delivery_date');
          $table->string('delivery_address');
          $table->string('vendor_name');
          $table->string('material_type');
          $table->string('purchase_material');
          $table->string('item_description');
          $table->string('contact_person');
          $table->string('account_person');
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
        Schema::dropIfExists('manf_generate_po');
    }
}
