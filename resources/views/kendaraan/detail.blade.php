<x-layouts.app>
    <div class="p-6 space-y-8">

        <div class="text-xl font-semibold">Detail Kendaraan</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Detail Kendaraan --}}
            <div class="bg-white rounded-xl shadow">
                <div class="bg-gray-700 text-white px-4 py-2 rounded-t font-semibold">Detail Kendaraan</div>

                <table class="w-full text-sm border">
                    <tr>
                        <td class="border px-3 py-2 font-medium">No. Kendaraan</td>
                        <td class="border px-3 py-2">{{ $kendaraan->no_plat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2 font-medium">Merek / Tipe</td>
                        <td class="border px-3 py-2">{{ $kendaraan->merek }} / {{ $kendaraan->tipe }}</td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2 font-medium">Tahun Pembuatan</td>
                        <td class="border px-3 py-2">{{ $kendaraan->tahun ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2 font-medium">Warna</td>
                        <td class="border px-3 py-2">{{ $kendaraan->warna ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2 font-medium">No. Rangka</td>
                        <td class="border px-3 py-2">{{ $kendaraan->no_rangka ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2 font-medium">No. Mesin</td>
                        <td class="border px-3 py-2">{{ $kendaraan->no_mesin ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2 font-medium">Status Pajak</td>
                        <td class="border px-3 py-2 font-semibold 
                            {{ $kendaraan->status_pajak == 'LUNAS' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $kendaraan->status_pajak ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2 font-medium">NJKB</td>
                        <td class="border px-3 py-2">Rp {{ number_format($kendaraan->njkb ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="border px-3 py-2 font-medium">Jatuh Tempo Pajak</td>
                        <td class="border px-3 py-2">
                            {{ $kendaraan->pajak->jatuh_tempo ?? '-' }}
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Riwayat Pembayaran --}}
            <div class="bg-white rounded-xl shadow">
                <div class="bg-gray-700 text-white px-4 py-2 rounded-t font-semibold">Riwayat Pembayaran Kendaraan Ini</div>

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
                        @forelse($kendaraan->pajak as $p)
                        <tr>
                            <td class="border px-3 py-2">{{ $p->tanggal_bayar }}</td>
                            <td class="border px-3 py-2">{{ $p->jenis }}</td>
                            <td class="border px-3 py-2">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                            <td class="border px-3 py-2">
                                @if ($p->struk)
                                    <a href="{{ asset('storage/'.$p->struk) }}" target="_blank" class="text-blue-600 underline">Lihat</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-gray-500">Belum ada riwayat pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- Detail Pemilik --}}
        <div class="bg-white rounded-xl shadow">
            <div class="bg-gray-700 text-white px-4 py-2 rounded-t font-semibold">Detail Pemilik</div>

            <table class="w-full text-sm border">
                <tr><td class="border px-3 py-2 font-medium">NIK</td><td class="border px-3 py-2">{{ $data->nik }}</td></tr>
                <tr><td class="border px-3 py-2 font-medium">Nama Pemilik</td><td class="border px-3 py-2">{{ $data->nama }}</td></tr>
                <tr><td class="border px-3 py-2 font-medium">Alamat</td><td class="border px-3 py-2">{{ $data->alamat }}</td></tr>
                <tr><td class="border px-3 py-2 font-medium">No. HP</td><td class="border px-3 py-2">{{ $data->no_hp }}</td></tr>
            </table>
        </div>

        <div class="text-center pt-4">
            <a href="{{ route('wajib.pajak') }}" class="bg-black text-white px-6 py-2 rounded">Kembali</a>
        </div>

    </div>
</x-layouts.app>
