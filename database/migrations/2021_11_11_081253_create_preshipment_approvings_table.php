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
            $table->bigInteger('status')->dafault(0)->comment = '0-Approval of PPS-WHS, 1-Approval of TS/CN WHS, 2-Uploading of TS/CN WHSE, 3-Approval of WHS Supervisor, 4-approved by supervisor(internal), 5-approved by QC(external), 6-PPS-CN WHSE to receive, 7- pps cn received';
            $table->bigInteger('is_invalid')->default(0)->comment = '0-not invalid, 1-has invalid';
            $table->bigInteger('qc_checker')->nullable();
            $table->string('qc_checker_date_time')->nullable();
            $table->bigInteger('checked_by')->nullable();
            $table->string('send_to')->nullable();
            // $table->bigInteger('mh_noted_status')->default(0)->comment = '0-dNone, 1-Checking, 2-Checked';
            // $table->string('MH_noter')->nullable();
            // $table->bigInteger('from_whse_status')->default(0)->comment = '0-dNone, 1-Checking, 2-Checked';
            $table->string('from_whse_noter')->nullable();
            $table->string('from_whse_noter_date_time')->nullable();
            // $table->bigInteger('to_whse_status')->default(0)->comment = '0-dNone, 1-Checking, 2-Checked';
            $table->string('to_whse_noter')->nullable();
            $table->string('to_whse_noter_date_time')->nullable();
            $table->string('whse_uploader')->nullable();
            $table->string('whse_uploader_date_time')->nullable();
            // $table->bigInteger('whse_superior_status')->default(0)->comment = '0-dNone, 1-Checking, 2-Checked';
            $table->string('whse_superior_noter')->nullable();
            $table->string('whse_superior_noter_date_time')->nullable();

            $table->string('rapid_invoice_number')->nullable();
            $table->string('wbs_receiving_number')->nullable();



            $table->string('remarks')->nullable();
            $table->string('disapproved_by')->nullable()->comment = "who disapproved";

            
            $table->bigInteger('logdel')->default(0)->comment = '0-Active, 1-Deleted';
            $table->bigInteger('has_invalid')->default(0)->comment = '0-not invalid, 1-has invalid';
            $table->timestamps();

            // $table->foreign('fk_preshipment_id')->references('id')->on('preshipments');



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
