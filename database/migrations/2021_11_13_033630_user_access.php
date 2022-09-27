<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_access', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rapidx_id');
            $table->string('email')->nullable();
            $table->string('access_level');
            $table->string('department')->nullable();
            // $table->string('position')->nullable();
            $table->bigInteger('approver')->default(0)->comment = "0-not approver, 1-approver";
            $table->bigInteger('authorize')->default(0)->comment = "0-Unauthorize, 1-authorize";
            $table->bigInteger('logdel')->default(0)->comment = '0-Active, 1-Deleted';
            $table->string('created_by')->nullable();
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
    }
}
