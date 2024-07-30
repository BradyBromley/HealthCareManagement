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
        Schema::create('Availability', function (Blueprint $table)
        {
            $table->increments('ID');
            $table->unsignedInteger('physicianID');
            $table->time('availableTime')->default('00:00:00');

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
        Schema::dropIfExists('Availability');
    }
};
