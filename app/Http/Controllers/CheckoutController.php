<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PesananTiket;
use App\Models\Gunung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Display a listing of user's bookings
     */
    public function index()
    {
        $bookings = PesananTiket::byUser(Auth::id())
                    ->with('gunung')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('pages.checkout.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking
     */
    public function create()
    {
        $gunungs = Gunung::all();
        return view('pages.checkout.create', compact('gunungs'));
    }

    /**
     * Store a newly created booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'ktp' => 'required|string|size:16',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'mountain_id' => 'required|exists:gunungs,id',
            'date' => 'required|date|after:today',
            'climber' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'metode' => 'required|in:BCA,BRI',
            'amount' => 'required|numeric|min:1',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Upload bukti pembayaran
        $buktiPath = null;
        if ($request->hasFile('proof')) {
            $buktiPath = $request->file('proof')->store('bukti-pembayaran', 'public');
        }

        // Buat pesanan baru
        $pesanan = new PesananTiket();
        $pesanan->kode_booking = PesananTiket::generateKodeBooking();
        $pesanan->user_id = Auth::id();
        $pesanan->gunung_id = $validated['mountain_id'];
        $pesanan->nama_pendaki = $validated['name'];
        $pesanan->nomor_ktp = $validated['ktp'];
        $pesanan->nomor_telepon = $validated['phone'];
        $pesanan->email = $validated['email'];
        $pesanan->tanggal_pendakian = $validated['date'];
        $pesanan->jumlah_pendaki = $validated['climber'];
        $pesanan->durasi_hari = $validated['duration'];
        $pesanan->metode_pembayaran = $validated['metode'];
        $pesanan->total_harga = $validated['amount'];
        $pesanan->bukti_pembayaran = $buktiPath;
        $pesanan->status_pembayaran = 'pending';
        $pesanan->save();

        return redirect()->route('checkout.success', $pesanan->kode_booking)
                        ->with('success', 'Pesanan berhasil dibuat! Kode booking: ' . $pesanan->kode_booking);
    }

    /**
     * Display the success page
     */
    public function success($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->with('gunung')
                               ->firstOrFail();

        return view('pages.checkout.success', compact('booking'));
    }

    /**
     * Show the form for editing a booking
     */
    public function edit($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->byUser(Auth::id())
                               ->with('gunung')
                               ->firstOrFail();

        // Cek apakah masih bisa diedit (belum dibatalkan)
        if ($booking->status_pembayaran === 'cancelled') {
            return redirect()->route('checkout.index')
                           ->with('error', 'Pesanan yang sudah dibatalkan tidak bisa diedit!');
        }

        return view('pages.checkout.edit', compact('booking'));
    }

    /**
     * Update the specified booking
     */
    public function update(Request $request, $kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->byUser(Auth::id())
                               ->firstOrFail();

        $validated = $request->validate([
            'date' => 'required|date|after:' . $booking->tanggal_pendakian,
        ]);

        // Update hanya tanggal pendakian (hanya bisa diundur)
        $booking->tanggal_pendakian = $validated['date'];
        $booking->save();

        return redirect()->route('checkout.index')
                        ->with('success', 'Tanggal pendakian berhasil diperbarui!');
    }

    /**
     * Show cancel confirmation page
     */
    public function cancelPage($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->byUser(Auth::id())
                               ->with('gunung')
                               ->firstOrFail();

        if ($booking->status_pembayaran === 'cancelled') {
            return redirect()->route('checkout.index')
                           ->with('error', 'Pesanan ini sudah dibatalkan sebelumnya!');
        }

        return view('pages.checkout.cancel', compact('booking'));
    }

    /**
     * Process booking cancellation with 70% refund
     */
    public function cancelProcess(Request $request, $kodeBooking)
    {
        $validated = $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->byUser(Auth::id())
                               ->firstOrFail();

        if ($booking->status_pembayaran === 'cancelled') {
            return redirect()->route('checkout.index')
                           ->with('error', 'Pesanan ini sudah dibatalkan sebelumnya!');
        }

        // Hitung refund 70%
        $refund = $booking->hitungRefund();

        // Update status pembatalan
        $booking->status_pembayaran = 'cancelled';
        $booking->alasan_pembatalan = $validated['reason'];
        $booking->jumlah_refund = $refund;
        $booking->tanggal_pembatalan = Carbon::now();
        $booking->save();

        return redirect()->route('checkout.index')
                        ->with('success', 'Pesanan berhasil dibatalkan! Refund 70%: Rp ' . number_format($refund, 0, ',', '.'));
    }

    /**
     * Delete a booking (hard delete)
     */
    public function destroy($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->byUser(Auth::id())
                               ->firstOrFail();

        // Hapus file bukti pembayaran jika ada
        if ($booking->bukti_pembayaran) {
            Storage::disk('public')->delete($booking->bukti_pembayaran);
        }

        $booking->delete();

        return redirect()->route('checkout.index')
                        ->with('success', 'Pesanan berhasil dihapus!');
    }

    /**
     * Admin: Update booking status to success
     */
    public function updateStatus($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)->firstOrFail();

        // Update status menjadi sukses
        $booking->status_pembayaran = 'success';
        $booking->save();

        return redirect()->back()
                        ->with('success', 'Status pesanan berhasil diubah menjadi sukses!');
    }
}
