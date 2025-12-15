<x-layouts.app title="Laporan">

    {{-- Breadcrumb --}}
    <div class="text-gray-800 text-sm mb-6">
        <span class="opacity-70">HOME</span> >
        <span class="font-semibold">LAPORAN</span>
    </div>

    {{-- CARD FILTER --}}
    <div class="bg-white rounded-lg shadow p-6 border border-gray-300 mb-10">

        {{-- Header --}}
        <div class="bg-gray-800 text-white px-4 py-2 rounded flex items-center gap-2 mb-6">
            <span>📘</span>
            <span class="font-semibold">LAPORAN</span>
        </div>

        {{-- Form Filter --}}
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Dari Tanggal --}}
            <div>
                <label class="block text-gray-800 text-sm font-semibold mb-1">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ $dari ?? null }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            {{-- Sampai Tanggal --}}
            <div>
                <label class="block text-gray-800 text-sm font-semibold mb-1">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ $sampai ?? null }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            {{-- Jenis Pajak --}}
            <div>
                <label class="block text-gray-800 text-sm font-semibold mb-1">Jenis Pajak</label>
                <select name="jenis"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">

                    <option value="semua" {{ $jenis == 'semua' ? 'selected' : '' }}>Semua</option>
                    
                    @foreach ($dataJenis as $key => $label)
                        <option value="{{ $label }}" {{ $jenis == $label ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>

            </div>    

            {{-- Tombol --}}
            <div class="flex items-end gap-4">
                <button class="bg-blue-900 text-white px-5 py-2 rounded hover:bg-blue-700 flex items-center gap-2">
                    🔍 Tampilkan
                </button>

                <a href="{{ route('laporan.pdf', request()->all()) }}"
                    class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 flex items-center gap-2">
                    📄 Cetak PDF
                </a>
            </div>

        </form>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-lg shadow border border-gray-300 p-4">

        <table class="w-full border border-gray-400 text-sm">
            <thead>
                <tr class="bg-gray-200 text-gray-800">
                    <th class="border border-gray-400 px-3 py-2 text-center">NO</th>
                    <th class="border border-gray-400 px-3 py-2 text-left">Tanggal Bayar</th>
                    <th class="border border-gray-400 px-3 py-2 text-left">NO KENDARAAN</th>
                    <th class="border border-gray-400 px-3 py-2 text-left">NAMA WAJIB PAJAK</th>
                    <th class="border border-gray-400 px-3 py-2 text-left">JENIS PAJAK</th>
                    <th class="border border-gray-400 px-3 py-2 text-right">JUMLAH (Rp)</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pembayaran as $pb)
                    <tr>
                        <td class="border border-gray-400 px-3 py-2 text-center">{{ $loop->iteration }}</td>

                        <td class="border border-gray-400 px-3 py-2">
                            {{ Carbon\Carbon::parse($pb->tanggal_bayar)->translatedFormat('d F Y') }}
                        </td>

                        <td class="border border-gray-400 px-3 py-2">
                            {{ $pb->kendaraan->nopol }}
                        </td>

                        <td class="border border-gray-400 px-3 py-2">
                            {{ $pb->kendaraan->wajibPajak->nama }}
                        </td>

                        <td class="border border-gray-400 px-3 py-2 font-semibold">
                            {{ $pb->jenis_pajak }}
                        </td>

                        <td class="border border-gray-400 px-3 py-2 text-right">
                            Rp. {{ number_format($pb->jumlah_bayar, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            Tidak ada data pembayaran.
                        </td>
                    </tr>
                @endforelse

            </tbody>

            {{-- TOTAL --}}
            <tfoot>
                <tr class="bg-blue-900 text-white font-semibold">
                    <td colspan="5" class="px-3 py-2 text-center">TOTAL PENDAPATAN</td>
                    <td class="px-3 py-2 text-right">
                        Rp. {{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

</x-layouts.app>
