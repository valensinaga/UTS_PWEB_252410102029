@extends('layouts.app')

@section('title', $grup['nama'])

@section('content')
<section class="section" x-data="{ tab: 'kegiatan' }">
    <div class="wrap">
        <div class="crumb"><a href="{{ route('grup.index') }}">Grup</a> / {{ $grup['nama'] }}</div>
        <div class="section-head">
            <div><h1 style="font-size:32px">{{ $grup['nama'] }}</h1><p class="muted" style="margin:4px 0 0;max-width:60ch">{{ $grup['tentang'] }}</p></div>
            <span class="badge {{ $grup['peranmu'] === 'Admin' ? 'amber' : 'grup' }}">Peranmu: {{ $grup['peranmu'] }}</span>
        </div>

        <div class="tabs" role="tablist">
            <button class="tab" :class="{ 'on': tab === 'kegiatan' }" role="tab" @click="tab = 'kegiatan'">Kegiatan grup</button>
            <button class="tab" :class="{ 'on': tab === 'anggota' }" role="tab" @click="tab = 'anggota'">Anggota ({{ count($grup['anggota']) }})</button>
            <button class="tab" :class="{ 'on': tab === 'privasi' }" role="tab" @click="tab = 'privasi'">Privasi</button>
        </div>

        <div x-show="tab === 'kegiatan'" class="list">
            @foreach ($grup['kegiatan'] as $k)
                <a class="row-item" href="{{ route('kalender.show', $k['id']) }}">
                    <div><strong>{{ $k['judul'] }}</strong><div class="muted" style="font-size:13px">{{ $k['tanggal'] }}, {{ $k['waktu'] }}, {{ $k['tempat'] }}</div></div>
                    <span class="muted" style="font-size:13px">Dibuat admin</span>
                </a>
            @endforeach
        </div>

        <div x-show="tab === 'anggota'" x-cloak class="card">
            @foreach ($grup['anggota'] as $a)
                <div style="display:flex;justify-content:space-between;padding:10px 0;{{ $loop->last ? '' : 'border-bottom:1px solid var(--line)' }}">
                    <span>{{ $a['nama'] }}</span>
                    <span class="badge {{ $a['peran'] === 'Admin' ? 'amber' : 'grup' }}">{{ $a['peran'] }}</span>
                </div>
            @endforeach
        </div>

        <div x-show="tab === 'privasi'" x-cloak class="note">
            <strong>Kegiatan pribadimu tidak terlihat oleh admin maupun anggota lain.</strong>
            <p style="margin:6px 0 0">Admin hanya mengatur kegiatan grup. Kalender pribadimu hanya bisa dibuka olehmu sendiri.</p>
        </div>
    </div>
</section>
<style>[x-cloak]{display:none !important}</style>
@endsection
