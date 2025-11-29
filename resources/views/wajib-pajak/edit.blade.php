<x-layouts.app title="Edit Wajib Pajak">

    <div class="p-6 space-y-6">

        <div class="text-xl font-semibold">Edit Wajib Pajak</div>

        <form action="{{ route('wajib.pajak.update', $data->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Data Wajib Pajak -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium">NIK</label>
                    <input type="text" name="nik" value="{{ old('nik', $data->nik) }}"
                        class="mt-1 w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $data->nama) }}"
                        class="mt-1 w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Alamat</label>
                    <input type="text" name="alamat" value="{{ old('alamat', $data->alamat) }}"
                        class="mt-1 w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block text-sm font-medium">Nomor HP</label>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $data->nomor_hp) }}"
                        class="mt-1 w-full border rounded p-2" />
                </div>

            </div>

            <hr class="border-t" />

            <!-- Data Kendaraan -->
            <div class="space-y-4">
                <div class="font-semibold text-lg">Data Kendaraan</div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium">Nomor Polisi (NOPOL)</label>
                        <input type="text" name="nopol" value="{{ old('nopol', $kendaraan->nopol) }}"
                            class="mt-1 w-full border rounded p-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Merek</label>
                        <input type="text" name="merek" value="{{ old('merek', $kendaraan->merek) }}"
                            class="mt-1 w-full border rounded p-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Tipe Kendaraan</label>
                            <select name="tipe" class="mt-1 w-full border rounded p-2">
                            @foreach (\App\Models\Kendaraan::$tipeList as $tipe)
                                <option value="{{ $tipe }}" 
                                    {{ old('tipe', $kendaraan->tipe) == $tipe ? 'selected' : '' }}>
                                    {{ $tipe }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Tahun Pembuatan</label>
                        <input type="number" name="tahun_pembuatan"
                            value="{{ old('tahun_pembuatan', $kendaraan->tahun_pembuatan) }}"
                            class="mt-1 w-full border rounded p-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Warna</label>
                        <input type="text" name="warna" value="{{ old('warna', $kendaraan->warna) }}"
                            class="mt-1 w-full border rounded p-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Nomor Mesin</label>
                        <input type="text" name="nomor_mesin"
                            value="{{ old('nomor_mesin', $kendaraan->nomor_mesin) }}"
                            class="mt-1 w-full border rounded p-2" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Nomor Rangka</label>
                        <input type="text" name="nomor_rangka"
                            value="{{ old('nomor_rangka', $kendaraan->nomor_rangka) }}"
                            class="mt-1 w-full border rounded p-2" />
                    </div>

                </div>
            </div>

            <hr class="border-t" />

            <!-- Data Pajak -->
            <div class="space-y-4">
                <div class="font-semibold text-lg">Data Pajak</div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <div>
                        <label class="block text-sm font-medium">NJKB</label>
                        <input type="text" name="njkb" value="{{ old('njkb', $pajak->njkb) }}"
                            class="mt-1 w-full border rounded p-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Tenggat Jatuh Tempo</label>
                        <input type="date" name="tenggat_jatuh_tempo"
                            value="{{ old('tenggat_jatuh_tempo', $pajak->tenggat_jatuh_tempo) }}"
                            class="mt-1 w-full border rounded p-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Status Pajak Awal</label>
                        <select name="status_awal" class="mt-1 w-full border rounded p-2">
                            @foreach ($statusPajakList as $status)
                                <option value="{{ $status }}"
                                    {{ old('status_awal', $pajak->status_awal) == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <!-- Actions -->
            <div class="flex space-x-4 pt-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Simpan</button>
                <a href="{{ route('wajib.pajak') }}" class="bg-gray-700 text-white px-6 py-2 rounded">Kembali</a>
            </div>

        </form>

    </div>
</x-layouts.app>
