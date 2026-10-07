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
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->integer('id_detail', true);
            $table->integer('id_pesanan')->index('idx_detail_pesanan');
            $table->integer('id_menu')->index('idx_detail_menu');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_satuan', 10);
            $table->text('kustomisasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
