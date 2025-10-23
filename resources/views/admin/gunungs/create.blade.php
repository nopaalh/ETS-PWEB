@extends('layouts.app')
@section('title', 'Tambah Gunung Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="text-center mb-10">
        <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-3">Add New Mountain</h1>
        <p class="text-gray-600">Fill in the mountain data to be added to the system</p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-8 border border-green-100">
        <form action="{{ route('admin.gunungs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Mountain Name</label>
                    <input type="text" name="nama_gunung" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                    @error('nama_gunung')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Provinsi</label>
                    <input type="text" name="lokasi_provinsi" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                    @error('lokasi_provinsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Regency</label>
                    <input type="text" name="lokasi_kabupaten" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                    @error('lokasi_kabupaten')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">height (meter)</label>
                    <input type="number" name="ketinggian" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                    @error('ketinggian')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Difficulty Level</label>
                    <select name="level_kesulitan" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                    @error('level_kesulitan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Ticket price</label>
                    <input type="number" name="harga_tiket" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                    @error('harga_tiket')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Daily Quota</label>
                    <input type="number" name="kuota_harian" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                    @error('kuota_harian')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="deskripsi" rows="4" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required></textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Picture</label>
                    <input type="file" name="gambar" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none">
                    @error('gambar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-600 focus:outline-none" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-8 py-3 rounded-full text-lg shadow-md transition transform hover:scale-105">
                    Save
                </button>
                <a href="{{ route('admin.dashboard') }}"
                   class="bg-white border border-green-700 text-green-700 hover:bg-green-50 px-8 py-3 rounded-full text-lg shadow-sm transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
