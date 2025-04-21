<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\JamKerja;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PresensiController extends Controller
{
    public function index()
    {
        $jamKerja = JamKerja::first();

        $presensiHariIni = Presensi::whereDate('waktu_presensi', Carbon::today())->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.presensi', compact('jamKerja', 'presensiHariIni'));
    }

    public function presensiIn()
    {
        $today = Carbon::today()->format('Y-m-d');
        $user = Auth::user();
        $existingPresensi = Presensi::whereDate('created_at', $today)
            ->where('user_id', $user->id)
            ->where('jenis_presensi', 'masuk')
            ->first();

        if ($existingPresensi) {
            return redirect()->back()->with('message', 'Anda telah mengisi presensi masuk hari ini.');
        }

        return view('users.presensi.presensi_in');
    }

    public function presensiOut()
    {
        $today = Carbon::today()->format('Y-m-d');
        $user = Auth::user();
        $existingPresensi = Presensi::whereDate('created_at', $today)
            ->where('user_id', $user->id)
            ->where('jenis_presensi', 'keluar')
            ->first();

        if ($existingPresensi) {
            return redirect()->back()->with('message', 'Anda telah mengisi presensi keluar hari ini.');
        }

        return view('users.presensi.presensi_out');
    }


    public function updateJamKerja(Request $request)
    {
        $jamKerja = JamKerja::first();
        if ($jamKerja) {
            $jamKerja->update([
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
            ]);
        } else {
            JamKerja::create([
                'jam_masuk' => $request->jam_masuk,
                'jam_keluar' => $request->jam_keluar,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function presensiMasuk(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gambar = $request->file('gambar');
        $gambarPath = $gambar->store('images/presensi', 'public');

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $waktuPresensi = Carbon::now();

        $presensi = Presensi::create([
            'user_id' => Auth::id(),
            'jenis_presensi' => 'masuk',
            'waktu_presensi' => $waktuPresensi,
            'gambar' => $gambarPath,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return response()->json([
            'message' => 'Presensi masuk berhasil!',
            'data' => $presensi,
        ]);
    }

    public function presensiKeluar(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gambar = $request->file('gambar');
        $gambarPath = $gambar->store('images/presensi', 'public');

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $waktuPresensi = Carbon::now();

        $presensi = Presensi::create([
            'user_id' => Auth::id(),
            'jenis_presensi' => 'keluar',
            'waktu_presensi' => $waktuPresensi,
            'gambar' => $gambarPath,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return response()->json([
            'message' => 'Presensi masuk berhasil!',
            'data' => $presensi,
        ]);
    }

    public function show($id)
    {
        // Ambil presensi masuk berdasarkan ID
        $presensiMasuk = Presensi::with('user')->where('id', $id)->where('jenis_presensi', 'masuk')->firstOrFail();

        // Cek apakah ada presensi keluar
        $presensiKeluar = Presensi::with('user')->where('user_id', $presensiMasuk->user_id)
            ->where('jenis_presensi', 'keluar')
            ->whereDate('created_at', $presensiMasuk->created_at->toDateString())
            ->first();

        return view('users.presensi.detail', compact('presensiMasuk', 'presensiKeluar'));
    }
}
