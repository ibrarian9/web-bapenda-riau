<?php

namespace App\Http\Controllers;

use App\Models\PembayaranPajak;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->dari ?? date('Y-m-01');
        $sampai = $request->sampai ?? date('Y-m-t');
        $jenis = $request->jenis ?? 'semua';

        $query = PembayaranPajak::with(['kendaraan.wajibPajak'])
            ->whereBetween('tanggal_bayar', [$dari, $sampai]);

        if ($jenis !== 'semua') {
            $query->where('jenis_pajak', $jenis);
        }

        $pembayaran = $query->orderBy('tanggal_bayar', 'asc')->get();

        $total = $pembayaran->sum('jumlah_bayar');

        return view('laporan.index', compact('pembayaran', 'dari', 'sampai', 'jenis', 'total'));
    }

}
