<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Pesanan;

class HapusPesananBelumLunas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id_pesanan;

    /**
     * Create a new job instance.
     */
    public function __construct($id_pesanan)
    {
        $this->id_pesanan = $id_pesanan;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Cari data pesanan berdasarkan ID
        $pesanan = Pesanan::find($this->id_pesanan);

        // Jika pesanan ada dan statusnya masih "Belum Lunas"
        if ($pesanan && $pesanan->status_pembayaran === 'Belum Lunas') {
            
            // Hapus detail pesanan terlebih dahulu (untuk menghindari error foreign key)
            $pesanan->detailPesanan()->delete(); 
            
            // Hapus data pesanan utama
            $pesanan->delete();
        }
    }
}