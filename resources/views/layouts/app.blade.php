<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pendakianku')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-b from-green-100 via-green-50 to-green-200 text-gray-800">

    {{-- Navbar --}}
    @include('layouts.navigation')

    {{-- Konten utama --}}
    <main class="flex-grow relative">
        <div class="absolute inset-0 bg-cover bg-center opacity-40" 
             style="background-image: url('{{ asset('images/bg_dashboard.jpg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-white/60 via-green-50/60 to-green-100/70"></div>

        <!-- Konten page -->
        <div class="relative z-20 flex flex-col items-center justify-center text-center py-24">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-green-900 text-gray-100 text-center py-4">
        © 2025 Pendakianku | Dibuat dengan 💚 oleh Kelompok WebPro
    </footer>

</body>
</html>
