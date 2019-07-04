<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::create('manf_vendor_docs', function (Blueprint $table) {
            $table->increments('entity_id');
            $table->string('vendor_name');
            $table->integer('vendor_id');
            $table->string('aggreement');
            $table->integer('scanned_cheque');
            $table->string('nda');
            $table->string('custom1');
            $table->string('custom2');
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
            Schema::dropIfExists('manf_vendor_docs');

    }
}
