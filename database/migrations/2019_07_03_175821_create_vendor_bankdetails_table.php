<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorBankdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::create('manf_vendor_bank_details',function(Blueprint $table){
          $table->increments('entity_id');
          $table->integer('vendor_id');
          $table->integer('bank_id');
          $table->integer('branch_name');
          $table->string('bank_account_no');
          $table->string('branch_code');
          $table->string('swift_code');
          $table->string('payment_type');
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
        Schema::dropIfExists('manf_vendor_bank_details');
    }
}