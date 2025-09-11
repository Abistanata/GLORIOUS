<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Glorious Computer')</title>

    {{-- ✅ Favicon Custom --}}
    <link rel="icon" type="image/png" href="{{ asset('glorious.png?v=1') }}">

    {{-- ✅ Warna tema untuk browser mobile --}}
    <meta name="theme-color" content="#1a1a1a">

    {{-- ✅ SEO (opsional) --}}
    <meta name="description" content="Glorious Computer - Solusi perangkat komputer, printer, dan aksesoris terbaik dengan harga terjangkau.">

    {{-- Styles --}}
    @vite('resources/css/app.css')
</head>
<body class="bg-white text-gray-900 font-sans antialiased">
    @yield('content')
</body>
</html>
