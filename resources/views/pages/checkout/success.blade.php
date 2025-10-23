@extends('layouts.app')

@section('title', 'Checkout Success')

@section('content')
<div class="text-center py-16">
    <h1 class="text-4xl font-bold text-green-700 mb-4">🎉 Booking Successful!</h1>
    <p class="text-gray-700 mb-6">
        Thank you for booking your climbing ticket.<br>
        Your Booking Code: <strong>{{ $tiket->kode_booking }}</strong>
    </p>

    <a href="{{ route('checkout.index') }}"
       class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
       Back to Booking List
    </a>
</div>
@endsection
