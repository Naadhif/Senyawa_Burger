<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBahan extends Model
{
    use HasFactory;

    protected $table = 'stok_bahan';
    protected $primaryKey = 'id_bahan';
    public $timestamps = false;

    protected $fillable = [
        'nama_bahan',
        'jumlah_stok',
        'satuan',
    ];
}
