<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'slug_produk',
        'deskripsi_produk',
        'gambar_produk',
        'stock_produk',
        'harga_satuan',
        'rating_produk'
    ];
}
