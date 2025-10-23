@extends('layouts.app')
@section('title', 'Booking Detail')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-green-800 text-center mb-6">Booking Detail</h1>

    <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
        {{-- QR Code --}}
        <div class="text-center mb-6">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data={{ $booking['code'] }}" 
                 alt="QR Code" class="mx-auto border border-gray-300 rounded-lg p-2 shadow-sm">
            <p class="text-sm text-gray-500 mt-2">Scan this QR code for your booking verification</p>
        </div>

        <div class="grid grid-cols-2 gap-4 text-gray-800">
            <p><strong>Booking Code:</strong> {{ $booking['code'] }}</p>
            <p><strong>Name:</strong> {{ $booking['name'] }}</p>
            <p><strong>Mountain ID:</strong> {{ $booking['mountain_id'] }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking['date'])->format('d M Y') }}</p>
            <p><strong>Climbers:</strong> {{ $booking['climber'] }}</p>
            <p><strong>Duration:</strong> {{ $booking['duration'] }} days</p>
            <p><strong>Payment Method:</strong> {{ $booking['metode'] }}</p>
            <p><strong>Total Amount:</strong> Rp {{ number_format($booking['amount'], 0, ',', '.') }}</p>
            <p><strong>Status:</strong> 
                <span class="{{ $booking['status'] == 'Cancelled' ? 'text-red-600' : 'text-green-700' }}">
                    {{ $booking['status'] }}
                </span>
            </p>
            @if(isset($booking['refund']))
                <p><strong>Refund:</strong> Rp {{ number_format($booking['refund'], 0, ',', '.') }} ({{ $booking['refund_rate'] }}%)</p>
                <p><strong>Reason:</strong> {{ $booking['reason'] ?? '-' }}</p>
            @endif
        </div>
    </div>

    <div class="mt-6 flex justify-center gap-3">
        <a href="{{ route('checkout.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
           Back to List
        </a>

        @if($booking['status'] !== 'Cancelled')
        <a href="{{ route('checkout.edit', $booking['code']) }}" 
           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
           Edit
        </a>
        @endif
    </div>
</div>
@endsection
