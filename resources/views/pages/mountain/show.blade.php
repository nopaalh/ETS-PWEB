@extends('layouts.app')
@section('title', $gunung['nama'])

@section('content')
<div class="max-w-5xl mx-auto text-center">
    <img src="{{ asset('images/' . $gunung['gambar']) }}" alt="{{ $gunung['nama'] }}"
         class="w-full h-96 object-cover rounded-2xl shadow-md mb-10">

    <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-4">
        {{ $gunung['nama'] }}
    </h1>
    <p class="text-gray-600 text-lg mb-6">{{ $gunung['lokasi'] }} — <span class="text-green-700 font-medium">{{ $gunung['tinggi'] }}</span></p>

    <p class="text-gray-700 leading-relaxed max-w-3xl mx-auto mb-10">
        {{ $gunung['deskripsi'] }}
    </p>

    <div class="flex justify-center gap-6">
        <a href="{{ route('checkout.create') }}" 
           class="bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-full text-lg shadow-md transition transform hover:scale-105">
            Pesan Tiket 🎫
        </a>
        <a href="{{ route('favorite.index') }}" 
           class="bg-white border border-green-700 text-green-700 hover:bg-green-50 px-6 py-3 rounded-full text-lg shadow-sm transition">
            Tambahkan ke Favorit 💚
        </a>
    </div>

    <div class="mt-10">
        <a href="{{ route('mountain.index') }}" 
           class="text-green-700 hover:underline font-medium text-sm">
           ← Kembali ke Daftar Gunung
        </a>
    </div>
</div>
@endsection
