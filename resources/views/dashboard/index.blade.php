<x-layouts.app title="Dashboard">

    <!-- Breadcrumb -->
    <div class="text-sm text-white mb-6">
        <span>HOME</span> ›
        <span>Dashboard</span>
    </div>

    <!-- Main Container -->
    <div class="bg-white shadow-xl rounded-lg w-full p-6">

        <!-- Header Logo + Title -->
        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo.png') }}" class="h-16" alt="Logo">

                <div class="text-left">
                    <div class="text-xl font-bold uppercase">
                        Pemerintah Provinsi Riau
                    </div>
                    <div class="text-sm uppercase font-semibold text-gray-600">
                        Badan Pendapatan Daerah (BAPENDA)
                    </div>
                </div>
            </div>

            <div class="text-sm font-semibold text-gray-700 px-4 py-2 bg-gray-100 rounded">
                Sistem Informasi SAMSAT Terpadu
            </div>
        </div>

        <!-- Welcome Section -->
        <div class="text-center mb-8">
            <h1 class="text-xl font-bold uppercase">
                Selamat Datang di Sistem Informasi SamSat Provinsi Riau
            </h1>
            <p class="text-sm text-gray-600">
                Sistem ini digunakan untuk mengelola data wajib pajak, kendaraan, dan pembayaran pajak kendaraan bermotor.
            </p>
        </div>

        <!-- Summary Boxes -->
        <div class="grid grid-cols-4 gap-4 mb-8">

            <div class="bg-gray-200 px-4 py-6 rounded text-center">
                <div class="text-sm font-semibold mb-1">Wajib Pajak</div>
                <div class="text-lg font-bold">{{ $totalWp }}</div>
            </div>

            <div class="bg-gray-200 px-4 py-6 rounded text-center">
                <div class="text-sm font-semibold mb-1">Kendaraan</div>
                <div class="text-lg font-bold">{{ $totalKendaraan }}</div>
            </div>

            <div class="bg-gray-200 px-4 py-6 rounded text-center">
                <div class="text-sm font-semibold mb-1">Telah Lunas</div>
                <div class="text-lg font-bold">{{ $totalLunas }}</div>
            </div>

            <div class="bg-gray-200 px-4 py-6 rounded text-center">
                <div class="text-sm font-semibold mb-1">Belum Lunas</div>
                <div class="text-lg font-bold">{{ $totalBelum }}</div>
            </div>

        </div>

        <!-- Payment Summary Boxes -->
        <div class="grid grid-cols-4 gap-4 mb-10">

            <div class="bg-gray-200 px-4 py-4 rounded text-center">
                <div class="text-sm font-semibold mb-1">Total Belum Lunas Bulan Ini</div>
                <div class="text-lg font-bold">Rp {{ number_format($totalBelumBulan, 0, ',', '.') }}</div>
            </div>

            <div class="bg-gray-200 px-4 py-4 rounded text-center">
                <div class="text-sm font-semibold mb-1">Total Lunas Bulan Ini</div>
                <div class="text-lg font-bold">Rp {{ number_format($totalLunasBulan, 0, ',', '.') }}</div>
            </div>

            <div class="bg-gray-200 px-4 py-4 rounded text-center">
                <div class="text-sm font-semibold mb-1">Total Belum Lunas Tahun Ini</div>
                <div class="text-lg font-bold">Rp {{ number_format($totalBelumTahun, 0, ',', '.') }}</div>
            </div>

            <div class="bg-gray-200 px-4 py-4 rounded text-center">
                <div class="text-sm font-semibold mb-1">Total Lunas Tahun Ini</div>
                <div class="text-lg font-bold">Rp {{ number_format($totalLunasTahun, 0, ',', '.') }}</div>
            </div>

        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-2 gap-8">

            <!-- Chart 1 -->
            <div class="flex flex-col items-center">
                <h2 class="text-sm font-semibold mb-2">Status Pembayaran per Bulan</h2>
                <img src="{{ asset('images/chart-month.png') }}" class="rounded shadow" alt="">
            </div>

            <!-- Chart 2 -->
            <div class="flex flex-col items-center">
                <h2 class="text-sm font-semibold mb-2">Status Pembayaran per Tahun</h2>
                <img src="{{ asset('images/chart-year.png') }}" class="rounded shadow" alt="">
            </div>

        </div>

    </div>

</x-layouts.app>
