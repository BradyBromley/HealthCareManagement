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
        Schema::create('availability_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('availability_id');
            $table->unsignedInteger('user_id');
            
            $table->foreign('availability_id')->references('id')->on('availabilities');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availability_user');
    }
};
