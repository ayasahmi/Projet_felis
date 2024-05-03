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
        Schema::create('histo_promo', function (Blueprint $table) {
            $table->unsignedBigInteger('PromotionID');
            $table->unsignedBigInteger('HistoriqueID');
            $table->foreign('PromotionID')->references('PromotionID')->on('promotions');
            $table->foreign('HistoriqueID')->references('HistoriqueID')->on('historiques');
            $table->primary(['PromotionID', 'HistoriqueID']);
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
