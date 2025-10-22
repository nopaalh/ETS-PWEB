@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-5xl font-[Playfair_Display] font-bold text-green-900 mb-3">Admin Dashboard</h1>
        <p class="text-gray-600">Kelola data gunung dan pantau statistik pendakian</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-2xl shadow-md p-6 border border-green-100">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-green-900">{{ $totalGunung }}</h3>
                <p class="text-gray-600 mt-2">Total Gunung</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-green-100">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-green-900">{{ $gunungAktif }}</h3>
                <p class="text-gray-600 mt-2">Gunung Aktif</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-green-100">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-green-900">0</h3>
                <p class="text-gray-600 mt-2">Pendaki Hari Ini</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-green-100">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-green-900">0</h3>
                <p class="text-gray-600 mt-2">Total Booking</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="text-center space-y-4 md:space-y-0 md:space-x-4">
        <a href="{{ route('admin.gunungs.create') }}"
           class="bg-green-700 hover:bg-green-800 text-white px-8 py-3 rounded-full text-lg shadow-md transition transform hover:scale-105 inline-block">
            + Tambah Gunung Baru
        </a>
        <a href="{{ route('mountain.index') }}"
           class="bg-white border border-green-700 text-green-700 hover:bg-green-50 px-8 py-3 rounded-full text-lg shadow-sm transition inline-block">
            Lihat Daftar Gunung
        </a>
    </div>
</div>
@endsection
