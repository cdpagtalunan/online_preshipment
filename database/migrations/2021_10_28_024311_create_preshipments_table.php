<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreshipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preshipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rapid_preshipment_id');
            $table->string('date');
            $table->string('station');
            $table->string('packing_list_ctrlNo');
            $table->string('Shipment_date');
            $table->string('Destination');
            $table->string('Usename');
            $table->string('qc_approver');
            $table->string('logdel')->default(0)->comment = '0-active, 1-deleted';
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
        Schema::dropIfExists('preshipments');
    }
}
