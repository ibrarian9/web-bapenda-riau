<x-layouts.app>
    <div class="p-6 space-y-6">

        <!-- Header -->
        <div class="text-xl font-semibold">Data Kendaraan</div>

        <!-- Statistik -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-green-600 text-white text-center">
                <div class="text-sm">Total Wajib Pajak</div>
                <div class="text-3xl font-bold">{{ $totalWp }}</div>
            </div>

            <div class="p-4 rounded-xl bg-yellow-500 text-white text-center">
                <div class="text-sm">Kendaraan</div>
                <div class="text-3xl font-bold">{{ $totalKendaraan }}</div>
            </div>

            <div class="p-4 rounded-xl bg-amber-300 text-gray-900 text-center">
                <div class="text-sm">Pembayaran Lunas</div>
                <div class="text-3xl font-bold">{{ $totalLunas }}</div>
            </div>

            <div class="p-4 rounded-xl bg-red-800 text-white text-center">
                <div class="text-sm">Pembayaran Belum Lunas</div>
                <div class="text-3xl font-bold">{{ $totalBelum }}</div>
            </div>
        </div>

        <!-- Panel Utama -->
        <div class="bg-white rounded-xl shadow p-4 space-y-4">

            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold">Data Kendaraan Bermotor</h2>
                <div class="flex gap-2">
                    <a href="{{ route('kendaraan.pdf') }}"
                        class="px-4 py-2 bg-red-600 text-white rounded flex items-center gap-1">
                        <span class="material-symbols-rounded">picture_as_pdf</span>
                        PDF
                    </a>

                    <a href="{{ route('wajib.pajak.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded flex items-center gap-1">
                        <span class="material-symbols-rounded">add</span>
                        Tambah Kendaraan
                    </a>
                </div>
            </div>

            <!-- Filter -->
            <form method="GET" class="flex items-center gap-2">
                <input type="text" name="search" value="{{ $search }}" class="w-full border rounded p-2"
                    placeholder="Cari No Kendaraan / Nama Wajib Pajak">

                <select name="status" class="border rounded p-2">
                    <option value="">-- Status Pajak --</option>
                    <option value="LUNAS" {{ $status=='LUNAS' ? 'selected' : '' }}>Lunas</option>
                    <option value="BELUM" {{ $status=='BELUM' ? 'selected' : '' }}>Belum Lunas</option>
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded flex items-center gap-1">
                    <span class="material-symbols-rounded">search</span>
                    Cari
                </button>
            </form>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border px-3 py-2">No</th>
                            <th class="border px-3 py-2">NOPOL</th>
                            <th class="border px-3 py-2">Nama WP</th>
                            <th class="border px-3 py-2">Merek</th>
                            <th class="border px-3 py-2">Tipe</th>
                            <th class="border px-3 py-2">Tahun</th>
                            <th class="border px-3 py-2">Warna</th>
                            <th class="border px-3 py-2">Status</th>
                            <th class="border px-3 py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($kendaraan as $k)
                            @php $statusPajak = $k->pembayaran ? 'LUNAS' : 'BELUM LUNAS'; @endphp

                            <tr class="text-center">
                                <td class="border px-3 py-1">{{ $loop->iteration }}</td>
                                <td class="border px-3 py-1">{{ $k->nopol }}</td>

                                <td class="border px-3 py-1">
                                    {{ $k->wajibPajak->nama ?? '-' }}
                                </td>

                                <td class="border px-3 py-1">{{ $k->merek }}</td>
                                <td class="border px-3 py-1">{{ $k->tipe }}</td>
                                <td class="border px-3 py-1">{{ $k->tahun_pembuatan }}</td>
                                <td class="border px-3 py-1">{{ $k->warna }}</td>

                                <td class="border px-3 py-1 font-semibold {{ $statusPajak == 'LUNAS' ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $statusPajak }}
                                </td>

                                <td class="border px-3 py-1 space-x-2">

                                    <a href="{{ route('wajib.pajak.show', $k->id) }}"
                                        class="text-yellow-500 material-symbols-rounded">visibility</a>

                                    <a href="{{ route('wajib.pajak.edit', $k->id) }}"
                                        class="text-blue-600 material-symbols-rounded">edit</a>

                                    <form action="{{ route('wajib.pajak.destroy', $k->id) }}"
                                        method="POST" class="inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                            class="text-red-600 material-symbols-rounded delete-btn">
                                            delete
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-gray-500">
                                    Belum ada data kendaraan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                let form = this.closest('.delete-form');
                Swal.fire({
                    title: 'Hapus data?',
                    text: "Data tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                })
            });
        });
    </script>
</x-layouts.app>
