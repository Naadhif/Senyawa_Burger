<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false; // Migration uses ->useCurrent() for created_at, no updated_at

    protected $fillable = [
        'total_pesanan',
        'total_harga',
        'no_telepon',
        'email',
        'nama',
        'tipe_order',
        'status_pembayaran',
        'payment_reference',
        'catatan'
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
