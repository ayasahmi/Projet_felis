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
        Schema::create('point_de_vente', function (Blueprint $table) {
            $table->id('pointeID');
            $table->string('Nom', 50);
            $table->string('ville', 50);
            $table->string('Adresse', 50);
            $table->decimal('localisation_long', 15, 2);
            $table->decimal('localisation_lat', 15, 2);
            $table->string('NomEnseigne', 50);
            $table->string('telephone', 50);
            $table->string('email', 50);
            $table->boolean('coche_par_admin');
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
