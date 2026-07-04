<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                Kendaraan
            </h2>
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal-kendaraan'))"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> Tambah Kendaraan
            </button>
        </div>
    </x-slot>

    <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }" x-on:open-modal-kendaraan.window="showModal = true">
        <div class="max-w-7xl">

            <x-alert />

            <p class="text-gray-500 text-base -mt-9 mb-6">
                Seluruh kendaraan dari setiap customer yang terdaftar.
            </p>

            {{-- Search Bar --}}
            <div class="relative mb-6 max-w-md">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchKendaraan" placeholder="Cari berdasarkan plat, merek, atau model..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            {{-- Card Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="kendaraanGrid">
                @forelse ($kendaraans as $kendaraan)
                    <div class="group bg-white rounded-xl border border-gray-300 shadow p-5 kendaraan-card hover:border-orange-400 transition-colors"
                        data-plat="{{ strtolower($kendaraan->plat_nomor) }}"
                        data-merek="{{ strtolower($kendaraan->merek) }}"
                        data-model="{{ strtolower($kendaraan->model) }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                @if ($kendaraan->foto)
                                    <img src="{{ Storage::url($kendaraan->foto) }}" alt="Foto Kendaraan"
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
                                    <p
                                        class="font-semibold text-gray-900 group-hover:text-orange-500 transition-colors">
                                        {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $kendaraan->user->name }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.kendaraan.destroy', $kendaraan) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 space-y-1.5 text-sm text-gray-600">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Plate:</span>
                                <span class="font-medium">{{ $kendaraan->plat_nomor }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Odometer:</span>
                                <span class="font-medium">{{ number_format($kendaraan->odometer ?? 0, 0, ',', '.') }}
                                    km</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Warna:</span>
                                <span class="font-medium">{{ $kendaraan->warna ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-400">Jenis:</span>
                                @if ($kendaraan->jenis === 'motor')
                                    <span
                                        class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded-full">Motor</span>
                                @else
                                    <span
                                        class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-0.5 rounded-full">Mobil</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('admin.kendaraan.show', $kendaraan) }}"
                                class="px-5 py-2 rounded-lg text-white text-sm font-semibold hover:opacity-90 transition"
                                style="background-color: #183356;">
                                View details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada data kendaraan.
                    </div>
                @endforelse
            </div>

            @if ($kendaraans->hasPages())
                <div class="mt-6">
                    {{ $kendaraans->links() }}
                </div>
            @endif

        </div>

        {{-- Modal Tambah Kendaraan --}}
        <div x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background-color: rgba(0,0,0,0.6);">
            <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[92vh] overflow-y-auto">

                <div class="p-5">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-extrabold text-lg text-gray-900">Tambah Kendaraan</h3>
                        <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-500 text-xs mb-4">Daftarkan kendaraan baru dan hubungkan ke pemiliknya.</p>

                    <form action="{{ route('admin.kendaraan.store') }}" method="POST" class="space-y-3"
                        enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="customer_id" value="Owner (Customer)" />
                            <select id="customer_id" name="customer_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                <option value="">-- Pilih Customer --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->nama_lengkap }} — {{ $customer->user->email }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                            @if ($customers->isEmpty())
                                <p class="text-xs text-amber-600 mt-1">
                                    Belum ada data customer. <a href="{{ route('admin.customers.create') }}"
                                        class="underline">Tambah customer dulu</a>.
                                </p>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="merek" value="Merek (Make)" />
                                <x-text-input id="merek" name="merek" type="text" class="block mt-1 w-full"
                                    :value="old('merek')" required />
                                <x-input-error :messages="$errors->get('merek')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="model" value="Model" />
                                <x-text-input id="model" name="model" type="text" class="block mt-1 w-full"
                                    :value="old('model')" required />
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="tahun" value="Tahun" />
                                <x-text-input id="tahun" name="tahun" type="number" min="1900"
                                    :max="date('Y')" class="block mt-1 w-full" :value="old('tahun')" required />
                                <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="odometer" value="Odometer (km)" />
                                <x-text-input id="odometer" name="odometer" type="number" min="0"
                                    class="block mt-1 w-full" :value="old('odometer', 0)" />
                                <x-input-error :messages="$errors->get('odometer')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="warna" value="Warna" />
                                <x-text-input id="warna" name="warna" type="text" class="block mt-1 w-full"
                                    :value="old('warna')" placeholder="Hitam" />
                                <x-input-error :messages="$errors->get('warna')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="jenis" value="Jenis Kendaraan" />
                                <select id="jenis" name="jenis" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                    <option value="motor" {{ old('jenis') === 'motor' ? 'selected' : '' }}>Motor
                                    </option>
                                    <option value="mobil" {{ old('jenis') === 'mobil' ? 'selected' : '' }}>Mobil
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="plat_nomor" value="Plat Nomor" />
                                <x-text-input id="plat_nomor" name="plat_nomor" type="text"
                                    class="block mt-1 w-full" :value="old('plat_nomor')" required />
                                <x-input-error :messages="$errors->get('plat_nomor')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="vin" value="VIN (opsional)" />
                                <x-text-input id="vin" name="vin" type="text" class="block mt-1 w-full"
                                    :value="old('vin')" placeholder="17-character VIN" />
                                <x-input-error :messages="$errors->get('vin')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="foto" value="Foto Kendaraan (opsional)" />
                            <input id="foto" name="foto" type="file" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                file:text-sm file:font-semibold file:text-white
                                hover:file:opacity-90 cursor-pointer"
                                style="--file-bg: #fa7c20;">
                            <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                            <button type="button" @click="showModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                                style="background-color: #183356;">
                                Save vehicle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchKendaraan');
        const cards = document.querySelectorAll('.kendaraan-card');

        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            cards.forEach(card => {
                const plat = card.dataset.plat;
                const merek = card.dataset.merek;
                const model = card.dataset.model;
                if (plat.includes(keyword) || merek.includes(keyword) || model.includes(keyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>
