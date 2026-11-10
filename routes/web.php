<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GrupController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TugasController;
use App\Http\Middleware\CekLogin;
use Illuminate\Support\Facades\Route;

// Halaman login dan logout (tanpa database, akun disimpan di controller).
Route::get('/login', [LoginController::class, 'form'])->name('login');
Route::post('/login', [LoginController::class, 'proses'])->name('login.proses');
Route::post('/keluar', [LoginController::class, 'keluar'])->name('keluar');

// Semua halaman lain hanya bisa dibuka setelah login.
Route::middleware(CekLogin::class)->group(function () {
    Route::get('/', [BerandaController::class, 'index'])->name('beranda');

    Route::get('/kalender', [KalenderController::class, 'index'])->name('kalender.index');
    Route::get('/kalender/kegiatan/{id}', [KalenderController::class, 'show'])
        ->whereNumber('id')
        ->name('kalender.show');

    Route::get('/grup', [GrupController::class, 'index'])->name('grup.index');
    Route::get('/grup/{slug}', [GrupController::class, 'show'])->name('grup.show');

    Route::get('/tugas', [TugasController::class, 'index'])->name('tugas.index');

    Route::get('/profil', [BerandaController::class, 'profil'])->name('profil');
    Route::get('/kontak', [BerandaController::class, 'kontak'])->name('kontak');
});
