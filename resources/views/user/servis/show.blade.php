<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Servis #{{ $servis->id }}
            </h2>
            <a href="{{ route('user.servis.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Status Banner --}}
            @php
                $statusColor = match ($servis->status) {
                    'menunggu' => 'bg-yellow-50 border-yellow-400 text-yellow-700',
                    'proses' => 'bg-blue-50 border-blue-400 text-blue-700',
                    'selesai' => 'bg-green-50 border-green-400 text-green-700',
                    'diambil' => 'bg-gray-50 border-gray-400 text-gray-700',
                    default => 'bg-gray-50 border-gray-400 text-gray-700',
                };
            @endphp
            <div class="border-l-4 p-4 rounded {{ $statusColor }}">
                <p class="font-bold text-lg">Status: {{ ucfirst($servis->status) }}</p>
                @if ($servis->status === 'menunggu')
                    <p class="text-sm mt-1">Kendaraan Anda sedang dalam antrian servis.</p>
                @elseif($servis->status === 'proses')
                    <p class="text-sm mt-1">Kendaraan Anda sedang dalam proses perbaikan.</p>
                @elseif($servis->status === 'selesai')
                    <p class="text-sm mt-1">Kendaraan Anda sudah selesai diperbaiki. Silakan diambil.</p>
                @elseif($servis->status === 'diambil')
                    <p class="text-sm mt-1">Kendaraan Anda sudah diambil.</p>
                @endif
            </div>

            {{-- Info Kendaraan --}}
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Informasi Kendaraan</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Kendaraan</p>
                        <p class="font-medium">{{ $servis->kendaraan->tahun }} {{ $servis->kendaraan->merek }} {{ $servis->kendaraan->model }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Plat Nomor</p>
                        <p class="font-medium">{{ $servis->kendaraan->plat_nomor }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Merek & Model</p>
                        <p class="font-medium">{{ $servis->kendaraan->merek }} {{ $servis->kendaraan->model }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tahun</p>
                        <p class="font-medium">{{ $servis->kendaraan->tahun }}</p>
                    </div>
                </div>
            </div>

            {{-- Info Servis --}}
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Detail Servis</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Mekanik</p>
                        <p class="font-medium">{{ $servis->mekanik->nama }}</p>
                        @if ($servis->mekanik->spesialisasi)
                            <p class="text-gray-400 text-xs">{{ $servis->mekanik->spesialisasi }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Masuk</p>
                        <p class="font-medium">{{ $servis->tanggal_masuk->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Selesai</p>
                        <p class="font-medium">{{ $servis->tanggal_selesai?->format('d M Y') ?? 'Belum selesai' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Total Biaya</p>
                        <p class="font-bold text-lg">Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Keluhan</p>
                        <p class="font-medium">{{ $servis->keluhan }}</p>
                    </div>
                    @if ($servis->catatan_mekanik)
                        <div class="col-span-2">
                            <p class="text-gray-500">Catatan Mekanik</p>
                            <p class="font-medium">{{ $servis->catatan_mekanik }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Spare Parts --}}
            @if ($servis->spareParts->count() > 0)
                <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                    <h3 class="font-bold text-lg text-gray-800 mb-4">Spare Part Digunakan</h3>
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Harga Satuan
                                </th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($servis->spareParts as $part)
                                <tr>
                                    <td class="px-4 py-3">{{ $part->nama }}</td>
                                    <td class="px-4 py-3">{{ $part->pivot->jumlah }}</td>
                                    <td class="px-4 py-3">Rp
                                        {{ number_format($part->pivot->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">Rp
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
