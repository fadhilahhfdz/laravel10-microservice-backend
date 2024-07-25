<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'kode',
        'nama',
        'gambar',
        'id_kategori',
        'id_satuan',
        'id_supplier',
        'harga',
        'stok',
    ];

    protected $guarded = [];

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function satuan() {
        return $this->belongsTo(Satuan::class, 'id_satuan', 'id');
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id');
    }
}
