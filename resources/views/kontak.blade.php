@extends('layouts.app')

@section('title', 'Kontak')

@section('content')
<section class="section">
    <div class="wrap">
        <h1 style="font-size:32px;margin-bottom:24px">Kontak</h1>
        <div class="grid g2" style="align-items:start">
            <div class="card" x-data="{ nama: '', email: '', pesan: '', terkirim: false, coba: false,
                get valid() { return this.nama.trim() !== '' && /^\S+@\S+\.\S+$/.test(this.email) && this.pesan.trim().length >= 10 },
                kirim() { this.coba = true; if (this.valid) { this.terkirim = true } } }">
                <h3 style="margin-bottom:14px">Kirim pesan</h3>
                <div x-show="terkirim" class="ok" role="status">Terima kasih, <span x-text="nama"></span>. Pesanmu sudah kami catat (simulasi, tidak ada data yang dikirim).</div>
                <div x-show="!terkirim" style="display:flex;flex-direction:column;gap:14px">
                    <div><label class="f" for="nama">Nama</label><input id="nama" class="in" x-model="nama" autocomplete="name"><p class="err" x-show="coba && nama.trim() === ''">Isi nama kamu.</p></div>
                    <div><label class="f" for="email">Email</label><input id="email" class="in" type="email" x-model="email" autocomplete="email"><p class="err" x-show="coba && !/^\S+@\S+\.\S+$/.test(email)">Masukkan email yang valid.</p></div>
                    <div><label class="f" for="pesan">Pesan</label><textarea id="pesan" class="in" rows="5" x-model="pesan"></textarea><p class="err" x-show="coba && pesan.trim().length < 10">Tulis minimal 10 karakter.</p></div>
                    <button type="button" class="btn" @click="kirim()">Kirim pesan</button>
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:20px">
                <div class="card">
                    <h3 style="margin-bottom:6px">Informasi kontak</h3>
                    <dl class="meta" style="margin-bottom:0">
                        @foreach ($info as $i)<div><dt>{{ $i['label'] }}</dt><dd>{{ $i['isi'] }}</dd></div>@endforeach
                    </dl>
                </div>
                <div class="card faq" x-data="{ buka: null }">
                    <h3 style="margin-bottom:6px">Pertanyaan umum</h3>
                    @foreach ($faq as $n => $f)
                        <div class="item">
                            <button type="button" @click="buka = buka === {{ $n }} ? null : {{ $n }}" :aria-expanded="buka === {{ $n }}">{{ $f['tanya'] }}<span aria-hidden="true" x-text="buka === {{ $n }} ? '-' : '+'">+</span></button>
                            <p class="muted" style="margin:0 0 14px;font-size:14px" x-show="buka === {{ $n }}" x-cloak>{{ $f['jawab'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<style>[x-cloak]{display:none !important}</style>
@endsection
