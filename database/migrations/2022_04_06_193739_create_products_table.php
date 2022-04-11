<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('kode_produk')->unique();
            $table->string('nama_produk')->unique();
            $table->string('slug_produk')->unique();
            $table->text('deskripsi_produk');
            $table->string('gambar_produk')->nullable();
            $table->integer('stock_produk');
            $table->integer('harga_satuan');
            $table->float('rating_produk')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
