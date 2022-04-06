<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Product\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->group(function () {
    // User Authentication
    Route::prefix('/user')->group(function () {
        Route::post('/register', 'App\Http\Controllers\Auth\User\RegisterController')->middleware('guest:api');
        Route::post('/login', 'App\Http\Controllers\Auth\User\LoginController')->middleware('guest:api');
        Route::post('/update/{user:username}', 'App\Http\Controllers\Auth\User\UpdateController')->middleware('auth:api');
        Route::post('/logout', 'App\Http\Controllers\Auth\User\LogoutController')->middleware('auth:api');
    });
    // Admin Authentication
    Route::prefix('/admin')->group(function () {
        Route::post('/read-all-admin', [AdminController::class, 'index'])->middleware('is_super_admin');
        Route::post('/register', 'App\Http\Controllers\Auth\Admin\RegisterController')->middleware('is_super_admin');
        Route::post('/login', 'App\Http\Controllers\Auth\Admin\LoginController')->middleware('guest:admins-api');
        Route::post('/logout', 'App\Http\Controllers\Auth\Admin\LogoutController')->middleware('auth:admins-api');
    });
});

Route::prefix('/article')->middleware('auth:admins-api')->group(function () {
    Route::post('/create-new-article', [ArticleController::class, 'store']);
    Route::post('/update-article/{article:slug}', [ArticleController::class, 'update']);
    Route::post('/delete-article/{article:slug}', [ArticleController::class, 'destroy']);
});

Route::prefix('/product')->middleware('auth:admins-api')->group(function () {
    Route::post('/create-new-product', [ProductController::class, 'store']);
    Route::post('/update-product/{product:slug_produk}', [ProductController::class, 'update']);
    Route::post('/delete-product/{product:slug_produk}', [ProductController::class, 'destroy']);
});

// Accessible non Auth
Route::post('/read-all-article', [ArticleController::class, 'index']);
Route::post('/read-article-by-slug/{article:slug}', [ArticleController::class, 'show']);

Route::post('/read-all-product', [ProductController::class, 'index']);
Route::post('/read-product-by-slug/{product:slug_produk}', [ProductController::class, 'show']);