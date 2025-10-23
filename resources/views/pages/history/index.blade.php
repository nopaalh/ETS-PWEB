@extends('layouts.app')
@section('title', 'Booking History')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-green-800 text-center mb-6">Successful Booking History</h1>

    @if(session('success'))
        <p class="text-green-600 mb-4 text-center">{{ session('success') }}</p>
    @endif

    @if($histories->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 rounded-lg">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="p-3 text-left">Booking Code</th>
                        <th class="p-3 text-left">Climber Name</th>
                        <th class="p-3 text-left">Mountain</th>
                        <th class="p-3 text-left">Climbing Date</th>
                        <th class="p-3 text-left">Climbers</th>
                        <th class="p-3 text-left">Duration</th>
                        <th class="p-3 text-left">Total Price</th>
                        <th class="p-3 text-left">Payment Method</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($histories as $history)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 font-medium text-blue-600">{{ $history->kode_booking }}</td>
                            <td class="p-3">{{ $history->nama_pendaki }}</td>
                            <td class="p-3">{{ $history->gunung->nama_gunung }}</td>
                            <td class="p-3">{{ $history->tanggal_pendakian->format('d M Y') }}</td>
                            <td class="p-3 text-center">{{ $history->jumlah_pendaki }}</td>
                            <td class="p-3 text-center">{{ $history->durasi_hari }} days</td>
                            <td class="p-3 font-semibold">Rp {{ number_format($history->total_harga, 0, ',', '.') }}</td>
                            <td class="p-3">{{ $history->metode_pembayaran }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                    Success
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Successful Bookings Yet</h3>
            <p class="text-gray-500 mb-6">You haven't completed any climbing bookings yet. Start your adventure!</p>
            <a href="{{ route('checkout.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Book Your First Climb
            </a>
        </div>
    @endif
</div>
@endsection
