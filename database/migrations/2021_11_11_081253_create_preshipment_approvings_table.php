<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreshipmentApprovingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preshipment_approvings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fk_preshipment_id')->unsigned();
            $table->bigInteger('status')->dafault(0)->comment = '0-Approval of PPS-WHS, 1-Approval of TS/CN WHS, 2-Approval of WHS Supervisor';
            $table->string('send_to')->nullable();
            // $table->bigInteger('mh_noted_status')->default(0)->comment = '0-dNone, 1-Checking, 2-Checked';
            // $table->string('MH_noter')->nullable();
            // $table->bigInteger('from_whse_status')->default(0)->comment = '0-dNone, 1-Checking, 2-Checked';
            $table->string('from_whse_noter')->nullable();
            // $table->bigInteger('to_whse_status')->default(0)->comment = '0-dNone, 1-Checking, 2-Checked';
            $table->string('to_whse_noter')->nullable();
            // $table->bigInteger('whse_superior_status')->default(0)->comment = '0-dNone, 1-Checking, 2-Checked';
            $table->string('whse_superior_noter')->nullable();
            $table->bigInteger('logdel')->default(0)->comment = '0-Active, 1-Deleted';
            $table->timestamps();

            $table->foreign('fk_preshipment_id')->references('id')->on('preshipments');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preshipment_approvings');
    }
}
