<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.customers.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-3 py-1.5 rounded-lg transition -ml-3">
            ← Kembali ke halaman customers
        </a>
    </x-slot>

    <div x-data="{ showEditModal: {{ $errors->any() ? 'true' : 'false' }} }" class="-mt-9">
        <div class="max-w-6xl space-y-6">

            <x-alert />

            {{-- Header --}}
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center text-white font-bold text-xl"
                        style="background-color: #183356;">
                        {{ strtoupper(substr($customer->nama_lengkap, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">{{ $customer->nama_lengkap }}
                        </h2>
                        <p class="text-gray-500 text-base mt-0.5">Customer sejak
                            {{ $customer->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.kendaraan.index', ['open_modal' => 1, 'customer_id' => $customer->id]) }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:border-orange-400 hover:text-orange-600 transition">
                        + Kendaraan
                    </a>
                    <button type="button" @click="showEditModal = true"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:border-orange-400 hover:text-orange-600 transition">
                        Edit
                    </button>
                    <a href="{{ route('admin.servis.index', ['open_modal' => 1, 'kendaraan_id' => $kendaraans->first()->id ?? '']) }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                        style="background-color: #fa7c20;">
                        + Servis Baru
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Kontak --}}
                <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
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
                <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
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
                            </a>
                        @empty
                            <p class="text-sm text-gray-400">Belum ada kendaraan terdaftar.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Servis Berjalan --}}
            <div class="bg-white rounded-xl border border-gray-300 shadow">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <h3 class="font-bold text-gray-900">Servis Berjalan</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse ($servisBerjalan as $item)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $item->kendaraan->tahun }} {{ $item->kendaraan->merek }}
                                    {{ $item->kendaraan->model }}
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
                        <p class="px-6 py-8 text-center text-sm text-gray-400">Tidak ada servis yang sedang berjalan.
                        </p>
                    @endforelse
                </div>
            </div>

            {{-- Riwayat Servis --}}
            <div class="bg-white rounded-xl border border-gray-300 shadow">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="font-bold text-gray-900">Riwayat Servis</h3>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse ($riwayatServis as $item)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $item->kendaraan->tahun }} {{ $item->kendaraan->merek }}
                                    {{ $item->kendaraan->model }}
                                    <span
                                        class="text-gray-400 font-normal">({{ $item->kendaraan->plat_nomor }})</span>
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

        {{-- Modal Edit Customer --}}
        <div x-show="showEditModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background-color: rgba(0,0,0,0.6);">
            <div @click.outside="showEditModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden">

                <div class="p-5 overflow-y-auto flex-1">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-extrabold text-lg text-gray-900">Edit Customer</h3>
                        <button type="button" @click="showEditModal = false"
                            class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-500 text-xs mb-4">Perbarui data customer ini.</p>

                    <div class="mb-3 p-3 bg-gray-50 rounded-lg text-sm">
                        <p class="text-gray-500 text-xs">Email</p>
                        <p class="font-medium text-gray-800">{{ $customer->user->email }}</p>
                    </div>

                    <form action="{{ route('admin.customers.update', $customer) }}" method="POST"
                        class="space-y-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="edit_nama_lengkap" value="Nama Lengkap" />
                            <x-text-input id="edit_nama_lengkap" name="nama_lengkap" type="text"
                                class="block mt-1 w-full" :value="old('nama_lengkap', $customer->nama_lengkap)" required />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="edit_no_telepon" value="No. Telepon" />
                                <x-text-input id="edit_no_telepon" name="no_telepon" type="text"
                                    class="block mt-1 w-full" :value="old('no_telepon', $customer->no_telepon)" />
                                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="edit_alamat" value="Alamat (Kota/Wilayah)" />
                                <x-text-input id="edit_alamat" name="alamat" type="text"
                                    class="block mt-1 w-full" :value="old('alamat', $customer->alamat)" placeholder="Contoh: Ngawi" />
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                            <button type="button" @click="showEditModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                                style="background-color: #183356;">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
