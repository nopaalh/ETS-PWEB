@extends('layouts.app')

@section('title', 'Cancel Booking')

@section('content')
<div class="max-w-2xl mx-auto py-10">
    <h1 class="text-3xl font-bold text-center text-red-600 mb-6">Cancel Booking</h1>

    <div class="bg-white p-6 rounded-xl shadow">
        <p class="mb-4">Booking Code: <strong>{{ $tiket->kode_booking }}</strong></p>
        <p class="mb-4 text-gray-700">Refund amount to be received:
            <strong>Rp{{ number_format($tiket->hitungRefund(), 0, ',', '.') }}</strong>
        </p>

        <form action="{{ route('checkout.cancel.process', $tiket->kode_booking) }}" method="POST">
            @csrf
            <label class="block font-semibold mb-2">Cancellation Reason</label>
            <textarea name="alasan_pembatalan" class="w-full border rounded p-2 mb-4" rows="4" required></textarea>

            <div class="flex justify-end gap-3">
                <a href="{{ route('checkout.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">Cancel</a>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Submit Cancellation</button>
            </div>
        </form>
    </div>
</div>
@endsection
