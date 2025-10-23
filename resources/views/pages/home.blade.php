@extends('layouts.landing')
@section('title', 'MyClimb')

@section('content')
<div class="relative min-h-screen flex flex-col items-center justify-center text-center overflow-hidden">
    <!-- Background image -->
    <div class="absolute inset-0 bg-cover bg-center" 
         style="background-image: url('{{ asset('images/bg_landing_page.jpg') }}'); filter: brightness(0.6);">
    </div>

    <!-- Gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-black/40 to-black/60"></div>

    <!-- Content -->
    <div class="relative z-10 text-white px-6">
        <h1 class="text-6xl md:text-7xl font-extrabold leading-tight drop-shadow-lg">
            Adventure Starts Here
        </h1>
        <p class="mt-5 text-lg md:text-xl text-gray-200 max-w-2xl mx-auto">
            Explore the best mountains in Indonesia and find your next journey with MyClimb 🌄
        </p>

        <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('login') }}"
               class="bg-white text-green-800 font-semibold px-8 py-3 rounded-full hover:bg-green-100 transition">
                Login
            </a>
            <a href="{{ route('register') }}"
               class="bg-green-700 text-white font-semibold px-8 py-3 rounded-full hover:bg-green-800 transition">
                Register
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="absolute bottom-0 w-full text-center text-gray-200 text-sm pb-4">
        © 2025 MyClimb | Made with 💚 by WebPro Team
    </footer>
</div>
@endsection
