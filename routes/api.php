<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Product\ReviewController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Auth\User\LoginController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\Auth\User\LogoutController;
use App\Http\Controllers\Auth\Admin\DeleteController;
use App\Http\Controllers\Auth\Admin\UpdateController;
use App\Http\Controllers\Auth\User\RegisterController;
use App\Http\Controllers\Auth\Admin\DashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Auth\User\UpdateController as UserUpdateController;
// use App\Http\Controllers\VerificationController;
use App\Http\Controllers\Auth\Admin\LogoutController as AdminLogoutController;
use App\Http\Controllers\Auth\Admin\RegisterController as AdminRegisterController;
use App\Http\Controllers\UpdatePasswordController;

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
        Route::post('/update-alamat/{user:username}', UserUpdateController::class)->middleware('verified');
        Route::post('/update-photo/{user:username}', [UserUpdateController::class, 'update_photo']);
        Route::post('/update-user/{user:username}', [UserUpdateController::class, 'update_user'])->middleware('verified');
        Route::post('/logout', LogoutController::class)->middleware('auth:api');
    });
    // Admin Authentication
    Route::prefix('/admin')->group(function () {
        Route::get('/read-all-admin', [AdminController::class, 'index'])->middleware('is_super_admin');
        Route::get('/read-admin/{admin:username}', [AdminController::class, 'show'])->middleware('is_super_admin');
        Route::get('/dashboard-data', DashboardController::class)->middleware('auth:admins-api');

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
Route::resource('article-category', CategoryController::class)->except(['edit', 'create']);
Route::resource('product-category', ProductCategoryController::class)->except(['edit', 'create']);

Route::get('/read-all-article-paginate', [ArticleController::class, 'paginate']);
Route::get('/read-all-article', [ArticleController::class, 'index']);
Route::get('/read-article/{article:slug}', [ArticleController::class, 'show']);
Route::get('/related-articles/{category_id}', [ArticleController::class, 'show_related']);
Route::get('/related-products/{category_id}', [ProductController::class, 'show_related']);

Route::get('/read-all-product-paginate', [ArticleController::class, 'paginate']);
Route::get('/read-all-product', [ProductController::class, 'index']);
Route::get('/read-product/{slug}', [ProductController::class, 'show']);

Route::get('/newest-products', [HomeController::class, 'newest_products']); 
Route::get('/newest-articles', [HomeController::class, 'newest_articles']); 
Route::get('/popular-products', [ProductController::class, 'show_popular']);

Route::get('/sort/newest-products', [HomeController::class, 'sort_newest_products']); 
Route::get('/sort/popular-products', [ProductController::class, 'sort_show_popular']);

Route::get('/search/{keyword}', SearchController::class);

// Transaction API
Route::post('/is-buyed-confirm/{product_id}/{buyed_total}', [ProductController::class, 'confirm_invent']);

// Verify Email API
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
Route::get('/email/resend/{id}', [VerificationController::class, 'resend'])->middleware(['auth:api'])->name('verification.resend');

// Forgot Password API
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot_password']); // get $request->email
Route::post('/reset-password', [ForgotPasswordController::class, 'reset_password']);
Route::get('/form-reset-password/{token}', [ForgotPasswordController::class, 'form_reset_password']);
// Route::get('/form-reset-password/{token}', [UpdatePasswordController::class, 'update_form']);


// Get Data User
Route::get('/user/{id}', [UserController::class, 'show']);