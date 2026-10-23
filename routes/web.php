<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\EnsureRole;

Route::get('/', fn () => redirect()->route('dashboard'));

// ---- Tamu (belum login) ----
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

// ---- Harus login (admin & staff) ----
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // ---- Khusus admin (didaftarkan SEBELUM products.show agar /products/create tidak tertangkap {product}) ----
    Route::middleware(EnsureRole::class . ':admin')->group(function () {
        Route::resource('products', ProductController::class)->except(['index', 'show']);
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('suppliers', SupplierController::class)->except('show');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });

    // Admin & staff boleh melihat produk & manajemen inventaris dasar
    Route::resource('products', ProductController::class)->only(['index', 'show']);
    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('suppliers', SupplierController::class)->only(['index', 'show']);

    // Barang masuk / keluar / histori (admin & staff)
    Route::get('/stock/history', [StockController::class, 'history'])->name('stock.history');
    Route::get('/stock/{type}', [StockController::class, 'create'])->whereIn('type', ['in', 'out'])->name('stock.create');
    Route::post('/stock/{type}', [StockController::class, 'store'])->whereIn('type', ['in', 'out'])->name('stock.store');
});