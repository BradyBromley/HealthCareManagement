<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Appointments', function (Blueprint $table)
        {
            $table->increments('ID');
            $table->unsignedInteger('patientID');
            $table->unsignedInteger('physicianID');
            $table->dateTime('startTime');
            $table->dateTime('endTime');
            $table->string('reason', 512);
            $table->string('status', 255)->default('Scheduled');

            $table->foreign('patientID')->references('ID')->on('Users');
            $table->foreign('physicianID')->references('ID')->on('Users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Appointments');
    }
};
