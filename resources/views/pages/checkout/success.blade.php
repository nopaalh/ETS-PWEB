@extends('layouts.app')

@section('title', 'Booking Success')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-lg p-8 rounded-xl text-center">
    <h2 class="text-3xl font-bold text-green-700 mb-4">Booking Successful</h2>

    @if(isset($booking))
        <p class="text-lg mb-2"><strong>Booking Code:</strong> {{ $booking['code'] }}</p>

        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $booking['code'] }}" 
             alt="QR Code" class="mx-auto my-4">

        <p><strong>Mountain:</strong> {{ $booking['mountain_id'] }}</p>
        <p><strong>Climbing Date:</strong> {{ \Carbon\Carbon::parse($booking['date'])->format('d M Y') }}</p>
        <p><strong>Status:</strong> 
            <span class="{{ $booking['status'] === 'Active' ? 'text-green-600' : 'text-red-600' }}">
                {{ $booking['status'] }}
            </span>
        </p>
    @else
        <p class="text-red-600">Booking data not found.</p>
    @endif

    <a href="{{ route('checkout.index') }}" 
       class="inline-block bg-green-700 text-white px-5 py-2 mt-5 rounded-lg hover:bg-green-800">
       View My Ticket Booking
    </a>
</div>
@endsection