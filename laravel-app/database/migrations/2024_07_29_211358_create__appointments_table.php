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
        Schema::create('appointments', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('physician_id');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->string('reason', 512);
            $table->string('status', 255)->default('Scheduled');

            $table->foreign('patient_id')->references('id')->on('users');
            $table->foreign('physician_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
