<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvalidDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invalid_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->BigInteger('rapid_preshipment_id');
            $table->string('authorize_id_no');
            $table->string('remarks');
            $table->string('invalid_on');
            $table->string('logdel')->default(0);
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
        Schema::dropIfExists('invalid_details');
    }
}
