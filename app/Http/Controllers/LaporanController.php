<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\JamKerja;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;

class LaporanController extends Controller
{
    public function index(Request $request)
{
    $presensiQuery = Presensi::with('user')
        ->whereIn('jenis_presensi', ['masuk', 'keluar']);
    
    if ($request->filled('bulan') && $request->filled('tahun')) {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $presensiQuery->whereYear('created_at', $tahun)
            ->whereMonth('created_at', $bulan);
    }
    
    // Fetch the filtered presensi data with pagination (10 records per page)
    $presensiData = $presensiQuery->orderBy('created_at', 'desc')->paginate(10);
    $groupedPresensi = [];
    
    foreach ($presensiData as $presensi) {
        $tanggal = Carbon::parse($presensi->waktu_presensi)->format('Y-m-d');
        $userId = $presensi->user_id;
        
        if (!isset($groupedPresensi[$userId][$tanggal])) {
            $groupedPresensi[$userId][$tanggal] = [
                'user' => $presensi->user,
                'masuk' => null,
                'keluar' => null
            ];
        }
        
        if ($presensi->jenis_presensi == 'masuk') {
            $groupedPresensi[$userId][$tanggal]['masuk'] = $presensi;
        } else if ($presensi->jenis_presensi == 'keluar') {
            $groupedPresensi[$userId][$tanggal]['keluar'] = $presensi;
        }
    }
    
    $jamKerja = JamKerja::first();
    $presensiList = [];
    
    foreach ($groupedPresensi as $userId => $userDates) {
        foreach ($userDates as $tanggal => $data) {
            if ($data['masuk']) {
                $presensiMasuk = $data['masuk'];
                $user = $data['user'];
                
                $userPresensi = [];
                $userPresensi['nama'] = $user->nama;
                $userPresensi['tanggal'] = Carbon::parse($tanggal)->format('d-m-Y');
                $userPresensi['waktu_masuk'] = Carbon::parse($presensiMasuk->waktu_presensi)->format('H:i');
                
                if ($data['keluar']) {
                    $userPresensi['waktu_keluar'] = Carbon::parse($data['keluar']->waktu_presensi)->format('H:i');
                } else {
                    $userPresensi['waktu_keluar'] = '-';
                }
                
                $waktuPresensi = Carbon::parse($presensiMasuk->waktu_presensi);
                
                $jamMasukString = $jamKerja->jam_masuk;
                
                $tanggalPresensi = Carbon::parse($tanggal);
                $jamMasukKerja = Carbon::createFromFormat(
                    'Y-m-d H:i',
                    $tanggalPresensi->format('Y-m-d') . ' ' . $jamMasukString
                );
                
                $batasToleransi = (clone $jamMasukKerja)->addMinutes(15);
                
                if ($waktuPresensi->gt($batasToleransi)) {
                    $userPresensi['status_kehadiran'] = 'Terlambat';
                } else {
                    $userPresensi['status_kehadiran'] = 'Tepat Waktu';
                }
                
                $presensiList[] = $userPresensi;
            }
        }
    }
    
    $availableMonths = Presensi::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();
    
    $availableYears = $availableMonths->unique('year');
    
    return view('admin.laporan', compact('presensiList', 'availableYears', 'availableMonths', 'presensiData'));
}


    public function exportPdf(Request $request)
    {
        // Get the month and year from the request
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        // Build the query to get presensi data
        $presensiQuery = Presensi::with('user')
            ->whereIn('jenis_presensi', ['masuk', 'keluar'])
            ->orderBy('created_at', 'desc');

        // If month and year are provided, filter the data by the range of dates
        if (!empty($bulan) && !empty($tahun)) {
            $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
            $presensiQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Fetch the filtered presensi data
        $presensiData = $presensiQuery->get();

        // Group the data by user and date
        $groupedPresensi = [];
        foreach ($presensiData as $presensi) {
            $tanggal = Carbon::parse($presensi->waktu_presensi)->format('Y-m-d');
            $userId = $presensi->user_id;

            if (!isset($groupedPresensi[$userId][$tanggal])) {
                $groupedPresensi[$userId][$tanggal] = [
                    'user' => $presensi->user,
                    'masuk' => null,
                    'keluar' => null
                ];
            }

            if ($presensi->jenis_presensi == 'masuk') {
                $groupedPresensi[$userId][$tanggal]['masuk'] = $presensi;
            } else if ($presensi->jenis_presensi == 'keluar') {
                $groupedPresensi[$userId][$tanggal]['keluar'] = $presensi;
            }
        }

        // Generate the PDF with the grouped presensi data
        $pdf = PDF::loadView('admin.laporan_pdf', compact('groupedPresensi'));

        // Return the PDF download
        return $pdf->download('laporan_presensi.pdf');
    }
}
