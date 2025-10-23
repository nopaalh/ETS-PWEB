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
                <h3 class="text-2xl font-bold text-green-900">{{ $totalBookings }}</h3>
                <p class="text-gray-600 mt-2">Total Booking</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-green-100">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-green-900">{{ $pendingBookings }}</h3>
                <p class="text-gray-600 mt-2">Pending Bookings</p>
            </div>
        </div>
    </div>

    <!-- Pending Bookings Table -->
    <div class="bg-white rounded-2xl shadow-md p-6 mb-10">
        <h2 class="text-2xl font-bold text-green-900 mb-6">Pending Transactions</h2>

        @if($pendingBookingsList->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-green-900">Kode Booking</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-green-900">Nama Pendaki</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-green-900">Gunung</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-green-900">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-green-900">Total Harga</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-green-900">Bukti Bayar</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-green-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($pendingBookingsList as $booking)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium">{{ $booking->kode_booking }}</td>
                            <td class="px-4 py-3 text-sm">{{ $booking->nama_pendaki }}</td>
                            <td class="px-4 py-3 text-sm">{{ $booking->gunung->nama_gunung }}</td>
                            <td class="px-4 py-3 text-sm">{{ $booking->tanggal_pendakian->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm">
                                @if($booking->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $booking->bukti_pembayaran) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 underline">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-gray-500">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <form method="POST" action="{{ route('admin.checkout.update-status', $booking->kode_booking) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs"
                                            onclick="return confirm('Apakah Anda yakin ingin menyetujui pembayaran ini?')">
                                        Setujui
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No pending transactions.</p>
        @endif
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
