<x-layouts.app title="Manajemen Anggota">

    <!-- Breadcrumb -->
    <div class="text-sm text-gray-600 mb-4">
        <span>HOME</span> ›
        <span class="font-semibold">Manajemen Anggota</span>
    </div>

    <!-- Wrapper -->
    <div class="bg-white shadow-lg rounded-lg">

        <!-- Header Box -->
        <div class="border-b px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-2 text-lg font-semibold text-gray-700">
                <span class="text-2xl">👥</span>
                <span>MANAGEMEN ANGGOTA</span>
            </div>

            <a href="{{ route('anggota.create') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded font-semibold flex items-center gap-2">
                <span class="text-xl">➕</span> Tambah Anggota
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto px-6 py-4">
            <table class="w-full border-collapse">

                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-sm">
                        <th class="border px-3 py-2 w-10">NO</th>
                        <th class="border px-3 py-2">NAMA</th>
                        <th class="border px-3 py-2">EMAIL</th>
                        <th class="border px-3 py-2">ROLE (PERAN)</th>
                        <th class="border px-3 py-2 w-24">AKSI</th>
                    </tr>
                </thead>

                <tbody class="text-sm">

                    @forelse($users as $index => $user)
                        <tr class="border">
                            <td class="border px-3 py-2">{{ $index + 1 }}</td>
                            <td class="border px-3 py-2 font-semibold">{{ $user->name }}</td>
                            <td class="border px-3 py-2">{{ $user->email }}</td>

                            <td class="border px-3 py-2 text-center">
                                @php
                                    $color = match ($user->role) {
                                        'pimpinan' => 'bg-red-700',
                                        'admin' => 'bg-blue-700',
                                        'petugas' => 'bg-teal-600',
                                        default => 'bg-gray-500',
                                    };
                                @endphp

                                <span class="{{ $color }} text-white text-xs px-3 py-1 rounded-full">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>

                            <td class="border px-3 py-2 text-center flex items-center justify-center gap-3">

                                <!-- Edit -->
                                <a href="{{ route('anggota.edit', $user->id) }}"
                                class="text-gray-700 hover:text-black">
                                    <span class="material-symbols-rounded text-[22px]">
                                        edit
                                    </span>
                                </a>

                                <!-- Delete -->
                                <button onclick="deleteUser({{ $user->id }})"
                                        class="text-red-600 hover:text-red-800">
                                    <span class="material-symbols-rounded text-[22px]">
                                        delete
                                    </span>
                                </button>

                                <!-- Form Delete (hidden) -->
                                <form id="delete-form-{{ $user->id }}"
                                    action="{{ route('anggota.destroy', $user->id) }}"
                                    method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-gray-600">
                                Tidak ada pengguna terdaftar.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</x-layouts.app>

<script>
    function deleteUser(id) {
        Swal.fire({
            title: "Hapus Pengguna?",
            text: "Data yang dihapus tidak dapat dikembalikan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
