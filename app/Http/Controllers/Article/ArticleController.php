<?php

namespace App\Http\Controllers\Article;

use Exception;
use App\Models\Product;
use App\Helpers\Helpers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Article\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ArticleCollection;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginate()
    {
        // $article = Article::get();

        // Pagination
        $article = Article::orderBy('updated_at', 'desc')->paginate(4);
        return new ArticleCollection($article);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $article = Article::get();
        return new ArticleCollection($article);
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
            'title' => 'required|min:3|max:255',
            'body' => 'required',
            'image' => 'file|image|mimes:jpg,jpeg,png|unique:articles|max:1024',
            'category_id' => 'required'
        ]);

        
        $imgName = "";
        $image = "";

        if($request->has('image')){
            $extension      = $request->file('image')->extension();
            $imgName        = time() . date('dmyHis') . rand() . '.' . $extension;

            Storage::disk('google')->putFileAs('', $request->file('image'), $imgName);
            $image = Storage::disk('google')->url($imgName);
        }

        $article = Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
            'excerpt' => Helpers::generateExcerpt($request->body),
            'image' => $image,
        ]);

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Article $article, Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
            'body' => 'required',
        ]);

        $imgName = "";
        $image = "";

        if($request->has('image')){
            $request->validate([
                'image' => 'file|image|mimes:jpg,jpeg,png|unique:articles|max:1024',
            ]);
            
            $extension      = $request->file('image')->extension();
            $imgName        = time() . date('dmyHis') . rand() . '.' . $extension;

            Storage::disk('google')->putFileAs('', $request->file('image'), $imgName);
            $image = Storage::disk('google')->url($imgName);

            $article->update([
                'image' => $image
            ]);
        }

        $article->update([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => Str::slug($request->title),
            'excerpt' => Helpers::generateExcerpt($request->body),
            'category_id' => $request->category_id,
        ]);

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return response()->json([
            'success' => 'success delete article'
        ]);
    }

    public function show_related($category_id)
    {
        $related_articles = Article::where('category_id', $category_id)
                            ->limit(3)
                            ->get();

        return response()->json([
            'message' => 'get related articles',
            'data' => $related_articles
        ]);
    }
}
