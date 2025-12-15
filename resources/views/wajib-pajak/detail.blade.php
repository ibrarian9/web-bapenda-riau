<x-layouts.app title="Detail Wajib Pajak">
    <div class="p-6 space-y-6">

        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Detail Wajib Pajak</h1>
            <a href="{{ route('wajib.pajak') }}"
               class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700">
                Kembali
            </a>
        </div>

        <!-- Informasi Wajib Pajak -->
        <div class="bg-white rounded-xl shadow p-6 space-y-3">
            <h2 class="text-lg font-semibold border-b pb-2">Informasi Wajib Pajak</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Nama</span>
                    <div class="font-medium">{{ $data->nama }}</div>
                </div>

                <div>
                    <span class="text-gray-500">NIK</span>
                    <div class="font-medium">{{ $data->nik }}</div>
                </div>

                <div>
                    <span class="text-gray-500">Nomor HP</span>
                    <div class="font-medium">{{ $data->nomor_hp }}</div>
                </div>

                <div>
                    <span class="text-gray-500">Alamat</span>
                    <div class="font-medium">{{ $data->alamat ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Informasi Kendaraan -->
        <div class="bg-white rounded-xl shadow p-6 space-y-4">
            <h2 class="text-lg font-semibold border-b pb-2">Informasi Kendaraan</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Nomor Polisi</span>
                    <div class="font-semibold text-lg">{{ $kendaraan->nopol }}</div>
                </div>

                <div>
                    <span class="text-gray-500">Merek</span>
                    <div class="font-medium">{{ $kendaraan->merek }}</div>
                </div>

                <div>
                    <span class="text-gray-500">Tipe</span>
                    <div class="font-medium">{{ $kendaraan->tipe }}</div>
                </div>

                <div>
                    <span class="text-gray-500">Tahun Pembuatan</span>
                    <div class="font-medium">{{ $kendaraan->tahun_pembuatan }}</div>
                </div>

                <div>
                    <span class="text-gray-500">Warna</span>
                    <div class="font-medium">{{ $kendaraan->warna }}</div>
                </div>
            </div>
        </div>

        <!-- Informasi Pajak -->
        <div class="bg-white rounded-xl shadow p-6 space-y-4">
            <h2 class="text-lg font-semibold border-b pb-2">Informasi Pajak</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Status Pajak</span>
                    <div class="font-semibold
                        {{ $statusPajak === 'LUNAS' ? 'text-green-700' : 'text-red-700' }}">
                        {{ $statusPajak }}
                    </div>
                </div>

                <div>
                    <span class="text-gray-500">Tanggal Jatuh Tempo</span>
                    <div class="font-semibold {{ $jatuhTempoInfo['color'] }}">
                        {{ $jatuhTempoInfo['tanggal'] }}
                        <span class="ml-1 text-xs">
                            ({{ $jatuhTempoInfo['label'] }})
                        </span>
                    </div>
                </div>

                <div>
                    <span class="text-gray-500">Jenis Pajak</span>
                    <div class="font-medium">
                        {{ $kendaraan->pajak->jenis_pajak ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Aksi -->
        <div class="flex gap-3">
            <a href="{{ route('pembayaran.create', $kendaraan->id) }}"
               class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Bayar Pajak
            </a>

            <a href="{{ route('wajib.pajak.edit', $kendaraan->id) }}"
               class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Edit Data
            </a>
        </div>

    </div>
</x-layouts.app>
