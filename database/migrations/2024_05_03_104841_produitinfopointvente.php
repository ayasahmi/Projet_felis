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
        Schema::create('produitinfopointvente', function (Blueprint $table) {
            $table->unsignedBigInteger('pointeID');
            $table->unsignedBigInteger('ProduitID');
            $table->string('facing', 50);
            $table->string('position_etagere', 50);
            $table->string('espace_etagere', 50);
            $table->string('espace_produit', 50);
            $table->string('shelf_sharing', 50);
            $table->integer('qte_stock_reserv');
            $table->integer('qte_stock_picking');
            $table->integer('qte_stock_min');
            $table->integer('qte_stock_max');
            $table->date('date_entree_stock');
            $table->foreign('pointeID')->references('pointeID')->on('point_de_ventes');
            $table->foreign('ProduitID')->references('ProduitID')->on('produits');
            $table->primary(['pointeID', 'ProduitID']);
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
