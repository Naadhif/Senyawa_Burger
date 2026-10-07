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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->integer('id_pesanan', true);
            $table->integer('total_pesanan');
            $table->decimal('total_harga', 12)->default(0);
            $table->string('no_telepon', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nama', 100);
            $table->enum('tipe_order', ['dine_in', 'take_away', 'delivery'])->default('dine_in');
            $table->text('catatan')->nullable();
            $table->enum('status_pembayaran', ['Lunas', 'Belum Lunas']);
            $table->string('status_pesanan')->default('Proses');
            $table->string('payment_reference')->nullable();
            $table->timestamp('created_at')->useCurrent()->index('idx_pesanan_created');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
