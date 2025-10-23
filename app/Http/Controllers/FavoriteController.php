<?php

namespace App\Http\Controllers;

use App\Models\Gunung;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    // Menampilkan daftar gunung favorit user
    public function index()
    {
        $user = Auth::user();
        // Eager load relasi gunung dari favorites
        $favoritGunung = $user->favorites()->with('gunung')->get();
        return view('pages.favorite.index', compact('favoritGunung'));
    }

    // Toggle favorit (tambah / hapus)
    public function toggle(Gunung $gunung)
    {
        $user = Auth::user();

        // Cek apakah sudah ada di favorit
        $favorite = Favorite::where('user_id', $user->id)
                           ->where('gunung_id', $gunung->id)
                           ->first();

        if ($favorite) {
            // Sudah favorit, hapus
            $favorite->delete();
            $status = 'removed';
            $message = "Gunung {$gunung->nama_gunung} berhasil dihapus dari favorit! 💔";
        } else {
            // Belum favorit, tambah
            Favorite::create([
                'user_id' => $user->id,
                'gunung_id' => $gunung->id,
            ]);
            $status = 'added';
            $message = "Gunung {$gunung->nama_gunung} berhasil ditambahkan ke favorit! 💚";
        }

        // Jika AJAX request
        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
}