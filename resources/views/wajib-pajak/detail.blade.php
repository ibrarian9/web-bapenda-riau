<x-layouts.app>
    <div class="p-6 space-y-8">

        <div class="text-xl font-semibold">Detail Kendaraan</div>

        @php
            $kendaraan = $data->kendaraans->first();
            $pajak = $kendaraan?->pajak;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Detail Kendaraan -->
            <div class="bg-white rounded-xl shadow p-4">
                <div class="bg-gray-700 text-white px-4 py-2 rounded-t font-semibold">Detail Kendaraan</div>

                @if ($kendaraan)
                    <table class="w-full text-sm border">
                        <tr>
                            <td class="border px-3 py-2 font-medium">No. Kendaraan</td>
                            <td class="border px-3 py-2">{{ $kendaraan->nopol }}</td>
                        </tr>

                        <tr>
                            <td class="border px-3 py-2 font-medium">Merek / Tipe</td>
                            <td class="border px-3 py-2">{{ $kendaraan->merek }} / {{ $kendaraan->tipe }}</td>
                        </tr>

                        <tr>
                            <td class="border px-3 py-2 font-medium">Tahun Pembuatan</td>
                            <td class="border px-3 py-2">{{ $kendaraan->tahun_pembuatan }}</td>
                        </tr>

                        <tr>
                            <td class="border px-3 py-2 font-medium">Warna</td>
                            <td class="border px-3 py-2">{{ $kendaraan->warna }}</td>
                        </tr>

                        <tr>
                            <td class="border px-3 py-2 font-medium">No. Rangka</td>
                            <td class="border px-3 py-2">{{ $kendaraan->nomor_rangka }}</td>
                        </tr>

                        <tr>
                            <td class="border px-3 py-2 font-medium">No. Mesin</td>
                            <td class="border px-3 py-2">{{ $kendaraan->nomor_mesin }}</td>
                        </tr>

                        <tr>
                            <td class="border px-3 py-2 font-medium">Status Pajak</td>
                            <td
                                class="border px-3 py-2 font-semibold 
                                {{ $statusPajak == 'LUNAS' ? 'text-green-700' : 'text-red-700' }}">
                                {{ strtoupper($statusPajak) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="border px-3 py-2 font-medium">NJKB</td>
                            <td class="border px-3 py-2">
                                {{ $pajak ? 'Rp. ' . number_format($pajak->njkb, 0, ',', '.') : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <td class="border px-3 py-2 font-medium">Jatuh Tempo Pajak</td>
                            <td class="border px-3 py-2">
                                {{ $pajak?->tenggat_jatuh_tempo ? \Carbon\Carbon::parse($pajak->tenggat_jatuh_tempo)->translatedFormat('d F Y') : '-' }}
                            </td>
                        </tr>
                    </table>
                @else
                    <p class="text-gray-500 text-center py-6">Belum ada data kendaraan.</p>
                @endif

            </div>

            <!-- Riwayat Pembayaran -->
            <div class="bg-white rounded-xl shadow p-4">
                <div class="bg-gray-700 text-white px-4 py-2 rounded-t font-semibold flex items-center gap-2">
                    <span>Riwayat Pembayaran Kendaraan Ini</span>
                </div>

                <table class="w-full text-sm border">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-3 py-2">Tanggal Bayar</th>
                            <th class="border px-3 py-2">Jenis Pajak</th>
                            <th class="border px-3 py-2">Jumlah</th>
                            <th class="border px-3 py-2">Struk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center py-3 text-gray-500">
                                Belum ada riwayat pembayaran
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Detail Pemilik -->
        <div class="bg-white rounded-xl shadow p-4">
            <div class="bg-gray-700 text-white px-4 py-2 rounded-t font-semibold">Detail Pemilik</div>

            <table class="w-full text-sm border">
                <tr>
                    <td class="border px-3 py-2 font-medium">NIK</td>
                    <td class="border px-3 py-2">{{ $data->nik }}</td>
                </tr>

                <tr>
                    <td class="border px-3 py-2 font-medium">Nama Pemilik</td>
                    <td class="border px-3 py-2">{{ $data->nama }}</td>
                </tr>

                <tr>
                    <td class="border px-3 py-2 font-medium">Alamat</td>
                    <td class="border px-3 py-2">{{ $data->alamat }}</td>
                </tr>

                <tr>
                    <td class="border px-3 py-2 font-medium">No. HP</td>
                    <td class="border px-3 py-2">{{ $data->nomor_hp }}</td>
                </tr>
            </table>
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('wajib.pajak') }}" class="bg-black text-white px-6 py-2 rounded">Kembali</a>
        </div>
    </div>
</x-layouts.app>
