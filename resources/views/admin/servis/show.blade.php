<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Servis #{{ $servis->id }}
            </h2>
            <a href="{{ route('admin.servis.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info Servis --}}
            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <h3 class="font-bold text-lg text-gray-800 mb-4">Informasi Servis</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Kendaraan</p>
                        <p class="font-medium">{{ $servis->kendaraan->nama_kendaraan }}</p>
                        <p class="text-gray-500">{{ $servis->kendaraan->plat_nomor }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Pemilik</p>
                        <p class="font-medium">{{ $servis->kendaraan->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Mekanik</p>
                        <p class="font-medium">{{ $servis->mekanik->nama }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status</p>
                        @php
                            $statusColor = match ($servis->status) {
                                'menunggu' => 'bg-yellow-100 text-yellow-700',
                                'proses' => 'bg-blue-100 text-blue-700',
                                'selesai' => 'bg-green-100 text-green-700',
                                'diambil' => 'bg-gray-100 text-gray-700',
                                default => 'bg-gray-100 text-gray-700',
                            };
                        @endphp
                        <span class="text-xs font-bold px-2 py-1 rounded-full {{ $statusColor }}">
                            {{ ucfirst($servis->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Masuk</p>
                        <p class="font-medium">{{ $servis->tanggal_masuk->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Selesai</p>
                        <p class="font-medium">{{ $servis->tanggal_selesai?->format('d M Y') ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Keluhan</p>
                        <p class="font-medium">{{ $servis->keluhan }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Catatan Mekanik</p>
                        <p class="font-medium">{{ $servis->catatan_mekanik ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Total Biaya</p>
                        <p class="font-bold text-lg">Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}</p>
                    </div>
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

            <div class="flex gap-4">
                <a href="{{ route('admin.servis.edit', $servis) }}"
                    class="bg-gray-800 text-white text-sm font-bold px-4 py-2 rounded hover:bg-gray-700 transition">
                    Edit Servis
                </a>
                <form action="{{ route('admin.servis.destroy', $servis) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus data servis ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-600 text-white text-sm font-bold px-4 py-2 rounded hover:bg-red-700 transition">
                        Hapus Servis
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
