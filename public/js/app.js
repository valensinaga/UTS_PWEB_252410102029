// Filter kegiatan kalender berdasarkan jenis (pribadi/grup).
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-filter]').forEach(function (tombol) {
        tombol.addEventListener('click', function () {
            var aktif = tombol.getAttribute('aria-pressed') === 'true';
            tombol.setAttribute('aria-pressed', aktif ? 'false' : 'true');
            var jenis = tombol.getAttribute('data-filter');
            document.querySelectorAll('[data-tipe="' + jenis + '"]').forEach(function (el) {
                el.style.display = aktif ? 'none' : '';
            });
        });
    });
});
