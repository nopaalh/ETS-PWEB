@extends('layouts.app')
@section('title', 'Booking History')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-green-800 text-center mb-6">Booking History</h1>

    @if(session('success'))
        <p class="text-green-600 mb-4 text-center">{{ session('success') }}</p>
    @endif

    @if(empty($history))
        <p class="text-gray-500 text-center">No past bookings.</p>
    @else
        <table class="w-full border border-gray-300 rounded-lg">
            <thead class="bg-green-700 text-white">
                <tr>
                    <th class="p-2">Code</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Refund</th>
                    <th class="p-2">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history as $booking)
                <tr class="border-t hover:bg-gray-100">
                    <td class="p-2">{{ $booking['code'] }}</td>
                    <td class="p-2">{{ $booking['name'] }}</td>
                    <td class="p-2">{{ $booking['date'] }}</td>

                    {{-- Status --}}
                    <td class="p-2 {{ $booking['status'] === 'Cancelled' ? 'text-red-600' : 'text-gray-600' }}">
                        {{ $booking['status'] }}
                    </td>

                    <td class="p-2">
                        @if(isset($booking['refund']))
                            Rp {{ number_format($booking['refund'], 0, ',', '.') }}
                            @if(isset($booking['refund_rate']))
                                <span class="text-sm text-gray-500">({{ $booking['refund_rate'] }}%)</span>
                            @endif
                        @else
                            -
                        @endif
                    </td>

                    {{-- Details --}}
                    <td class="p-2 text-gray-700 text-center">
                        @if($booking['status'] === 'Cancelled')
                            Cancelled because {{ $booking['reason'] ?? 'no reason provided' }}
                        @elseif($booking['status'] === 'Completed')
                            Climbing done
                        @elseif($booking['status'] === 'Expired')
                            -
                        @else
                            {{ $booking['reason'] ?? '-' }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection