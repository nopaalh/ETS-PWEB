@extends('layouts.app')
@section('title', 'Ticket Booking List')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-green-800 text-center mb-6">Ticket Booking List</h1>

    <a href="{{ route('checkout.create') }}"
       class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
        + Create a New Order
    </a>

    @if(session('success'))
        <p class="text-green-600 mb-4">{{ session('success') }}</p>
    @endif

    @if(empty($bookings))
        <p class="text-gray-500 text-center">No bookings yet.</p>
    @else
        <table class="w-full border border-gray-300 rounded-lg">
            <thead class="bg-green-700 text-white">
                <tr>
                    <th class="p-2">Code</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Refund</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $booking)
                <tr class="border-t hover:bg-gray-100">
<<<<<<< Updated upstream
                    <td class="p-2">{{ $booking['code'] }}</td>
                    <td class="p-2">{{ $booking['name'] }}</td>
                    <td class="p-2">{{ $booking['date'] }}</td>
                    <td class="p-2 {{ $booking['status'] == 'Cancelled' ? 'text-red-600' : 'text-green-700' }}">
                        {{ $booking['status'] }}
=======
                    <td class="p-2">{{ $booking->kode_booking }}</td>
                    <td class="p-2">{{ $booking->nama_pendaki }}</td>
                    <td class="p-2">{{ $booking->tanggal_pendakian->format('d/m/Y') }}</td>
                    <td class="p-2 {{ $booking->status_pembayaran == 'dibatalkan' ? 'text-red-600' : 'text-green-700' }}">
                        {{ ucfirst($booking->status_pembayaran) }}
>>>>>>> Stashed changes
                    </td>
                    <td class="p-2">
                        @if($booking->jumlah_refund)
                            Rp {{ number_format($booking->jumlah_refund, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-2 flex gap-2 justify-center">
<<<<<<< Updated upstream
                        {{-- Detail --}}
                        <a href="{{ route('checkout.show', $booking['code']) }}" 
                           class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            Detail
                        </a>

                        {{-- Edit & Cancel muncul hanya kalau belum dibatalkan --}}
                        @if($booking['status'] !== 'Cancelled')
                        <button onclick="openCancel('{{ $booking['code'] }}')" 
=======
                        @if($booking->status_pembayaran !== 'dibatalkan')
                        <a href="{{ route('checkout.edit', $booking->kode_booking) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <button onclick="openCancel('{{ $booking->kode_booking }}')"
>>>>>>> Stashed changes
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                            Cancel
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

<div id="Cancel" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Cancel Booking</h2>
        <p class="text-sm text-gray-600 mb-4">Provide a reason for cancellation and agree to a 70% refund.</p>
        <form id="cancelForm" method="POST">
            @csrf
            <textarea name="reason" rows="3" class="w-full border rounded p-2 mb-3"
                      placeholder="Reason for cancellation..." required></textarea>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCancel()" class="px-3 py-1 border rounded">Close</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCancel(code) {
    document.getElementById('Cancel').classList.remove('hidden');
    document.getElementById('cancelForm').action = '/checkout/cancel/' + code;
}
function closeCancel() {
    document.getElementById('Cancel').classList.add('hidden');
}
</script>
@endsection
