@extends('layouts.app')
@section('title', 'Daftar Gunung')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 text-center">
    <h1 class="text-4xl font-bold text-green-900 mb-4">Daftar Gunung</h1>
    <p class="text-gray-600 mb-10">Temukan gunung yang ingin kamu jelajahi 🌿</p>

    {{-- Search bar --}}
    <div class="flex justify-center mb-10">
        <form action="{{ route('mountain.index') }}" method="GET" class="flex w-full max-w-lg">
            <input type="text" name="search" placeholder="Cari gunung berdasarkan lokasi..."
                class="flex-grow border border-gray-300 rounded-l-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            <button type="submit"
                class="bg-green-600 text-white px-5 py-2 rounded-r-full hover:bg-green-700 transition">
                🔍
            </button>
        </form>
    </div>

    {{-- Grid daftar gunung --}}
    <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-8">
        @foreach ($gunungs as $gunung)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition">
                <img src="{{ asset('images/' . $gunung->gambar) }}"
                     alt="{{ $gunung->nama_gunung }}"
                     class="w-full h-52 object-cover">

                <div class="p-5 text-left">
                    <h2 class="text-2xl font-semibold text-green-800 mb-2">
                        {{ $gunung->nama_gunung }}
                    </h2>
                    <p class="text-gray-600 mb-1">
                        🏔️ <span class="font-medium">{{ number_format($gunung->ketinggian) }} mdpl</span>
                    </p>
                    <p class="text-gray-600 mb-3">
                        ⚡ Kesulitan: 
                        <span class="
                            @if($gunung->level_kesulitan == 'easy') text-green-600
                            @elseif($gunung->level_kesulitan == 'medium') text-yellow-600
                            @else text-red-600
                            @endif font-medium
                        ">
                            {{ ucfirst($gunung->level_kesulitan) }}
                        </span>
                    </p>

                    <a href="{{ route('mountain.show', $gunung->id) }}"
                        class="inline-block bg-green-700 hover:bg-green-800 text-white px-5 py-2 rounded-full text-sm transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
