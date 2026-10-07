<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokBahan;

class StokBahanController extends Controller
{
    public function index()
    {
        $bahanRaw = StokBahan::all();
        
        $bahan = $bahanRaw->map(function($item) {
            return [
                'id' => $item->id_bahan,
                'nama' => $item->nama_bahan,
                'jumlah' => $item->jumlah_stok,
                'satuan' => $item->satuan,
            ];
        });

        $satuans = StokBahan::select('satuan')->distinct()->whereNotNull('satuan')->pluck('satuan');

        // Jika tabel kosong, berikan satuan default
        if ($satuans->isEmpty()) {
            $satuans = collect(['pcs', 'kg', 'liter', 'gram', 'botol', 'pak']);
        }

        return view('Owner.Daftar_bahan', compact('bahan', 'satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        $bahan = StokBahan::create([
            'nama_bahan' => strtoupper($request->nama),
            'jumlah_stok' => $request->jumlah,
            'satuan' => strtolower($request->satuan),
        ]);

        return response()->json([
            'success' => true, 
            'message' => 'Bahan berhasil ditambahkan.',
            'data' => [
                'id' => $bahan->id_bahan,
                'nama' => $bahan->nama_bahan,
                'jumlah' => $bahan->jumlah_stok,
                'satuan' => $bahan->satuan,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:50',
        ]);

        $bahan = StokBahan::findOrFail($id);
        $bahan->update([
            'nama_bahan' => strtoupper($request->nama),
            'jumlah_stok' => $request->jumlah,
            'satuan' => strtolower($request->satuan),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bahan berhasil diperbarui.',
            'data' => [
                'id' => $bahan->id_bahan,
                'nama' => $bahan->nama_bahan,
                'jumlah' => $bahan->jumlah_stok,
                'satuan' => $bahan->satuan,
            ]
        ]);
    }

    public function destroy($id)
    {
        $bahan = StokBahan::findOrFail($id);
        $bahan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bahan berhasil dihapus.'
        ]);
    }
}
