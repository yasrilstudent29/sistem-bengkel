<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Manajemen Servis
            </h2>
            <a href="{{ route('admin.servis.create') }}"
                class="bg-gray-800 text-white text-sm font-bold px-4 py-2 rounded hover:bg-gray-700 transition">
                + Tambah Servis
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
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kendaraan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pemilik</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mekanik</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tgl Masuk</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Total Biaya
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($servis as $index => $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $servis->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $item->kendaraan->nama_kendaraan }}
                                        <span class="text-gray-500">({{ $item->kendaraan->plat_nomor }})</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->kendaraan->user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->mekanik->nama }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->tanggal_masuk->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $statusColor = match ($item->status) {
                                                'menunggu' => 'bg-yellow-100 text-yellow-700',
                                                'proses' => 'bg-blue-100 text-blue-700',
                                                'selesai' => 'bg-green-100 text-green-700',
                                                'diambil' => 'bg-gray-100 text-gray-700',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span class="text-xs font-bold px-2 py-1 rounded-full {{ $statusColor }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        Rp {{ number_format($item->total_biaya, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm space-x-3">
                                        <a href="{{ route('admin.servis.show', $item) }}"
                                            class="text-green-600 hover:underline">Detail</a>
                                        <a href="{{ route('admin.servis.edit', $item) }}"
                                            class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('admin.servis.destroy', $item) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus data servis ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data servis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($servis->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $servis->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
