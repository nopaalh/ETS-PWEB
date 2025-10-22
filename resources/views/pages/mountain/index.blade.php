@extends('layouts.app')
@section('title', 'Daftar Gunung')

@section('content')
<div class="text-center mb-10">
    <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-3">Daftar Gunung</h1>
    <p class="text-gray-600">Temukan gunung yang ingin kamu jelajahi 🌿</p>
</div>

{{-- Search bar --}}
<div class="max-w-md mx-auto mb-10">
    <form class="relative">
        <input type="text" placeholder="Cari gunung berdasarkan lokasi..." 
               class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none">
        <button type="submit" 
                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-green-700 text-white px-4 py-2 rounded-full hover:bg-green-800 transition">
            🔍
        </button>
    </form>
</div>

{{-- Grid daftar gunung --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
    @foreach ($gunungs as $gunung)
        <x-gunung-card :gunung="$gunung" />
    @endforeach
</div>
@endsection
