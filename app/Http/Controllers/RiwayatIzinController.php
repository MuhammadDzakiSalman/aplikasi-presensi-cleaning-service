<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RiwayatIzinController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Mengecek role pengguna
        if ($user->role == 'cleaning_service') {
            // Jika role adalah 'cleaning_service', ambil data izin milik user tersebut
            $izins = Izin::where('user_id', $user->id)->get();

            // Direct ke view untuk user dengan data izin milik user
            return view('users.riwayat_izin', compact('izins'));
        } elseif ($user->role == 'admin') {
            // Jika role adalah 'admin', ambil semua data izin
            $izins = Izin::all();

            // Direct ke view untuk admin dengan semua data izin
            return view('admin.riwayat_izin', compact('izins'));
        }

        // Jika role tidak dikenali, Anda bisa menambahkan pengalihan ke halaman lain atau error
        return redirect()->route('home');
    }
}
