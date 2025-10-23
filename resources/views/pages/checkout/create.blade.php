@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-2xl font-bold mb-4 text-green-700">Ticket Checkout</h2>

    <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        {{-- Climber Data --}}
        <h4 class="text-lg font-semibold text-green-800 mb-3">Climber Data</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg p-2">
                @error('name') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium">Identity Number (KTP) *</label>
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
        <h4 class="text-lg font-semibold text-green-800 mt-6 mb-3">Climbing Data</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Choose Mountain *</label>
                <select name="mountain_id" class="w-full border rounded-lg p-2">
                    <option value="">-- Choose Mountain --</option>
                    @foreach ($gunungs as $g)
                        <option value="{{ $g->id }}" {{ old('mountain_id') == $g->id ? 'selected' : '' }}>
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
                <input type="number" name="climber" min="1" value="{{ old('climber') }}" class="w-full border rounded-lg p-2">
                @error('climber') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Climbing Duration (days) *</label>
                <input type="number" name="duration" min="1" value="{{ old('duration') }}" class="w-full border rounded-lg p-2">
                @error('duration') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
        </div>

        {{-- Payment Data --}}
        <h4 class="text-lg font-semibold text-green-800 mt-6 mb-3">Payment</h4>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium">Payment Method *</label>
                <select name="metode" class="w-full border rounded-lg p-2">
                    <option value="">-- Choose Bank --</option>
                    <option value="BCA" {{ old('metode') == 'BCA' ? 'selected' : '' }}>BCA</option>
                    <option value="BRI" {{ old('metode') == 'BRI' ? 'selected' : '' }}>BRI</option>
                </select>
                @error('metode') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium">Payment Amount (Rp) *</label>
                <input type="number" name="amount" min="0" value="{{ old('amount') }}" class="w-full border rounded-lg p-2">
                @error('amount') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium">Upload Proof of Payment *</label>
                <input type="file" name="proof" class="w-full border rounded-lg p-2">
                @error('proof') <small class="text-red-600">{{ $message }}</small> @enderror
            </div>
        </div>

        <div class="mt-6 text-center">
            <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg">
                Send Order
            </button>
        </div>
    </form>
</div>
@endsection
