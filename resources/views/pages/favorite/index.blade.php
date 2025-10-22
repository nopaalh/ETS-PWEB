@extends('layouts.app')
@section('title', 'Gunung Favorit Saya')

@section('content')
    <div class="text-center mb-10">
        <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-3">Gunung Favorit Saya 💚</h1>
        <p class="text-gray-600">Tempat menyimpan gunung yang paling kamu sukai</p>
    </div>

    @php
        $favorit = [
            [
                'nama' => 'Gunung Rinjani',
                'lokasi' => 'Lombok, NTB',
                'tinggi' => '3.726 m',
                'gambar' => 'rinjani.jpg',
            ],
            [
                'nama' => 'Gunung Prau',
                'lokasi' => 'Dieng, Jawa Tengah',
                'tinggi' => '2.565 m',
                'gambar' => 'prau.jpg',
            ],
        ];
    @endphp

    @if (count($favorit) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
            @foreach ($favorit as $gunung)
                <x-gunung-card :gunung="$gunung" />
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-gray-500 text-lg">Kamu belum menambahkan gunung ke favorit 💭</p>
            <a href="{{ route('mountain.index') }}" 
            class="inline-block mt-4 bg-green-700 hover:bg-green-800 text-white px-6 py-3 rounded-full transition">
            Jelajahi Gunung
            </a>
        </div>
    @endif

    {{-- Script interaktif hapus card --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const deleteButtons = document.querySelectorAll('.delete-card');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const card = btn.closest('.relative');
                    card.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => card.remove(), 300);
                });
            });
        });
    </script>
@endsection