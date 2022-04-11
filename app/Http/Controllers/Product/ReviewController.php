<?php

namespace App\Http\Controllers\Product;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    public function calculateRating($product)
    {
        // $products = Product::where('slug_produk', $slug)->get();
        $rating = 0;

        $total_review = Review::where('product_id', $product->id)->count();
        $rate_data = Review::where('product_id', $product->id)->get(['rate']);
        
        foreach ($rate_data as $rd) {
            $rating += $rd->rate;
        }

        if ($total_review == 0) {
            $rating = $rating;
        }else{
            $rating = $rating/$total_review;
        }

        $product->update([
            'rating_produk' => $rating
        ]);
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Product $product , Request $request)
    {

        $request->validate([
            'body' => 'required',
            'rate' => 'required'
        ]);

        $review = Review::create([
            'body' => $request->body,
            'rate' => $request->rate,
            'product_id' => $product->id,
            'user_id' => auth()->user()->id
        ]);

        $this->calculateRating($product);

        return new ReviewResource($review);
    }
}
