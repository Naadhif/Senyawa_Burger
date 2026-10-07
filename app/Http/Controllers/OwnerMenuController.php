<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\StokBahan;

class OwnerMenuController extends Controller
{
    public function create()
    {
        $bahanList  = StokBahan::orderBy('nama_bahan')->get(['id_bahan', 'nama_bahan', 'satuan'])->toArray();
        $categories = Menu::distinct()->pluck('Kategori')->filter()->values()->toArray();
        return view('Owner.Create_menu', compact('bahanList', 'categories'));
    }

    public function store(Request $request)
    {
        $menu = new Menu();
        $menu->nama_menu = $request->input('nama_menu');
        $menu->harga = $request->input('harga');
        $menu->Kategori = $request->input('Kategori');

        if ($request->hasFile('foto')) {
            $menu->foto = file_get_contents($request->file('foto')->getRealPath());
        }

        $menu->save();

        // Sync bahan (ingredients)
        $resepData = json_decode($request->input('resep', '[]'), true);

if (!empty($resepData)) {
    $bahanIds = [];
    foreach ($resepData as $item) {
        $bahan = \App\Models\StokBahan::where('nama_bahan', $item['nama'])->first();
        if ($bahan) {
            // Gunakan jumlah yang dinamis dari input form, bukan angka statis 1
            $bahanIds[$bahan->id_bahan] = [
                'jumlah_digunakan' => $item['jumlah'] 
            ];
        }
    }
    // Lakukan sinkronisasi ke tabel pivot resep (menu_bahan)
    $menu->bahan()->sync($bahanIds);
} else {
    $menu->bahan()->detach();
}

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan.'
        ]);
    }

    public function index()
    {
        $menusRaw = Menu::with('bahan')->get();

        $menus = $menusRaw->map(function($item) {
            return [
                'id' => $item->id_menu,
                'nama' => $item->nama_menu,
                'harga' => intval($item->harga),
                'bahan' => $item->bahan ? $item->bahan->pluck('nama_bahan')->toArray() : [],
                'kategori' => $item->Kategori,
                'status' => (bool) $item->status_tersedia,
                'foto' => $item->foto ? 'data:image/jpeg;base64,' . base64_encode($item->foto) : null,
            ];
        })->values()->toArray();

        return view('Owner.Daftar_menu', compact('menus'));
    }

    public function edit($id)
{
    $menu = Menu::with('bahan')->findOrFail($id);

    // Ambil semua kategori unik dari tabel menu untuk dropdown
    $categories = Menu::distinct()->pluck('Kategori')->filter()->toArray();

    $menuData = [
        'id' => $menu->id_menu,
        'nama' => $menu->nama_menu,
        'harga' => intval($menu->harga),
        'bahan' => $menu->bahan ? $menu->bahan->map(function($b) {
            return [
                'nama' => $b->nama_bahan,
                'jumlah' => $b->pivot->jumlah_digunakan,
                'satuan' => $b->satuan
            ];
        })->toArray() : [],
        'kategori' => $menu->Kategori,
        'status' => (bool) $menu->status_tersedia,
        'foto' => $menu->foto ? 'data:image/jpeg;base64,' . base64_encode($menu->foto) : null,
        
    ];

    $bahanList = StokBahan::orderBy('nama_bahan')->get(['id_bahan', 'nama_bahan', 'satuan'])->toArray();
    
    // Kirim variabel $categories ke view
    return view('Owner.Update_menu', [
        'menu' => $menuData, 
        'bahanList' => $bahanList, 
        'categories' => $categories
    ]);
}

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->nama_menu = $request->input('nama_menu');
        $menu->harga = $request->input('harga');

        if ($request->has('Kategori')) {
            $menu->Kategori = $request->input('Kategori');
        }

        $menu->status_tersedia = $request->input('status', 1);

        if ($request->hasFile('foto')) {
            $menu->foto = file_get_contents($request->file('foto')->getRealPath());
        }

        $menu->save();

        // Sync bahan (ingredients)
        // Ambil input resep yang dikirim dari frontend
$resepData = json_decode($request->input('resep', '[]'), true);

if (!empty($resepData)) {
    $bahanIds = [];
    foreach ($resepData as $item) {
        $bahan = \App\Models\StokBahan::where('nama_bahan', $item['nama'])->first();
        if ($bahan) {
            // Gunakan jumlah yang dinamis dari input form, bukan angka statis 1
            $bahanIds[$bahan->id_bahan] = [
                'jumlah_digunakan' => $item['jumlah'] 
            ];
        }
    }
    // Lakukan sinkronisasi ke tabel pivot resep (menu_bahan)
    $menu->bahan()->sync($bahanIds);
} else {
    $menu->bahan()->detach();
}

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Relasi pivot menu_bahan harusnya otomatis terhapus jika di-set terpisah atau memiliki on cascade, 
        // namun untuk amannya kita detach manual:
        $menu->bahan()->detach();

        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil dihapus.'
        ]);
    }
}
