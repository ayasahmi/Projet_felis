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
        Schema::create('visite_datas', function (Blueprint $table) {
            $table->id('ImageID');
            $table->binary('url_image');
            $table->string('type_data', 50);
            $table->dateTime('date_image');
            $table->string('facing', 50);
            $table->integer('stock');
            $table->string('position_rack', 50);
            $table->unsignedBigInteger('VisiteID');
            $table->unsignedBigInteger('UtilisateurID');
            $table->unsignedBigInteger('pointeID')->nullable();
            $table->unsignedBigInteger('PromotionID')->nullable();
            $table->unsignedBigInteger('ProduitID')->nullable();
            $table->foreign('VisiteID')->references('VisiteID')->on('visites');
            $table->foreign('UtilisateurID')->references('UtilisateurID')->on('utilisateurs');
            $table->foreign('pointeID')->references('pointeID')->on('point_de_ventes');
            $table->foreign('PromotionID')->references('PromotionID')->on('promotions');
            $table->foreign('ProduitID')->references('ProduitID')->on('produits');
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
