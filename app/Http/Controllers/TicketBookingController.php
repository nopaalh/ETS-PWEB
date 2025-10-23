<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketBookingController extends Controller
{
    /** Display all active bookings (and move expired to history) */
    public function index()
    {
        $bookings = session('bookings', []);
        $history = session('history', []);

        foreach ($bookings as $code => $booking) {
            // Pastikan data tanggal dan durasi valid
            if (empty($booking['date']) || empty($booking['duration'])) {
                continue;
            }

            try {
                $endDate = Carbon::parse($booking['date'])->addDays((int)$booking['duration']);
            } catch (\Exception $e) {
                continue;
            }

            // Jika pendakian sudah selesai
            if (Carbon::now()->greaterThan($endDate)) {
                $booking['status'] = 'Expired';
                $history[$code] = $booking;
                unset($bookings[$code]);
            }

            // Jika dibatalkan, pindahkan juga
            if (isset($booking['status']) && $booking['status'] === 'Cancelled') {
                $history[$code] = $booking;
                unset($bookings[$code]);
            }
        }

        // Simpan kembali session
        session()->put('bookings', $bookings);
        session()->put('history', $history);

        return view('pages.checkout.index', compact('bookings'));
    }

    /** Show booking creation form */
    public function create()
    {
        return view('pages.checkout.create');
    }

    /** Store a new booking into session */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'ktp' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'mountain_id' => 'required',
            'date' => 'required|date',
            'climber' => 'required|numeric|min:1',
            'duration' => 'required|numeric|min:1',
            'metode' => 'required',
            'amount' => 'required',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $bookingCode = 'BK' . strtoupper(uniqid());
        $bookings = session('bookings', []);

        // Bersihkan titik pemisah ribuan (misal "14.000" jadi "14000")
        $cleanAmount = str_replace('.', '', $request->amount);

        $newBooking = [
            'code' => $bookingCode,
            'name' => $request->name,
            'mountain_id' => $request->mountain_id,
            'date' => $request->date,
            'climber' => $request->climber,
            'duration' => $request->duration,
            'metode' => $request->metode,
            'amount' => (int) $cleanAmount, // sudah dikonversi jadi integer
            'status' => 'Active',
        ];

        $bookings[$bookingCode] = $newBooking;
        session()->put('bookings', $bookings);

        return redirect()->route('checkout.success')->with('booking', $newBooking);
    }

    /** Display booking success page */
    public function success(Request $request)
    {
        $booking = session('booking');

        if (!$booking) {
            return redirect()->route('checkout.create')->with('error', 'Booking data not found.');
        }

        $climbDate = Carbon::parse($booking['date']);
        if (Carbon::now()->greaterThan($climbDate->addDays(7))) {
            $booking['status'] = 'Expired';
        }

        return view('pages.checkout.success', compact('booking'));
    }

    /** Display booking details */
    public function show($code)
    {
        $bookings = session('bookings', []);

        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }

        $booking = $bookings[$code];
        return view('pages.checkout.show', compact('booking'));
    }

    /** Show booking edit form */
    public function edit($code)
    {
        $bookings = session('bookings', []);

        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }

        $booking = $bookings[$code];
        return view('pages.checkout.edit', compact('booking'));
    }

    /** Update booking details */
    public function update(Request $request, $code)
    {
        $bookings = session('bookings', []);

        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }

        $bookings[$code]['name'] = $request->name;
        $bookings[$code]['date'] = $request->date;
        $bookings[$code]['climber'] = $request->climber;
        $bookings[$code]['duration'] = $request->duration;
        $bookings[$code]['amount'] = $request->amount;

        session()->put('bookings', $bookings);

        return redirect()->route('checkout.index')->with('success', 'Booking updated successfully.');
    }

    /** Show cancel confirmation form */
    public function cancelForm($code)
    {
        $bookings = session('bookings', []);

        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }

        $booking = $bookings[$code];
        return view('pages.checkout.cancel', compact('booking'));
    }

    /** Handle booking cancellation (move to history) */
    public function cancel(Request $request, $code)
    {
        $bookings = session('bookings', []);
        $history = session('history', []);

        if (!isset($bookings[$code])) {
            return redirect()->route('checkout.index')->with('error', 'Booking not found.');
        }

        $refundRate = 0.7; // 70% refund
        $booking = $bookings[$code];

        // Pastikan amount ada
        $amount = isset($booking['amount']) && $booking['amount'] > 0 ? (float)$booking['amount'] : 0;

        // Simpan data refund
        $booking['status'] = 'Cancelled';
        $booking['reason'] = $request->reason ?? 'No reason provided';
        $booking['refund_rate'] = $refundRate * 100;
        $booking['refund'] = $amount > 0 ? round($amount * $refundRate, 0) : 0;
        $booking['cancel_date'] = Carbon::now()->format('Y-m-d H:i:s');

        // Pindahkan ke history
        $history[$code] = $booking;
        unset($bookings[$code]);

        session()->put('bookings', $bookings);
        session()->put('history', $history);

        return redirect()->route('history.index')->with('success', 'Booking cancelled and moved to history.');
    }

    /** Show booking history */
    public function history()
    {
        $history = session('history', []);
        return view('pages.history.index', compact('history'));
    }
}