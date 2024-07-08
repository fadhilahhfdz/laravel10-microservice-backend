<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    use HasFormatRupiah;

    protected $fillable = [
        'kode',
        'nama',
        'harga',
    ];

    protected $guarded = [];

    // public function DetailTransaksi() {
    //     return $this->hasMany(DetailTransaksi::class);
    // }

    // public function Kasir() {
    //     return $this->hasMany(Kasir::class, 'id_produk', 'id');
    // }
}
