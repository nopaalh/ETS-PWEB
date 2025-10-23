@extends('layouts.app')
@section('title', $gunung->nama_gunung)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <img src="{{ asset('images/' . $gunung->gambar) }}" alt="{{ $gunung->nama_gunung }}"
         class="w-full h-96 object-cover rounded-2xl shadow-md mb-10">

    <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-4 text-center">
        {{ $gunung->nama_gunung }}
    </h1>
    <p class="text-gray-600 text-lg mb-6 text-center">
        📍 {{ $gunung->lokasi_provinsi }}, {{ $gunung->lokasi_kabupaten }} — 
        <span class="text-green-700 font-medium">{{ number_format($gunung->ketinggian) }} mdpl</span>
    </p>

    <p class="text-gray-700 leading-relaxed max-w-3xl mx-auto mb-10 text-center">
        {{ $gunung->deskripsi }}
    </p>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-center max-w-2xl mx-auto">
        {{ session('success') }}
    </div>
    @endif

    <div class="flex justify-center gap-6 mb-10">
        <a href="{{ route('checkout.create') }}" 
           class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-full text-lg shadow-md transition transform hover:scale-105">
            Pesan Tiket 🎫
        </a>
        
        {{-- Button Favorite dengan Toggle --}}
        <form action="{{ route('favorite.toggle', $gunung->id) }}" method="POST">
            @csrf
            @php
                $isFavorited = auth()->user()->hasFavorited($gunung->id);
            @endphp
            <button type="submit" 
                    class="border-2 px-6 py-3 rounded-full text-lg shadow-sm transition transform hover:scale-105
                    {{ $isFavorited 
                        ? 'border-red-500 text-red-500 bg-white hover:bg-red-50' 
                        : 'border-green-700 text-green-700 bg-white hover:bg-green-50' }}">
                {{ $isFavorited ? 'Hapus dari Favorit 💔' : 'Tambahkan ke Favorit 💚' }}
            </button>
        </form>
    </div>

    <div class="text-center">
        <a href="{{ route('mountain.index') }}" 
           class="text-green-700 hover:underline font-medium text-sm">
           ← Kembali ke Daftar Gunung
        </a>
    </div>
</div>
@endsection