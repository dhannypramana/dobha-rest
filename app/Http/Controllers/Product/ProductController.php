<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Exception;

class ProductController extends Controller
{
    public function index()
    {
        $article = Product::get();
        return new ProductCollection($article);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        $product = Product::paginate(4);
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
            'gambar_produk' => 'file|image|mimes:jpg,jpeg,png|unique:products',
        ]);

        $imgName = "";

        if($request->has('gambar_produk')){
            $extension      = $request->file('gambar_produk')->extension();
            $imgName        = time() . date('dmyHis') . rand() . '.' . $extension;

            Storage::putFileAs('images', $request->file('gambar_produk'), $imgName);
        }

        $product = Product::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'slug_produk' => Str::slug($request->nama_produk),
            'deskripsi_produk' => $request->deskripsi_produk,
            'stock_produk' => $request->stock_produk,
            'harga_satuan' => $request->harga_satuan,
            'gambar_produk' => $request->gambar_produk
            // 'gambar_produk' => $imgName
        ]);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $products = Product::where('slug_produk', $slug)->with('review.user')->first();

        return new ProductResource($products);
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

    public function show_popular()
    {
        try {
            $products = Product::orderBy('rating_produk', 'DESC')->limit(4)->get();
            
            return response()->json([
                'message' => 'success',
                'data' => $products
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
