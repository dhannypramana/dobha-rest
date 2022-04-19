<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Exception;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = ProductCategory::get();
        return new ProductCategoryResource($category);
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
            'name' => 'required'
        ]);

        try {
            $category = ProductCategory::create([
                'name' => $request->name
            ]);

            return new ProductCategoryResource($category);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'error' => 'error '.$e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = ProductCategory::findOrFail($id);
        return new ProductCategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required'
        ]);

        try {
            $category->update([
                'name' => $request->name
            ]);

            return new ProductCategoryResource($category);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'error' => 'error ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);
        try {
            $category->delete();
            
            return response()->json([
                'status' => 'success delete category'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'error' => 'error '.$e->getMessage()
            ]);
        }
    }
}
