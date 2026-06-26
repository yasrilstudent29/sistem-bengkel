<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Mekanik
            </h2>
            <a href="{{ route('admin.mekanik.create') }}"
                class="bg-gray-800 text-white text-sm font-bold px-4 py-2 rounded hover:bg-gray-700 transition">
                + Tambah Mekanik
            </a>
        </div>
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
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">No. Telepon
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Spesialisasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($mekaniks as $index => $mekanik)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $mekaniks->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $mekanik->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $mekanik->no_telepon }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $mekanik->spesialisasi ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($mekanik->status === 'aktif')
                                            <span
                                                class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">Aktif</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm space-x-3">
                                        <a href="{{ route('admin.mekanik.edit', $mekanik) }}"
                                            class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('admin.mekanik.destroy', $mekanik) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus mekanik ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data mekanik.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($mekaniks->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $mekaniks->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
