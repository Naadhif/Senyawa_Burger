<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    public $timestamps = false; // No created_at or updated_at in migration

    protected $fillable = [
        'nama_menu',
        'harga',
        'foto',
        'Kategori',
        'status_tersedia',
    ];

    public function bahan()
    {
        return $this->belongsToMany(StokBahan::class, 'menu_bahan', 'id_menu', 'id_bahan')
                    ->withPivot('jumlah_digunakan');
    }
}
