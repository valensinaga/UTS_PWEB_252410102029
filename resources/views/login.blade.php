@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<section class="section">
    <div class="wrap" style="max-width:440px">
        <h1 style="font-size:32px;margin-bottom:6px">Masuk ke Kalenku</h1>
        <p class="muted" style="margin:0 0 20px">Lihat kalender pribadi dan jadwal grupmu.</p>

        <form class="card" method="POST" action="{{ route('login.proses') }}" style="display:flex;flex-direction:column;gap:14px" novalidate>
            @csrf
            <div>
                <label class="f" for="username">Username</label>
                <input id="username" name="username" class="in" value="{{ old('username') }}" autocomplete="username" autofocus>
                @error('username')<p class="err">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="f" for="password">Password</label>
                <input id="password" name="password" type="password" class="in" autocomplete="current-password">
                @error('password')<p class="err">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn" style="justify-content:center">Masuk</button>
        </form>

        <div class="note" style="margin-top:18px">
            <strong>Akun demo</strong>
            <p style="margin:6px 0 0">Username: <b>{{ $akunDemo['username'] }}</b><br>Password: <b>{{ $akunDemo['password'] }}</b></p>
        </div>
    </div>
</section>
@endsection
