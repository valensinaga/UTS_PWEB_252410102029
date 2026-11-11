@extends('layouts.app')

@section('title', 'Pengelolaan')

@section('content')
<section class="section">
    <div class="wrap">
        <div class="cal-top">
            <div>
                <div class="muted" style="font-size:13px;font-weight:600">PENGELOLAAN KEGIATAN</div>
                <h1 style="font-size:32px">{{ $judulBulan }}</h1>
                <p class="muted" style="margin:4px 0 0">{{ count($bulanIni) }} kegiatan bulan ini</p>
            </div>
            <div style="display:flex;gap:8px">
                <a class="btn ghost" href="{{ route('pengelolaan', ['bulan' => $sebelumnya]) }}" aria-label="Bulan sebelumnya">Sebelumnya</a>
                <a class="btn ghost" href="{{ route('pengelolaan') }}">Bulan ini</a>
                <a class="btn ghost" href="{{ route('pengelolaan', ['bulan' => $berikutnya]) }}" aria-label="Bulan berikutnya">Berikutnya</a>
            </div>
        </div>

        <div class="chips" role="group" aria-label="Filter jenis kegiatan">
            <button type="button" class="chip" data-filter="pribadi" aria-pressed="true"><span class="dot indigo"></span>Pribadi</button>
            <button type="button" class="chip" data-filter="grup" aria-pressed="true"><span class="dot teal"></span>Grup</button>
        </div>

        <div class="cal">
            <div class="cal-grid">
                @foreach ($namaHari as $h)
                    <div class="cal-h">{{ $h }}</div>
                @endforeach
                @foreach ($minggu as $baris)
                    @foreach ($baris as $hari)
                        <div class="cell {{ $hari['dalamBulan'] ? '' : 'off' }}">
                            @if ($hari['hariIni'])
                                <span class="today">{{ $hari['tanggal'] }}</span>
                            @else
                                <b style="font-weight:600">{{ $hari['tanggal'] }}</b>
                            @endif
                            @if ($hari['dalamBulan'])
                                @foreach ($hari['kegiatan'] as $k)
                                    <a href="{{ route('kegiatan', $k['id']) }}" class="pill {{ $k['tipe'] }}" data-tipe="{{ $k['tipe'] }}" title="{{ $k['judul'] }}">{{ $k['judul'] }}</a>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

        <div class="section-head" style="margin-top:40px"><h2>Daftar kegiatan</h2></div>
        <div class="list">
            @forelse ($bulanIni as $k)
                @include('partials.kegiatan-item', ['k' => $k, 'sub' => \Carbon\Carbon::parse($k['tanggal'])->locale('id')->translatedFormat('d F') . ', ' . $k['mulai'] . ', ' . $k['tempat']])
            @empty
                <div class="card muted">Belum ada kegiatan di bulan ini. Coba buka bulan November atau Desember 2026.</div>
            @endforelse
        </div>
    </div>
</section>
@endsection
