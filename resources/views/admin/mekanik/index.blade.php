<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Mekanik
            </h2>
            <a href="{{ route('admin.mekanik.create') }}"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> Tambah Mekanik
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <p class="text-gray-500 text-sm mb-6">
                Kelola data mekanik bengkel Anda — kontak, spesialisasi, dan status ketersediaan.
            </p>

            {{-- Search Bar --}}
            <div class="relative mb-6 max-w-md">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchMekanik" placeholder="Cari berdasarkan nama atau spesialisasi..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            {{-- Card Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="mekanikGrid">
                @forelse ($mekaniks as $mekanik)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mekanik-card"
                        data-nama="{{ strtolower($mekanik->nama) }}"
                        data-spesialisasi="{{ strtolower($mekanik->spesialisasi ?? '') }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                                    style="background-color: #183356;">
                                    {{ strtoupper(substr($mekanik->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $mekanik->nama }}</p>
                                    <p class="text-xs text-gray-400">{{ $mekanik->spesialisasi ?? '-' }}</p>
                                </div>
                            </div>
                            @if ($mekanik->status === 'aktif')
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">Aktif</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-xs font-bold px-2.5 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </div>

                        <div class="mt-4 space-y-1.5 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $mekanik->no_telepon }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                @php
                                    $servisAktif = $mekanik->servis()->whereIn('status', ['menunggu', 'proses'])->count();
                                @endphp
                                @if ($servisAktif > 0)
                                    <span class="text-orange-600 font-medium">{{ $servisAktif }} servis sedang ditangani</span>
                                @else
                                    <span class="text-gray-400">Tidak ada servis aktif</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <a href="{{ route('admin.mekanik.edit', $mekanik) }}"
                                class="flex-1 text-center py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                                Edit
                            </a>
                            <form action="{{ route('admin.mekanik.destroy', $mekanik) }}" method="POST"
                                class="flex-1"
                                onsubmit="return confirm('Yakin ingin menghapus mekanik ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full py-2 rounded-lg border border-red-100 text-red-600 text-sm font-medium hover:bg-red-50 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada data mekanik.
                    </div>
                @endforelse
            </div>

            @if ($mekaniks->hasPages())
                <div class="mt-6">
                    {{ $mekaniks->links() }}
                </div>
            @endif

        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchMekanik');
        const cards = document.querySelectorAll('.mekanik-card');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            cards.forEach(card => {
                const nama = card.dataset.nama;
                const spesialisasi = card.dataset.spesialisasi;
                if (nama.includes(keyword) || spesialisasi.includes(keyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>