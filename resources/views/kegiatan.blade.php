@extends('layouts.app')

@section('title', $kegiatan['judul'])

@section('content')
<section class="section">
    <div class="wrap" style="max-width:820px">
        <div class="crumb"><a href="{{ route('pengelolaan') }}">Pengelolaan</a> / {{ $kegiatan['judul'] }}</div>
        <div class="card">
            <x-badge :tipe="$kegiatan['tipe']" />
            <h1 style="font-size:32px;margin-top:12px">{{ $kegiatan['judul'] }}</h1>
            <dl class="meta">
                <div><dt>Tanggal</dt><dd>{{ $kegiatan['tanggalLengkap'] }}</dd></div>
                <div><dt>Waktu</dt><dd>{{ $kegiatan['mulai'] }} sampai {{ $kegiatan['selesai'] }}</dd></div>
                <div><dt>Tempat</dt><dd>{{ $kegiatan['tempat'] }}</dd></div>
                <div><dt>Penyelenggara</dt><dd>{{ $kegiatan['grup'] ?? 'Kamu sendiri' }}</dd></div>
            </dl>
            <p style="margin:0">{{ $kegiatan['deskripsi'] }}</p>
        </div>

        @if ($kegiatan['tipe'] === 'pribadi')
            <div class="note" style="margin-top:20px"><strong>Kegiatan pribadi.</strong> Hanya kamu yang bisa melihat kegiatan ini. Admin grup dan anggota lain tidak punya akses.</div>
        @else
            <div class="note" style="margin-top:20px"><strong>Kegiatan grup.</strong> Dibuat oleh admin {{ $kegiatan['grup'] }} dan tampil di kalender semua anggota.</div>
        @endif

        @if (count($lainnya))
            <div class="section-head" style="margin-top:40px"><h2 style="font-size:20px">Kegiatan {{ $kegiatan['tipe'] }} lainnya</h2></div>
            <div class="list">
                @foreach ($lainnya as $k)
                    @include('partials.kegiatan-item', ['k' => $k, 'sub' => \Carbon\Carbon::parse($k['tanggal'])->locale('id')->translatedFormat('d F Y')])
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
