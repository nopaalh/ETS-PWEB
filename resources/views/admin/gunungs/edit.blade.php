@extends('layouts.app')
@section('title', 'Edit Gunung: ' . $gunung->nama_gunung)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-3">Edit Gunung</h1>
        <p class="text-gray-600">Update data gunung {{ $gunung->nama_gunung }}</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-md p-8 border border-green-100">
        <form action="{{ route('admin.gunungs.update', $gunung->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Field sama seperti create, tapi dengan value -->
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Nama Gunung</label>
                    <input type="text" name="nama_gunung" value="{{ $gunung->nama_gunung }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Provinsi</label>
                    <input type="text" name="lokasi_provinsi" value="{{ $gunung->lokasi_provinsi }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Kabupaten</label>
                    <input type="text" name="lokasi_kabupaten" value="{{ $gunung->lokasi_kabupaten }}" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                </div>

                <!-- ... field lainnya dengan value ... -->

            </div>

            <!-- Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <button type="submit" 
                        class="bg-green-700 hover:bg-green-800 text-white px-8 py-3 rounded-full text-lg shadow-md transition transform hover:scale-105">
                    Update Gunung
                </button>
                <a href="{{ route('admin.dashboard') }}" 
                   class="bg-white border border-green-700 text-green-700 hover:bg-green-50 px-8 py-3 rounded-full text-lg shadow-sm transition text-center">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection