<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pajak;
use App\Models\WajibPajak;
use App\Models\WaLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class WajibPajakController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $data = WajibPajak::with(['kendaraans.pembayaran'])
            ->when($search, function ($query) use ($search) {
                $query->where('nik', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhereHas('kendaraans', function ($q) use ($search) {
                        $q->where('nopol', 'like', "%{$search}%");
                    });
            })
            ->orderBy('nama')
            ->paginate(10);

        $totalWp = $data->count();
        $totalKendaraan = $data->sum(fn($wp) => $wp->kendaraans->count());
        $totalLunas = $data->sum(function ($wp) {
            return $wp->kendaraans->filter(fn($k) => $k->pembayaran)->count();
        });
        $totalBelum = $totalKendaraan - $totalLunas;

        return view('wajib-pajak.index', compact('data', 'totalWp', 'totalKendaraan', 'totalLunas', 'totalBelum'));
    }

    public function show($id)
    {
        $data = WajibPajak::with(['kendaraans.pajak', 'kendaraans.pembayaran'])->findOrFail($id);
        $kendaraan = $data->kendaraans->first();
        $statusPajak = $kendaraan->pembayaran ? 'LUNAS' : 'BELUM LUNAS';
        return view('wajib-pajak.detail', compact('data', 'statusPajak'));
    }

    public function create()
    {
        return view('wajib-pajak.create', [
            'tipeList' => Kendaraan::$tipeList,
            'statusPajakList' => Pajak::$statusPajakList
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // Wajib Pajak
            'nik' => 'required|unique:wajib_pajaks,nik',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nomor_hp' => 'required|string',

            // Kendaraan
            'nopol' => 'required|string',
            'merek' => 'required|string',
            'tipe' => 'required|string',
            'tahun_pembuatan' => 'required|integer|min:1900',
            'warna' => 'required|string',
            'nomor_mesin' => 'required|string',
            'nomor_rangka' => 'required|string',

            // Pajak
            'njkb' => 'required|numeric',
            'tenggat_jatuh_tempo' => 'required|date',
            'status_awal' => 'required|string'
        ]);

        // Insert Wajib Pajak
        $wp = WajibPajak::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'nomor_hp' => $request->nomor_hp,
        ]);

        // Insert Kendaraan
        $kendaraan = Kendaraan::create([
            'wajib_pajak_id' => $wp->id,
            'nopol' => $request->nopol,
            'merek' => $request->merek,
            'tipe' => $request->tipe,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'warna' => $request->warna,
            'nomor_mesin' => $request->nomor_mesin,
            'nomor_rangka' => $request->nomor_rangka,
        ]);

        // Insert Pajak
        Pajak::create([
            'kendaraan_id' => $kendaraan->id,
            'njkb' => $request->njkb,
            'tenggat_jatuh_tempo' => $request->tenggat_jatuh_tempo,
            'status_awal' => $request->status_awal
        ]);

        return redirect()->route('wajib.pajak')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = WajibPajak::with(['kendaraans.pajak'])->findOrFail($id);

        // Ambil kendaraan pertama (UI hanya mendukung 1)
        $kendaraan = $data->kendaraans->first();
        $pajak = $kendaraan?->pajak;
        $statusPajakList = Pajak::$statusPajakList;

        return view('wajib-pajak.edit', compact('data', 'kendaraan', 'pajak', 'statusPajakList'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|unique:wajib_pajaks,nik,' . $id,
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'nomor_hp' => 'required|string',

            'nopol' => 'required|string',
            'merek' => 'required|string',
            'tipe' => 'required|string',
            'tahun_pembuatan' => 'required|integer|min:1900',
            'warna' => 'required|string',
            'nomor_mesin' => 'required|string',
            'nomor_rangka' => 'required|string',

            'njkb' => 'required|numeric',
            'tenggat_jatuh_tempo' => 'required|date',
            'status_awal' => 'required|string'
        ]);

        // Update Wajib Pajak
        $wp = WajibPajak::findOrFail($id);
        $wp->update($request->only(['nik', 'nama', 'alamat', 'nomor_hp']));

        // Update kendaraan pertama
        $kendaraan = $wp->kendaraans->first();
        $kendaraan->update([
            'nopol' => $request->nopol,
            'merek' => $request->merek,
            'tipe' => $request->tipe,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'warna' => $request->warna,
            'nomor_mesin' => $request->nomor_mesin,
            'nomor_rangka' => $request->nomor_rangka,
        ]);

        // Update pajak
        $kendaraan->pajak->update([
            'njkb' => $request->njkb,
            'tenggat_jatuh_tempo' => $request->tenggat_jatuh_tempo,
            'status_awal' => $request->status_awal
        ]);

        return redirect()->route('wajib.pajak')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $wp = WajibPajak::findOrFail($id);

        foreach ($wp->kendaraans as $kendaraan) {
            $kendaraan->pajak()->delete();
            $kendaraan->delete();
        }

        $wp->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = WajibPajak::with(['kendaraans.pembayaran'])->orderBy('nama')->get();

        $pdf = Pdf::loadView('pdf.wajib_pajak', compact('data'))
            ->setPaper('A4', 'portrait');

        return $pdf->download('data-wajib-pajak.pdf');
    }

    public function notifikasiWa($id)
    {
        $data = Kendaraan::with('wajibPajak')->findOrFail($id);

        return view('notifikasi.create', [
            'data' => $data
        ]);
    }

    public function kirim(Request $request, $id)
    {
        $data = Kendaraan::with('wajibPajak')->findOrFail($id);

        $nama = $data->wajibPajak->nama;
        $hp   = $data->wajibPajak->nomor_hp;
        $nopol = $data->nopol;
        $jatuh_tempo = $request->jatuh_tempo;

        $days = now()->diffInDays($jatuh_tempo, false);

        $pesan =
            "*Peringatan Pajak Kendaraan*\n\n" .
            "Halo *{$nama}*,\n\n" .
            "Pajak kendaraan dengan nomor *{$nopol}* akan jatuh tempo dalam *{$days} hari*.\n" .
            "Tanggal jatuh tempo: *{$jatuh_tempo}*\n\n" .
            "Segera lakukan pembayaran untuk menghindari denda.\n\n" .
            "_Pesan otomatis dari Sistem SAMSAT Provinsi Riau._";

        $this->sendWaFonnte($data, $nama, $hp, $pesan);

        return back()->with('success', 'Notifikasi berhasil dikirim!');
    }

    private function sendWaFonnte($kendaraan, $nama, $hp, $message)
    {
        $token = env('FONNTE_TOKEN');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => $hp,
                'message' => $message,
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        $response = curl_exec($curl);
        $json = json_decode($response, true);
        curl_close($curl);

        // pastikan status aman
        $status = $json['status'] ?? 'unknown';

        // ===== SIMPAN LOG =====
        WaLog::create([
            'kendaraan_id' => $kendaraan->id,
            'wajib_pajak_id' => $kendaraan->wajibPajak->id,
            'nama_wajib_pajak' => $nama,
            'nomor_hp' => $hp,
            'pesan' => $message,
            'status' => $status,
            'response_api' => $json,
        ]);

        return $json;
    }
}
