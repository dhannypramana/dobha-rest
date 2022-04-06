<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::paginate(2);
        return new ProductCollection($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|min:3|max:12|unique:products,kode_produk',
            'nama_produk' => 'required|min:3|max:255|unique:products,nama_produk',
            'deskripsi_produk' => 'required',
            'stock_produk' => 'required',
            'harga_satuan' => 'required',
        ]);

        /* Image Handling Logic Goes Here */
        /* Image Handling Logic Goes Here */

        $product = Product::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'slug_produk' => Str::slug($request->nama_produk),
            'deskripsi_produk' => $request->deskripsi_produk,
            'stock_produk' => $request->stock_produk,
            'harga_satuan' => $request->harga_satuan,
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'kode_produk' => 'required|min:3|max:12',
            'nama_produk' => 'required|min:3|max:255',
            'deskripsi_produk' => 'required',
            'stock_produk' => 'required',
            'harga_satuan' => 'required',
        ]);

        $product->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'slug_produk' => Str::slug($request->nama_produk),
            'deskripsi_produk' => $request->deskripsi_produk,
            'stock_produk' => $request->stock_produk,
            'harga_satuan' => $request->harga_satuan,
            'rating_produk' => $product->rating_produk
        ]);

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => 'success delete product'
        ]);
    }
}
