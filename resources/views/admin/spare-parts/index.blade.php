<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                Spare Part
            </h2>
            <a href="{{ route('admin.spare-parts.create') }}"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> Tambah Spare Part
            </a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl">

            <x-alert />

            <p class="text-gray-500 text-base -mt-9 mb-6">
                Kelola stok dan harga spare part bengkel Anda.
            </p>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-300 shadow p-5">
                    <p class="text-gray-500 text-sm">Total Item</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalItem }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-300 shadow p-5">
                    <p class="text-gray-500 text-sm">Stok Menipis</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stokMenipis }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-300 shadow p-5">
                    <p class="text-gray-500 text-sm">Stok Habis</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $stokHabis }}</p>
                </div>
                <div class="bg-white rounded-xl border border-gray-300 shadow p-5">
                    <p class="text-gray-500 text-sm">Nilai Inventaris</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($nilaiInventaris, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="relative mb-6 max-w-md">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchSparePart" placeholder="Cari berdasarkan nama atau kode..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow rounded-xl border border-gray-300">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Harga</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="sparePartTableBody">
                            @forelse ($spareParts as $part)
                                <tr class="spare-part-row hover:bg-gray-50 transition"
                                    data-nama="{{ strtolower($part->nama) }}"
                                    data-kode="{{ strtolower($part->kode) }}">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $part->kode }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $part->nama }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($part->stok == 0)
                                            <span class="bg-red-100 text-red-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                                Habis
                                            </span>
                                        @elseif ($part->stok <= 5)
                                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                                Menipis ({{ $part->stok }})
                                            </span>
                                        @else
                                            <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">
                                                {{ $part->stok }} unit
                                            </span>
                                        @endif
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
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data spare part.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($spareParts->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $spareParts->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchSparePart');
        const rows = document.querySelectorAll('.spare-part-row');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            rows.forEach(row => {
                const nama = row.dataset.nama;
                const kode = row.dataset.kode;
                if (nama.includes(keyword) || kode.includes(keyword)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>