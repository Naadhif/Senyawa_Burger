<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class KasirController extends Controller
{
    public function antrian()
    {
        $pesanans = Pesanan::with('detailPesanan.menu')
            ->where('status_pesanan', '!=', 'Selesai')
            ->orderBy('id_pesanan', 'desc')
            ->get();
        
        $queue = $pesanans->map(function($p) {
            $menus = $p->detailPesanan->map(function($d) {
                return $d->menu ? $d->menu->nama_menu : 'Unknown';
            })->implode(', ');

            $statusStr = strtolower($p->status_pembayaran);
            
            $mappedStatus = 'belum';
            if (str_contains($statusStr, 'lunas') && !str_contains($statusStr, 'belum')) {
                $mappedStatus = 'lunas';
            } elseif (str_contains($statusStr, 'proses')) {
                $mappedStatus = 'proses';
            }

            return [
                'id' => $p->id_pesanan,
                'nama' => $p->nama,
                'jumlah' => $p->total_pesanan,
                'total' => $p->total_harga,
                'status' => $mappedStatus,
                'menu' => $menus ?: '-'
            ];
        })->values()->toArray();

        return view('Kasir.Antrian', compact('queue'));
    }

    public function detail($id)
    {
        $pesanan = Pesanan::with('detailPesanan.menu')->findOrFail($id);
        
        $orders = $pesanan->detailPesanan->map(function($d) {
            return [
                'name' => $d->menu ? $d->menu->nama_menu : 'Unknown',
                'qty' => $d->jumlah,
                'price' => $d->harga_satuan,
                'note' => $d->kustomisasi ?? ''
            ];
        })->values()->toArray();

        return view('Kasir.Detail', compact('pesanan', 'orders'));
    }

    public function selesai(Request $request, $id)
    {
        $pesanan = Pesanan::with('detailPesanan.menu.bahan')->findOrFail($id);

        if (strtolower($pesanan->status_pembayaran) != 'lunas') {
            return response()->json(['success' => false, 'message' => 'Pesanan belum lunas.']);
        }

        if ($pesanan->status_pesanan == 'Selesai') {
            return response()->json(['success' => false, 'message' => 'Pesanan sudah selesai.']);
        }

        try {
            DB::beginTransaction();

            // 1. Update status_pesanan
            $pesanan->status_pesanan = 'Selesai';
            $pesanan->save();

            // 2. Laporan Keuangan Harian
            $today = \Carbon\Carbon::today()->toDateString();
            $laporan = DB::table('laporan_keuangan')
                ->where('tipe_periode', 'harian')
                ->where('tanggal_mulai', $today)
                ->first();

            if ($laporan) {
                DB::table('laporan_keuangan')
                    ->where('id_laporan', $laporan->id_laporan)
                    ->update([
                        'total_pendapatan' => $laporan->total_pendapatan + $pesanan->total_harga,
                        'total_transaksi' => $laporan->total_transaksi + 1,
                        'jumlah_pesanan' => $laporan->jumlah_pesanan + 1,
                        'total_terjual' => $laporan->total_terjual + $pesanan->total_pesanan
                    ]);
            } else {
                DB::table('laporan_keuangan')->insert([
                    'id_user' => 1,
                    'tipe_periode' => 'harian',
                    'tanggal_mulai' => $today,
                    'tanggal_selesai' => $today,
                    'total_pendapatan' => $pesanan->total_harga,
                    'total_transaksi' => 1,
                    'jumlah_pesanan' => 1,
                    'total_terjual' => $pesanan->total_pesanan,
                    'generated_at' => now()
                ]);
            }

            // 3. Pengurangan Stok
            foreach($pesanan->detailPesanan as $detail) {
                if ($detail->menu && $detail->menu->bahan) {
                    foreach($detail->menu->bahan as $bahan) {
                        $jumlahDigunakan = $bahan->pivot->jumlah_digunakan;
                        $totalPengurangan = $jumlahDigunakan * $detail->jumlah;
                        
                        DB::table('stok_bahan')
                            ->where('id_bahan', $bahan->id_bahan)
                            ->decrement('jumlah_stok', $totalPengurangan);
                    }
                }
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pesanan berhasil diselesaikan!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function lunas($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status_pembayaran = 'Lunas';
        $pesanan->save();

        return response()->json(['success' => true, 'message' => 'Status pembayaran berhasil diubah menjadi Lunas.']);
    }

    public function unlunas($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status_pembayaran = 'Belum Lunas';
        $pesanan->save();

        return response()->json(['success' => true, 'message' => 'Status pelunasan dibatalkan.']);
    }

    public function hapus($id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::findOrFail($id);
            
            // Hapus detail pesanan terlebih dahulu (jika database tidak menggunakan onDelete cascade)
            $pesanan->detailPesanan()->delete(); 
            
            // Hapus data pesanan utama
            $pesanan->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Pesanan berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    public function cetak($id)
    {
        $pesanan = \App\Models\Pesanan::with('detailPesanan.menu')->findOrFail($id);

        // Load view PDF dan passing data pesanan
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Kasir.Struk', compact('pesanan'));
        
        // (Opsional) Mengatur ukuran kertas. 
        // A4 adalah default. Kode di bawah ini jika Anda ingin ukuran mirip struk kasir thermal (lebar ~80mm).
        // $pdf->setPaper([0, 0, 226.77, 600], 'portrait'); 

        // Stream akan membuka PDF di browser tanpa langsung men-download
        return $pdf->stream('Struk_Pesanan_#' . $pesanan->id_pesanan . '.pdf');
    }

    public function riwayat()
    {
        // Ambil data pesanan yang sudah selesai
        $pesanans = Pesanan::with('detailPesanan.menu')
            ->where('status_pesanan', '=', 'Selesai')
            ->orderBy('id_pesanan', 'desc')
            ->get();
        
        $queue = $pesanans->map(function($p) {
            $menus = $p->detailPesanan->map(function($d) {
                return $d->menu ? $d->menu->nama_menu : 'Unknown';
            })->implode(', ');

            return [
                'id' => $p->id_pesanan,
                'nama' => $p->nama,
                'jumlah' => $p->total_pesanan,
                'total' => $p->total_harga,
                'status' => 'selesai', // Status dipaksa Selesai untuk UI
                'menu' => $menus ?: '-',
                'tanggal' => $p->created_at ?? date('Y-m-d H:i:s')
            ];
        })->values()->toArray();

        return view('Kasir.Riwayat', compact('queue'));
    }

    public function detailRiwayat($id)
    {
        $pesanan = Pesanan::with('detailPesanan.menu')->findOrFail($id);
        
        $orders = $pesanan->detailPesanan->map(function($d) {
            return [
                'name' => $d->menu ? $d->menu->nama_menu : 'Unknown',
                'qty' => $d->jumlah,
                'price' => $d->harga_satuan,
                'note' => $d->kustomisasi ?? ''
            ];
        })->values()->toArray();

        // Pastikan nama file view sesuai, yaitu Kasir.Detail_riwayat
        return view('Kasir.Detail_riwayat', compact('pesanan', 'orders'));
    }
}