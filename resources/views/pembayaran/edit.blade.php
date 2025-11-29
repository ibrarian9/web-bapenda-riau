<x-layouts.app title="Edit Pembayaran Pajak">

    <div class="text-white mb-4">
        <span class="font-semibold">HOME</span>
        <span class="mx-1">›</span>
        <span>Edit Pembayaran Pajak</span>
    </div>

    <div class="bg-white shadow rounded p-6">

        <h2 class="text-lg font-bold mb-4">Edit Pembayaran Pajak</h2>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-600 text-red-700 p-4 mb-4 rounded">
                <strong class="font-semibold">Terjadi Kesalahan:</strong>
                <ul class="list-disc list-inside text-sm mt-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="formEdit" action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- KENDARAAN (TIDAK BOLEH DIUBAH) --}}
            <div>
                <label class="block font-semibold text-sm">No Kendaraan</label>
                <input type="text" class="w-full mt-1 border rounded p-2 bg-gray-100" value="{{ $pembayaran->kendaraan->nopol }}" readonly>
                <input type="hidden" name="kendaraan_id" value="{{ $pembayaran->kendaraan_id }}">
            </div>

            {{-- Nama WP --}}
            <div>
                <label class="block font-semibold text-sm">Nama Wajib Pajak</label>
                <input type="text"
                       id="nama_wp"
                       value="{{ $pembayaran->kendaraan->wajibPajak->nama }}"
                       class="w-full border rounded p-2 mt-1 bg-gray-100" readonly>
            </div>

            {{-- Telepon --}}
            <div>
                <label class="block font-semibold text-sm">No Telpon</label>
                <input type="text"
                       id="telepon"
                       value="{{ $pembayaran->kendaraan->wajibPajak->nomor_hp }}"
                       class="w-full border rounded p-2 mt-1 bg-gray-100" readonly>
            </div>

            {{-- RINCIAN TAGIHAN --}}
            <div>
                <h3 class="font-bold mb-2">Rincian Tagihan</h3>

                <div class="bg-gray-100 rounded p-4">
                    <div class="flex justify-between text-sm">
                        <div>
                            <p>Jatuh Tempo Terakhir</p>
                            <p>PKB (Pajak Pokok)</p>
                            <p>SWDKLLJ</p>
                            <p>Denda</p>
                        </div>
                        <div class="text-right">
                            <p id="jatuh_tempo_display">{{ $pembayaran->rincian->jatuh_tempo }}</p>
                            <p id="pkb_display">Rp {{ number_format($pembayaran->rincian->pkb) }}</p>
                            <p id="swdkllj_display">Rp {{ number_format($pembayaran->rincian->swdkllj) }}</p>
                            <p id="denda_display">Rp {{ number_format($pembayaran->rincian->denda) }}</p>
                        </div>
                    </div>

                    <div class="border-t mt-2 pt-2 flex justify-between font-bold">
                        <span>TOTAL BAYAR</span>
                        <span id="total_display">Rp {{ number_format($pembayaran->jumlah_bayar) }}</span>
                    </div>
                </div>
            </div>

            {{-- Jenis Pajak + Tanggal Bayar --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block font-semibold text-sm">Jenis Pajak</label>
                    <select id="jenis_pajak" name="jenis_pajak"
                            class="w-full border rounded p-2 mt-1">
                        <option value="Pajak 1 Tahun" {{ $pembayaran->jenis_pajak == 'Pajak 1 Tahun' ? 'selected':'' }}>
                            Pajak 1 Tahun
                        </option>
                        <option value="Pajak 5 Tahun" {{ $pembayaran->jenis_pajak == 'Pajak 5 Tahun' ? 'selected':'' }}>
                            Pajak 5 Tahun
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-sm">Tanggal Bayar</label>
                    <input type="date" id="tanggal_bayar" name="tanggal_bayar"
                           value="{{ $pembayaran->tanggal_bayar }}"
                           class="w-full border rounded p-2 mt-1">
                </div>
            </div>

            {{-- JUMLAH --}}
            <div>
                <label class="block font-semibold text-sm">Jumlah (Otomatis)</label>
                <input readonly type="text" id="jumlah_bayar"
                       value="{{ number_format($pembayaran->jumlah_bayar) }}"
                       name="jumlah_bayar"
                       class="w-full border rounded p-2 mt-1 bg-gray-100">
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end gap-4 mt-6">
                <button class="bg-green-600 text-white px-6 py-2 rounded font-semibold">
                    UPDATE
                </button>
                <a href="{{ route('pembayaran') }}"
                   class="bg-black text-white px-6 py-2 rounded font-semibold">
                    KEMBALI
                </a>
            </div>

        </form>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisPajakSelect = document.getElementById('jenis_pajak');
            const kendaraanId = "{{ $pembayaran->kendaraan_id }}";

            function loadRincian() {
                fetch(`/pembayaran/load-detail/${kendaraanId}?jenis=${jenisPajakSelect.value}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('jatuh_tempo_display').innerText = data.jatuh_tempo;
                        document.getElementById('pkb_display').innerText = "Rp " + data.pkb;
                        document.getElementById('swdkllj_display').innerText = "Rp " + data.swdkllj;
                        document.getElementById('denda_display').innerText = "Rp " + data.denda;
                        document.getElementById('total_display').innerText = "Rp " + data.total;
                        document.getElementById('jumlah_bayar').value = data.total_raw;
                    });
            }

            jenisPajakSelect.addEventListener('change', loadRincian);
        });
    </script>

</x-layouts.app>
