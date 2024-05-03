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
        Schema::create('produit', function (Blueprint $table) {
            $table->id('ProduitID');
            $table->string('designation', 50);
            $table->double('prix_unitaire');
            $table->string('description', 50);
            $table->double('prix_renseigne');
            $table->string('categorie', 50);
            $table->string('famille', 50);
            $table->string('sous_famille', 50);
            $table->string('sous_sous_famille', 50);
            $table->date('date_validite');
            $table->unsignedBigInteger('PlanoID')->nullable();
            $table->foreign('PlanoID')->references('PlanoID')->on('planogrammes');
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
