<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('manf_vendor_details',function(Blueprint $table){
          $table->increments('entity_id');
          $table->integer('vendor_id');
          $table->string('vendor_address');
          $table->integer('vendor_city_id');
          $table->string('vendor_mobile');
          $table->string('vendor_landline');
          $table->string('vendor_website');
          $table->string('ac_person');
          $table->string('ac_person_mobile');
          $table->string('ac_person_email');
          $table->string('gst_number');
          $table->string('pan_number');
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
         Schema::dropIfExists('manf_vendor_details');
    }
}
