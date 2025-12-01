<?php

namespace App\Http\Controllers;

use App\Models\PembayaranPajak;
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
}
