<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{

    // ===== Login dan logout =====
    // Simulasi login: tanpa database, username dikirim ke dashboard dan profil lewat request parameter.
    public function login(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('username')) {
            return redirect()->route('dashboard', ['username' => $request->session()->get('username')]);
        }

        return view('login');
    }

    public function proses(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:30'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Isi username kamu.',
            'username.min' => 'Username minimal 3 karakter.',
            'password.required' => 'Isi password kamu.',
        ]);

        $username = trim($data['username']);

        $request->session()->regenerate();
        $request->session()->put('username', $username);

        return redirect()->route('dashboard', ['username' => $username]);
    }

    public function keluar(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    // ===== Dashboard, profil, kontak =====
    public function dashboard(Request $request): View
    {
        $username = $request->query('username', $request->session()->get('username'));

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

        return view('dashboard', compact('username', 'statistik', 'fitur', 'grupUnggulan', 'terdekat'));
    }

    public function profile(Request $request): View
    {
        $username = $request->query('username', $request->session()->get('username'));

        $pengguna = [
            'nama' => $username,
            'peran' => 'Mahasiswa',
            'kampus' => 'Universitas Jember',
            'email' => strtolower(str_replace(' ', '.', $username)) . '@mail.unej.ac.id',
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

        return view('profile', compact('username', 'pengguna', 'grup', 'privasi'));
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

    // ===== Pengelolaan (kalender) dan detail kegiatan =====
    public function pengelolaan(Request $request): View
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

        return view('pengelolaan', compact('minggu', 'judulBulan', 'sebelumnya', 'berikutnya', 'namaHari', 'bulanIni'));
    }

    public function kegiatan(int $id): View
    {
        $semua = $this->daftarKegiatan();
        $kegiatan = collect($semua)->firstWhere('id', $id);
        abort_if($kegiatan === null, 404);

        $kegiatan['tanggalLengkap'] = Carbon::parse($kegiatan['tanggal'])->locale('id')->translatedFormat('l, d F Y');
        $lainnya = array_values(array_filter($semua, fn ($k) => $k['id'] !== $id && $k['tipe'] === $kegiatan['tipe']));
        $lainnya = array_slice($lainnya, 0, 3);

        return view('kegiatan', compact('kegiatan', 'lainnya'));
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

    // ===== Grup =====
    public function grup(): View
    {
        $grup = $this->daftarGrup();

        return view('grup.index', compact('grup'));
    }

    public function grupDetail(string $slug): View
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

    // ===== Tugas =====
    public function tugas(): View
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

        return view('tugas', compact('tugas'));
    }
}
