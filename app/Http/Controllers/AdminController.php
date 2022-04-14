<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\ReviewResource;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admins-api');
    }

    public function index()
    {
        $admin = Admin::whereNotIn('id', [auth('admins-api')->id(1)])->get();

        return response()->json([
            'message' => 'success',
            'admin' => $admin
        ]);
    }

    public function show(Admin $admin)
    {
        return response()->json([
            'message' => 'success',
            'admin' => $admin
        ]);
    }

    public function reply_review($product_id, $review_id, Request $request)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $review = Review::create([
            'parent_id' => $review_id,
            'body' => $request->body,
            'product_id' => $product_id,
            'user_id' => 0
        ]);

        return new ReviewResource($review);
    }
}
