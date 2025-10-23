@extends('layouts.app')
@section('title', 'Gunung Favorit Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-4">
                Gunung Favorit Saya 💚
            </h1>
            <p class="text-gray-600 text-lg">
                Tempat menyimpan gunung yang paling kamu sukai
            </p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-8 max-w-2xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg shadow-sm">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        {{-- Content --}}
        @if($favoritGunung->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($favoritGunung as $favorite)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                {{-- Gambar Gunung --}}
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/' . $favorite->gunung->gambar) }}" 
                         alt="{{ $favorite->gunung->nama_gunung }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                    
                    {{-- Badge Level Kesulitan --}}
                    <div class="absolute top-4 right-4">
                        @php
                            $badges = [
                                'easy' => ['bg' => 'bg-green-500', 'text' => 'Mudah'],
                                'medium' => ['bg' => 'bg-yellow-500', 'text' => 'Sedang'],
                                'hard' => ['bg' => 'bg-red-500', 'text' => 'Sulit']
                            ];
                            $badge = $badges[$favorite->gunung->level_kesulitan] ?? $badges['medium'];
                        @endphp
                        <span class="{{ $badge['bg'] }} text-white text-xs font-bold px-3 py-1 rounded-full">
                            {{ $badge['text'] }}
                        </span>
                    </div>
                </div>
                
                {{-- Info Gunung --}}
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-green-900 mb-3 font-[Playfair_Display]">
                        {{ $favorite->gunung->nama_gunung }}
                    </h3>
                    
                    <div class="space-y-2 mb-4">
                        <p class="text-gray-600 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            {{ $favorite->gunung->lokasi_provinsi }}, {{ $favorite->gunung->lokasi_kabupaten }}
                        </p>
                        
                        <p class="text-gray-600 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            {{ number_format($favorite->gunung->ketinggian) }} mdpl
                        </p>

                        <p class="text-gray-600 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Rp {{ number_format($favorite->gunung->harga_tiket, 0, ',', '.') }}
                        </p>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="flex gap-3">
                        <a href="{{ route('mountain.show', $favorite->gunung->id) }}" 
                           class="flex-1 bg-green-700 hover:bg-green-800 text-white text-center py-3 rounded-lg transition font-medium shadow-md hover:shadow-lg">
                            📖 Lihat Detail
                        </a>
                        
                        <form action="{{ route('favorite.toggle', $favorite->gunung->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-5 py-3 rounded-lg transition font-medium shadow-md hover:shadow-lg"
                                    title="Hapus dari favorit">
                                💔
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Empty State --}}
        <div class="text-center py-20">
            <div class="mb-8">
                <svg class="w-32 h-32 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-700 mb-4 font-[Playfair_Display]">
                Belum Ada Gunung Favorit
            </h2>
            <p class="text-gray-500 text-lg mb-8">
                Mulai jelajahi gunung-gunung indah dan tambahkan yang kamu suka!
            </p>
            <a href="{{ route('mountain.index') }}" 
               class="inline-block bg-green-700 hover:bg-green-800 text-white px-8 py-4 rounded-full text-lg font-medium transition transform hover:scale-105 shadow-lg">
                🏔️ Jelajahi Gunung
            </a>
        </div>
        @endif

    </div>
</div>
@endsection