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
        Schema::create('visite', function (Blueprint $table) {
            $table->id('VisiteID');
            $table->string('statut', 50);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->dateTime('date_planifiee');
            $table->integer('num_semaines');
            $table->string('nom_journée', 50);
            $table->char('annee', 4);
            $table->unsignedBigInteger('UtilisateurID');
            $table->unsignedBigInteger('pointeID');
            $table->foreign('UtilisateurID')->references('UtilisateurID')->on('utilisateurs');
            $table->foreign('pointeID')->references('pointeID')->on('point_de_ventes');
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
