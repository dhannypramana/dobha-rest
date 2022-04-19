<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function newest_products()
    {
        try {
            $products = Product::orderBy('created_at', 'DESC')->limit(4)->get();

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

    public function sort_newest_products()
    {
        try {
            $products = Product::orderBy('created_at', 'DESC')->paginate(5);

            return response()->json([
                'message' => 'newest products with paginate(5)',
                'data' => $products
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
    
    public function newest_articles()
    {
        try {
            $articles = Article::orderBy('created_at', 'DESC')->limit(3)->get();

            return response()->json([
                'message' => 'success',
                'data' => $articles
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
