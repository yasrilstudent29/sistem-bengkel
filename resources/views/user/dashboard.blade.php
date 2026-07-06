<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="-mt-9 space-y-6">

        <x-alert />

        {{-- Greeting --}}
        <div>
            <h1 class="text-xl font-bold text-gray-900">
                {{ now()->hour < 12 ? 'Selamat pagi' : (now()->hour < 17 ? 'Selamat siang' : 'Selamat malam') }},
                {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-gray-500 text-sm mt-1">{{ now()->format('l, d F Y') }}</p>
        </div>

        {{-- Stats Cards (Clickable) --}}
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('user.kendaraan.index') }}"
                class="group bg-white rounded-xl border border-gray-300 p-5 shadow hover:border-orange-400 transition-colors">
                <p class="text-gray-500 text-sm">Kendaraan Terdaftar</p>
                <p class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-orange-500 transition-colors">
                    {{ $kendaraans->count() }}</p>
                <div class="mt-3 w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                    </svg>
                </div>
            </a>
            <a href="{{ route('user.servis.index') }}"
                class="group bg-white rounded-xl border border-gray-300 p-5 shadow hover:border-orange-400 transition-colors">
                <p class="text-gray-500 text-sm">Servis Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-orange-500 transition-colors">
                    {{ $servisAktif }}</p>
                <div class="mt-3 w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
            </a>
        </div>

        {{-- Kendaraan --}}
        <div class="bg-white rounded-xl border border-gray-300 shadow">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                    </svg>
                    <h3 class="font-bold text-gray-900">Kendaraan Saya</h3>
                </div>
                <a href="{{ route('user.kendaraan.index') }}" class="text-sm font-semibold hover:underline"
                    style="color: #fa7c20;">
                    Lihat semua →
                </a>
            </div>
            @if ($kendaraans->count() > 0)
                <div class="divide-y divide-gray-50">
                    @foreach ($kendaraans as $kendaraan)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition">
                            <div class="flex items-center gap-3">
                                @if ($kendaraan->foto)
                                    <img src="{{ Storage::url($kendaraan->foto) }}" alt="Foto"
                                        class="w-10 h-10 rounded-lg object-cover border border-gray-200 shrink-0">
                                @else
                                    <div
                                        class="w-10 h-10 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $kendaraan->tahun }}
                                        {{ $kendaraan->merek }} {{ $kendaraan->model }}</p>
                                    <p class="text-sm text-gray-500">{{ $kendaraan->plat_nomor }}</p>
                                </div>
                            </div>
                            <span
                                class="{{ $kendaraan->jenis === 'motor' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }} text-xs font-bold px-2.5 py-1 rounded-full">
                                {{ ucfirst($kendaraan->jenis) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <p class="text-gray-500 text-sm mb-3">Belum ada kendaraan terdaftar.</p>
                    <a href="{{ route('user.kendaraan.index') }}"
                        class="inline-block px-5 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                        style="background-color: #fa7c20;">
                        + Tambah Kendaraan
                    </a>
                </div>
            @endif
        </div>

        {{-- Riwayat Servis Terbaru --}}
        @if ($riwayatServis->count() > 0)
            <div class="bg-white rounded-xl border border-gray-300 shadow">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="font-bold text-gray-900">Servis Terbaru</h3>
                    </div>
                    <a href="{{ route('user.servis.index') }}" class="text-sm font-semibold hover:underline"
                        style="color: #fa7c20;">
                        Lihat semua →
                    </a>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach ($riwayatServis as $item)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition cursor-pointer"
                            onclick="window.location='{{ route('user.servis.show', $item) }}'">
                            <div>
                                <p class="font-semibold text-gray-900">{{ $item->kendaraan->tahun }}
                                    {{ $item->kendaraan->merek }} {{ $item->kendaraan->model }}</p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ $item->tanggal_masuk->format('d M Y') }} • {{ Str::limit($item->keluhan, 50) }}
                                </p>
                            </div>
                            @php
                                $statusColor = match ($item->status) {
                                    'menunggu' => 'bg-yellow-100 text-yellow-700',
                                    'proses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    'diambil' => 'bg-gray-100 text-gray-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $statusColor }} shrink-0">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
