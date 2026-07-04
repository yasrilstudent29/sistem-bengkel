<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
            Manajemen User
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl">

            <x-alert />

            <p class="text-gray-500 text-base -mt-9 mb-6">
                Kelola role dan akses seluruh pengguna sistem.
            </p>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-300 shadow p-5">
                    <p class="text-gray-500 text-sm">Total User</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalUser }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-300 shadow p-5">
                    <p class="text-gray-500 text-sm">Total Admin</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalAdmin }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-300 shadow p-5">
                    <p class="text-gray-500 text-sm">Terverifikasi</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $terverifikasi }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-300 shadow p-5">
                    <p class="text-gray-500 text-sm">Belum Verifikasi</p>
                    <p class="text-2xl font-bold text-red-500 mt-1">{{ $belumTerverifikasi }}</p>
                </div>
            </div>

            {{-- Search & Filter --}}
            <div class="flex flex-col sm:flex-row gap-3 mb-6">
                <div class="relative flex-1 max-w-md">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="searchUser" placeholder="Cari berdasarkan nama atau email..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
                </div>
                <select id="filterRole"
                    class="border border-gray-300 rounded-lg text-sm px-4 py-2.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow rounded-xl border border-gray-300">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Verified</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="userTableBody">
                            @forelse ($users as $user)
                                <tr class="user-row transition {{ $user->id === auth()->id() ? 'bg-orange-50' : 'hover:bg-gray-50' }}"
                                    data-nama="{{ strtolower($user->name) }}"
                                    data-email="{{ strtolower($user->email) }}"
                                    data-role="{{ $user->role }}">
                                    <td class="px-6 py-4 text-sm">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-xs shrink-0"
                                                style="background-color: #183356;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                            @if ($user->id === auth()->id())
                                                <span class="text-xs text-gray-400">(Anda)</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($user->role === 'admin')
                                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">Admin</span>
                                        @else
                                            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-1 rounded-full">User</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($user->email_verified_at)
                                            <span class="text-green-600 font-bold">✓ Verified</span>
                                        @else
                                            <span class="text-red-500">✕ Belum</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm space-x-3">
                                        @if ($user->id !== auth()->id())
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="text-blue-600 hover:underline">Ubah Role</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data user.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchUser');
        const filterRole = document.getElementById('filterRole');
        const rows = document.querySelectorAll('.user-row');

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const role = filterRole.value;

            rows.forEach(row => {
                const nama = row.dataset.nama;
                const email = row.dataset.email;
                const rowRole = row.dataset.role;

                const matchKeyword = nama.includes(keyword) || email.includes(keyword);
                const matchRole = role === '' || rowRole === role;

                row.style.display = (matchKeyword && matchRole) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterRole.addEventListener('change', filterTable);
    </script>
</x-app-layout>