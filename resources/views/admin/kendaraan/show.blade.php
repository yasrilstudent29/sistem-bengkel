<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.kendaraan.index') }}"
            class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-orange-600 hover:bg-orange-50 px-3 py-1.5 rounded-lg transition -ml-3">
            ← Back to vehicles
        </a>
    </x-slot>

    <div x-data="{ showEditModal: {{ $errors->any() ? 'true' : 'false' }} }" class="-mt-9">
        <div class="max-w-6xl space-y-6">

            <x-alert />

            {{-- Header --}}
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    @if ($kendaraan->foto)
                        <img src="{{ Storage::url($kendaraan->foto) }}" alt="Foto Kendaraan"
                            class="w-14 h-14 rounded-xl object-cover border border-gray-200 shrink-0">
                    @else
                        <div class="w-14 h-14 rounded-xl bg-orange-50 flex items-center justify-center shrink-0">
                            <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                            {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                        </h2>
                        <p class="text-gray-500 text-base mt-0.5">
                            Plat <span class="font-medium">{{ $kendaraan->plat_nomor }}</span>
                            @if ($kendaraan->warna)
                                — {{ $kendaraan->warna }}
                            @endif
                            — {{ number_format($kendaraan->odometer ?? 0, 0, ',', '.') }} km
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" @click="showEditModal = true"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-medium hover:border-orange-400 hover:text-orange-600 transition">
                        Edit vehicle
                    </button>
                    <a href="{{ route('admin.servis.create') }}"
                        class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                        style="background-color: #fa7c20;">
                        + New job
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

                {{-- Vehicle Details --}}
                <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
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
                            <span
                                class="font-medium text-gray-900">{{ number_format($kendaraan->odometer ?? 0, 0, ',', '.') }}
                                km</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500">Jenis</span>
                            <span class="font-medium text-gray-900">{{ ucfirst($kendaraan->jenis) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Owner --}}
                <div class="bg-white rounded-xl border border-gray-300 shadow p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Owner</h3>
                    @if ($kendaraan->user->customer)
                        <a href="{{ route('admin.customers.show', $kendaraan->user->customer) }}"
                            class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:bg-gray-50 transition">
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                                style="background-color: #183356;">
                                {{ strtoupper(substr($kendaraan->user->customer->nama_lengkap, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">
                                    {{ $kendaraan->user->customer->nama_lengkap }}</p>
                                <p class="text-xs text-gray-500">{{ $kendaraan->user->customer->no_telepon ?? '-' }}
                                </p>
                            </div>
                        </a>
                    @else
                        <p class="text-sm text-gray-400">Data customer belum lengkap untuk pemilik ini.</p>
                    @endif
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
                                <p class="text-sm font-semibold text-gray-900">{{ Str::limit($item->keluhan, 50) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    Mekanik: {{ $item->mekanik->nama }} — Masuk
                                    {{ $item->tanggal_masuk->format('d M Y') }}
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
                                <p class="text-sm font-semibold text-gray-900">{{ Str::limit($item->keluhan, 50) }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">
                                    {{ $item->tanggal_masuk->format('d M Y') }} — Mekanik: {{ $item->mekanik->nama }}
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

        {{-- Modal Edit Kendaraan --}}
        <div x-show="showEditModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background-color: rgba(0,0,0,0.6);">
            <div @click.outside="showEditModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">

                <div class="p-5 overflow-y-auto flex-1">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-extrabold text-lg text-gray-900">Edit Kendaraan</h3>
                        <button type="button" @click="showEditModal = false"
                            class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-500 text-xs mb-4">Perbarui data kendaraan ini.</p>

                    <form action="{{ route('admin.kendaraan.update', $kendaraan) }}" method="POST"
                        class="space-y-3" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="edit_customer_id" value="Owner (Customer)" />
                            <select id="edit_customer_id" name="customer_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                <option value="">-- Pilih Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id', $kendaraan->user->customer->id ?? '') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->nama_lengkap }} — {{ $customer->user->email }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="edit_merek" value="Merek (Make)" />
                                <x-text-input id="edit_merek" name="merek" type="text"
                                    class="block mt-1 w-full" :value="old('merek', $kendaraan->merek)" required />
                                <x-input-error :messages="$errors->get('merek')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="edit_model" value="Model" />
                                <x-text-input id="edit_model" name="model" type="text"
                                    class="block mt-1 w-full" :value="old('model', $kendaraan->model)" required />
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="edit_tahun" value="Tahun" />
                                <x-text-input id="edit_tahun" name="tahun" type="number" min="1900"
                                    :max="date('Y')" class="block mt-1 w-full" :value="old('tahun', $kendaraan->tahun)" required />
                                <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="edit_odometer" value="Odometer (km)" />
                                <x-text-input id="edit_odometer" name="odometer" type="number" min="0"
                                    class="block mt-1 w-full" :value="old('odometer', $kendaraan->odometer)" />
                                <x-input-error :messages="$errors->get('odometer')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="edit_warna" value="Warna" />
                                <x-text-input id="edit_warna" name="warna" type="text"
                                    class="block mt-1 w-full" :value="old('warna', $kendaraan->warna)" placeholder="Hitam" />
                                <x-input-error :messages="$errors->get('warna')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="edit_jenis" value="Jenis Kendaraan" />
                                <select id="edit_jenis" name="jenis" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                    <option value="motor"
                                        {{ old('jenis', $kendaraan->jenis) === 'motor' ? 'selected' : '' }}>Motor
                                    </option>
                                    <option value="mobil"
                                        {{ old('jenis', $kendaraan->jenis) === 'mobil' ? 'selected' : '' }}>Mobil
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="edit_plat_nomor" value="Plat Nomor" />
                                <x-text-input id="edit_plat_nomor" name="plat_nomor" type="text"
                                    class="block mt-1 w-full" :value="old('plat_nomor', $kendaraan->plat_nomor)" required />
                                <x-input-error :messages="$errors->get('plat_nomor')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="edit_vin" value="VIN (opsional)" />
                                <x-text-input id="edit_vin" name="vin" type="text" class="block mt-1 w-full"
                                    :value="old('vin', $kendaraan->vin)" placeholder="17-character VIN" />
                                <x-input-error :messages="$errors->get('vin')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="edit_foto" value="Foto Kendaraan" />
                            @if ($kendaraan->foto)
                                <div class="mt-1 mb-2">
                                    <img src="{{ Storage::url($kendaraan->foto) }}" alt="Foto Kendaraan"
                                        class="w-24 h-20 object-cover rounded-lg border border-gray-200">
                                </div>
                            @endif
                            <input id="edit_foto" name="foto" type="file" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:text-sm file:font-semibold file:text-white
                                hover:file:opacity-90 cursor-pointer">
                            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
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
