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
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->integer('id_laporan', true);
            $table->integer('id_user')->index('idx_laporan_user');
            $table->enum('tipe_periode', ['harian', 'mingguan', 'bulanan', 'tahunan']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->decimal('total_pendapatan', 15)->default(0);
            $table->decimal('total_transaksi', 15)->default(0);
            $table->integer('jumlah_pesanan')->default(0);
            $table->integer('total_terjual')->default(0);
            $table->timestamp('generated_at')->useCurrent();

            $table->index(['tanggal_mulai', 'tanggal_selesai'], 'idx_laporan_periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_keuangan');
    }
};
