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
        Schema::create('criteres_clients', function (Blueprint $table) {
            $table->id('id_critere');
            $table->boolean('facing');
            $table->boolean('prix');
            $table->boolean('stock');
            $table->boolean('position_prod');
            $table->boolean('shelf_sharing');
            $table->boolean('conformite_plano');
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
