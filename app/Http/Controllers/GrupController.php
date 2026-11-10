<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class GrupController extends Controller
{
    public function index(): View
    {
        $grup = $this->daftarGrup();

        return view('grup.index', compact('grup'));
    }

    public function show(string $slug): View
    {
        $grup = $this->daftarGrup()[$slug] ?? null;
        abort_if($grup === null, 404);

        return view('grup.show', compact('grup'));
    }

    private function daftarGrup(): array
    {
        return [
            'himpunan-mahasiswa' => [
                'slug' => 'himpunan-mahasiswa',
                'nama' => 'Himpunan Mahasiswa',
                'warna' => 'teal',
                'peranmu' => 'Anggota',
                'tentang' => 'Wadah mahasiswa jurusan untuk kaderisasi, seminar, dan kegiatan sosial sepanjang tahun.',
                'kegiatan' => [
                    ['id' => 1, 'judul' => 'Rapat evaluasi', 'tanggal' => '10 Nov', 'waktu' => '19.00', 'tempat' => 'Sekretariat'],
                    ['id' => 7, 'judul' => 'Rapat divisi acara', 'tanggal' => '18 Nov', 'waktu' => '15.30', 'tempat' => 'Daring'],
                    ['id' => 11, 'judul' => 'Seminar jurusan', 'tanggal' => '5 Des', 'waktu' => '09.00', 'tempat' => 'Gedung Serbaguna'],
                ],
                'anggota' => [
                    ['nama' => 'Andi', 'peran' => 'Admin'],
                    ['nama' => 'Sari', 'peran' => 'Admin'],
                    ['nama' => 'Valen', 'peran' => 'Anggota'],
                    ['nama' => 'Rina', 'peran' => 'Anggota'],
                    ['nama' => 'Dika', 'peran' => 'Anggota'],
                ],
            ],
            'ukm-seni' => [
                'slug' => 'ukm-seni',
                'nama' => 'UKM Seni',
                'warna' => 'amber',
                'peranmu' => 'Admin',
                'tentang' => 'Unit kegiatan mahasiswa untuk tari, musik, dan teater dengan pentas rutin tiap semester.',
                'kegiatan' => [
                    ['id' => 3, 'judul' => 'Latihan pentas', 'tanggal' => '12 Nov', 'waktu' => '16.00', 'tempat' => 'Aula'],
                    ['id' => 9, 'judul' => 'Gladi bersih', 'tanggal' => '26 Nov', 'waktu' => '14.00', 'tempat' => 'Aula'],
                    ['id' => 10, 'judul' => 'Pentas akhir semester', 'tanggal' => '28 Nov', 'waktu' => '18.00', 'tempat' => 'Aula'],
                ],
                'anggota' => [
                    ['nama' => 'Valen', 'peran' => 'Admin'],
                    ['nama' => 'Maya', 'peran' => 'Anggota'],
                    ['nama' => 'Bima', 'peran' => 'Anggota'],
                    ['nama' => 'Lia', 'peran' => 'Anggota'],
                ],
            ],
            'panitia-pameran' => [
                'slug' => 'panitia-pameran',
                'nama' => 'Panitia Pameran',
                'warna' => 'teal',
                'peranmu' => 'Anggota',
                'tentang' => 'Panitia pameran karya mahasiswa, mengurus venue, konsumsi, dan jadwal pengunjung.',
                'kegiatan' => [
                    ['id' => 5, 'judul' => 'Briefing panitia', 'tanggal' => '14 Nov', 'waktu' => '09.00', 'tempat' => 'Ruang rapat'],
                ],
                'anggota' => [
                    ['nama' => 'Fajar', 'peran' => 'Admin'],
                    ['nama' => 'Valen', 'peran' => 'Anggota'],
                    ['nama' => 'Nadia', 'peran' => 'Anggota'],
                ],
            ],
        ];
    }
}
