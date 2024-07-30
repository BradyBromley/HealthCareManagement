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
        Schema::create('Users', function (Blueprint $table)
        {
            $table->increments('ID');
            $table->string('email', 255)->unique();
            $table->string('passwordHash', 255);
            $table->string('firstName', 255);
            $table->string('lastName', 255);
            $table->string('address', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->integer('roleID');
            $table->boolean('isActive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Users');
    }
};
