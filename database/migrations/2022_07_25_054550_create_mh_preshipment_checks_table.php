<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMhPreshipmentChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mh_preshipment_checks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fkControlNo')->nullable();
            $table->string('Master_CartonNo')->nullable();
            $table->string('ItemNo')->nullable();
            $table->string('PONo')->nullable();
            $table->string('Partscode')->nullable();
            $table->string('DeviceName')->nullable();
            $table->string('LotNo')->nullable();
            $table->string('Qty')->nullable();
            $table->string('PackageCategory')->nullable();
            $table->string('PackageQty')->nullable();
            $table->string('status')->nullable();
            // $table->string('WeighedBy');
            // $table->string('PackedBy');
            // $table->string('Remarks');
            // $table->string('Username');
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
        Schema::dropIfExists('mh_preshipment_checks');
    }
}
