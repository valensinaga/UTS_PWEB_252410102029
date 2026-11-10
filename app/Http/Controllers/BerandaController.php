<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class BerandaController extends Controller
{
    public function index(): View
    {
        $statistik = [
            ['label' => 'Kegiatan bulan ini', 'nilai' => 10, 'ket' => 'pribadi dan grup'],
            ['label' => 'Grup diikuti', 'nilai' => 3, 'ket' => 'satu sebagai admin'],
            ['label' => 'Tugas selesai', 'nilai' => '5/8', 'ket' => 'minggu ini'],
            ['label' => 'Kegiatan pribadi', 'nilai' => 4, 'ket' => 'hanya terlihat olehmu'],
        ];

        $fitur = [
            ['judul' => 'Satu kalender, dua jenis kegiatan', 'isi' => 'Jadwal kuliah dan jadwal organisasi tampil berdampingan, dibedakan warna dan ikon gembok.'],
            ['judul' => 'Kegiatan pribadi tetap privat', 'isi' => 'Admin grup hanya mengatur jadwal grup. Kegiatan pribadimu tidak terlihat oleh admin maupun anggota lain.'],
            ['judul' => 'Grup dengan jadwal bersama', 'isi' => 'Admin menetapkan rapat dan acara, anggota langsung melihatnya di kalender masing-masing.'],
        ];

        $grupUnggulan = [
            ['slug' => 'himpunan-mahasiswa', 'nama' => 'Himpunan Mahasiswa', 'anggota' => 42, 'warna' => 'teal', 'ringkas' => 'Rapat pengurus, kaderisasi, dan seminar jurusan.'],
            ['slug' => 'ukm-seni', 'nama' => 'UKM Seni', 'anggota' => 28, 'warna' => 'amber', 'ringkas' => 'Latihan rutin dan pentas akhir semester.'],
            ['slug' => 'panitia-pameran', 'nama' => 'Panitia Pameran', 'anggota' => 17, 'warna' => 'teal', 'ringkas' => 'Persiapan pameran karya dan koordinasi venue.'],
        ];

        $terdekat = [
            ['id' => 1, 'judul' => 'Rapat evaluasi', 'tanggal' => '10 Nov 2026', 'waktu' => '19.00', 'tipe' => 'grup'],
            ['id' => 2, 'judul' => 'Tugas Kecerdasan Buatan', 'tanggal' => '11 Nov 2026', 'waktu' => '08.00', 'tipe' => 'pribadi'],
            ['id' => 3, 'judul' => 'Latihan pentas', 'tanggal' => '12 Nov 2026', 'waktu' => '16.00', 'tipe' => 'grup'],
        ];

        return view('beranda', compact('statistik', 'fitur', 'grupUnggulan', 'terdekat'));
    }

    public function profil(): View
    {
        $pengguna = [
            'nama' => ucfirst(session('username', 'valen')),
            'peran' => 'Mahasiswa',
            'kampus' => 'Universitas Jember',
            'email' => 'valen@mail.unej.ac.id',
            'bergabung' => 'September 2026',
        ];

        $grup = [
            ['nama' => 'Himpunan Mahasiswa', 'peran' => 'Anggota'],
            ['nama' => 'UKM Seni', 'peran' => 'Admin'],
            ['nama' => 'Panitia Pameran', 'peran' => 'Anggota'],
        ];

        $privasi = [
            'Kegiatan pribadi hanya terlihat olehmu.',
            'Admin grup tidak bisa membuka jadwal pribadi anggota.',
            'Anggota lain hanya melihat kegiatan grup yang diikuti bersama.',
        ];

        return view('profil', compact('pengguna', 'grup', 'privasi'));
    }

    public function kontak(): View
    {
        $info = [
            ['label' => 'Email', 'isi' => 'halo@kalenku.test'],
            ['label' => 'Telepon', 'isi' => '0331-000-000'],
            ['label' => 'Alamat', 'isi' => 'Jl. Kalimantan No. 37, Jember'],
            ['label' => 'Jam layanan', 'isi' => 'Senin sampai Jumat, 08.00 sampai 16.00'],
        ];

        $faq = [
            ['tanya' => 'Apakah admin bisa melihat kegiatan pribadi saya?', 'jawab' => 'Tidak. Kegiatan pribadi hanya muncul di kalendermu sendiri.'],
            ['tanya' => 'Siapa yang bisa menambah kegiatan grup?', 'jawab' => 'Hanya admin grup. Anggota melihat jadwalnya di kalender masing-masing.'],
            ['tanya' => 'Apakah perlu daftar akun?', 'jawab' => 'Untuk versi demo ini tidak perlu. Semua data adalah contoh.'],
        ];

        return view('kontak', compact('info', 'faq'));
    }
}
