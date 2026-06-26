<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Spare Part
            </h2>
            <a href="{{ route('admin.spare-parts.create') }}"
                class="bg-gray-800 text-white text-sm font-bold px-4 py-2 rounded hover:bg-gray-700 transition">
                + Tambah Spare Part
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
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($spareParts as $index => $part)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $spareParts->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $part->kode }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $part->nama }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span
                                            class="{{ $part->stok <= 5 ? 'text-red-600 font-bold' : 'text-gray-600' }}">
                                            {{ $part->stok }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        Rp {{ number_format($part->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm space-x-3">
                                        <a href="{{ route('admin.spare-parts.edit', $part) }}"
                                            class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('admin.spare-parts.destroy', $part) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus spare part ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data spare part.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($spareParts->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $spareParts->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
