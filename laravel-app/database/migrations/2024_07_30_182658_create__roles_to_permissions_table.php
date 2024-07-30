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
        Schema::create('RolesToPermissions', function (Blueprint $table) {
            $table->increments('ID');
            $table->unsignedInteger('roleID');
            $table->unsignedInteger('permissionID');

            $table->foreign('roleID')->references('ID')->on('Roles');
            $table->foreign('permissionID')->references('ID')->on('Permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RolesToPermissions');
    }
};
