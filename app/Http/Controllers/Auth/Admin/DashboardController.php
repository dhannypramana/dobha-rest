<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $total_produk = Product::all()->count();
        $total_article = Article::all()->count();
        $total_admin = Admin::all()->count();
        $total_admin -= 1; // dengan asumsi superadmin tidak termasuk di dalam hitungan

        return response()->json([
            'total_produk' => $total_produk,
            'total_article' => $total_article,
            'total_admin' => $total_admin
        ]);
    }
}
