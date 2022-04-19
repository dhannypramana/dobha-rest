<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'kode_produk' => 'AAA-12',
            'nama_produk' => 'Aqua Halvana',
            'slug_produk' => 'aqua-halvana',
            'deskripsi_produk' => 'lorem ipsum dolor sit amet',
            'stock_produk' => '12',
            'harga_satuan' => '45000',
            'product_category_id' => 1
        ]);
        Product::create([
            'kode_produk' => 'BNB-12',
            'nama_produk' => 'Dobha Dalal',
            'slug_produk' => 'dobha-dalal',
            'deskripsi_produk' => 'lorem ipsum dolor sit amet',
            'stock_produk' => '12',
            'harga_satuan' => '45000',
            'product_category_id' => 1
        ]);
        Product::create([
            'kode_produk' => 'CCC-12',
            'nama_produk' => 'Dobha Hamr',
            'slug_produk' => 'dobha-hamr',
            'deskripsi_produk' => 'lorem ipsum dolor sit amet',
            'stock_produk' => '12',
            'harga_satuan' => '45000',
            'product_category_id' => 2
        ]);
    }
}
