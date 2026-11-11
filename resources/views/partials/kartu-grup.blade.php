<a href="{{ route('grup.show', $g['slug']) }}" class="card" style="text-decoration:none">
    <span class="dot {{ $g['warna'] }}"></span>
    <h3 style="margin-top:10px">{{ $g['nama'] }}</h3>
    <p class="muted" style="margin:6px 0 12px;font-size:14px">{{ $g['ringkas'] }}</p>
    <span class="muted" style="font-size:13px">{{ $g['anggota'] }} anggota</span>
</a>
