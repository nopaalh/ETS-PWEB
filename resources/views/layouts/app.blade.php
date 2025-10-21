<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pendakianku')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-b from-green-50 to-green-200 min-h-screen flex flex-col">
    {{-- Navbar --}}
    <nav class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-3">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-green-800">🌿 Pendakianku</a>
            <div class="flex gap-5">
                <a href="{{ route('dashboard') }}" class="hover:text-green-700">Dashboard</a>
                <a href="{{ route('gunung.index') }}" class="hover:text-green-700">Gunung</a>
                <a href="{{ route('pesanan.index') }}" class="hover:text-green-700">Pesanan</a>
                <a href="{{ route('favorit.index') }}" class="hover:text-green-700">Favorit</a>
            </div>
            <div>
                @auth
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-600 hover:underline">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-green-700 font-medium">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <main class="flex-grow container mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-green-900 text-white text-center py-4 mt-auto">
        <p>&copy; {{ date('Y') }} Pendakianku | Dibuat dengan 💚 oleh Kelompok WebPro</p>
    </footer>
</body>
</html>
