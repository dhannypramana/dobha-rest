<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($keyword)
    {
        $product = Product::where('nama_produk', 'like', "%" . $keyword . "%")->get();

        return response()->json([
            'message' => 'search product data',
            'data' => $product
        ]);
    }
}
