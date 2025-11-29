<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- GOOGLE MATERIAL SYMBOLS -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:wght@300;400;500;600;700" />

    <title>{{ $title ?? 'Dashboard' }}</title>
    @vite('resources/css/app.css')

    <style>
        .icon {
            font-family: 'Material Symbols Rounded';
            font-weight: 400;
            font-size: 22px;
        }
    </style>
</head>

<body class="bg-gray-100 flex">

    <!-- SIDEBAR -->
    <aside class="w-64 min-h-screen bg-linear-to-b from-blue-900 to-blue-300 text-white p-5">

        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/logo.png') }}" class="h-24 mb-3">
            <p class="text-center font-semibold leading-tight">
                SAMSAT RIAU <br>
                <span class="text-sm">Bapenda Provinsi Riau</span>
            </p>
        </div>

        <nav class="space-y-3 mt-6">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 py-2 px-3 rounded transition
               {{ request()->routeIs('dashboard') ? 'bg-blue-800 text-white' : 'hover:bg-blue-700' }}">
                <span class="icon">home</span> Dashboard
            </a>

            <a href="{{ route('anggota') }}"
               class="flex items-center gap-3 py-2 px-3 rounded transition
               {{ request()->routeIs('anggota*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-700' }}">
                <span class="icon">group</span> Manajemen Anggota
            </a>

            <a href="{{ route('wajib.pajak') }}"
               class="flex items-center gap-3 py-2 px-3 rounded transition
               {{ request()->routeIs('wajib.pajak*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-700' }}">
                <span class="icon">description</span> Wajib Pajak
            </a>

            <a href="{{ route('kendaraan') }}"
               class="flex items-center gap-3 py-2 px-3 rounded transition
               {{ request()->routeIs('kendaraan*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-700' }}">
                <span class="icon">directions_car</span> Data Kendaraan
            </a>

            <a href="{{ route('pembayaran') }}"
               class="flex items-center gap-3 py-2 px-3 rounded transition
               {{ request()->routeIs('pembayaran*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-700' }}">
                <span class="icon">payments</span> Pembayaran Pajak
            </a>

            <a href="{{ route('laporan') }}"
               class="flex items-center gap-3 py-2 px-3 rounded transition
               {{ request()->routeIs('laporan*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-700' }}">
                <span class="icon">bar_chart</span> Laporan
            </a>

            <a href="{{ route('log.pesan') }}"
               class="flex items-center gap-3 py-2 px-3 rounded transition
               {{ request()->routeIs('log.pesan*') ? 'bg-blue-800 text-white' : 'hover:bg-blue-700' }}">
                <span class="icon">chat</span> Log Pesan
            </a>

        </nav>

        <div class="mt-10">
            <button class="w-full bg-black py-2 rounded text-white font-semibold flex justify-center items-center gap-2">
                <span class="icon">logout</span> LOGOUT
            </button>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1">

        <!-- TOP BAR -->
        <header class="bg-blue-900 text-white py-4 px-8 flex justify-between items-center">
            <h1 class="text-xl font-semibold">
                Sistem Informasi Pelayanan Pajak Kendaraan
            </h1>

            <div class="flex items-center gap-2">
                <span class="icon text-xl">account_circle</span>
                <span class="text-sm">Halo, admin</span>
            </div>
        </header>

        <!-- CONTENT -->
        <div class="p-8">
            {{ $slot }}
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
