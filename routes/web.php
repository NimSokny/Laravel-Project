<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.auth.login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/auth/token-login', [AuthController::class, 'tokenLogin'])->name('auth.token.login');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategoryController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('products', ProductController::class);
        Route::resource('orders', OrderController::class)->except(['create', 'store']);
        Route::resource('users', UserController::class);

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    });
});
