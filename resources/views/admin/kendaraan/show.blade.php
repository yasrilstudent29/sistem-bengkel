<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.kendaraan.index') }}" class="text-sm text-gray-600 hover:underline flex items-center gap-1">
            ← Back to vehicles
        </a>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <x-alert />

            {{-- Header --}}
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                        </h2>
                        <p class="text-gray-500 text-sm">
                            Plat <span class="font-medium">{{ $kendaraan->plat_nomor }}</span>
                            @if ($kendaraan->warna) — {{ $kendaraan->warna }} @endif
                            — {{ number_format($kendaraan->odometer ?? 0, 0, ',', '.') }} km
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.kendaraan.edit', $kendaraan) }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                        Edit vehicle
                    </a>
                    <a href="{{ route('admin.servis.create') }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                        style="background-color: #fa7c20;">
                        + New job
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Vehicle Details --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Vehicle details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Plate</span>
                            <span class="font-medium text-gray-900">{{ $kendaraan->plat_nomor }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Make</span>
                            <span class="font-medium text-gray-900">{{ $kendaraan->merek }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Model</span>
                            <span class="font-medium text-gray-900">{{ $kendaraan->model }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Year</span>
                            <span class="font-medium text-gray-900">{{ $kendaraan->tahun }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">VIN</span>
                            <span class="font-medium text-gray-900">{{ $kendaraan->vin ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Color</span>
                            <span class="font-medium text-gray-900">{{ $kendaraan->warna ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Mileage</span>
                            <span class="font-medium text-gray-900">{{ number_format($kendaraan->odometer ?? 0, 0, ',', '.') }} km</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Jenis</span>
                            <span class="font-medium text-gray-900">{{ ucfirst($kendaraan->jenis) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Owner --}}
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Owner</h3>
                    @if ($kendaraan->user->customer)
                        <a href="{{ route('admin.customers.show', $kendaraan->user->customer) }}"
                            class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                                style="background-color: #183356;">
                                {{ strtoupper(substr($kendaraan->user->customer->nama_lengkap, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $kendaraan->user->customer->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500">{{ $kendaraan->user->customer->no_telepon ?? '-' }}</p>
                            </div>
                        </a>
                    @else
                        <p class="text-sm text-gray-400">Data customer belum lengkap untuk pemilik ini.</p>
                    @endif
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
                                <p class="text-sm font-semibold text-gray-900">{{ Str::limit($item->keluhan, 50) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Mekanik: {{ $item->mekanik->nama }} — Masuk {{ $item->tanggal_masuk->format('d M Y') }}
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
                                <p class="text-sm font-semibold text-gray-900">{{ Str::limit($item->keluhan, 50) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $item->tanggal_masuk->format('d M Y') }} — Mekanik: {{ $item->mekanik->nama }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($item->total_biaya, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('admin.servis.show', $item) }}"
                                    class="text-xs hover:underline" style="color: #fa7c20;">Lihat detail</a>
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