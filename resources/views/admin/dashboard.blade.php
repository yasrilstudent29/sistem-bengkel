<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
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
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Total Servis</p>
                    <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalServis }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Servis Proses</p>
                    <p class="text-3xl font-black text-gray-800 mt-1">{{ $servisProses }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Servis Selesai</p>
                    <p class="text-3xl font-black text-gray-800 mt-1">{{ $servisSelesai }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Mekanik Aktif</p>
                    <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalMekanik }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border-l-4 border-orange-500">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Total Kendaraan</p>
                    <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalKendaraan }}</p>
                </div>
                <div class="bg-white p-6 shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wide">Total User</p>
                    <p class="text-3xl font-black text-gray-800 mt-1">{{ $totalUser }}</p>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-bold text-gray-800 mb-4">Menu Cepat</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="{{ route('admin.servis.create') }}"
                        class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition text-center">
                        <span class="text-2xl mb-2">🔧</span>
                        <span class="text-sm font-bold text-gray-700">Tambah Servis</span>
                    </a>
                    <a href="{{ route('admin.mekanik.index') }}"
                        class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition text-center">
                        <span class="text-2xl mb-2">👨‍🔧</span>
                        <span class="text-sm font-bold text-gray-700">Kelola Mekanik</span>
                    </a>
                    <a href="{{ route('admin.spare-parts.index') }}"
                        class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition text-center">
                        <span class="text-2xl mb-2">⚙️</span>
                        <span class="text-sm font-bold text-gray-700">Spare Part</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}"
                        class="flex flex-col items-center p-4 border-2 border-gray-200 rounded-lg hover:border-gray-400 hover:bg-gray-50 transition text-center">
                        <span class="text-2xl mb-2">👥</span>
                        <span class="text-sm font-bold text-gray-700">Manajemen User</span>
                    </a>
                </div>
            </div>

            {{-- Servis Terbaru --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800">Servis Terbaru</h3>
                    <a href="{{ route('admin.servis.index') }}" class="text-sm text-blue-600 hover:underline">
                        Lihat semua →
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kendaraan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Pemilik</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Mekanik</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tgl Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($servisTerbaru as $item)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $item->kendaraan->nama_kendaraan }}
                                        <span
                                            class="text-gray-500 text-xs block">{{ $item->kendaraan->plat_nomor }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->kendaraan->user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->mekanik->nama }}</td>
                                    <td class="px-6 py-4 text-sm">
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
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->tanggal_masuk->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada data servis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
