<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreshipmentListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preshipment_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fkControlNo')->unsigned();
            $table->string('Master_CartonNo');
            $table->string('ItemNo');
            $table->string('PONo');
            $table->string('Partscode');
            $table->string('DeviceName');
            $table->string('LotNo');
            $table->string('Qty');
            $table->string('PackageCategory');
            $table->string('PackageQty');
            $table->string('WeighedBy');
            $table->string('PackedBy');
            $table->string('Remarks');
            $table->string('Username');
            $table->string('logdel')->default(0)->comment = '0-active, 1-deleted';
            $table->timestamps();


            $table->foreign('fkControlNo')->references('id')->on('preshipments');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preshipment_lists');
    }
}
