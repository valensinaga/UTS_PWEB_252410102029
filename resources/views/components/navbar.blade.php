@php
    $menu = [
        ['rute' => 'beranda', 'cocok' => 'beranda', 'label' => 'Beranda'],
        ['rute' => 'kalender.index', 'cocok' => 'kalender.*', 'label' => 'Kalender'],
        ['rute' => 'grup.index', 'cocok' => 'grup.*', 'label' => 'Grup'],
        ['rute' => 'tugas.index', 'cocok' => 'tugas.*', 'label' => 'Tugas'],
        ['rute' => 'profil', 'cocok' => 'profil', 'label' => 'Profil'],
        ['rute' => 'kontak', 'cocok' => 'kontak', 'label' => 'Kontak'],
    ];
    $masuk = session()->has('username');
@endphp
<header class="nav" x-data="{ buka: false }">
    <div class="wrap nav-in">
        <a href="{{ $masuk ? route('beranda') : route('login') }}" class="brand">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 6h16v14H4zM4 10h16M8 3v4M16 3v4"/></svg>
            Kalenku
        </a>
        @if ($masuk)
            <button class="burger" type="button" aria-label="Buka menu" :aria-expanded="buka" @click="buka = !buka">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
            <nav class="menu" :class="{ 'open': buka }" aria-label="Menu utama">
                @foreach ($menu as $item)
                    <a href="{{ route($item['rute']) }}" class="{{ request()->routeIs($item['cocok']) ? 'on' : '' }}" @if (request()->routeIs($item['cocok'])) aria-current="page" @endif>{{ $item['label'] }}</a>
                @endforeach
                <form method="POST" action="{{ route('keluar') }}" style="margin:0">
                    @csrf
                    <button type="submit" class="btn ghost" style="min-height:40px;padding:8px 14px;font-size:14px">Keluar ({{ session('username') }})</button>
                </form>
            </nav>
        @endif
    </div>
</header>
