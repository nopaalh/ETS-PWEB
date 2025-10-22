<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Informasi Pesanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <strong>Kode Pesanan:</strong> {{ $pesananTiket->kode_pesanan }}
                            </div>
                            <div>
                                <strong>Status:</strong>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ml-2
                                    @if($pesananTiket->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($pesananTiket->status == 'confirmed') bg-green-100 text-green-800
                                    @elseif($pesananTiket->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($pesananTiket->status) }}
                                </span>
                            </div>
                            <div>
                                <strong>Gunung:</strong> {{ $pesananTiket->gunung->nama_gunung }}
                            </div>
                            <div>
                                <strong>Lokasi:</strong> {{ $pesananTiket->gunung->lokasi_provinsi }}, {{ $pesananTiket->gunung->lokasi_kabupaten }}
                            </div>
                            <div>
                                <strong>Jumlah Tiket:</strong> {{ $pesananTiket->jumlah_tiket }}
                            </div>
                            <div>
                                <strong>Harga per Tiket:</strong> Rp {{ number_format($pesananTiket->gunung->harga_tiket, 0, ',', '.') }}
                            </div>
                            <div>
                                <strong>Tanggal Naik:</strong> {{ \Carbon\Carbon::parse($pesananTiket->tanggal_naik)->format('d M Y') }}
                            </div>
                            <div>
                                <strong>Tanggal Turun:</strong> {{ \Carbon\Carbon::parse($pesananTiket->tanggal_turun)->format('d M Y') }}
                            </div>
                            <div>
                                <strong>Total Harga:</strong> Rp {{ number_format($pesananTiket->total_harga, 0, ',', '.') }}
                            </div>
                            <div>
                                <strong>Metode Pembayaran:</strong> {{ ucfirst($pesananTiket->metode_bayar) }}
                            </div>
                        </div>
                    </div>

                    @if($pesananTiket->catatan)
                        <div class="mb-6">
                            <h4 class="text-md font-medium mb-2">Catatan:</h4>
                            <p class="text-gray-600">{{ $pesananTiket->catatan }}</p>
                        </div>
                    @endif

                    @if($pesananTiket->bukti_bayar)
                        <div class="mb-6">
                            <h4 class="text-md font-medium mb-2">Bukti Pembayaran:</h4>
                            <img src="{{ asset('storage/' . $pesananTiket->bukti_bayar) }}" alt="Bukti Pembayaran" class="max-w-xs">
                        </div>
                    @endif

                    <div class="flex items-center justify-between">
                        <a href="{{ route('pesanan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Kembali ke Daftar Pesanan
                        </a>

                        @if($pesananTiket->status == 'pending')
                            <div>
                                <a href="{{ route('pesanan.edit', $pesananTiket) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Edit Pesanan
                                </a>
                                <form method="POST" action="{{ route('pesanan.destroy', $pesananTiket) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                        Hapus Pesanan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
