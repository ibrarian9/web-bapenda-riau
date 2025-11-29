<x-layouts.app title="Tambah Wajib Pajak">
    <div class="p-6 space-y-6">

        <!-- Header -->
        <div class="text-xl font-semibold">Form Input Wajib Pajak</div>

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

        <!-- Form -->
        <form action="{{ route('wajib.pajak.store') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Data Wajib Pajak -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">NIK</label>
                    <input type="text" name="nik" class="mt-1 w-full border rounded p-2"
                        value="{{ old('nik') }}" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="nama" class="mt-1 w-full border rounded p-2"
                        value="{{ old('nama') }}" />
                </div>

                <div class="md:col-span-1">
                    <label class="block text-sm font-medium">Alamat</label>
                    <input type="text" name="alamat" class="mt-1 w-full border rounded p-2"
                        value="{{ old('alamat') }}" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Nomor HP</label>
                    <input type="text" name="nomor_hp" class="mt-1 w-full border rounded p-2"
                        value="{{ old('nomor_hp') }}" />
                </div>
            </div>

            <hr class="border-t" />

            <!-- Data Kendaraan -->
            <div class="space-y-4">
                <div class="font-semibold text-lg">Data Kendaraan Pertama</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Nomor Polisi (NOPOL)</label>
                        <input type="text" name="nopol" class="mt-1 w-full border rounded p-2"
                            value="{{ old('nopol') }}" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Merek</label>
                        <input type="text" name="merek" class="mt-1 w-full border rounded p-2"
                            value="{{ old('merek') }}" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Tipe</label>
                        <select name="tipe" class="mt-1 w-full border rounded p-2">
                            @foreach ($tipeList as $tipe)
                                <option value="{{ $tipe }}" {{ old('tipe') == $tipe ? 'selected' : '' }}>
                                    {{ $tipe }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Tahun Pembuatan</label>
                        <input type="number" name="tahun_pembuatan" class="mt-1 w-full border rounded p-2"
                            value="{{ old('tahun_pembuatan') }}" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Warna</label>
                        <input type="text" name="warna" class="mt-1 w-full border rounded p-2"
                            value="{{ old('warna') }}" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Nomor Mesin</label>
                        <input type="text" name="nomor_mesin" class="mt-1 w-full border rounded p-2"
                            value="{{ old('nomor_mesin') }}" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Nomor Rangka</label>
                        <input type="text" name="nomor_rangka" class="mt-1 w-full border rounded p-2"
                            value="{{ old('nomor_rangka') }}" />
                    </div>
                </div>
            </div>

            <hr class="border-t" />

            <!-- Data Perhitungan Pajak -->
            <div class="space-y-4">
                <div class="font-semibold text-lg">Data Perhitungan Pajak</div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium">NJKB (Nilai Jual)</label>
                        <input type="text" name="njkb" class="mt-1 w-full border rounded p-2"
                            value="{{ old('njkb') }}" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Tenggat Jatuh Tempo Pajak</label>
                        <input type="date" name="tenggat_jatuh_tempo" class="mt-1 w-full border rounded p-2"
                            value="{{ old('tenggat_jatuh_tempo') }}" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Status Pajak Awal</label>
                        <select name="status_awal" class="mt-1 w-full border rounded p-2">
                            @foreach ($statusPajakList as $status)
                                <option value="{{ $status }}"
                                    {{ old('status_awal') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <!-- Actions -->
            <div class="flex space-x-4 pt-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">
                    Simpan
                </button>

                <a href="{{ route('wajib.pajak') }}" class="bg-gray-700 text-white px-6 py-2 rounded">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</x-layouts.app>
