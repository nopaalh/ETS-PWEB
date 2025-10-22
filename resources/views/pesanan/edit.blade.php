<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pesanan Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('pesanan.update', $pesananTiket) }}">
                        @csrf
                        @method('PUT')

                        <!-- Gunung Selection -->
                        <div class="mb-4">
                            <x-input-label for="gunung_id" :value="__('Pilih Gunung')" />
                            <select name="gunung_id" id="gunung_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('gunung_id') border-red-500 @enderror" required>
                                <option value="">-- Pilih Gunung --</option>
                                @foreach($gunungs as $gunung)
                                    <option value="{{ $gunung->id }}" {{ old('gunung_id', $pesananTiket->gunung_id) == $gunung->id ? 'selected' : '' }}>
                                        {{ $gunung->nama_gunung }} - {{ $gunung->lokasi_provinsi }}, {{ $gunung->lokasi_kabupaten }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('gunung_id')" class="mt-2" />
                        </div>

                        <!-- Jumlah Tiket -->
                        <div class="mb-4">
                            <x-input-label for="jumlah_tiket" :value="__('Jumlah Tiket')" />
                            <x-text-input id="jumlah_tiket" class="block mt-1 w-full" type="number" name="jumlah_tiket" :value="old('jumlah_tiket', $pesananTiket->jumlah_tiket)" min="1" required />
                            <x-input-error :messages="$errors->get('jumlah_tiket')" class="mt-2" />
                        </div>

                        <!-- Tanggal Naik -->
                        <div class="mb-4">
                            <x-input-label for="tanggal_naik" :value="__('Tanggal Naik')" />
                            <x-text-input id="tanggal_naik" class="block mt-1 w-full" type="date" name="tanggal_naik" :value="old('tanggal_naik', $pesananTiket->tanggal_naik)" required />
                            <x-input-error :messages="$errors->get('tanggal_naik')" class="mt-2" />
                        </div>

                        <!-- Tanggal Turun -->
                        <div class="mb-4">
                            <x-input-label for="tanggal_turun" :value="__('Tanggal Turun')" />
                            <x-text-input id="tanggal_turun" class="block mt-1 w-full" type="date" name="tanggal_turun" :value="old('tanggal_turun', $pesananTiket->tanggal_turun)" required />
                            <x-input-error :messages="$errors->get('tanggal_turun')" class="mt-2" />
                        </div>

                        <!-- Metode Bayar -->
                        <div class="mb-4">
                            <x-input-label for="metode_bayar" :value="__('Metode Pembayaran')" />
                            <select name="metode_bayar" id="metode_bayar" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm @error('metode_bayar') border-red-500 @enderror" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="transfer" {{ old('metode_bayar', $pesananTiket->metode_bayar) == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="cash" {{ old('metode_bayar', $pesananTiket->metode_bayar) == 'cash' ? 'selected' : '' }}>Tunai</option>
                            </select>
                            <x-input-error :messages="$errors->get('metode_bayar')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('pesanan.show', $pesananTiket) }}" class="mr-4 text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>
                                {{ __('Update Pesanan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set minimum date for tanggal_naik to tomorrow
        document.getElementById('tanggal_naik').min = new Date(Date.now() + 86400000).toISOString().split('T')[0];

        // Update tanggal_turun min when tanggal_naik changes
        document.getElementById('tanggal_naik').addEventListener('change', function() {
            document.getElementById('tanggal_turun').min = this.value;
        });
    </script>
</x-app-layout>
