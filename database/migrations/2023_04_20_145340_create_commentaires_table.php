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
        Schema::create('commentaires', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id_commentaire');
            $table->bigInteger('id_utilisateur')->unsigned();
            $table->bigInteger('id_produit')->unsigned();
            $table->string('telephone');
            $table->string('sujet');
            $table->boolean('question');
            $table->string('message');
            $table->timestamps();
        });
        Schema::table('commentaires', function (Blueprint $table) {
            $table->foreign('id_utilisateur')->references('id')->on('users');
            $table->foreign('id_produit')->references('id_produit')->on('produits');
        });

    }

    /**
    * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commentaires');
    }
};
