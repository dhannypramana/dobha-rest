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
        $product = Product::get();
        return new ProductCollection($product);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate(Request $request)
    {
        if ($request->has('q')) {
            $request = strtolower($request->q);
            $product = Product::where('nama_produk', 'ILIKE', '%' . trim($request) . '%')->paginate(5)->withQueryString();
            return new ProductCollection($product);
        }

        $product = Product::orderBy('updated_at', 'desc')->paginate(5);
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
            'gambar_produk' => 'file|image|mimes:jpg,jpeg,png|unique:products|max:1024',
            'product_category_id' => 'required'
        ]);

        $imgName = "";
        $image = "";

        if($request->has('gambar_produk')){
            $extension      = $request->file('gambar_produk')->extension();
            $imgName        = time() . date('dmyHis') . rand() . '.' . $extension;

            Storage::disk('google')->putFileAs('', $request->file('gambar_produk'), $imgName);
            $image = Storage::disk('google')->url($imgName);
        }

        $product = Product::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'slug_produk' => Str::slug($request->nama_produk),
            'deskripsi_produk' => $request->deskripsi_produk,
            'stock_produk' => $request->stock_produk,
            'harga_satuan' => $request->harga_satuan,
            'product_category_id' => $request->product_category_id,
            'gambar_produk' => $image
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
            'product_category_id' => 'required'
        ]);


        $imgName = "";
        $image = "";

        if($request->has('gambar_produk')){
            $request->validate([
                'gambar_produk' => 'file|image|mimes:jpg,jpeg,png|unique:products|max:1024',
            ]);

            $extension      = $request->file('gambar_produk')->extension();
            $imgName        = time() . date('dmyHis') . rand() . '.' . $extension;

            Storage::disk('google')->putFileAs('', $request->file('gambar_produk'), $imgName);
            $image = Storage::disk('google')->url($imgName);

            $product->update([
                'gambar_produk' => $image
            ]);
        }

        $product->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'slug_produk' => Str::slug($request->nama_produk),
            'deskripsi_produk' => $request->deskripsi_produk,
            'stock_produk' => $request->stock_produk,
            'harga_satuan' => $request->harga_satuan,
            'product_category_id' => $request->product_category_id
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
        Storage::disk('google')->delete($product->gambar_produk);

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

    public function confirm_invent($product_id, $buyed_total)
    {
        try {
            $product = Product::find($product_id);
            
            if (!$product) {
                return response()->json([
                    'error' => 'no product found'
                ]);
            }

            $product->update([
                'stock_produk' => $product->stock_produk - $buyed_total
            ]);

            return response()->json([
                'message' => 'success',
                'data' => $product
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function show_related($category_id)
    {
        $related_product = Product::where('product_category_id', $category_id)
                            ->limit(5)
                            ->get();

        return response()->json([
            'message' => 'get related product',
            'data' => $related_product
        ]);
    }

    public function sort_show_popular()
    {
        try {
            $products = Product::orderBy('rating_produk', 'DESC')->paginate(5);

            return new ProductCollection($products);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
