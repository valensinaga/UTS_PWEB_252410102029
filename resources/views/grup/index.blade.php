@extends('layouts.app')

@section('title', 'Grup')

@section('content')
<section class="section">
    <div class="wrap">
        <div class="section-head">
            <div><h1 style="font-size:32px">Grup</h1><p class="muted" style="margin:4px 0 0">Jadwal grup diatur admin dan tampil di kalender semua anggota.</p></div>
        </div>
        <div class="grid g3">
            @foreach ($grup as $g)
                <a href="{{ route('grup.show', $g['slug']) }}" class="card" style="text-decoration:none">
                    <div style="display:flex;justify-content:space-between;align-items:center">
                        <span class="dot {{ $g['warna'] }}"></span>
                        <span class="badge {{ $g['peranmu'] === 'Admin' ? 'amber' : 'grup' }}">{{ $g['peranmu'] }}</span>
                    </div>
                    <h3 style="margin-top:12px">{{ $g['nama'] }}</h3>
                    <p class="muted" style="margin:6px 0 14px;font-size:14px">{{ $g['tentang'] }}</p>
                    <span class="muted" style="font-size:13px">{{ count($g['anggota']) }} anggota, {{ count($g['kegiatan']) }} kegiatan</span>
                </a>
            @endforeach
        </div>
        <div class="note" style="margin-top:28px"><strong>Privasi.</strong> Admin hanya mengelola kegiatan grup. Kegiatan pribadi anggota tidak terlihat oleh siapa pun selain pemiliknya.</div>
    </div>
</section>
@endsection
