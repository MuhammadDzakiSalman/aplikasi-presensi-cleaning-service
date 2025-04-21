<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\JamKerja;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jamKerja = JamKerja::first();
        $izins = Izin::where('user_id', $user->id)
                    ->whereDate('created_at', today()->toDateString())
                    ->get();

        return view('users.home', compact('izins', 'jamKerja'));
    }
}
