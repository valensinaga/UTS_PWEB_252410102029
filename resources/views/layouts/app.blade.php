<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Kalenku') | Kalenku</title>
    <meta name="description" content="@yield('description', 'Kalender kegiatan pribadi dan organisasi dalam satu tempat.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <script defer src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <x-navbar />
    <main>
        @yield('content')
    </main>
    <x-footer />
</body>
</html>
