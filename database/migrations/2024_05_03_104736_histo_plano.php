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
        Schema::create('histo_plano', function (Blueprint $table) {
            $table->unsignedBigInteger('PlanoID');
            $table->unsignedBigInteger('HistoriqueID');
            $table->foreign('PlanoID')->references('PlanoID')->on('planogrammes');
            $table->foreign('HistoriqueID')->references('HistoriqueID')->on('historiques');
            $table->primary(['PlanoID', 'HistoriqueID']);
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
