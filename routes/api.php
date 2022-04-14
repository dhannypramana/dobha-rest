<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Product\ReviewController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Auth\Admin\DeleteController;
use App\Http\Controllers\Auth\Admin\UpdateController;
use App\Http\Controllers\Auth\Admin\DashboardController;
use App\Http\Controllers\Auth\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Auth\Admin\LogoutController as AdminLogoutController;
use App\Http\Controllers\Auth\Admin\RegisterController as AdminRegisterController;
use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Auth\User\LogoutController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\Auth\User\UpdateController as UserUpdateController;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
// use App\Http\Controllers\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
        Route::post('/register', RegisterController::class)->middleware('guest:api');
        Route::post('/login', LoginController::class)->middleware('guest:api');
        Route::post('/update/{user:username}', UserUpdateController::class)->middleware('auth:api');
        Route::post('/logout', LogoutController::class)->middleware('auth:api');        
    });
    // Admin Authentication
    Route::prefix('/admin')->group(function () {
        Route::get('/read-all-admin', [AdminController::class, 'index'])->middleware('is_super_admin');
        Route::get('/read-admin/{admin:username}', [AdminController::class, 'show'])->middleware('is_super_admin');
        Route::get('/dashboard-data', DashboardController::class)->middleware('is_super_admin');


        Route::post('/register', AdminRegisterController::class)->middleware('is_super_admin');
        Route::post('/login', AdminLoginController::class)->middleware('guest:admins-api');
        Route::post('/logout', AdminLogoutController::class)->middleware('auth:admins-api');
        Route::post('/delete/{admin:username}', DeleteController::class)->middleware('is_super_admin');
        Route::post('/update/{admin:username}', UpdateController::class)->middleware('is_super_admin');
        
        Route::post('/delete-review/{product_id}/{review_id}', [ReviewController::class, 'destroy'])->middleware('auth:admins-api');
        Route::post('/reply-review/{product_id}/{review_id}', [AdminController::class, 'reply_review'])->middleware('auth:admins-api');
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
Route::prefix('/product')->middleware(['auth:api', 'verified'])->group(function () {
    Route::post('/review-product/{product_id}/{user_id}', ReviewController::class);
    Route::post('/update-review/{product_id}/{review_id}/{user_id}', [ReviewController::class, 'update']);
});

// Accessible non Auth
Route::get('/read-all-article-paginate', [ArticleController::class, 'paginate']);
Route::get('/read-all-article', [ArticleController::class, 'index']);
Route::get('/read-article/{article:slug}', [ArticleController::class, 'show']);

Route::get('/read-all-product-paginate', [ArticleController::class, 'paginate']);
Route::get('/read-all-product', [ProductController::class, 'index']);
Route::get('/read-product/{slug}', [ProductController::class, 'show']);

// Home API
Route::get('/newest-products', [HomeController::class, 'newest_products']); 
Route::get('/newest-articles', [HomeController::class, 'newest_articles']); 
Route::get('/popular-products', [ProductController::class, 'show_popular']);

// Transaction API
Route::post('/is-buyed-confirm/{product_id}/{buyed_total}', [ProductController::class, 'confirm_invent']);

// Verify Email API
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::find($id);

    abort_if(!$user, 403);
    abort_if(!hash_equals($hash, sha1($user->getEmailForVerification())), 403);

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return response()->json([
        'message' => 'email telah di verifikasi'
    ], 200);
})->middleware(['signed'])->name('verification.verify');