<?php

namespace App\Http\Controllers;

use App\Models\PesananTiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    /**
     * Display user's successful booking history
     */
    public function index()
    {
        $histories = PesananTiket::byUser(Auth::id())
                    ->byStatus('success')
                    ->with('gunung')
                    ->orderBy('updated_at', 'desc')
                    ->get();

        return view('pages.history.index', compact('histories'));
    }
}