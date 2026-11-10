@extends('layouts.app')

@section('title', 'Profil')

@section('content')
<section class="section">
    <div class="wrap">
        <h1 style="font-size:32px;margin-bottom:24px">Profil</h1>
        <div class="grid g2" style="align-items:start">
            <div class="card">
                <div style="width:64px;height:64px;border-radius:50%;background:var(--teal-l);color:var(--teal-d);display:grid;place-items:center;font-size:26px;font-weight:800">{{ strtoupper(substr($pengguna['nama'], 0, 1)) }}</div>
                <h2 style="margin-top:14px">{{ $pengguna['nama'] }}</h2>
                <dl class="meta">
                    <div><dt>Peran</dt><dd>{{ $pengguna['peran'] }}</dd></div>
                    <div><dt>Kampus</dt><dd>{{ $pengguna['kampus'] }}</dd></div>
                    <div><dt>Email</dt><dd>{{ $pengguna['email'] }}</dd></div>
                    <div><dt>Bergabung</dt><dd>{{ $pengguna['bergabung'] }}</dd></div>
                </dl>
            </div>
            <div style="display:flex;flex-direction:column;gap:20px">
                <div class="card">
                    <h3 style="margin-bottom:10px">Grup saya</h3>
                    @foreach ($grup as $g)
                        <div style="display:flex;justify-content:space-between;padding:8px 0">
                            <span>{{ $g['nama'] }}</span>
                            <span class="badge {{ $g['peran'] === 'Admin' ? 'amber' : 'grup' }}">{{ $g['peran'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="note">
                    <strong>Pengaturan privasi</strong>
                    <ul style="margin:8px 0 0;padding-left:18px">
                        @foreach ($privasi as $p)<li>{{ $p }}</li>@endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
