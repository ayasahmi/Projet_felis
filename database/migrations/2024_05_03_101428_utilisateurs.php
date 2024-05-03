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
        Schema::create('utilisateur', function (Blueprint $table) {
            $table->id('UtilisateurID');
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->string('mail', 60)->unique();
            $table->string('password');
            $table->string('phone', 50)->nullable();
            $table->string('role', 50);
            $table->string('photo_user')->nullable();
            $table->integer('Nbr_users')->nullable();
            $table->string('type_souscription', 50)->nullable();
            $table->string('nomentreprise', 50)->nullable();
            $table->string('adresse', 50)->nullable();
            $table->string('ville', 50)->nullable();
            $table->date('date_creation')->nullable();
            $table->string('statut_activation', 50)->nullable();
            $table->date('date_expiration')->nullable();
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
