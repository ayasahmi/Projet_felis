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
        Schema::create('historique', function (Blueprint $table) {
            $table->id('HistoriqueID');
            $table->string('champ_modifie', 50);
            $table->string('type_modification', 50);
            $table->date('date_modif');
            $table->unsignedBigInteger('UtilisateurID');
            $table->foreign('UtilisateurID')->references('UtilisateurID')->on('utilisateur');
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
