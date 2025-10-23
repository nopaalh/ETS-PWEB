<?php

namespace App\Http\Controllers;

use App\Models\Gunung;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favoritGunung = $user->favorites()->with('gunung')->get();
        return view('pages.favorite.index', compact('favoritGunung'));
    }

    public function toggle(Gunung $gunung)
    {
        $user = Auth::user();

        $favorite = Favorite::where('user_id', $user->id)
                           ->where('gunung_id', $gunung->id)
                           ->first();

        if ($favorite) {
            $favorite->delete();
            $status = 'removed';
            $message = "Gunung {$gunung->nama_gunung} successfully removed from favorites!";
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'gunung_id' => $gunung->id,
            ]);
            $status = 'added';
            $message = "Gunung {$gunung->nama_gunung} successfully added to favorites!";
        }
        if (request()->ajax()) {
            return response()->json([
                'status' => $status,
                'message' => $message
            ]);
        }

        return back()->with('success', $message);
    }
}