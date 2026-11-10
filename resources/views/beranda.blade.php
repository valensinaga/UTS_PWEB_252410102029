@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="hero">
    <div class="wrap hero-in">
        <div>
            <h1>Satu kalender untuk kuliah dan organisasi</h1>
            <p class="muted">Lihat jadwal grup dari admin dan atur kegiatan pribadimu di tempat yang sama. Kegiatan pribadi tidak pernah terlihat oleh admin maupun anggota lain.</p>
            <div class="hero-actions">
                <a href="{{ route('kalender.index') }}" class="btn">Buka kalender</a>
                <a href="{{ route('grup.index') }}" class="btn ghost">Lihat grup</a>
            </div>
        </div>
        <div class="card preview">
            <div class="muted" style="font-size:13px;font-weight:600;margin-bottom:10px">Kegiatan terdekat</div>
            <div class="list">
                @foreach ($terdekat as $k)
                    <a class="row-item" href="{{ route('kalender.show', $k['id']) }}">
                        <div><strong>{{ $k['judul'] }}</strong><div class="muted" style="font-size:13px">{{ $k['tanggal'] }}, {{ $k['waktu'] }}</div></div>
                        <x-badge :tipe="$k['tipe']" />
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="wrap">
    <div class="grid g4">
        @foreach ($statistik as $s)
            <x-stat-card :label="$s['label']" :nilai="$s['nilai']" :ket="$s['ket']" />
        @endforeach
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="section-head"><h2>Dirancang untuk pengurus dan anggota</h2></div>
        <div class="grid g3">
            @foreach ($fitur as $f)
                <div class="card"><h3>{{ $f['judul'] }}</h3><p class="muted" style="margin:8px 0 0">{{ $f['isi'] }}</p></div>
            @endforeach
        </div>
    </div>
</section>

<section class="wrap">
    <div class="section-head">
        <h2>Grup unggulan</h2>
        <a href="{{ route('grup.index') }}" class="btn ghost">Semua grup</a>
    </div>
    <div class="grid g3">
        @foreach ($grupUnggulan as $g)
            <a href="{{ route('grup.show', $g['slug']) }}" class="card" style="text-decoration:none">
                <span class="dot {{ $g['warna'] }}"></span>
                <h3 style="margin-top:10px">{{ $g['nama'] }}</h3>
                <p class="muted" style="margin:6px 0 12px;font-size:14px">{{ $g['ringkas'] }}</p>
                <span class="muted" style="font-size:13px">{{ $g['anggota'] }} anggota</span>
            </a>
        @endforeach
    </div>
</section>
@endsection
