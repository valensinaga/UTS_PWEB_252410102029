<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GrupController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\TugasController;
use Illuminate\Support\Facades\Route;

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
