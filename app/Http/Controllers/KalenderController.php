<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index(Request $request): View
    {
        $bulanDipilih = (string) $request->query('bulan', '2026-11');

        try {
            $bulan = Carbon::createFromFormat('!Y-m', $bulanDipilih)->locale('id');
        } catch (\Throwable $e) {
            $bulan = Carbon::create(2026, 11, 1)->locale('id');
        }

        $kegiatan = $this->daftarKegiatan();
        $hari = $bulan->copy()->startOfWeek(Carbon::MONDAY);
        $akhir = $bulan->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        $minggu = [];
        while ($hari->lte($akhir)) {
            $baris = [];
            for ($i = 0; $i < 7; $i++) {
                $kunci = $hari->format('Y-m-d');
                $baris[] = [
                    'tanggal' => $hari->day,
                    'dalamBulan' => $hari->month === $bulan->month,
                    'hariIni' => $hari->isSameDay(Carbon::now()),
                    'kegiatan' => array_values(array_filter($kegiatan, fn ($k) => $k['tanggal'] === $kunci)),
                ];
                $hari->addDay();
            }
            $minggu[] = $baris;
        }

        $judulBulan = $bulan->translatedFormat('F Y');
        $sebelumnya = $bulan->copy()->subMonth()->format('Y-m');
        $berikutnya = $bulan->copy()->addMonth()->format('Y-m');
        $namaHari = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

        $bulanIni = array_values(array_filter($kegiatan, fn ($k) => str_starts_with($k['tanggal'], $bulan->format('Y-m'))));
        usort($bulanIni, fn ($a, $b) => [$a['tanggal'], $a['mulai']] <=> [$b['tanggal'], $b['mulai']]);

        return view('kalender.index', compact('minggu', 'judulBulan', 'sebelumnya', 'berikutnya', 'namaHari', 'bulanIni'));
    }

    public function show(int $id): View
    {
        $semua = $this->daftarKegiatan();
        $kegiatan = collect($semua)->firstWhere('id', $id);
        abort_if($kegiatan === null, 404);

        $kegiatan['tanggalLengkap'] = Carbon::parse($kegiatan['tanggal'])->locale('id')->translatedFormat('l, d F Y');
        $lainnya = array_values(array_filter($semua, fn ($k) => $k['id'] !== $id && $k['tipe'] === $kegiatan['tipe']));
        $lainnya = array_slice($lainnya, 0, 3);

        return view('kalender.show', compact('kegiatan', 'lainnya'));
    }

    private function daftarKegiatan(): array
    {
        return [
            ['id' => 1, 'judul' => 'Rapat evaluasi', 'tanggal' => '2026-11-10', 'mulai' => '19.00', 'selesai' => '21.00', 'tempat' => 'Sekretariat', 'tipe' => 'grup', 'grup' => 'Himpunan Mahasiswa', 'deskripsi' => 'Evaluasi program kerja bulan lalu dan pembagian tugas bulan berikutnya.'],
            ['id' => 2, 'judul' => 'Tugas Kecerdasan Buatan', 'tanggal' => '2026-11-11', 'mulai' => '08.00', 'selesai' => '10.00', 'tempat' => 'Rumah', 'tipe' => 'pribadi', 'grup' => null, 'deskripsi' => 'Mengerjakan bagian analisis laporan kelompok.'],
            ['id' => 3, 'judul' => 'Latihan pentas', 'tanggal' => '2026-11-12', 'mulai' => '16.00', 'selesai' => '18.00', 'tempat' => 'Aula', 'tipe' => 'grup', 'grup' => 'UKM Seni', 'deskripsi' => 'Latihan penuh dua babak pertama sebelum pentas akhir.'],
            ['id' => 4, 'judul' => 'Belajar untuk kuis Statistika', 'tanggal' => '2026-11-13', 'mulai' => '19.30', 'selesai' => '21.00', 'tempat' => 'Perpustakaan', 'tipe' => 'pribadi', 'grup' => null, 'deskripsi' => 'Mengulang materi distribusi sampling.'],
            ['id' => 5, 'judul' => 'Briefing panitia', 'tanggal' => '2026-11-14', 'mulai' => '09.00', 'selesai' => '11.00', 'tempat' => 'Ruang rapat', 'tipe' => 'grup', 'grup' => 'Panitia Pameran', 'deskripsi' => 'Pembagian posisi dan pengecekan kebutuhan hari acara.'],
            ['id' => 6, 'judul' => 'Praktikum Jaringan Komputer', 'tanggal' => '2026-11-17', 'mulai' => '13.00', 'selesai' => '15.00', 'tempat' => 'Lab Jaringan', 'tipe' => 'pribadi', 'grup' => null, 'deskripsi' => 'Praktikum konfigurasi routing statis.'],
            ['id' => 7, 'judul' => 'Rapat divisi acara', 'tanggal' => '2026-11-18', 'mulai' => '15.30', 'selesai' => '17.00', 'tempat' => 'Daring', 'tipe' => 'grup', 'grup' => 'Himpunan Mahasiswa', 'deskripsi' => 'Membahas rundown seminar jurusan.'],
            ['id' => 8, 'judul' => 'Tenggat laporan akhir', 'tanggal' => '2026-11-20', 'mulai' => '23.59', 'selesai' => '23.59', 'tempat' => 'Daring', 'tipe' => 'pribadi', 'grup' => null, 'deskripsi' => 'Kumpulkan laporan akhir sebelum tengah malam.'],
            ['id' => 9, 'judul' => 'Gladi bersih', 'tanggal' => '2026-11-26', 'mulai' => '14.00', 'selesai' => '18.00', 'tempat' => 'Aula', 'tipe' => 'grup', 'grup' => 'UKM Seni', 'deskripsi' => 'Gladi bersih lengkap dengan tata cahaya dan suara.'],
            ['id' => 10, 'judul' => 'Pentas akhir semester', 'tanggal' => '2026-11-28', 'mulai' => '18.00', 'selesai' => '21.00', 'tempat' => 'Aula', 'tipe' => 'grup', 'grup' => 'UKM Seni', 'deskripsi' => 'Pentas penutup dengan tiga penampilan utama.'],
            ['id' => 11, 'judul' => 'Seminar jurusan', 'tanggal' => '2026-12-05', 'mulai' => '09.00', 'selesai' => '12.00', 'tempat' => 'Gedung Serbaguna', 'tipe' => 'grup', 'grup' => 'Himpunan Mahasiswa', 'deskripsi' => 'Seminar terbuka bersama alumni.'],
            ['id' => 12, 'judul' => 'Belajar UAS Jaringan Komputer', 'tanggal' => '2026-12-08', 'mulai' => '19.00', 'selesai' => '21.00', 'tempat' => 'Rumah', 'tipe' => 'pribadi', 'grup' => null, 'deskripsi' => 'Mengulang materi subnetting.'],
        ];
    }
}
