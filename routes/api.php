<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WishlistController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/logout',   [AuthController::class, 'logout'])
        ->middleware('auth:sanctum');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile',       [AuthController::class, 'profile']);
        Route::put('/profile',       [AuthController::class, 'updateProfile']);
    });

    Route::post('/admin-session', [AuthController::class, 'createAdminSession'])
        ->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart',        [CartController::class, 'index']);
    Route::post('/cart',       [CartController::class, 'store']);
    Route::put('/cart/{itemId}', [CartController::class, 'update']);
    Route::delete('/cart/{itemId}', [CartController::class, 'destroy']);

    Route::get('/wishlist',         [WishlistController::class, 'index']);
    Route::post('/wishlist',        [WishlistController::class, 'store']);
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy']);

    Route::get('/orders',         [OrderController::class, 'index']);
    Route::post('/orders',        [OrderController::class, 'store']);
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/featured', [ProductController::class, 'featured']);
    Route::get('/categories', [ProductController::class, 'categories']);
    Route::get('/brands', [ProductController::class, 'brands']);
    Route::get('/{slug}', [ProductController::class, 'show']);
});

Route::get('/home/featured', [HomeController::class, 'featured']);
Route::get('/home/latest',   [HomeController::class, 'latest']);
Route::get('/home/categories', [HomeController::class, 'categories']);
Route::get('/home/hero',     [HomeController::class, 'hero']);

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/user', [AuthController::class, 'adminUser']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});
