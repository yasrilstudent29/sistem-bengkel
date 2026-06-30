<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="space-y-6">

        {{-- Greeting --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ now()->hour < 12 ? 'Selamat pagi' : (now()->hour < 17 ? 'Selamat siang' : 'Selamat malam') }}, {{ auth()->user()->name }}!
            </h1>
            <p class="text-gray-500 text-sm mt-1">Here's what's happening at Sistem Bengkel today.</p>
        </div>

        {{-- Quick Actions --}}
        <div class="flex items-center justify-between p-4 rounded-xl border border-orange-100 bg-orange-50">
            <div>
                <p class="font-semibold text-gray-800 text-sm">Quick actions</p>
                <p class="text-gray-500 text-xs">Jump straight into the most common tasks.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.customers.create') }}"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                    <span>+</span> Customer
                </a>
                <a href="{{ route('admin.kendaraan.create') }}"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                    <span>+</span> Kendaraan
                </a>
                <a href="{{ route('admin.mekanik.create') }}"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                    <span>+</span> Mekanik
                </a>
                <a href="{{ route('admin.servis.create') }}"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-white text-sm font-medium transition"
                    style="background-color: #fa7c20;">
                    <span>+</span> Servis Baru
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <p class="text-gray-500 text-sm">Total Servis</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalServis }}</p>
                <div class="mt-3 w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <p class="text-gray-500 text-sm">Servis Proses</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $servisProses }}</p>
                <div class="mt-3 w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <p class="text-gray-500 text-sm">Servis Selesai</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $servisSelesai }}</p>
                <div class="mt-3 w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <p class="text-gray-500 text-sm">Mekanik Aktif</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalMekanik }}</p>
                <div class="mt-3 w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <p class="text-gray-500 text-sm">Total Kendaraan</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalKendaraan }}</p>
                <div class="mt-3 w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
                <p class="text-gray-500 text-sm">Total Customer</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUser }}</p>
                <div class="mt-3 w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Servis Terbaru --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-900">Servis Terbaru</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Daftar servis kendaraan yang masuk terakhir</p>
                </div>
                <a href="{{ route('admin.servis.index') }}"
                    class="text-sm font-medium hover:underline"
                    style="color: #fa7c20;">
                    Lihat semua →
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kendaraan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pemilik</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mekanik</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tgl Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($servisTerbaru as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $item->kendaraan->tahun }} {{ $item->kendaraan->merek }} {{ $item->kendaraan->model }}</p>
                                    <p class="text-xs text-gray-400">{{ $item->kendaraan->plat_nomor }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->kendaraan->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->mekanik->nama }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusColor = match ($item->status) {
                                            'menunggu' => 'bg-yellow-100 text-yellow-700',
                                            'proses' => 'bg-blue-100 text-blue-700',
                                            'selesai' => 'bg-green-100 text-green-700',
                                            'diambil' => 'bg-gray-100 text-gray-600',
                                            default => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $statusColor }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $item->tanggal_masuk->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400 text-sm">
                                    Belum ada data servis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>