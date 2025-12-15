<?php

namespace App\Http\Controllers;

use App\Models\PembayaranPajak;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dataJenis = PembayaranPajak::$jenisPajakList;
        $query = PembayaranPajak::with(['kendaraan.wajibPajak']);

        // FILTER TANGGAL
        if ($request->has('dari') && $request->dari !== null) {
            $query->whereDate('tanggal_bayar', '>=', $request->dari);
        }

        if ($request->has('sampai') && $request->sampai !== null) {
            $query->whereDate('tanggal_bayar', '<=', $request->sampai);
        }

        // FILTER JENIS
        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->where('jenis_pajak', $request->jenis);
        }

        $pembayaran = $query->orderBy('tanggal_bayar')->get();
        $total = $pembayaran->sum('jumlah_bayar');

        return view('laporan.index', [
            'dataJenis'  => $dataJenis,
            'pembayaran' => $pembayaran,
            'dari'       => $request->dari,
            'sampai'     => $request->sampai,
            'jenis'      => $request->jenis ?? 'semua',
            'total'      => $total
        ]);
    }

    public function pdf(Request $request)
    {
        $query = PembayaranPajak::with(['kendaraan.wajibPajak']);

        // FILTER TANGGAL
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_bayar', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_bayar', '<=', $request->sampai);
        }

        // FILTER JENIS
        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->where('jenis_pajak', $request->jenis);
        }

        $pembayaran = $query->orderBy('tanggal_bayar')->get();
        $total = $pembayaran->sum('jumlah_bayar');

        $pdf = Pdf::loadView('laporan.pdf', [
            'pembayaran' => $pembayaran,
            'total'      => $total,
            'dari'       => $request->dari,
            'sampai'     => $request->sampai,
            'jenis'      => $request->jenis ?? 'semua'
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('laporan.pdf');
    }
}
