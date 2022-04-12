<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Product\ReviewController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Auth\Admin\DashboardController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Auth\Admin\DeleteController;
use App\Http\Controllers\Auth\Admin\UpdateController;

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
        Route::get('/read-all-admin', [AdminController::class, 'index'])->middleware('is_super_admin');
        Route::get('/read-admin/{admin:username}', [AdminController::class, 'show'])->middleware('is_super_admin');
        Route::get('/dashboard-data', DashboardController::class)->middleware('is_super_admin');

        Route::post('/register', 'App\Http\Controllers\Auth\Admin\RegisterController')->middleware('is_super_admin');
        Route::post('/login', 'App\Http\Controllers\Auth\Admin\LoginController')->middleware('guest:admins-api');
        Route::post('/logout', 'App\Http\Controllers\Auth\Admin\LogoutController')->middleware('auth:admins-api');
        Route::post('/delete/{admin:username}', DeleteController::class)->middleware('is_super_admin');
        Route::post('/update/{admin:username}', UpdateController::class)->middleware('is_super_admin');
    });
});

// Accessible Admin Auth
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

// Accessible Auth User
Route::prefix('/product')->middleware('auth:api')->group(function () {
    Route::post('/review-product/{product:slug_produk}', ReviewController::class);
});

// Accessible non Auth
Route::get('/read-all-article-paginate', [ArticleController::class, 'paginate']);
Route::get('/read-all-article', [ArticleController::class, 'index']);
Route::get('/read-article/{article:slug}', [ArticleController::class, 'show']);

Route::get('/read-all-product-paginate', [ArticleController::class, 'paginate']);
Route::get('/read-all-product', [ProductController::class, 'index']);
Route::get('/read-product/{slug}', [ProductController::class, 'show']);