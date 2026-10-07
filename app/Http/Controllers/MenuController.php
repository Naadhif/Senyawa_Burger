<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index()
    {
        // Get all unique categories
        $kategoriList = Menu::select('Kategori')
            ->where('status_tersedia', true)
            ->distinct()
            ->pluck('Kategori')
            ->toArray();

        // Get menus and group them by Kategori
        $menus = Menu::where('status_tersedia', true)
            ->get()
            ->groupBy('Kategori');

        return view('Menu', compact('kategoriList', 'menus'));
    }

    public function detail($id_menu)
    {
        $menu = Menu::with('bahan')->findOrFail($id_menu);
        return view('Detail_Menu', compact('menu'));
    }

    public function keranjang()
    {
        return view('Keranjang');
    }

    public function pembayaran()
    {
        return view('Pembayaran');
    }
}
