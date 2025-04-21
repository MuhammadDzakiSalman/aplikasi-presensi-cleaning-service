<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Presensi;
use App\Models\Izin;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
{
    $today = Carbon::today();

    // Ambil data jumlah presensi per bulan untuk tahun ini
    $presensiMonthlyData = Presensi::select(DB::raw('MONTH(waktu_presensi) as month'), DB::raw('COUNT(*) as count'))
                                    ->whereYear('waktu_presensi', $today->year)
                                    ->groupBy(DB::raw('MONTH(waktu_presensi)'))
                                    ->pluck('count', 'month')
                                    ->toArray();

    // Membuat array dengan default value 0 untuk setiap bulan
    $monthlyData = array_fill(1, 12, 0); // Mengisi array dari bulan 1-12 dengan nilai 0
    foreach ($presensiMonthlyData as $month => $count) {
        $monthlyData[$month] = $count; // Menetapkan data jumlah presensi untuk bulan yang ada
    }

    // Ambil data jumlah cleaning_service
    $cleaningServiceCount = User::where('role', 'cleaning_service')->count();

    // Ambil data jumlah presensi 'masuk' hari ini
    $todayPresensiInCount = Presensi::where('jenis_presensi', 'masuk')
                                    ->whereDate('waktu_presensi', $today)
                                    ->count();

    // Ambil data izin hari ini
    $todayIzinCount = Izin::whereDate('created_at', $today)->count();

    // Ambil data distribusi jenis kelamin
    $genderDistribution = User::where('role', 'cleaning_service')
                              ->selectRaw('jenis_kelamin, COUNT(*) as count')
                              ->groupBy('jenis_kelamin')
                              ->pluck('count', 'jenis_kelamin')
                              ->toArray();

    // Menyiapkan data untuk grafik distribusi jenis kelamin
    $genderData = [
        'Male' => $genderDistribution['laki-laki'] ?? 0,
        'Female' => $genderDistribution['perempuan'] ?? 0,
    ];

    return view('admin.dashboard', compact(
        'cleaningServiceCount', 
        'todayPresensiInCount', 
        'todayIzinCount', 
        'monthlyData', 
        'genderData'
    ));
}

}
