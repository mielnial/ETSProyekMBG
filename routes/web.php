<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatelessCartController;
use App\Http\Controllers\RoleController;

Route::get('/', [ProductController::class, 'index'])->name('produk.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [CartController::class, 'add'])
        ->middleware('can:use-cart')
        ->name('keranjang.tambah');
    Route::post('/keranjang/{id}/ubah', [CartController::class, 'update'])->name('keranjang.ubah');
    Route::post('/keranjang/{id}/hapus', [CartController::class, 'remove'])->name('keranjang.hapus');
    Route::post('/keranjang/kosongkan', [CartController::class, 'clear'])->name('keranjang.kosongkan');

    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan', [OrderController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [OrderController::class, 'show'])->name('pesanan.show');
        Route::get('/admin/users', [RoleController::class, 'index'])
        ->middleware('can:manage-roles')
        ->name('admin.users.index');

    Route::patch('/admin/users/{user}/role', [RoleController::class, 'update'])
        ->middleware('can:manage-roles')
        ->name('admin.users.role.update');
});

Route::get('/stateless', [StatelessCartController::class, 'index'])->name('stateless.index');
Route::post('/stateless/cart/add', [StatelessCartController::class, 'add'])
    ->middleware(['auth', 'can:use-cart'])
    ->name('stateless.add');
Route::post('/stateless/cart/update', [StatelessCartController::class, 'update'])->name('stateless.update');