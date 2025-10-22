<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananTiket;
use App\Models\Gunung;

class PesananTiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesananTikets = PesananTiket::where('user_id', auth()->id())->get();
        return view('pesanan.index', compact('pesananTikets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gunungs = Gunung::where('status', 'active')->get();
        return view('pesanan.create', compact('gunungs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'gunung_id' => 'required|exists:gunungs,id',
            'jumlah_tiket' => 'required|integer|min:1',
            'tanggal_naik' => 'required|date|after:today',
            'tanggal_turun' => 'required|date|after:tanggal_naik',
            'metode_bayar' => 'required|in:transfer,cash',
        ]);

        // Cek kuota tersedia
        $gunung = Gunung::findOrFail($validated['gunung_id']);

        // Hitung total tiket yang sudah dipesan untuk tanggal tersebut
        $existingBookings = PesananTiket::where('gunung_id', $validated['gunung_id'])
            ->where('tanggal_naik', $validated['tanggal_naik'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('jumlah_tiket');

        // Cek apakah kuota mencukupi
        if ($existingBookings + $validated['jumlah_tiket'] > $gunung->kuota_harian) {
            return back()->withErrors(['jumlah_tiket' => 'Kuota tiket untuk tanggal tersebut tidak mencukupi.']);
        }

        // Buat pesanan tiket
        PesananTiket::create([
            'user_id' => auth()->id(),
            'gunung_id' => $validated['gunung_id'],
            'jumlah_tiket' => $validated['jumlah_tiket'],
            'tanggal_naik' => $validated['tanggal_naik'],
            'tanggal_turun' => $validated['tanggal_turun'],
            'metode_bayar' => $validated['metode_bayar'],
            'status' => 'pending',
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan tiket berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pesananTiket = PesananTiket::where('user_id', auth()->id())->findOrFail($id);
        return view('pesanan.show', compact('pesananTiket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pesananTiket = PesananTiket::where('user_id', auth()->id())->findOrFail($id);
        $gunungs = Gunung::where('status', 'active')->get();
        return view('pesanan.edit', compact('pesananTiket', 'gunungs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pesananTiket = PesananTiket::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'gunung_id' => 'required|exists:gunungs,id',
            'jumlah_tiket' => 'required|integer|min:1',
            'tanggal_naik' => 'required|date|after:today',
            'tanggal_turun' => 'required|date|after:tanggal_naik',
            'metode_bayar' => 'required|in:transfer,cash',
        ]);

        // Cek kuota tersedia jika ada perubahan
        $gunung = Gunung::findOrFail($validated['gunung_id']);

        $existingBookings = PesananTiket::where('gunung_id', $validated['gunung_id'])
            ->where('tanggal_naik', $validated['tanggal_naik'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('id', '!=', $id)
            ->sum('jumlah_tiket');

        if ($existingBookings + $validated['jumlah_tiket'] > $gunung->kuota_harian) {
            return back()->withErrors(['jumlah_tiket' => 'Kuota tiket untuk tanggal tersebut tidak mencukupi.']);
        }

        $pesananTiket->update($validated);

        return redirect()->route('pesanan.index')->with('success', 'Pesanan tiket berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pesananTiket = PesananTiket::where('user_id', auth()->id())->findOrFail($id);
        $pesananTiket->delete();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan tiket berhasil dihapus.');
    }
}
