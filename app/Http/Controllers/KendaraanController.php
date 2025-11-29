<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $kendaraan = Kendaraan::with(['pembayaran', 'wajibPajak'])
            ->when($search, function ($q) use ($search) {
                $q->where('nopol', 'LIKE', "%$search%")
              ->orWhereHas('wajibPajak', fn($wp) => 
                    $wp->where('nama', 'LIKE', "%$search%"));
        })
        ->when($status, function ($q) use ($status) {
            if ($status == "LUNAS") {
                $q->whereHas('pembayaran');
            } elseif ($status == "BELUM") {
                $q->doesntHave('pembayaran');
            }
        })
        ->get();

        $totalWp         = $kendaraan->count();
        $totalKendaraan  = $kendaraan->count();
        $totalLunas      = $kendaraan->filter(fn($k) => $k->pembayaran)->count();
        $totalBelum      = $totalKendaraan - $totalLunas;

        return view('kendaraan.index', compact(
            'kendaraan','totalWp','totalKendaraan','totalLunas','totalBelum',
            'search','status'
        ));
    }

    public function exportPdf()
    {
        $data['kendaraan'] = Kendaraan::with(['pembayaran', 'wajibPajak'])->get();
        $pdf = Pdf::loadView('kendaraan.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('laporan-kendaraan.pdf');
    }

}
