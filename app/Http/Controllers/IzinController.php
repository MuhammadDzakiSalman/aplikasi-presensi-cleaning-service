<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\IzinFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    public function index()
    {
        $izins = Izin::whereDate('created_at', today()->toDateString())
                    ->get();

        return view('admin.izin', compact('izins'));
    }

    public function create()
    {
        return view('izin');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'deskripsi' => 'required|string',
            'files.*' => 'file|mimes:jpeg,png,jpg,pdf,doc,docx,mp4|max:10240', // Validasi file
        ]);

        // Simpan izin
        $izin = Izin::create([
            'user_id' => Auth::id(),
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending', // Status sementara
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Simpan file jika ada
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                // Menyimpan file ke storage
                $path = $file->store('izin_files', 'public');

                // Simpan file path ke tabel izin_files
                IzinFile::create([
                    'izin_id' => $izin->id, // ID izin terkait
                    'file_path' => $path,   // Lokasi file
                ]);
            }
        }

        return redirect()->route('user.home')->with('success', 'Izin berhasil dibuat!');
    }
}
