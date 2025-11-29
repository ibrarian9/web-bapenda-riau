<x-layouts.app title="Wajib Pajak">

    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-600 mb-4">
        <span>HOME</span> › <span class="font-semibold">Wajib Pajak</span>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-lime-500 p-5 rounded text-white text-center">
            <p>TOTAL WAJIB PAJAK</p>
            <p class="text-3xl mt-2">{{ $totalWp ?? 0 }}</p>
        </div>

        <div class="bg-yellow-400 p-5 rounded text-white text-center">
            <p>KENDARAAN</p>
            <p class="text-3xl mt-2">{{ $totalKendaraan ?? 0 }}</p>
        </div>

        <div class="bg-orange-300 p-5 rounded text-white text-center">
            <p>PEMBAYARAN LUNAS</p>
            <p class="text-3xl mt-2">{{ $totalLunas ?? 0 }}</p>
        </div>

        <div class="bg-red-600 p-5 rounded text-white text-center">
            <p>PEMBAYARAN BELUM LUNAS</p>
            <p class="text-3xl mt-2">{{ $totalBelum ?? 0 }}</p>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white shadow-md rounded">

        <div class="flex justify-between items-center bg-blue-900 text-white px-5 py-3 rounded-t">
            <p class="font-semibold">DATA WAJIB PAJAK</p>
        </div>

        <div class="p-4 flex justify-between items-center">

            <!-- Search -->
            <div class="flex items-center gap-2 w-1/2">
                <form method="GET" action="{{ route('wajib.pajak') }}" class="flex w-full">
                    <input type="text" name="search" placeholder="Cari NIK/Nama/NOPOL"
                        value="{{ request('search') }}"
                        class="w-full border border-gray-300 rounded px-3 py-2">
                    <button class="bg-blue-800 text-white px-4 py-2 rounded flex items-center gap-1">
                        <span class="material-symbols-outlined">search</span>
                        CARI
                    </button>
                </form>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3">
                <a href="{{ route('wajib.pajak.create') }}"
                    class="bg-gray-200 px-3 py-2 rounded flex items-center gap-1">
                    <span class="material-symbols-outlined">add</span>
                    Tambah Wajib Pajak
                </a>

                <a href="{{ route('wajib.pajak.export.pdf') }}"
                    class="bg-gray-200 px-3 py-2 rounded flex items-center gap-1">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                    Export PDF
                </a>
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 border">
                        <th class="border px-3 py-2">No</th>
                        <th class="border px-3 py-2">NIK</th>
                        <th class="border px-3 py-2">Nama</th>
                        <th class="border px-3 py-2">No HP</th>
                        <th class="border px-3 py-2">Alamat</th>
                        <th class="border px-3 py-2">NOPOL</th>
                        <th class="border px-3 py-2">KET</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($data as $wp)
                        @php
                            $kendaraan = $wp->kendaraans->first();
                            $statusPajak = $kendaraan && $kendaraan->pembayaran ? 'LUNAS' : 'BELUM LUNAS';
                        @endphp

                        <tr class="border">
                            <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-3 py-2">{{ $wp->nik }}</td>
                            <td class="border px-3 py-2">{{ $wp->nama }}</td>
                            <td class="border px-3 py-2">{{ $wp->nomor_hp }}</td>
                            <td class="border px-3 py-2">{{ $wp->alamat }}</td>

                            <td class="border px-3 py-2">{{ $kendaraan?->nopol ?? '-' }}</td>

                            <td class="border px-3 py-2 font-semibold
                                {{ $statusPajak == 'LUNAS' ? 'text-green-700' : 'text-red-700' }}">
                                {{ $statusPajak }}
                            </td>

                            <td class="border px-3 py-2 flex gap-2">

                                <!-- Detail -->
                                <a href="{{ route('wajib.pajak.show', $wp->id) }}"
                                    class="text-blue-700">
                                    <span class="material-symbols-outlined text-2xl">visibility</span>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('wajib.pajak.edit', $wp->id) }}"
                                    class="text-yellow-600">
                                    <span class="material-symbols-outlined text-2xl">edit</span>
                                </a>

                                <!-- WhatsApp -->
                                <a href="{{ route('wajib.pajak.notifikasi', $wp->id) }}"
                                    class="text-green-600">
                                    <span class="material-symbols-outlined text-2xl">chat</span>
                                </a>

                                <!-- Delete -->
                                <form id="delete-form-{{ $wp->id }}"
                                    action="{{ route('wajib.pajak.destroy', $wp->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $wp->id }})"
                                        class="text-red-600">
                                        <span class="material-symbols-outlined text-2xl">delete</span>
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-3 text-gray-500">
                                Tidak ada data wajib pajak
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</x-layouts.app>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data wajib pajak akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
