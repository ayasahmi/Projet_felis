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
        Schema::create('histo_pointage', function (Blueprint $table) {
            $table->unsignedBigInteger('PointageID');
            $table->unsignedBigInteger('HistoriqueID');
            $table->foreign('PointageID')->references('PointageID')->on('pointages');
            $table->foreign('HistoriqueID')->references('HistoriqueID')->on('historiques');
            $table->primary(['PointageID', 'HistoriqueID']);
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
