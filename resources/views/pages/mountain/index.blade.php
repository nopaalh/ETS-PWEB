@extends('layouts.app')
@section('title', 'Daftar Gunung')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white py-12">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-4">
                Daftar Gunung 🏔️
            </h1>
            <p class="text-gray-600 text-lg">
                Temukan gunung yang ingin kamu jelajahi 🌿
            </p>
        </div>

        {{-- Search Bar --}}
        <div class="max-w-2xl mx-auto mb-12">
            <div class="relative">
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari gunung berdasarkan lokasi..." 
                       class="w-full px-6 py-4 rounded-full border-2 border-green-200 focus:border-green-500 focus:outline-none text-lg shadow-md">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-green-700 hover:bg-green-800 text-white p-3 rounded-full transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-8 max-w-2xl mx-auto bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-lg shadow-sm">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
        @endif

        {{-- Mountain Cards --}}
        @if($gunungs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="mountainGrid">
            @foreach($gunungs as $gunung)
            <div class="mountain-card bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2" 
                 data-location="{{ strtolower($gunung->lokasi_provinsi . ' ' . $gunung->lokasi_kabupaten) }}">
                
                {{-- Gambar Gunung --}}
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/' . $gunung->gambar) }}" 
                         alt="{{ $gunung->nama_gunung }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                    
                    {{-- Badge Level Kesulitan --}}
                    <div class="absolute top-4 right-4">
                        @php
                            $badges = [
                                'easy' => ['bg' => 'bg-green-500', 'text' => 'Mudah'],
                                'medium' => ['bg' => 'bg-yellow-500', 'text' => 'Sedang'],
                                'hard' => ['bg' => 'bg-red-500', 'text' => 'Sulit']
                            ];
                            $badge = $badges[$gunung->level_kesulitan] ?? $badges['medium'];
                        @endphp
                        <span class="{{ $badge['bg'] }} text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                            {{ $badge['text'] }}
                        </span>
                    </div>

                    {{-- Favorite Badge (jika sudah difavoritkan) --}}
                    @auth
                        @if(auth()->user()->hasFavorited($gunung->id))
                        <div class="absolute top-4 left-4">
                            <span class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                💚 Favorit
                            </span>
                        </div>
                        @endif
                    @endauth
                </div>
                
                {{-- Info Gunung --}}
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-green-900 mb-3 font-[Playfair_Display]">
                        {{ $gunung->nama_gunung }}
                    </h3>
                    
                    <div class="space-y-2 mb-4">
                        <p class="text-gray-600 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="truncate">{{ $gunung->lokasi_provinsi }}, {{ $gunung->lokasi_kabupaten }}</span>
                        </p>
                        
                        <p class="text-gray-600 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                            {{ number_format($gunung->ketinggian) }} mdpl
                        </p>

                        <p class="text-gray-600 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Rp {{ number_format($gunung->harga_tiket, 0, ',', '.') }}
                        </p>
                    </div>
                    
                    {{-- Action Buttons --}}
                    <div class="flex gap-3">
                        <a href="{{ route('mountain.show', $gunung->id) }}" 
                           class="flex-1 bg-green-700 hover:bg-green-800 text-white text-center py-3 rounded-lg transition font-medium shadow-md hover:shadow-lg">
                            📖 Lihat Detail
                        </a>
                        
                        @auth
                        <form action="{{ route('favorite.toggle', $gunung->id) }}" method="POST" class="inline">
                            @csrf
                            @php
                                $isFavorited = auth()->user()->hasFavorited($gunung->id);
                            @endphp
                            <button type="submit" 
                                    class="{{ $isFavorited ? 'bg-red-500 hover:bg-red-600' : 'bg-pink-500 hover:bg-pink-600' }} text-white px-5 py-3 rounded-lg transition font-medium shadow-md hover:shadow-lg"
                                    title="{{ $isFavorited ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
                                {{ $isFavorited ? '💔' : '💚' }}
                            </button>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Empty State (jika tidak ada gunung) --}}
        @else
        <div class="text-center py-20">
            <div class="mb-8">
                <svg class="w-32 h-32 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-700 mb-4 font-[Playfair_Display]">
                Belum Ada Data Gunung
            </h2>
            <p class="text-gray-500 text-lg">
                Data gunung sedang dalam proses penambahan
            </p>
        </div>
        @endif

    </div>
</div>

{{-- Search Functionality --}}
<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const cards = document.querySelectorAll('.mountain-card');
    
    cards.forEach(card => {
        const location = card.getAttribute('data-location');
        if (location.includes(searchValue)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});
</script>
@endsection