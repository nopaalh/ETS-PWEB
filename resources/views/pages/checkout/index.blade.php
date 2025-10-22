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
                    <td class="p-2">{{ $booking['code'] }}</td>
                    <td class="p-2">{{ $booking['name'] }}</td>
                    <td class="p-2">{{ $booking['date'] }}</td>
                    <td class="p-2 {{ $booking['status'] == 'Canceled' ? 'text-red-600' : 'text-green-700' }}">
                        {{ $booking['status'] }}
                    </td>
                    <td class="p-2">
                        @if(isset($booking['refund']))
                            Rp {{ number_format($booking['refund'], 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="p-2 flex gap-2 justify-center">
                        @if($booking['status'] !== 'Canceled')
                        <a href="{{ route('checkout.edit', $booking['code']) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                            Edit
                        </a>
                        <button onclick="openCancelModal('{{ $booking['code'] }}')" 
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

<!-- 🔹 Modal Alasan Pembatalan -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96 shadow-lg">
        <h2 class="text-lg font-semibold mb-2">Batalkan checkout</h2>
        <p class="text-sm text-gray-600 mb-4">Berikan alasan pembatalan dan setujui pengembalian 70%.</p>
        <form id="cancelForm" method="POST">
            @csrf
            <textarea name="reason" rows="3" class="w-full border rounded p-2 mb-3" 
                      placeholder="Alasan pembatalan..." required></textarea>
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeCancelModal()" class="px-3 py-1 border rounded">Batal</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCancelModal(code) {
    document.getElementById('cancelModal').classList.remove('hidden');
    document.getElementById('cancelForm').action = '/checkout/delete/' + code;
}
function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}
</script>
@endsection