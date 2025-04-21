<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'cleaning_service')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.cleaning_service.index', compact('users'));
    }


    public function show($id)
    {
        $user = User::all();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    public function create()
    {
        return view('admin.cleaning_service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|max:12',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'required|string',
            'foto_diri' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Menyimpan file foto_diri dan foto_ktp jika ada
        $fotoDiriPath = null;

        if ($request->hasFile('foto_diri')) {
            $fotoDiriPath = $request->file('foto_diri')->store('uploads/foto_diri', 'public');
        }

        // Membuat data pengguna baru
        $user = User::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'foto_diri' => $fotoDiriPath,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('cleaning_service.index')->with('success', 'Data pengguna berhasil disimpan!');
    }

    public function edit($id)
    {
        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        return view('admin.cleaning_service.edit', compact('user'));
    }

    // Fungsi untuk mengupdate data pengguna
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'alamat' => 'required|string',
            'foto_diri' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil data pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Update data pengguna
        $user->nama = $validated['nama'];
        $user->telepon = $validated['telepon'];
        $user->jenis_kelamin = $validated['jenis_kelamin'];
        $user->alamat = $validated['alamat'];

        // Jika ada foto baru, simpan file-nya
        if ($request->hasFile('foto_diri')) {
            $user->foto_diri = $request->file('foto_diri')->store('foto_diri', 'public');
        }

        $user->save();

        return redirect()->route('cleaning_service.index')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();
        return redirect()->route('cleaning_service.index')->with('success', 'Data pengguna berhasil dihapus');
    }

    public function downloadPdf()
    {
        $users = User::where('role', 'cleaning_service')->get();

        $pdf = PDF::loadView('admin.cleaning_service.laporan', compact('users'));

        return $pdf->download('data_cleaning_service.pdf');
    }
}
