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
        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->foreign(['id_menu'], 'fk_detail_menu')->references(['id_menu'])->on('menu')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['id_pesanan'], 'fk_detail_pesanan')->references(['id_pesanan'])->on('pesanan')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_pesanan', function (Blueprint $table) {
            $table->dropForeign('fk_detail_menu');
            $table->dropForeign('fk_detail_pesanan');
        });
    }
};
