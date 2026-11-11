<?php

use App\Http\Controllers\PageController;
use App\Http\Middleware\CekLogin;
use Illuminate\Support\Facades\Route;

// Login dan logout (simulasi, tanpa database).
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/login', [PageController::class, 'proses'])->name('login.proses');
Route::post('/keluar', [PageController::class, 'keluar'])->name('keluar');

// Halaman lain hanya bisa dibuka setelah login.
Route::middleware(CekLogin::class)->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    Route::get('/pengelolaan', [PageController::class, 'pengelolaan'])->name('pengelolaan');
    Route::get('/pengelolaan/kegiatan/{id}', [PageController::class, 'kegiatan'])
        ->whereNumber('id')
        ->name('kegiatan');

    Route::get('/grup', [PageController::class, 'grup'])->name('grup.index');
    Route::get('/grup/{slug}', [PageController::class, 'grupDetail'])->name('grup.show');

    Route::get('/tugas', [PageController::class, 'tugas'])->name('tugas.index');

    Route::get('/profile', [PageController::class, 'profile'])->name('profile');
    Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');
});
