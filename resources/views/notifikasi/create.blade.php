<x-layouts.app title="Form Notifikasi Pajak">
    <div class="px-6 py-8">

        <nav class="text-sm mb-4 text-gray-600">
            <a href="#" class="hover:underline">HOME</a> >
            <span>Data Kendaraan</span>
        </nav>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-bold mb-2">
                Data Kendaraan : 
                <span class="font-semibold">{{ $data->nopol }}</span>

                <span class="ml-4">
                    Nomor Telpon : 
                    <span class="font-semibold">{{ $data->wajibPajak->nomor_hp }}</span>
                </span>
            </h2>

            <hr class="my-4">

            <div class="text-center mb-6">
                <h3 class="text-xl font-semibold text-yellow-600">
                    ⚠️ Peringatan Pajak Kendaraan ⚠️
                </h3>
            </div>

            <form action="{{ route('wajib.pajak.notifikasi.kirim', $data->id) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-lg font-medium mb-2">Halo 👋</label>
                    <input type="text" name="nama"
                           class="w-64 bg-gray-200 rounded px-3 py-2"
                           value="{{ $data->wajibPajak->nama }}"
                           readonly />
                </div>

                <div>
                    @php
                        $days = now()->diffInDays($data->jatuh_tempo, false);
                    @endphp

                    <p class="text-lg">
                        Pajak kendaraan Anda akan jatuh tempo dalam 
                        <input type="number"
                               class="w-20 bg-gray-200 rounded px-2 py-1"
                               value="{{ $days }}"
                               readonly>
                        hari.
                    </p>
                </div>

                <!-- Nomor Kendaraan -->
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🚗</span>
                    <label class="text-lg w-48">Nomor Kendaraan:</label>
                    <input type="text"
                           class="bg-gray-200 rounded px-3 py-2 w-56"
                           value="{{ $data->nopol }}"
                           readonly>
                </div>

                <!-- Jatuh Tempo -->
                <div class="flex items-center gap-3">
                    <span class="text-2xl">📅</span>
                    <label class="text-lg w-48">Jatuh Tempo:</label>
                    <input type="date" name="jatuh_tempo"
                           value="{{ $data->jatuh_tempo }}"
                           class="bg-white border rounded px-3 py-2 w-56">
                </div>

                <p class="text-lg leading-relaxed mt-4">
                    Segera lakukan pembayaran untuk menghindari denda keterlambatan. 💸
                </p>

                <p class="text-lg mt-4">
                    Pesan otomatis dari Sistem SAMSAT Provinsi Riau
                </p>

                <div class="flex gap-4 mt-8">
                    <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        KIRIM
                    </button>

                    <a href="{{ url()->previous() }}"
                       class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-gray-800">
                        KEMBALI
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
