<x-layouts.app title="Tambah Pengguna Baru">

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-900 mb-6">
        <span>HOME</span> ›
        <span>Manajemen Anggota</span> ›
        <span class="font-semibold">Tambah Pengguna Baru</span>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-600 text-red-700 p-4 mb-6 rounded">
            <div class="font-semibold text-red-800 mb-2">Terjadi Kesalahan:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Wrapper -->
    <div class="bg-white shadow-xl rounded-lg w-full">

        <!-- Header -->
        <div class="bg-[#1B3A4B] text-white px-6 py-3 rounded-t-lg flex items-center gap-2">
            <span class="text-xl font-bold">＋</span>
            <span class="font-semibold">Tambah Pengguna Baru</span>
        </div>

        <!-- Form -->
        <form action="{{ route('anggota.store') }}" method="POST" class="px-8 py-6 space-y-5">
            @csrf

            <!-- Nama -->
            <div>
                <label class="block font-semibold mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
            </div>

            <!-- Email -->
            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
            </div>

            <!-- ROLE -->
            <div>
                <label class="block font-semibold mb-1">ROLE (Peran)</label>
                <select name="role"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
                    <option value="">-- Pilih Role --</option>
                    <option value="Pimpinan" {{ old('role') == 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                    <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Petugas" {{ old('role') == 'Petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
            </div>

            <!-- Password -->
            <div>
                <label class="block font-semibold mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label class="block font-semibold mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300" />
            </div>

            <!-- Buttons -->
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold px-6 py-2 rounded">
                    SIMPAN
                </button>

                <a href="{{ route('anggota') }}"
                    class="bg-black hover:bg-gray-900 text-white font-bold px-6 py-2 rounded">
                    KEMBALI
                </a>
            </div>

        </form>

    </div>

</x-layouts.app>
