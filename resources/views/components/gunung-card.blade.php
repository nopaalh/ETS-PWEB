@props(['gunung'])

<div class="relative bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition transform hover:-translate-y-1">
    <img src="{{ asset('images/' . $gunung['gambar']) }}" alt="{{ $gunung['nama'] }}" class="w-full h-48 object-cover">

    {{-- Tombol hapus favorit (hanya muncul di halaman /favorite) --}}
    @if (request()->is('favorite*'))
        <button 
            class="absolute top-3 right-3 bg-white/80 hover:bg-red-100 text-red-600 px-2 py-1 text-sm rounded-full shadow transition delete-card">
            💔
        </button>
    @else
        <div class="absolute top-3 right-3 bg-white/80 backdrop-blur-sm p-2 rounded-full shadow">
            💚
        </div>
    @endif

    <div class="p-4 text-left">
        <h3 class="text-xl font-semibold text-green-900">{{ $gunung['nama'] }}</h3>
        <p class="text-gray-600 text-sm mt-1">{{ $gunung['lokasi'] }}</p>
        <p class="text-gray-500 text-sm mt-1">⛰️ {{ $gunung['tinggi'] }}</p>
        <div class="mt-4">
            <a href="{{ route('mountain.show', ['id' => $gunung['id'] ?? 1]) }}" 
               class="inline-block bg-green-700 hover:bg-green-800 text-white text-sm px-4 py-2 rounded-lg transition">
                Lihat Detail
            </a>
        </div>
    </div>
</div>
