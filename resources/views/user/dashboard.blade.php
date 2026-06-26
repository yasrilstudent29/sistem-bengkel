<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Greeting --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-bold text-gray-800">
                    Selamat datang, {{ auth()->user()->name }}! 👋
                </h3>
                <p class="text-gray-500 text-sm mt-1">
                    {{ now()->format('l, d F Y') }}
                </p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Kendaraan Terdaftar</p>
                    <p class="text-3xl font-black text-gray-800 mt-1">{{ $kendaraans->count() }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Servis Aktif</p>
                    <p class="text-3xl font-black text-gray-800 mt-1">{{ $servisAktif }}</p>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-bold text-gray-800 mb-4">Menu Cepat</h3>
                <div class="grid grid-cols-2 gap-4">
                    <a href="{{ route('user.kendaraan.index') }}"
                        class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition text-center">
                        <span class="text-2xl mb-2">🚗</span>
                        <span class="text-sm font-bold text-gray-700">Kendaraan Saya</span>
                    </a>
                    <a href="{{ route('user.servis.index') }}"
                        class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition text-center">
                        <span class="text-2xl mb-2">🔧</span>
                        <span class="text-sm font-bold text-gray-700">Riwayat Servis</span>
                    </a>
                </div>
            </div>

            {{-- Kendaraan --}}
            @if ($kendaraans->count() > 0)
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="font-bold text-gray-800">Kendaraan Saya</h3>
                        <a href="{{ route('user.kendaraan.index') }}" class="text-sm text-blue-600 hover:underline">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach ($kendaraans as $kendaraan)
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $kendaraan->nama_kendaraan }}</p>
                                    <p class="text-sm text-gray-500">{{ $kendaraan->merek }} {{ $kendaraan->model }} •
                                        {{ $kendaraan->tahun }} • {{ $kendaraan->plat_nomor }}</p>
                                </div>
                                <span
                                    class="{{ $kendaraan->jenis === 'motor' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }} text-xs font-bold px-2 py-1 rounded-full">
                                    {{ ucfirst($kendaraan->jenis) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white p-6 shadow-sm sm:rounded-lg text-center">
                    <p class="text-gray-500 mb-3">Belum ada kendaraan terdaftar.</p>
                    <a href="{{ route('user.kendaraan.create') }}"
                        class="bg-gray-800 text-white text-sm font-bold px-4 py-2 rounded hover:bg-gray-700 transition">
                        + Tambah Kendaraan
                    </a>
                </div>
            @endif

            {{-- Riwayat Servis Terbaru --}}
            @if ($riwayatServis->count() > 0)
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="font-bold text-gray-800">Servis Terbaru</h3>
                        <a href="{{ route('user.servis.index') }}" class="text-sm text-blue-600 hover:underline">
                            Lihat semua →
                        </a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach ($riwayatServis as $item)
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $item->kendaraan->nama_kendaraan }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $item->tanggal_masuk->format('d M Y') }} •
                                        {{ Str::limit($item->keluhan, 50) }}
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
                                <span class="text-xs font-bold px-2 py-1 rounded-full {{ $statusColor }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
