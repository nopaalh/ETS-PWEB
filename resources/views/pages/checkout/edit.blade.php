@extends('layouts.app')
@section('title', 'Edit Booking')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg p-8 rounded-xl">
    <h2 class="text-3xl font-bold text-center text-green-800 mb-6">Edit Booking</h2>

    <form action="{{ route('checkout.update', $booking->kode_booking) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium">Full Name</label>
            <input type="text" name="name" value="{{ $booking->nama_pendaki }}" class="w-full border rounded p-2" readonly>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Climbing Date</label>
            <input type="date" name="date" value="{{ $booking->tanggal_pendakian->format('Y-m-d') }}" class="w-full border rounded p-2" min="{{ now()->addDay()->format('Y-m-d') }}">
        </div>

        <div class="mb-4">
            <label class="block font-medium">Number of Climbers</label>
            <input type="number" name="climber" value="{{ $booking->jumlah_pendaki }}" class="w-full border rounded p-2" readonly>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Duration (days)</label>
            <input type="number" name="duration" value="{{ $booking->durasi_hari }}" class="w-full border rounded p-2" readonly>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
