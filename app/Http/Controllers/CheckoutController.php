<?php

namespace App\Http\Controllers;

use App\Models\PesananTiket;
use App\Models\Gunung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index()
    {
        $bookings = PesananTiket::byUser(Auth::id())
                    ->with('gunung')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('pages.checkout.index', compact('bookings'));
    }

    public function create()
    {
        $gunungs = Gunung::all();
        return view('pages.checkout.create', compact('gunungs'));
    }

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

        $buktiPath = $request->file('proof')->store('bukti-pembayaran', 'public');

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

    public function success($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->with('gunung')
                               ->firstOrFail();

        return view('pages.checkout.success', compact('booking'));
    }

    public function edit($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->byUser(Auth::id())
                               ->with('gunung')
                               ->firstOrFail();

        $gunungs = Gunung::all();

        if ($booking->status_pembayaran === 'cancelled') {
            return redirect()->route('checkout.index')
                            ->with('error', 'Pesanan yang sudah dibatalkan tidak bisa diedit!');
        }

        return view('pages.checkout.edit', compact('booking', 'gunungs'));
    }

    public function update(Request $request, $kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->byUser(Auth::id())
                               ->firstOrFail();

        $validated = $request->validate([
            'mountain_id' => 'required|exists:gunungs,id',
            'date' => 'required|date|after:today',
            'climber' => 'required|integer|min:1',
            'duration' => 'required|integer|min:1',
            'metode' => 'required|in:BCA,BRI',
            'amount' => 'required|numeric|min:1',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', 
        ]);

        if ($booking->bukti_pembayaran) {
            Storage::disk('public')->delete($booking->bukti_pembayaran);
        }

        $buktiPath = $request->file('proof')->store('bukti-pembayaran', 'public');

        $booking->update([
            'gunung_id' => $validated['mountain_id'],
            'tanggal_pendakian' => $validated['date'],
            'jumlah_pendaki' => $validated['climber'],
            'durasi_hari' => $validated['duration'],
            'metode_pembayaran' => $validated['metode'],
            'total_harga' => $validated['amount'],
            'bukti_pembayaran' => $buktiPath,
            'status_pembayaran' => 'pending', 
        ]);

        return redirect()->route('checkout.index')
                        ->with('success', 'Booking berhasil diperbarui! Bukti pembayaran baru telah diunggah.');
    }

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

        $refund = $booking->hitungRefund();
        $booking->status_pembayaran = 'cancelled';
        $booking->alasan_pembatalan = $validated['reason'];
        $booking->jumlah_refund = $refund;
        $booking->tanggal_pembatalan = Carbon::now();
        $booking->save();

        return redirect()->route('checkout.index')
                        ->with('success', 'Pesanan berhasil dibatalkan! Refund 70%: Rp ' . number_format($refund, 0, ',', '.'));
    }

    public function destroy($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)
                               ->byUser(Auth::id())
                               ->firstOrFail();

        if ($booking->bukti_pembayaran) {
            Storage::disk('public')->delete($booking->bukti_pembayaran);
        }

        $booking->delete();

        return redirect()->route('checkout.index')
                        ->with('success', 'Pesanan berhasil dihapus!');
    }

    public function updateStatus($kodeBooking)
    {
        $booking = PesananTiket::where('kode_booking', $kodeBooking)->firstOrFail();
        $booking->status_pembayaran = 'success';
        $booking->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diubah menjadi sukses!');
    }
}