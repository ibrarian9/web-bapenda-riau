<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\PembayaranPajak;
use App\Models\WajibPajak;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() 
    {
        $totalWp = WajibPajak::count();

        $totalKendaraan = Kendaraan::count();

        $totalLunas = Kendaraan::whereHas('pembayaran')->count();

        $totalBelum = $totalKendaraan - $totalLunas;

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalLunasBulan = PembayaranPajak::whereMonth('tanggal_bayar', $bulanIni)
            ->whereYear('tanggal_bayar', $tahunIni)
            ->sum('jumlah_bayar');

        $totalLunasTahun = PembayaranPajak::whereYear('tanggal_bayar', $tahunIni)
            ->sum('jumlah_bayar');

        $totalBelumBulan = 0;
        $totalBelumTahun = 0;

        return view('dashboard.index', compact(
            'totalWp',
            'totalKendaraan',
            'totalLunas',
            'totalBelum',
            'totalLunasBulan',
            'totalLunasTahun',
            'totalBelumBulan',
            'totalBelumTahun'
        ));
    }
}
