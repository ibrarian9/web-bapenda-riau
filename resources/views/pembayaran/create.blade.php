<x-layouts.app title="Tambah Pembayaran Pajak">

    {{-- Breadcrumb --}}
    <div class="text-white mb-4">
        <span class="font-semibold">HOME</span>
        <span class="mx-1">›</span>
        <span>Tambah Pembayaran Pajak</span>
    </div>

    <div class="bg-white shadow rounded p-6">

        <h2 class="text-lg font-bold mb-4">Tambah Pembayaran Pajak</h2>

        {{-- ERROR --}}
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

        <form action="{{ route('pembayaran.store') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Pilih Kendaraan --}}
            <div>
                <label class="block font-semibold text-sm">Pilih Kendaraan</label>
                <select name="kendaraan_id" id="kendaraan_id"
                        class="w-full mt-1 border rounded p-2 bg-white">
                    <option value="">-- Pilih Kendaraan --</option>
                    @foreach ($kendaraans as $k)
                        <option value="{{ $k->id }}">{{ $k->nopol }} — {{ $k->wajibPajak->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Nama WP --}}
            <div>
                <label class="block font-semibold text-sm">Nama Wajib Pajak</label>
                <input id="nama_wp" type="text" readonly
                       class="w-full border rounded p-2 mt-1 bg-gray-100 text-gray-600">
            </div>

            {{-- Telepon --}}
            <div>
                <label class="block font-semibold text-sm">No Telepon</label>
                <input id="telepon" type="text" readonly
                       class="w-full border rounded p-2 mt-1 bg-gray-100 text-gray-600">
            </div>

            {{-- Rincian Tagihan --}}
            <div>
                <h3 class="font-bold mb-2">Rincian Tagihan</h3>

                <div class="bg-gray-200 rounded p-4">
                    <div class="flex justify-between text-sm">

                        <div>
                            <p>Jatuh Tempo Terakhir</p>
                            <p>PKB (Pajak Pokok)</p>
                            <p>SWDKLLJ</p>
                            <p class="text-red-600">
                                Denda (Telat <span id="bulan_telat">0</span> bulan)
                            </p>

                            {{-- Biaya Khusus 5 Tahun --}}
                            <p id="stnk_row" class="text-blue-600 hidden">Biaya STNK</p>
                            <p id="tnkb_row" class="text-blue-600 hidden">Biaya TNKB</p>
                            <p id="admin_row" class="text-blue-600 hidden">Biaya Admin</p>
                        </div>

                        <div class="text-right font-semibold">
                            <p id="jatuh_tempo_display">-</p>
                            <p id="pkb_display">Rp. 0</p>
                            <p id="swdkllj_display">Rp. 0</p>
                            <p id="denda_display" class="text-red-600">
                                Rp. 0
                            </p>

                            {{-- Kolom angka 5 tahun --}}
                            <p id="stnk_display" class="hidden">Rp. 0</p>
                            <p id="tnkb_display" class="hidden">Rp. 0</p>
                            <p id="admin_display" class="hidden">Rp. 0</p>
                        </div>
                    </div>

                    <div class="border-t mt-2 pt-2 flex justify-between font-bold text-sm">
                        <span>Total Bayar</span>
                        <span id="total_display">Rp. 0</span>
                    </div>
                </div>
            </div>

            {{-- Jenis Pajak + Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block font-semibold text-sm">Jenis Pajak</label>
                    <select name="jenis_pajak" id="jenis_pajak"
                            class="w-full mt-1 border rounded p-2">
                        <option value="">-- Pilih --</option>
                        <option value="Pajak 1 Tahun">Pajak 1 Tahun</option>
                        <option value="Pajak 5 Tahun">Pajak 5 Tahun</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-sm">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" class="w-full mt-1 border rounded p-2">
                </div>

            </div>

            {{-- Jumlah Bayar (readonly) --}}
            <div>
                <label class="block font-semibold text-sm">Jumlah Bayar</label>
                <input id="jumlah_bayar" name="jumlah_bayar"
                       class="w-full border rounded p-2 mt-1 bg-gray-100 text-gray-600" readonly>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end gap-4 mt-6">
                <button
                    class="bg-green-600 text-white px-6 py-2 rounded font-semibold">
                    SIMPAN
                </button>
                <a href="{{ route('pembayaran') }}"
                   class="bg-black text-white px-6 py-2 rounded font-semibold">
                    KEMBALI
                </a>
            </div>
        </form>

    </div>

    {{-- AJAX Script --}}
    <script>
    const kendaraanSelect = document.getElementById('kendaraan_id');
    const jenisSelect = document.getElementById('jenis_pajak');

    function loadPajak() {
        const id = kendaraanSelect.value;
        const jenis = jenisSelect.value;

        if (!id || !jenis) return;

        fetch(`/pembayaran/load-detail/${id}?jenis=${jenis}`)
            .then(res => res.json())
            .then(data => {

                // Data dasar
                document.getElementById('nama_wp').value = data.nama_wp;
                document.getElementById('telepon').value = data.telepon;
                document.getElementById('jatuh_tempo_display').innerText = data.jatuh_tempo;

                document.getElementById('pkb_display').innerText = "Rp. " + data.pkb;
                document.getElementById('swdkllj_display').innerText = "Rp. " + data.swdkllj;
                document.getElementById('denda_display').innerText = "Rp. " + data.denda;
                document.getElementById('bulan_telat').innerText = data.bulan_telat;

                // Jika Pajak 5 Tahun → tampilkan 3 biaya tambahan
                if (jenis === "Pajak 5 Tahun") {
                    document.getElementById('stnk_row').classList.remove('hidden');
                    document.getElementById('tnkb_row').classList.remove('hidden');
                    document.getElementById('admin_row').classList.remove('hidden');

                    document.getElementById('stnk_display').classList.remove('hidden');
                    document.getElementById('tnkb_display').classList.remove('hidden');
                    document.getElementById('admin_display').classList.remove('hidden');

                    document.getElementById('stnk_display').innerText = "Rp. " + data.stnk;
                    document.getElementById('tnkb_display').innerText = "Rp. " + data.tnkb;
                    document.getElementById('admin_display').innerText = "Rp. " + data.admin;

                } else {
                    document.getElementById('stnk_row').classList.add('hidden');
                    document.getElementById('tnkb_row').classList.add('hidden');
                    document.getElementById('admin_row').classList.add('hidden');

                    document.getElementById('stnk_display').classList.add('hidden');
                    document.getElementById('tnkb_display').classList.add('hidden');
                    document.getElementById('admin_display').classList.add('hidden');
                }

                // Total bayar
                document.getElementById('total_display').innerText = "Rp. " + data.total;

                // Value raw untuk submit
                document.getElementById('jumlah_bayar').value = data.total_raw;
            });
    }

    kendaraanSelect.addEventListener('change', loadPajak);
    jenisSelect.addEventListener('change', loadPajak);
    </script>

</x-layouts.app>
