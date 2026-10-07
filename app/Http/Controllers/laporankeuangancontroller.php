<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $tipe    = $request->input('tipe_periode', 'harian');
        $dari    = $request->input('dari');
        $sampai  = $request->input('sampai');

        $query = DB::table('laporan_keuangan');

        if ($tipe !== 'semua') {
            $query->where('tipe_periode', $tipe);
        }

        if ($dari) {
            $query->where('tanggal_mulai', '>=', $dari);
        }

        if ($sampai) {
            $query->where('tanggal_selesai', '<=', $sampai);
        }

        $laporanList = $query->orderBy('tanggal_mulai', 'desc')->get();

        // Summary Cards — agregasi dari hasil query
        $summary = [
            'total_pendapatan' => $laporanList->sum('total_pendapatan'),
            'total_transaksi'  => $laporanList->sum('total_transaksi'),
            'jumlah_pesanan'   => $laporanList->sum('jumlah_pesanan'),
            'total_terjual'    => $laporanList->sum('total_terjual'),
        ];

        // Data untuk chart (maks 12 titik, urut dari terlama)
        $chartData = $laporanList->sortBy('tanggal_mulai')->take(12)->map(function ($row) {
            return [
                'label'      => \Carbon\Carbon::parse($row->tanggal_mulai)->format('d/m'),
                'pendapatan' => (float) $row->total_pendapatan,
                'pesanan'    => (int)   $row->jumlah_pesanan,
            ];
        })->values();

        // Format list untuk tabel
        $laporan = $laporanList->map(function ($row) {
            return [
                'id'               => $row->id_laporan,
                'tipe'             => ucfirst($row->tipe_periode),
                'dari'             => \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M Y'),
                'sampai'           => \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y'),
                'total_pendapatan' => (float) $row->total_pendapatan,
                'total_transaksi'  => (int)   $row->total_transaksi,
                'jumlah_pesanan'   => (int)   $row->jumlah_pesanan,
                'total_terjual'    => (int)   $row->total_terjual,
                'generated_at'     => \Carbon\Carbon::parse($row->generated_at)->format('d M Y H:i'),
            ];
        })->values()->toArray();

        return view('Owner.Laporan', compact(
            'laporan', 'summary', 'chartData', 'tipe', 'dari', 'sampai'
        ));
    }
}