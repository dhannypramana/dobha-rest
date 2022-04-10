<?php

namespace App\Http\Controllers\Product;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
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

        return new ReviewResource($review);
    }
}
