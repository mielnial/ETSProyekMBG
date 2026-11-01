<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RekapController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')
    ->middleware('auth')
    ->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('/rekap', [RekapController::class, 'index'])
        ->middleware('role:pemantau,koordinator')
        ->name('rekap.index');

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->middleware('role:pelapor')
        ->name('laporan.index');

    Route::get('/laporan/create', [LaporanController::class, 'create'])
        ->middleware('role:pelapor')
        ->name('laporan.create');

    Route::get('/sekolah/{sekolah}/distribusi', [LaporanController::class, 'distribusiUntukSekolah'])
        ->middleware('role:pelapor')
        ->name('laporan.sekolah.distribusi');

    Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])
        ->name('laporan.edit');

    Route::post('/laporan', [LaporanController::class, 'store'])
        ->middleware('role:pelapor')
        ->name('laporan.store');

    Route::get('/laporan/{laporan}/bukti', [LaporanController::class, 'downloadBukti'])
        ->name('laporan.bukti');

    Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])
        ->name('laporan.update');

    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])
        ->name('laporan.show');
});
