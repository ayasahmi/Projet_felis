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
        Schema::create('pointage', function (Blueprint $table) {
            $table->id('PointageID');
            $table->double('localisation_long');
            $table->double('localisation_lat');
            $table->integer('tolerance');
            $table->boolean('presence');
            $table->string('retard', 50);
            $table->date('date_arrivee');
            $table->date('date_depart');
            $table->unsignedBigInteger('UtilisateurID');
            $table->foreign('UtilisateurID')->references('UtilisateurID')->on('utilisateurs');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
