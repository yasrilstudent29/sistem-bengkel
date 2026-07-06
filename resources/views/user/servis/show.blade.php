<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('user.servis.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-3 py-1.5 rounded-lg transition -ml-3">
            ← Kembali
        </a>
    </x-slot>

    <div class="-mt-9">
        <div class="max-w-4xl space-y-6">

            <x-alert />

            @php
                $statusInfo = match ($servis->status) {
                    'menunggu' => [
                        'bg-yellow-50',
                        'border-yellow-400',
                        'text-yellow-700',
                        'Kendaraan Anda sedang dalam antrian servis.',
                    ],
                    'proses' => [
                        'bg-blue-50',
                        'border-blue-400',
                        'text-blue-700',
                        'Kendaraan Anda sedang dalam proses perbaikan.',
                    ],
                    'selesai' => [
                        'bg-green-50',
                        'border-green-400',
                        'text-green-700',
                        'Kendaraan Anda sudah selesai diperbaiki. Silakan diambil.',
                    ],
                    'diambil' => ['bg-gray-50', 'border-gray-400', 'text-gray-700', 'Kendaraan Anda sudah diambil.'],
                    default => ['bg-gray-50', 'border-gray-400', 'text-gray-700', ''],
                };
            @endphp

            {{-- Status Banner --}}
            <div
                class="border-l-4 p-4 rounded-lg {{ $statusInfo[0] }} {{ $statusInfo[1] }} {{ $statusInfo[2] }} shadow-sm">
                <p class="font-bold text-lg">Status: {{ ucfirst($servis->status) }}</p>
                <p class="text-sm mt-1">{{ $statusInfo[3] }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Info Kendaraan --}}
                <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Informasi Kendaraan</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Kendaraan</span>
                            <span class="font-medium text-gray-900">{{ $servis->kendaraan->tahun }}
                                {{ $servis->kendaraan->merek }} {{ $servis->kendaraan->model }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Plat Nomor</span>
                            <span class="font-medium text-gray-900">{{ $servis->kendaraan->plat_nomor }}</span>
                        </div>
                    </div>
                </div>

                {{-- Mekanik --}}
                <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Mekanik</h3>
                    <div class="flex items-center gap-3 p-3 rounded-lg border border-gray-100">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                            style="background-color: #183356;">
                            {{ strtoupper(substr($servis->mekanik->nama, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $servis->mekanik->nama }}</p>
                            <p class="text-xs text-gray-500">{{ $servis->mekanik->spesialisasi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Servis --}}
            <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Detail Servis</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-gray-500">Keluhan</p>
                        <p class="font-medium text-gray-900 mt-0.5">{{ $servis->keluhan }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500">Tanggal Masuk</p>
                            <p class="font-semibold text-gray-900 mt-0.5">{{ $servis->tanggal_masuk->format('d M Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-gray-500">Tanggal Selesai</p>
                            <p class="font-semibold text-gray-900 mt-0.5">
                                {{ $servis->tanggal_selesai?->format('d M Y') ?? 'Belum selesai' }}</p>
                        </div>
                    </div>
                    @if ($servis->catatan_mekanik)
                        <div>
                            <p class="text-gray-500">Catatan Mekanik</p>
                            <p class="font-medium text-gray-900 mt-0.5">{{ $servis->catatan_mekanik }}</p>
                        </div>
                    @endif
                    <div class="pt-3 border-t border-gray-100">
                        <p class="text-gray-500">Total Biaya</p>
                        <p class="font-bold text-2xl mt-0.5" style="color: #fa7c20;">
                            Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Spare Parts --}}
            @if ($servis->spareParts->count() > 0)
                <div class="bg-white rounded-xl border border-gray-300 shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-bold text-gray-900">Spare Part Digunakan</h3>
                    </div>
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Harga Satuan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($servis->spareParts as $part)
                                <tr>
                                    <td class="px-6 py-3">{{ $part->nama }}</td>
                                    <td class="px-6 py-3">{{ $part->pivot->jumlah }}</td>
                                    <td class="px-6 py-3">Rp
                                        {{ number_format($part->pivot->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-6 py-3 font-medium">
                                        Rp
                                        {{ number_format($part->pivot->jumlah * $part->pivot->harga_satuan, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
