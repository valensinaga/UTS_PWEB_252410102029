<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class TugasController extends Controller
{
    public function index(): View
    {
        $tugas = [
            ['judul' => 'Kirim bahan rapat evaluasi', 'tenggat' => '10 Nov', 'kategori' => 'Grup', 'selesai' => true],
            ['judul' => 'Rangkum materi Kecerdasan Buatan', 'tenggat' => '11 Nov', 'kategori' => 'Pribadi', 'selesai' => false],
            ['judul' => 'Konfirmasi tempat latihan pentas', 'tenggat' => '11 Nov', 'kategori' => 'Grup', 'selesai' => true],
            ['judul' => 'Kerjakan latihan Statistika', 'tenggat' => '13 Nov', 'kategori' => 'Pribadi', 'selesai' => false],
            ['judul' => 'Susun daftar posisi panitia', 'tenggat' => '14 Nov', 'kategori' => 'Grup', 'selesai' => false],
            ['judul' => 'Siapkan laporan praktikum Jaringan', 'tenggat' => '17 Nov', 'kategori' => 'Pribadi', 'selesai' => true],
            ['judul' => 'Cetak rundown seminar', 'tenggat' => '18 Nov', 'kategori' => 'Grup', 'selesai' => true],
            ['judul' => 'Kumpulkan laporan akhir', 'tenggat' => '20 Nov', 'kategori' => 'Pribadi', 'selesai' => true],
        ];

        return view('tugas.index', compact('tugas'));
    }
}
