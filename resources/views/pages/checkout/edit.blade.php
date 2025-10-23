@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white shadow-md rounded-2xl p-6">
    <h2 class="text-2xl font-bold text-green-700 mb-6">Edit Booking</h2>

    <form action="{{ route('checkout.update', $booking->kode_booking) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Personal Info --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block font-semibold text-gray-700">Full Name *</label>
                <input type="text" name="name" value="{{ $booking->nama_pendaki }}" readonly
                       class="w-full border rounded p-2 bg-gray-100 cursor-not-allowed">
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Identity Number (ID Card) *</label>
                <input type="text" name="ktp" value="{{ $booking->nomor_ktp }}" readonly
                       class="w-full border rounded p-2 bg-gray-100 cursor-not-allowed">
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Phone Number *</label>
                <input type="text" name="phone" value="{{ $booking->nomor_telepon }}" readonly
                       class="w-full border rounded p-2 bg-gray-100 cursor-not-allowed">
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Email *</label>
                <input type="email" name="email" value="{{ $booking->email }}" readonly
                       class="w-full border rounded p-2 bg-gray-100 cursor-not-allowed">
            </div>
        </div>

        {{-- Climbing Info --}}
        <h3 class="text-lg font-bold text-green-700 mb-2">Climbing Information</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block font-semibold text-gray-700">Select Mountain *</label>
                <select name="mountain_id" id="mountain_id" class="w-full border rounded p-2" required>
                    <option value="">-- Select Mountain --</option>
                    @foreach ($gunungs as $g)
                        <option value="{{ $g->id }}" data-price="{{ $g->harga_tiket }}"
                            {{ $booking->gunung_id == $g->id ? 'selected' : '' }}>
                            {{ $g->nama_gunung }} - Rp {{ number_format($g->harga_tiket, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Climbing Date *</label>
                <input type="date" name="date" value="{{ $booking->tanggal_pendakian->format('Y-m-d') }}"
                       class="w-full border rounded p-2" required>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Number of Climbers *</label>
                <input type="number" name="climber" id="climber" value="{{ $booking->jumlah_pendaki }}"
                       class="w-full border rounded p-2" required min="1">
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Duration (days) *</label>
                <input type="number" name="duration" id="duration" value="{{ $booking->durasi_hari }}"
                       class="w-full border rounded p-2" required min="1">
            </div>
        </div>

        {{-- Payment Info --}}
        <h3 class="text-lg font-bold text-green-700 mb-2">Payment Information</h3>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block font-semibold text-gray-700">Payment Method *</label>
                <select name="metode" class="w-full border rounded p-2" required>
                    <option value="BCA" {{ $booking->metode_pembayaran == 'BCA' ? 'selected' : '' }}>
                        BCA - 1234567890 (a.n. Admin Pendakian)
                    </option>
                    <option value="BRI" {{ $booking->metode_pembayaran == 'BRI' ? 'selected' : '' }}>
                        BRI - 0987654321 (a.n. Nashwa Umi Setiawan)
                    </option>
                </select>
            </div>
            <div>
                <label class="block font-semibold text-gray-700">Payment Amount (Rp) *</label>
                <input type="number" name="amount" id="amount" value="{{ $booking->total_harga }}"
                       class="w-full border rounded p-2" required readonly>
            </div>
        </div>

        {{-- Proof of Payment --}}
        <h3 class="text-lg font-bold text-green-700 mb-2">Upload Payment Proof *</h3>
        <div class="mb-6">
            @if ($booking->bukti_pembayaran)
                <p class="mb-2">Current file: 
                    <a href="{{ asset('storage/' . $booking->bukti_pembayaran) }}" target="_blank" class="text-blue-500 underline">
                        View previous proof
                    </a>
                </p>
            @endif
            <input type="file" name="proof" class="w-full border rounded p-2" required>
            @error('proof') <small class="text-red-600">{{ $message }}</small> @enderror
        </div>

        {{-- Submit --}}
        <div class="text-center">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded">
                Update Booking
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mountainSelect = document.getElementById('mountain_id');
        const climberInput = document.getElementById('climber');
        const durationInput = document.getElementById('duration');
        const amountInput = document.getElementById('amount');

        function updateTotal() {
            const price = mountainSelect.options[mountainSelect.selectedIndex]?.dataset.price || 0;
            const climbers = parseInt(climberInput.value) || 0;
            const days = parseInt(durationInput.value) || 0;
            amountInput.value = price * climbers * days;
        }

        mountainSelect.addEventListener('change', updateTotal);
        climberInput.addEventListener('input', updateTotal);
        durationInput.addEventListener('input', updateTotal);
    });
</script>
@endsection