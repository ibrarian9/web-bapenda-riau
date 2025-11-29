<?php

namespace App\Http\Controllers;

use App\Models\WaLog;
use Barryvdh\DomPDF\Facade\Pdf;

class WaLogController extends Controller
{
    public function index()
    {
        $logs = WaLog::orderBy('created_at', 'desc')->paginate(20);

        return view('log-pesan.index', compact('logs'));
    }

    public function exportPdf()
    {
        $logs = WaLog::orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('log-pesan.export', compact('logs'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('log_pesan_whatsapp.pdf');
    }
}
