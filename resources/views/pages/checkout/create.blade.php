@extends('layouts.app')
@section('title', 'Create Ticket Booking')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-lg p-8 rounded-xl">
    <h2 class="text-3xl font-bold text-center text-green-800 mb-6">Climbing Ticket Booking</h2>

    <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-green-700 mb-3">Climber Data</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="w-full border rounded p-2 @error('name') border-red-500 @enderror" 
                        placeholder="Climber name">
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Identity Number (KTP) <span class="text-red-500">*</span></label>
                    <input type="text" name="ktp" value="{{ old('ktp') }}" 
                        class="w-full border rounded p-2 @error('ktp') border-red-500 @enderror" 
                        placeholder="Number KTP">
                    @error('ktp') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                        class="w-full border rounded p-2 @error('phone') border-red-500 @enderror" 
                        placeholder="08xxxxxxxxxx">
                    @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full border rounded p-2 @error('email') border-red-500 @enderror" 
                        placeholder="email@example.com">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-green-700 mb-3">Climbing Data</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Choose Mountain <span class="text-red-500">*</span></label>
                    <select name="mountain_id" class="w-full border rounded p-2 @error('mountain_id') border-red-500 @enderror">
                        <option value="">-- Choose Mountain --</option>
                        <option value="1" {{ old('mountain_id') == 1 ? 'selected' : '' }}>Mt. Bromo</option>
                        <option value="2" {{ old('mountain_id') == 2 ? 'selected' : '' }}>Mt. Rinjani</option>
                        <option value="3" {{ old('mountain_id') == 3 ? 'selected' : '' }}>Mt. Semeru</option>
                    </select>
                    @error('mountain_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Climbing Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" value="{{ old('date') }}" 
                        class="w-full border rounded p-2 @error('date') border-red-500 @enderror">
                    @error('date') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Number of Climbers <span class="text-red-500">*</span></label>
                    <input type="number" name="A" value="{{ old('A') }}" min="1"
                        class="w-full border rounded p-2 @error('A') border-red-500 @enderror" 
                        placeholder="Number of People">
                    @error('A') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Climbing Duration (day) <span class="text-red-500">*</span></label>
                    <input type="number" name="duration" value="{{ old('duration') }}" min="1"
                        class="w-full border rounded p-2 @error('duration') border-red-500 @enderror" 
                        placeholder="Example: 3">
                    @error('duration') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-semibold text-green-700 mb-3">Payment</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Payment Method <span class="text-red-500">*</span></label>
                    <select name="metode" class="w-full border rounded p-2 @error('metode') border-red-500 @enderror">
                        <option value="">-- Choose Method --</option>
                        <option value="transfer" {{ old('metode') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="ewallet" {{ old('metode') == 'ewallet' ? 'selected' : '' }}>E-Wallet (Dana/OVO/Gopay)</option>
                    </select>
                    @error('metode') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Payment Amount <span class="text-red-500">*</span></label>
                    <input type="number" name="amount" value="{{ old('amount') }}"
                        class="w-full border rounded p-2 @error('amount') border-red-500 @enderror" placeholder="Rp">
                    @error('amount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block mb-1 font-medium">Upload Proof of Payment <span class="text-red-500">*</span></label>
                    <input type="file" name="proof" class="w-full border rounded p-2 @error('proof') border-red-500 @enderror">
                    @error('proof') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="text-center">
            <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800">
                Send Order
            </button>
        </div>
    </form>
</div>
@endsection