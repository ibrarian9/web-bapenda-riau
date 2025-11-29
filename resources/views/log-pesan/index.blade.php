<x-layouts.app title="Log Pesan">

    {{-- Breadcrumb --}}
    <div class="text-gray-800 text-sm mb-6">
        <span class="opacity-70">HOME</span> >
        <span class="font-semibold">LOG PESAN</span>
    </div>

    {{-- Log WhatsApp Info --}}
    <div class="flex items-center gap-2 mb-4 text-gray-800">
        <span class="text-green-500 text-xl">🟢</span>
        <span>Log Notifikasi WhatsApp</span>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-lg shadow border border-gray-300">

        {{-- Header --}}
        <div class="bg-gray-800 text-white px-4 py-2 rounded-t flex items-center gap-2">
            <span>📁</span>
            <span class="font-semibold">DAFTAR LOG PESAN</span>
        </div>

        {{-- Table --}}
        <div class="p-4">

            <table class="w-full border border-gray-400 text-sm">
                <thead>
                    <tr class="bg-gray-200 text-gray-800">
                        <th class="border border-gray-400 px-3 py-2 text-center w-12">NO</th>
                        <th class="border border-gray-400 px-3 py-2 text-left">Nama Wajib Pajak</th>
                        <th class="border border-gray-400 px-3 py-2 text-left">NO HP</th>
                        <th class="border border-gray-400 px-3 py-2 text-left">Pesan</th>
                        <th class="border border-gray-400 px-3 py-2 text-center w-32">Status</th>
                        <th class="border border-gray-400 px-3 py-2 text-center w-32">Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td class="border border-gray-400 px-3 py-2 text-center">
                                {{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ $log->nama_wajib_pajak }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ $log->nomor_hp }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ Str::limit($log->pesan, 60) }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2 text-center">
                                @if($log->status == '1')
                                    <span class="text-green-600 font-semibold">Terkirim</span>
                                @else
                                    <span class="text-red-600 font-semibold">Gagal</span>
                                @endif
                            </td>

                            <td class="border border-gray-400 px-3 py-2 text-center">
                                {{ $log->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-3 text-gray-600">
                                Belum ada log pesan.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            <div class="mt-4">
                {{ $logs->links() }}
            </div>

            {{-- Button --}}
            <div class="mt-4 flex justify-end">
                <a href="{{ route('log.pesan.export.pdf') }}"
                    class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 flex items-center gap-2">
                    📄 Cetak PDF
                </a>
            </div>
        </div>

    </div>

</x-layouts.app>
