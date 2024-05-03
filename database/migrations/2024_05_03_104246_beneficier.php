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
        Schema::create('beneficier', function (Blueprint $table) {
            $table->unsignedBigInteger('pointeID');
            $table->unsignedBigInteger('ProduitID');
            $table->unsignedBigInteger('PromotionID');
            $table->foreign('pointeID')->references('pointeID')->on('point_de_ventes')->onDelete('cascade');
            $table->foreign('ProduitID')->references('ProduitID')->on('produits')->onDelete('cascade');
            $table->foreign('PromotionID')->references('PromotionID')->on('promotions')->onDelete('cascade');
            $table->primary(['pointeID', 'ProduitID', 'PromotionID']);
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
