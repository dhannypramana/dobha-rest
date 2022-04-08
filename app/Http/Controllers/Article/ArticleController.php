<?php

namespace App\Http\Controllers\Article;

use Exception;
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
    public function index()
    {
        // $article = Article::get();

        // Pagination
        $article = Article::paginate(4);
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
            'image' => 'file|image|mimes:jpg,jpeg,png|unique:articles',
        ]);

        $imageName = "";

        if($request->has('image')){
            $extension      = $request->file('image')->extension();
            $imgName        = time() . date('dmyHis') . rand() . '.' . $extension;

            Storage::putFileAs('images', $request->file('image'), $imgName);
        }

        $article = Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => Str::slug($request->title),
            'excerpt' => Helpers::generateExcerpt($request->body),
            'image' => $request->image
            // 'image' => $imageName
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

        $article->update([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => Str::slug($request->title),
            'excerpt' => Helpers::generateExcerpt($request->body),
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
}
