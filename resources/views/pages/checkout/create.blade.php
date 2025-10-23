@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-2xl font-bold mb-4 text-green-700">Ticket Checkout</h2>

    <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        {{-- Climber Data --}}
        <h4 class="text-lg font-semibold text-green-800 mb-3">Climber Information</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg p-2">
                @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Identity Number (ID Card) *</label>
                <input type="text" name="ktp" value="{{ old('ktp') }}" class="w-full border rounded-lg p-2">
                @error('ktp') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Phone Number *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="w-full border rounded-lg p-2">
                @error('phone') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg p-2">
                @error('email') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Climbing Data --}}
        <h4 class="text-lg font-semibold text-green-800 mt-6 mb-3">Climbing Information</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Select Mountain *</label>
                <select name="mountain_id" id="mountain_id" class="w-full border rounded-lg p-2" onchange="calculateAmount()">
                    <option value="">-- Select Mountain --</option>
                    @foreach ($gunungs as $g)
                        <option value="{{ $g->id }}" data-price="{{ $g->harga_tiket }}" {{ old('mountain_id') == $g->id ? 'selected' : '' }}>
                            {{ $g->nama_gunung }} - Rp {{ number_format($g->harga_tiket, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('mountain_id') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Climbing Date *</label>
                <input type="date" name="date" value="{{ old('date') }}" class="w-full border rounded-lg p-2" min="{{ now()->addDay()->format('Y-m-d') }}">
                @error('date') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Number of Climbers *</label>
                <input type="number" name="climber" id="climber" min="1" value="{{ old('climber') }}" class="w-full border rounded-lg p-2" onchange="calculateAmount()">
                @error('climber') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Climbing Duration (days) *</label>
                <input type="number" name="duration" id="duration" min="1" value="{{ old('duration') }}" class="w-full border rounded-lg p-2" onchange="calculateAmount()">
                @error('duration') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Payment Data --}}
        <h4 class="text-lg font-semibold text-green-800 mt-6 mb-3">Payment Information</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Payment Method *</label>
                <select name="metode" id="metode" class="w-full border rounded-lg p-2" onchange="showBankInfo()">
                    <option value="">-- Select Bank --</option>
                    <option value="BCA" {{ old('metode') == 'BCA' ? 'selected' : '' }}>BCA - 1234567890 (a.n. Nashwa Umi Setiawan)</option>
                    <option value="BRI" {{ old('metode') == 'BRI' ? 'selected' : '' }}>BRI - 0987654321 (a.n. Nashwa Umi Setiawan)</option>
                </select>
                @error('metode') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Payment Amount (Rp) *</label>
                <input type="number" name="amount" id="amount" min="0" value="{{ old('amount') }}" class="w-full border rounded-lg p-2" readonly>
                @error('amount') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium">Upload Payment Proof *</label>
                <input type="file" name="proof" class="w-full border rounded-lg p-2">
                @error('proof') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="mt-6 text-center">
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg">
                Submit Order
            </button>
        </div>
    </form>
</div>

<script>
function calculateAmount() {
    const mountainSelect = document.getElementById('mountain_id');
    const climberInput = document.getElementById('climber');
    const durationInput = document.getElementById('duration');
    const amountInput = document.getElementById('amount');

    const selectedOption = mountainSelect.options[mountainSelect.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    const climber = climberInput.value;
    const duration = durationInput.value;

    if (price && climber && duration) {
        const total = price * climber * duration;
        amountInput.value = total;
    } else {
        amountInput.value = '';
    }
}

function showBankInfo() {
    const metode = document.getElementById('metode').value;
    let info = '';

    switch(metode) {
        case 'BCA':
            info = 'Please transfer to this Bank Account BCA 1234567890 a.n. Nashwa Umi Setiawan';
            break;
        case 'BRI':
            info = 'Please transfer to this Bank Account BRI 0987654321 a.n. Nashwa Umi Setiawan';
            break;
    }

    if(info) {
        alert(info);
    }
}

// Calculate amount on page load if values are already set
document.addEventListener('DOMContentLoaded', function() {
    calculateAmount();
});
</script>
@endsection