<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('manf_vendor_master', function (Blueprint $table) {
            $table->increments('entity_id');
            $table->string('vendor_name');
            $table->string('vendor_mobile');
            $table->string('vendor_email');
            $table->integer('vendor_city_id');
            $table->string('contact_person');
            $table->string('status');
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
            Schema::dropIfExists('manf_vendor_master');

    }
}