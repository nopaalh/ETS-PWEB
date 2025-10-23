<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesananTiket;
use App\Models\Gunung;

class PesananTiketController extends Controller
{
    public function index()
    {
        $pesananTikets = PesananTiket::where('user_id', auth()->id())->get();
        return view('pesanan.index', compact('pesananTikets'));
    }

    public function create()
    {
        $gunungs = Gunung::where('status', 'active')->get();
        return view('pesanan.create', compact('gunungs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gunung_id' => 'required|exists:gunungs,id',
            'jumlah_tiket' => 'required|integer|min:1',
            'tanggal_naik' => 'required|date|after:today',
            'tanggal_turun' => 'required|date|after:tanggal_naik',
            'metode_bayar' => 'required|in:transfer,cash',
        ]);

        $gunung = Gunung::findOrFail($validated['gunung_id']);

        $existingBookings = PesananTiket::where('gunung_id', $validated['gunung_id'])
            ->where('tanggal_naik', $validated['tanggal_naik'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->sum('jumlah_tiket');

        if ($existingBookings + $validated['jumlah_tiket'] > $gunung->kuota_harian) {
            return back()->withErrors(['jumlah_tiket' => 'The ticket quota for that date is insufficient.']);
        }

        PesananTiket::create([
            'user_id' => auth()->id(),
            'gunung_id' => $validated['gunung_id'],
            'jumlah_tiket' => $validated['jumlah_tiket'],
            'tanggal_naik' => $validated['tanggal_naik'],
            'tanggal_turun' => $validated['tanggal_turun'],
            'metode_bayar' => $validated['metode_bayar'],
            'status' => 'pending',
        ]);

        return redirect()->route('pesanan.index')->with('success', 'Ticket order successfully created.');
    }

    public function show(string $id)
    {
        $pesananTiket = PesananTiket::where('user_id', auth()->id())->findOrFail($id);
        return view('pesanan.show', compact('pesananTiket'));
    }

    public function edit(string $id)
    {
        $pesananTiket = PesananTiket::where('user_id', auth()->id())->findOrFail($id);
        $gunungs = Gunung::where('status', 'active')->get();
        return view('pesanan.edit', compact('pesananTiket', 'gunungs'));
    }

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

        $gunung = Gunung::findOrFail($validated['gunung_id']);

        $existingBookings = PesananTiket::where('gunung_id', $validated['gunung_id'])
            ->where('tanggal_naik', $validated['tanggal_naik'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('id', '!=', $id)
            ->sum('jumlah_tiket');

        if ($existingBookings + $validated['jumlah_tiket'] > $gunung->kuota_harian) {
            return back()->withErrors(['jumlah_tiket' => 'The ticket quota for that date is insufficient.']);
        }

        $pesananTiket->update($validated);

        return redirect()->route('pesanan.index')->with('success', 'Ticket order successfully updated.');
    }

    public function destroy(string $id)
    {
        $pesananTiket = PesananTiket::where('user_id', auth()->id())->findOrFail($id);
        $pesananTiket->delete();

        return redirect()->route('pesanan.index')->with('success', 'Ticket order successfully deleted.');
    }
}
