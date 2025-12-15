<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\PembayaranPajak;
use App\Models\RincianPembayaranPajak;
use App\Models\WaLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PembayaranPajakController extends Controller
{
    private function hitungPajak($kendaraan, $jenisPajak, ?Carbon $tanggalBayar = null)
    {
        $tanggalBayar = $tanggalBayar ?? Carbon::now();

        $pajak = $kendaraan->pajak;
        $njkb = $pajak->njkb;

        /* ================= TARIF PKB ================= */
        $tarifPkb = [
            'Sepeda Motor' => 0.02,
            'Mobil'        => 0.04,
            'Pick Up'      => 0.06,
            'Truk'         => 0.06,
            'Bus'          => 0.06,
        ];

        $persentase = $tarifPkb[$kendaraan->tipe] ?? 0.02;
        $pkb = $njkb * $persentase;

        /* ================= SWDKLLJ ================= */
        $swdkllj = 35000;

        /* ================= DENDA ================= */
        $jatuhTempoLama = Carbon::parse($pajak->tenggat_jatuh_tempo);

        if ($tanggalBayar->greaterThan($jatuhTempoLama)) {
            $bulanTelat = min(
                ceil($jatuhTempoLama->diffInDays($tanggalBayar) / 30),
                24
            );
        } else {
            $bulanTelat = 0;
        }

        $denda_pkb = $bulanTelat > 0 ? $pkb * 0.25 * $bulanTelat : 0;
        $denda_swd = $bulanTelat > 0 ? 8000 : 0;

        /* ================= BIAYA TAMBAHAN ================= */
        $stnk  = $jenisPajak === 'Pajak 5 Tahun' ? 100000 : 0;
        $tnkb  = $jenisPajak === 'Pajak 5 Tahun' ? 60000  : 0;
        $admin = $jenisPajak === 'Pajak 5 Tahun' ? 25000  : 0;

        /* ================= JATUH TEMPO BARU ================= */
        $jatuhTempoBaru = match ($jenisPajak) {
            'Pajak 1 Tahun' => $tanggalBayar->copy()->addYear(),
            'Pajak 5 Tahun' => $tanggalBayar->copy()->addYears(5),
            default => throw new \Exception('Jenis pajak tidak valid'),
        };

        /* ================= TOTAL ================= */
        $total = $pkb + $swdkllj + $denda_pkb + $denda_swd + $stnk + $tnkb + $admin;

        return [
            // lama (dipakai UI & JS)
            'pkb'         => (int) $pkb,
            'swdkllj'     => (int) $swdkllj,
            'denda_pkb'   => (int) $denda_pkb,
            'denda_swd'   => (int) $denda_swd,
            'bulan_telat' => $bulanTelat,
            'stnk'        => $stnk,
            'tnkb'        => $tnkb,
            'admin'       => $admin,
            'total'       => (int) $total,
            'jatuh_tempo_lama' => $jatuhTempoLama,
            'jatuh_tempo_baru' => $jatuhTempoBaru,
        ];
    }

    public function index()
    {
        $pembayaran = PembayaranPajak::with(['kendaraan'])
            ->latest()
            ->get();

        return view('pembayaran.index', compact('pembayaran'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::whereHas('pajak', function ($q) {
            $q->where('status_awal', 'Belum Bayar Pajak');
        })->get();

        return view('pembayaran.create', compact('kendaraans'));
    }

    public function loadDetail($id)
    {
        $kendaraan = Kendaraan::with('pajak', 'wajibPajak')->findOrFail($id);

        $jenis = request()->get('jenis', 'Pajak 1 Tahun');

        $hasil = $this->hitungPajak($kendaraan, $jenis);

        return response()->json([
            'nama_wp' => $kendaraan->wajibPajak->nama,
            'telepon' => $kendaraan->wajibPajak->nomor_hp,
            'jatuh_tempo' => $hasil['jatuh_tempo_lama']->format('d/m/Y'),
            'pkb'     => number_format($hasil['pkb'], 0, ',', '.'),
            'swdkllj' => number_format($hasil['swdkllj'], 0, ',', '.'),
            'denda'   => number_format($hasil['denda_pkb'] + $hasil['denda_swd'], 0, ',', '.'),
            'bulan_telat' => $hasil['bulan_telat'],
            'stnk'    => number_format($hasil['stnk'], 0, ',', '.'),
            'tnkb'    => number_format($hasil['tnkb'], 0, ',', '.'),
            'admin'   => number_format($hasil['admin'], 0, ',', '.'),

            'total'   => number_format($hasil['total'], 0, ',', '.'),
            'total_raw' => $hasil['total']
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_bayar' => 'required|date',
            'jenis_pajak' => 'required'
        ]);

        $kendaraan = Kendaraan::with('pajak')->findOrFail($request->kendaraan_id);

        $hasil = $this->hitungPajak($kendaraan, $request->jenis_pajak, Carbon::parse($request->tanggal_bayar));

        $bayar = PembayaranPajak::create([
            'kendaraan_id'  => $kendaraan->id,
            'jenis_pajak'   => $request->jenis_pajak,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_bayar'  => $hasil['total']
        ]);

        // Simpan rincian
        RincianPembayaranPajak::create([
            'pembayaran_pajak_id' => $bayar->id,
            'jatuh_tempo' => $hasil['jatuh_tempo_baru']->format('Y-m-d'),
            'pkb' => $hasil['pkb'],
            'swdkllj' => $hasil['swdkllj'],
            'denda' => $hasil['denda_pkb'] + $hasil['denda_swd'],
            'total_bayar' => $hasil['total']
        ]);

        $kendaraan->pajak->update([
            'tenggat_jatuh_tempo' => $hasil['jatuh_tempo_baru']->format('Y-m-d'),
            'status_awal' => 'Sudah Bayar Pajak'
        ]);

        $nama  = $kendaraan->wajibPajak->nama;
        $hp    = $kendaraan->wajibPajak->nomor_hp;
        $nopol = $kendaraan->nopol;

        $pesan =
            "🟢 *Pembayaran Pajak Berhasil*\n\n" .
            "Halo *{$nama}*, pembayaran pajak telah dicatat.\n\n" .
            "• Nomor Kendaraan: *{$nopol}*\n" .
            "• Jenis Pajak: *{$request->jenis_pajak}*\n" .
            "• Tanggal Bayar: *{$request->tanggal_bayar}*\n" .
            "• Jumlah: *Rp " . number_format($hasil['total'], 0, ',', '.') . "*\n\n" .
            "Terima kasih telah melakukan pembayaran tepat waktu. 🙏";

        $this->sendWaFonnte($kendaraan, $nama, $hp, $pesan);

        return redirect()->route('pembayaran')
            ->with('success', 'Pembayaran berhasil disimpan!');
    }

    public function edit($id)
    {
        $pembayaran = PembayaranPajak::with(['kendaraan.pajak', 'rincian'])->findOrFail($id);
        return view('pembayaran.edit', compact('pembayaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_bayar' => 'required|date',
            'jenis_pajak' => 'required|string',
        ]);

        $pembayaran = PembayaranPajak::with('kendaraan.pajak', 'rincian')->findOrFail($id);

        $hasil = $this->hitungPajak($pembayaran->kendaraan, $request->jenis_pajak);

        $pembayaran->update([
            'jenis_pajak' => $request->jenis_pajak,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_bayar' => $hasil['total']
        ]);

        $pembayaran->rincian->update([
            'jatuh_tempo' => $hasil['jatuh_tempo']->format('Y-m-d'),
            'pkb' => $hasil['pkb'],
            'swdkllj' => $hasil['swdkllj'],
            'denda' => $hasil['denda_pkb'] + $hasil['denda_swd'],
            'total_bayar' => $hasil['total'],
        ]);

        return redirect()->route('pembayaran')
            ->with('success', 'Pembayaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pembayaran = PembayaranPajak::findOrFail($id);

        if ($pembayaran->rincian) {
            $pembayaran->rincian->delete();
        }

        $pembayaran->delete();

        return redirect()->route('pembayaran')
            ->with('success', 'Pembayaran berhasil dihapus!');
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

        // SIMPAN LOG
        WaLog::create([
            'kendaraan_id' => $kendaraan->id,
            'wajib_pajak_id' => $kendaraan->wajibPajak->id,
            'nama_wajib_pajak' => $nama,
            'nomor_hp' => $hp,
            'pesan' => $message,
            'status' => $json['status'] ?? 'unknown',
            'response_api' => $json,
        ]);

        return $json;
    }
}
