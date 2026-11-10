@props(['label', 'nilai', 'ket' => ''])
<div class="card stat">
    <div class="muted" style="font-size:14px;font-weight:600">{{ $label }}</div>
    <b>{{ $nilai }}</b>
    <div class="muted" style="font-size:13px">{{ $ket }}</div>
</div>
