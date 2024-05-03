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
        Schema::create('histo_ptvente', function (Blueprint $table) {
            $table->unsignedBigInteger('pointeID');
            $table->unsignedBigInteger('HistoriqueID');
            $table->foreign('pointeID')->references('pointeID')->on('point_de_ventes');
            $table->foreign('HistoriqueID')->references('HistoriqueID')->on('historiques');
            $table->primary(['pointeID', 'HistoriqueID']);
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
