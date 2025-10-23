<?php

namespace App\Http\Controllers;

use App\Models\Gunung;
use App\Models\PesananTiket;
use Illuminate\Http\Request;

class GunungController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy', 'dashboard']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gunungs = Gunung::all();
        return view('pages.mountain.index', compact('gunungs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gunungs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gunung' => 'required|string|max:255',
            'lokasi_provinsi' => 'required|string|max:255',
            'lokasi_kabupaten' => 'required|string|max:255',
            'ketinggian' => 'required|integer|min:1',
            'level_kesulitan' => 'required|in:easy,medium,hard',
            'gambar' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'harga_tiket' => 'required|numeric|min:0',
            'kuota_harian' => 'required|integer|min:1',
        ]);

        Gunung::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Gunung berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gunung = Gunung::findOrFail($id);
        return view('pages.mountain.show', compact('gunung'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $gunung = Gunung::findOrFail($id);
        return view('admin.gunungs.edit', compact('gunung'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $gunung = Gunung::findOrFail($id);

        $validated = $request->validate([
            'nama_gunung' => 'required|string|max:255',
            'lokasi_provinsi' => 'required|string|max:255',
            'lokasi_kabupaten' => 'required|string|max:255',
            'ketinggian' => 'required|integer|min:1',
            'level_kesulitan' => 'required|in:easy,medium,hard',
            'gambar' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'harga_tiket' => 'required|numeric|min:0',
            'kuota_harian' => 'required|integer|min:1',
        ]);

        $gunung->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Gunung berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $gunung = Gunung::findOrFail($id);
        $gunung->delete();

        return redirect()->route('mountain.index')
            ->with('success', 'Gunung berhasil dihapus!');
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $totalGunung = Gunung::count();
        $gunungAktif = Gunung::where('status', 'active')->count();
        $totalBookings = PesananTiket::count();
        $pendingBookings = PesananTiket::where('status_pembayaran', 'pending')->count();
        $pendingBookingsList = PesananTiket::where('status_pembayaran', 'pending')
            ->with('gunung')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact('totalGunung', 'gunungAktif', 'totalBookings', 'pendingBookings', 'pendingBookingsList'));
    }
}
