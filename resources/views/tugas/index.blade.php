@extends('layouts.app')

@section('title', 'Tugas')

@section('content')
<section class="section" x-data='{ daftar: @json($tugas), saring: "semua",
    get selesai() { return this.daftar.filter(t => t.selesai).length },
    get persen() { return Math.round(this.selesai / this.daftar.length * 100) },
    tampil(t) { return this.saring === "semua" || t.kategori === this.saring } }'>
    <div class="wrap" style="max-width:820px">
        <h1 style="font-size:32px">Tugas</h1>
        <p class="muted" style="margin:4px 0 20px"><span x-text="selesai"></span> dari <span x-text="daftar.length"></span> tugas selesai</p>
        <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" :aria-valuenow="persen"><span :style="'width:' + persen + '%'"></span></div>

        <div class="tabs" style="margin-top:24px">
            <button class="tab" :class="{ 'on': saring === 'semua' }" @click="saring = 'semua'">Semua</button>
            <button class="tab" :class="{ 'on': saring === 'Pribadi' }" @click="saring = 'Pribadi'">Pribadi</button>
            <button class="tab" :class="{ 'on': saring === 'Grup' }" @click="saring = 'Grup'">Grup</button>
        </div>

        <div class="list">
            <template x-for="(t, i) in daftar" :key="i">
                <label class="check" :class="{ 'done': t.selesai }" x-show="tampil(t)">
                    <input type="checkbox" x-model="t.selesai">
                    <span class="t" style="flex:1" x-text="t.judul"></span>
                    <span class="muted" style="font-size:13px" x-text="t.tenggat"></span>
                    <span class="badge" :class="t.kategori === 'Pribadi' ? 'pribadi' : 'grup'" x-text="t.kategori"></span>
                </label>
            </template>
        </div>
        <p class="muted" style="font-size:13px;margin-top:16px">Centang hanya berlaku selama halaman terbuka. Data tidak disimpan.</p>
    </div>
</section>
@endsection
