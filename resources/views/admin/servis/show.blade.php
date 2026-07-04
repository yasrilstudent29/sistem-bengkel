<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.servis.index') }}" class="text-sm text-gray-600 hover:underline flex items-center gap-1">
            ← Back to jobs
        </a>
    </x-slot>

    <div>
        <div class="max-w-6xl space-y-6">

            <x-alert />

            {{-- Header --}}
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                            {{ Str::limit($servis->keluhan, 40) }}
                        </h2>
                        <div class="flex items-center gap-2 mt-1">
                            @php
                                $statusColor = match ($servis->status) {
                                    'menunggu' => 'bg-yellow-100 text-yellow-700',
                                    'proses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    'diambil' => 'bg-gray-100 text-gray-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $statusColor }}">
                                {{ ucfirst($servis->status) }}
                            </span>
                            <span class="text-gray-400 text-sm">Masuk
                                {{ $servis->tanggal_masuk->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.servis.edit', $servis) }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                        Edit job
                    </a>
                    <a href="{{ route('admin.servis.struk', $servis) }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                        style="background-color: #fa7c20;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download Struk
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Work Order --}}
                <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Work Order</h3>
                    <div class="space-y-4 text-sm">
                        <div>
                            <p class="text-gray-500">Keluhan</p>
                            <p class="font-medium text-gray-900 mt-0.5">{{ $servis->keluhan }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-500">Tanggal Masuk</p>
                                <p class="font-semibold text-gray-900 mt-0.5">
                                    {{ $servis->tanggal_masuk->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Tanggal Selesai</p>
                                <p class="font-semibold text-gray-900 mt-0.5">
                                    {{ $servis->tanggal_selesai?->format('d M Y') ?? '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-500">Catatan Mekanik</p>
                            <p class="font-medium text-gray-900 mt-0.5">{{ $servis->catatan_mekanik ?? '-' }}</p>
                        </div>
                        <div class="pt-3 border-t border-gray-100">
                            <p class="text-gray-500">Total Biaya</p>
                            <p class="font-bold text-2xl mt-0.5" style="color: #fa7c20;">
                                Rp {{ number_format($servis->total_biaya, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Customer & Mekanik --}}
                <div class="space-y-5">
                    <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
                        <h3 class="font-bold text-gray-900 mb-4">Customer</h3>
                        <a href="{{ route('admin.customers.show', $servis->kendaraan->user->customer) }}"
                            class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                                style="background-color: #183356;">
                                {{ strtoupper(substr($servis->kendaraan->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $servis->kendaraan->user->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $servis->kendaraan->user->customer->no_telepon ?? '-' }}</p>
                            </div>
                        </a>
                    </div>

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
            </div>

            {{-- Vehicle --}}
            <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
                <h3 class="font-bold text-gray-900 mb-4">Vehicle</h3>
                <a href="{{ route('admin.kendaraan.show', $servis->kendaraan) }}"
                    class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition w-fit">
                    <div class="w-9 h-9 rounded-lg bg-orange-50 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $servis->kendaraan->tahun }} {{ $servis->kendaraan->merek }}
                            {{ $servis->kendaraan->model }}
                        </p>
                        <p class="text-xs text-gray-500">Plat {{ $servis->kendaraan->plat_nomor }}</p>
                    </div>
                </a>
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

            {{-- Delete --}}
            <div class="flex justify-end pb-6">
                <form action="{{ route('admin.servis.destroy', $servis) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus data servis ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline text-sm font-medium">
                        Delete job
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
