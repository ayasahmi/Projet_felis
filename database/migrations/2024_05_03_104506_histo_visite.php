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
        Schema::create('histo_visite', function (Blueprint $table) {
            $table->unsignedBigInteger('VisiteID');
            $table->unsignedBigInteger('HistoriqueID');
            $table->foreign('VisiteID')->references('VisiteID')->on('visites');
            $table->foreign('HistoriqueID')->references('HistoriqueID')->on('historiques');
            $table->primary(['VisiteID', 'HistoriqueID']);
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
