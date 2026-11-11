<a class="row-item" href="{{ route('kegiatan', $k['id']) }}" data-tipe="{{ $k['tipe'] }}">
    <div>
        <strong>{{ $k['judul'] }}</strong>
        <div class="muted" style="font-size:13px">{{ $sub }}</div>
    </div>
    <x-badge :tipe="$k['tipe']" />
</a>
