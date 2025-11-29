<x-layouts.app title="Pembayaran Pajak">

    {{-- Breadcrumb --}}
    <div class="text-gray-900 text-sm mb-6">
        <span class="opacity-70">HOME</span> >
        <span class="font-semibold">Pembayaran Pajak</span>
    </div>

    <div class="bg-white shadow rounded-xl p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
                <span class="material-symbols-rounded text-2xl text-gray-700">receipt_long</span>
                <span class="text-lg font-semibold text-gray-900">Daftar Pembayaran Pajak</span>
            </div>

            <a href="{{ route('pembayaran.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium shadow hover:bg-blue-700 flex items-center gap-1">
                <span class="material-symbols-rounded">add</span>
                Tambah Pembayaran
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-lg border border-gray-300">
            <table class="min-w-full text-sm bg-white">
                <thead class="bg-gray-100 text-gray-900 font-semibold border-b border-gray-300">
                    <tr>
                        <th class="px-4 py-2 border-r">NO</th>
                        <th class="px-4 py-2 border-r">TANGGAL BAYAR</th>
                        <th class="px-4 py-2 border-r">NO KENDARAAN</th>
                        <th class="px-4 py-2 border-r">WAJIB PAJAK</th>
                        <th class="px-4 py-2 border-r">JENIS PAJAK</th>
                        <th class="px-4 py-2 border-r">JUMLAH BAYAR</th>
                        <th class="px-4 py-2 text-center">AKSI</th>
                    </tr>
                </thead>

                <tbody class="text-gray-900">

                    @forelse ($pembayaran as $index => $pb)
                        <tr class="hover:bg-gray-50 border-b border-gray-300">

                            {{-- No --}}
                            <td class="px-4 py-2 border-r text-center">
                                {{ $index + 1 }}
                            </td>

                            {{-- Tanggal Bayar --}}
                            <td class="px-4 py-2 border-r">
                                {{ \Carbon\Carbon::parse($pb->tanggal_bayar)->translatedFormat('d F Y') }}
                            </td>

                            {{-- Nomor Kendaraan --}}
                            <td class="px-4 py-2 border-r">
                                {{ $pb->kendaraan->nopol }}
                            </td>

                            {{-- Nama Wajib Pajak --}}
                            <td class="px-4 py-2 border-r">
                                {{ $pb->kendaraan->wajibPajak->nama }}
                            </td>

                            {{-- Jenis Pajak --}}
                            <td class="px-4 py-2 border-r font-semibold uppercase">
                                {{ $pb->jenis_pajak }}
                            </td>

                            {{-- Jumlah Bayar --}}
                            <td class="px-4 py-2 border-r">
                                Rp {{ number_format($pb->jumlah_bayar, 0, ',', '.') }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-2 flex items-center justify-center gap-3">

                                {{-- Edit --}}
                                <a href="{{ route('pembayaran.edit', $pb->id) }}"
                                   class="text-yellow-600 hover:text-yellow-700">
                                    <span class="material-symbols-rounded">edit</span>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('pembayaran.destroy', $pb->id) }}" method="POST"
                                      class="inline delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="text-red-600 hover:text-red-700 delete-btn">
                                        <span class="material-symbols-rounded">delete</span>
                                    </button>
                                </form>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-600">
                                Belum ada data pembayaran pajak.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

    {{-- SweetAlert --}}
    <script>
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                let form = this.closest('form');

                Swal.fire({
                    title: 'Hapus pembayaran?',
                    text: "Tindakan ini tidak bisa dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>

</x-layouts.app>
