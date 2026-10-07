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
        Schema::table('menu_bahan', function (Blueprint $table) {
            $table->foreign(['id_bahan'], 'fk_menubahan_bahan')->references(['id_bahan'])->on('stok_bahan')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_menu'], 'fk_menubahan_menu')->references(['id_menu'])->on('menu')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_bahan', function (Blueprint $table) {
            $table->dropForeign('fk_menubahan_bahan');
            $table->dropForeign('fk_menubahan_menu');
        });
    }
};
