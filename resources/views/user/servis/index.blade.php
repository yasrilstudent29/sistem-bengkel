<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
            Riwayat Servis
        </h2>
    </x-slot>

    <div class="-mt-9">
        <div class="max-w-7xl">

            <x-alert />

            <p class="text-gray-500 text-base -mt-1 mb-6">
                Pantau status dan riwayat servis kendaraan Anda.
            </p>

            {{-- Card Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @forelse ($servis as $item)
                    @php
                        $statusColor = match ($item->status) {
                            'menunggu' => 'bg-yellow-100 text-yellow-700',
                            'proses' => 'bg-blue-100 text-blue-700',
                            'selesai' => 'bg-green-100 text-green-700',
                            'diambil' => 'bg-gray-100 text-gray-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <a href="{{ route('user.servis.show', $item) }}"
                        class="group bg-white rounded-xl border border-gray-300 shadow p-5 hover:border-orange-400 transition-colors block">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-orange-500 transition-colors">
                                    {{ $item->kendaraan->tahun }} {{ $item->kendaraan->merek }}
                                    {{ $item->kendaraan->model }}
                                </p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    Plat {{ $item->kendaraan->plat_nomor }} — Mekanik: {{ $item->mekanik->nama }}
                                </p>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $statusColor }} shrink-0">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mt-3">{{ Str::limit($item->keluhan, 80) }}</p>

                        <div class="flex items-center justify-between mt-3 text-sm">
                            <span class="text-gray-400">
                                Masuk {{ $item->tanggal_masuk->format('d M Y') }}
                            </span>
                            <span class="font-semibold text-gray-900">
                                Rp {{ number_format($item->total_biaya, 0, ',', '.') }}
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada riwayat servis.
                    </div>
                @endforelse
            </div>

            @if ($servis->hasPages())
                <div class="mt-6">
                    {{ $servis->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
