<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\JamKerja;
use App\Models\Presensi;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RiwayatPresensiController extends Controller
{
    public function index()
    {
        // Ambil ID user yang sedang login
        $userId = Auth::user();

        // Ambil data presensi khusus untuk user yang login
        $presensiData = Presensi::with('user')
            ->where('user_id', $userId->id) // Filter hanya untuk user yang login
            ->whereIn('jenis_presensi', ['masuk', 'keluar'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);  // Use paginate to get paginated data

        // Kelompokkan berdasarkan tanggal
        $groupedPresensi = [];
        foreach ($presensiData as $presensi) {
            $tanggal = Carbon::parse($presensi->waktu_presensi)->format('Y-m-d');

            if (!isset($groupedPresensi[$tanggal])) {
                $groupedPresensi[$tanggal] = [
                    'user' => $presensi->user,
                    'masuk' => null,
                    'keluar' => null
                ];
            }

            // Simpan presensi berdasarkan jenisnya
            if ($presensi->jenis_presensi == 'masuk') {
                $groupedPresensi[$tanggal]['masuk'] = $presensi;
            } else if ($presensi->jenis_presensi == 'keluar') {
                $groupedPresensi[$tanggal]['keluar'] = $presensi;
            }
        }

        // Ambil jam kerja yang ditetapkan
        $jamKerja = JamKerja::first();

        $presensiList = [];

        // Proses data presensi yang sudah dikelompokkan
        foreach ($groupedPresensi as $tanggal => $data) {
            $userPresensi = [];

            // Pastikan ada data presensi masuk
            if ($data['masuk']) {
                $presensiMasuk = $data['masuk'];
                $user = $data['user'];

                $userPresensi['nama'] = $user->nama;
                $userPresensi['tanggal'] = Carbon::parse($tanggal)->format('d-m-Y');
                $userPresensi['id'] = $presensiMasuk->id;
                $userPresensi['waktu_masuk'] = Carbon::parse($presensiMasuk->waktu_presensi)->format('H:i');
                $userPresensi['status_kehadiran'] = $presensiMasuk->status_kehadiran;

                // Cek data presensi keluar
                if ($data['keluar']) {
                    $userPresensi['waktu_keluar'] = Carbon::parse($data['keluar']->waktu_presensi)->format('H:i');
                } else {
                    $userPresensi['waktu_keluar'] = '-';
                }

                $presensiList[] = $userPresensi;
            }
        }

        // Return paginated data instead of the array
        return view('users.presensi.riwayat', compact('presensiList', 'presensiData'));
    }
}
