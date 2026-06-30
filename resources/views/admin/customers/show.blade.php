<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.customers.index') }}"
            class="text-sm text-gray-600 hover:underline flex items-center gap-1">
            ← Back to customers
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <x-alert />

            {{-- Header --}}
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl"
                        style="background-color: #183356;">
                        {{ strtoupper(substr($customer->nama_lengkap, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $customer->nama_lengkap }}</h2>
                        <p class="text-gray-500 text-sm">Customer sejak {{ $customer->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('user.kendaraan.create') }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                        + Kendaraan
                    </a>
                    <a href="{{ route('admin.customers.edit', $customer) }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                        Edit
                    </a>
                    <a href="{{ route('admin.servis.create') }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                        style="background-color: #fa7c20;">
                        + Servis Baru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Kontak --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Contact</h3>
                    <div class="space-y-3 text-sm text-gray-700">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $customer->no_telepon ?? '-' }}
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $customer->user->email }}
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $customer->alamat ?? '-' }}
                        </div>
                    </div>
                </div>

                {{-- Kendaraan --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-900">Kendaraan</h3>
                        <span class="text-xs text-gray-400">{{ $kendaraans->count() }} unit</span>
                    </div>
                    <div class="space-y-3">
                        @forelse ($kendaraans as $kendaraan)
                            <a href="{{ route('admin.kendaraan.show', $kendaraan) }}"
                                class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition">
                                <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Plat <span class="font-medium">{{ $kendaraan->plat_nomor }}</span>
                                        — {{ $kendaraan->servis_count }}x servis
                                    </p>
                                </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-400">Belum ada kendaraan terdaftar.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Servis Berjalan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-900">Servis Berjalan</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse ($servisBerjalan as $item)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $item->kendaraan->nama_kendaraan }}
                                <span class="text-gray-400 font-normal">({{ $item->kendaraan->plat_nomor }})</span>
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ Str::limit($item->keluhan, 50) }} — Mekanik: {{ $item->mekanik->nama }}
                            </p>
                        </div>
                        @php
                            $statusColor = match ($item->status) {
                                'menunggu' => 'bg-yellow-100 text-yellow-700',
                                'proses' => 'bg-blue-100 text-blue-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $statusColor }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                @empty
                    <p class="px-6 py-8 text-center text-sm text-gray-400">Tidak ada servis yang sedang berjalan.</p>
                @endforelse
            </div>
        </div>

        {{-- Riwayat Servis --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-900">Riwayat Servis</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse ($riwayatServis as $item)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $item->kendaraan->nama_kendaraan }}
                                <span class="text-gray-400 font-normal">({{ $item->kendaraan->plat_nomor }})</span>
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                {{ $item->tanggal_masuk->format('d M Y') }} — {{ Str::limit($item->keluhan, 50) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-900">
                                Rp {{ number_format($item->total_biaya, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('admin.servis.show', $item) }}" class="text-xs hover:underline"
                                style="color: #fa7c20;">Lihat detail</a>
                        </div>
                    </div>
                @empty
                    <p class="px-6 py-8 text-center text-sm text-gray-400">Belum ada riwayat servis.</p>
                @endforelse
            </div>
        </div>

    </div>
    </div>
</x-app-layout>
