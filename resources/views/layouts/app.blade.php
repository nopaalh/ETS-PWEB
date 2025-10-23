<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MyClimb')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex flex-col bg-[#f9f9f6] text-gray-800 font-[Inter]">

    @include('layouts.navigation')
    <main class="flex-grow relative">
        <div class="absolute inset-0 bg-cover bg-center opacity-20"
             style="background-image: url('{{ asset('images/bg_landing_page.jpg') }}');"></div>

        <div class="relative z-10 container mx-auto px-6 py-20">
            @yield('content')
        </div>
    </main>
    
    <footer class="bg-white border-t border-gray-200 text-gray-500 text-center py-5 text-sm">
        © 2025 MyClimb | Made with by WebPro Team
    </footer>

</body>
</html>
