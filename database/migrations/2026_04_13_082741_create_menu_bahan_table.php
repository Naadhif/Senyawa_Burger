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
        Schema::create('menu_bahan', function (Blueprint $table) {
            $table->integer('id_menu');
            $table->integer('id_bahan')->index('fk_menubahan_bahan');
            $table->decimal('jumlah_digunakan', 10);

            $table->primary(['id_menu', 'id_bahan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_bahan');
    }
};
