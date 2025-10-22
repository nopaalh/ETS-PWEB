@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Cancel Booking</h2>

    <p><strong>Mountain:</strong> {{ $order['gunung'] }}</p>
    <p><strong>Price:</strong> Rp{{ number_format($order['harga']) }}</p>

    <form action="{{ url('/pemesanan/' . $order['id'] . '/cancel') }}" method="POST">
        @csrf
        <label class="block mt-4 mb-2 font-medium">Reason for Cancellation</label>
        <textarea name="reason" class="w-full border rounded p-2" required></textarea>

        <p class="mt-4 text-sm text-gray-600">
            Refund amount: <strong class="text-green-600">Rp{{ number_format($order['harga'] * 0.7) }}</strong> (70%)
        </p>

        <div class="mt-6 flex justify-between">
            <a href="{{ url('/pemesanan') }}" class="text-gray-500">Back</a>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Confirm Cancellation
            </button>
        </div>
    </form>
</div>
@endsection