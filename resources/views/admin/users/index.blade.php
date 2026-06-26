<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Verified</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $users->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($user->role === 'admin')
                                            <span
                                                class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">Admin</span>
                                        @else
                                            <span
                                                class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full">User</span>
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
                                                <button type="submit"
                                                    class="text-red-600 hover:underline">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data user.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($users->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
