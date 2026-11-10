<footer class="foot">
    <div class="wrap">
        <div class="foot-in">
            <div>
                <strong style="font-size:18px;color:var(--teal-d)">Kalenku</strong>
                <p class="muted" style="font-size:14px;max-width:44ch;margin:8px 0 0">Kalender untuk kegiatan pribadi dan organisasi. Jadwal grup dibagikan, jadwal pribadi tetap milikmu.</p>
            </div>
            <div>
                <strong>Halaman</strong>
                <a href="{{ route('kalender.index') }}">Kalender</a>
                <a href="{{ route('grup.index') }}">Grup</a>
                <a href="{{ route('tugas.index') }}">Tugas</a>
            </div>
            <div>
                <strong>Lainnya</strong>
                <a href="{{ route('profil') }}">Profil</a>
                <a href="{{ route('kontak') }}">Kontak</a>
            </div>
        </div>
        <div class="copy">&copy; {{ date('Y') }} Kalenku. Proyek demo tanpa database, semua data adalah contoh.</div>
    </div>
</footer>
