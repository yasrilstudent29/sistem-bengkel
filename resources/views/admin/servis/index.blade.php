<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                Repair Jobs
            </h2>
            <a href="{{ route('admin.servis.create') }}"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> New Job
            </a>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl">

            <x-alert />

            <p class="text-gray-500 text-base -mt-9 mb-6">
                Servis kendaraan yang sedang berjalan di bengkel Anda.
            </p>

            {{-- Filter Tabs --}}
            <div class="flex items-center gap-1 mb-6 bg-gray-100 p-1 rounded-lg w-fit">
                <a href="{{ route('admin.servis.index') }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ !$status || $status === 'all' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    All ({{ $countAll }})
                </a>
                <a href="{{ route('admin.servis.index', ['status' => 'menunggu']) }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ $status === 'menunggu' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Menunggu ({{ $countMenunggu }})
                </a>
                <a href="{{ route('admin.servis.index', ['status' => 'proses']) }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ $status === 'proses' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Proses ({{ $countProses }})
                </a>
                <a href="{{ route('admin.servis.index', ['status' => 'selesai']) }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ $status === 'selesai' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Selesai ({{ $countSelesai }})
                </a>
                <a href="{{ route('admin.servis.index', ['status' => 'diambil']) }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ $status === 'diambil' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Diambil ({{ $countDiambil }})
                </a>
            </div>

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
                    <div
                        class="group bg-white rounded-xl border border-gray-300 shadow p-5 hover:border-orange-400 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-orange-500 transition-colors">
                                    {{ $item->kendaraan->tahun }} {{ $item->kendaraan->merek }}
                                    {{ $item->kendaraan->model }}
                                </p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ $item->kendaraan->user->name }} — {{ $item->kendaraan->plat_nomor }}
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

                        <div class="mt-4 flex items-center gap-2">
                            <form action="{{ route('admin.servis.update-status', $item) }}" method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-200">
                                    <option value="menunggu" {{ $item->status === 'menunggu' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="proses" {{ $item->status === 'proses' ? 'selected' : '' }}>Proses
                                    </option>
                                    <option value="selesai" {{ $item->status === 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="diambil" {{ $item->status === 'diambil' ? 'selected' : '' }}>Diambil
                                    </option>
                                </select>
                            </form>
                            <a href="{{ route('admin.servis.show', $item) }}"
                                class="px-5 py-2 rounded-lg text-white text-sm font-semibold hover:opacity-90 transition shrink-0"
                                style="background-color: #183356;">
                                View details
                            </a>
                            <form action="{{ route('admin.servis.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data servis ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada data servis.
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
