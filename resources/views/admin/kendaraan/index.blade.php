<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Vehicles
            </h2>
            <a href="{{ route('admin.kendaraan.create') }}"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> Add vehicle
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <p class="text-gray-500 text-sm mb-6">
                Seluruh kendaraan dari setiap customer yang terdaftar.
            </p>

            {{-- Search Bar --}}
            <div class="relative mb-6 max-w-md">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchKendaraan" placeholder="Cari berdasarkan plat, merek, atau model..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            {{-- Card Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="kendaraanGrid">
                @forelse ($kendaraans as $kendaraan)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 kendaraan-card"
                        data-plat="{{ strtolower($kendaraan->plat_nomor) }}"
                        data-merek="{{ strtolower($kendaraan->merek) }}"
                        data-model="{{ strtolower($kendaraan->model) }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $kendaraan->user->name }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.kendaraan.destroy', $kendaraan) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 space-y-1.5 text-sm text-gray-600">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Plate:</span>
                                <span class="font-medium">{{ $kendaraan->plat_nomor }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Odometer:</span>
                                <span class="font-medium">{{ number_format($kendaraan->odometer ?? 0, 0, ',', '.') }} km</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Warna:</span>
                                <span class="font-medium">{{ $kendaraan->warna ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Jenis:</span>
                                @if ($kendaraan->jenis === 'motor')
                                    <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">Motor</span>
                                @else
                                    <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-0.5 rounded-full">Mobil</span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('admin.kendaraan.show', $kendaraan) }}"
                            class="mt-4 block text-center w-full py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                            View details
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada data kendaraan.
                    </div>
                @endforelse
            </div>

            @if ($kendaraans->hasPages())
                <div class="mt-6">
                    {{ $kendaraans->links() }}
                </div>
            @endif

        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchKendaraan');
        const cards = document.querySelectorAll('.kendaraan-card');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            cards.forEach(card => {
                const plat = card.dataset.plat;
                const merek = card.dataset.merek;
                const model = card.dataset.model;
                if (plat.includes(keyword) || merek.includes(keyword) || model.includes(keyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>