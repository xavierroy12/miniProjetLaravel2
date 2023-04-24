<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_roles_users');
            $table->bigInteger('id_role')->unsigned();
            $table->bigInteger('id_user')->unsigned();
           });
           Schema::table('roles_users', function (Blueprint $table) {
            $table->foreign('id_role')->references('id_role')->on('roles');
            $table->foreign('id_user')->references('id')->on('users');
           });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_users');
    }
};
