<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                Mekanik
            </h2>
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal-mekanik'))"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> Tambah Mekanik
            </button>
        </div>
    </x-slot>

    <div x-data="{ showModal: {{ $errors->any() && !old('_edit_id') ? 'true' : 'false' }}, showEditModal: {{ $errors->any() && old('_edit_id') ? 'true' : 'false' }}, editData: {} }" x-on:open-modal-mekanik.window="showModal = true">
        <div class="max-w-7xl">

            <x-alert />

            <p class="text-gray-500 text-base -mt-9 mb-6">
                Tempat seluruh data mekanik yang bekerja tersimpan
            </p>

            {{-- Search Bar --}}
            <div class="relative mb-6 max-w-md">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchMekanik" placeholder="Cari berdasarkan nama atau spesialisasi..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            {{-- Card Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="mekanikGrid">
                @forelse ($mekaniks as $mekanik)
                    <div class="group bg-white rounded-xl border border-gray-300 shadow p-5 mekanik-card hover:border-orange-400 transition-colors"
                        data-nama="{{ strtolower($mekanik->nama) }}"
                        data-spesialisasi="{{ strtolower($mekanik->spesialisasi ?? '') }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                                    style="background-color: #183356;">
                                    {{ strtoupper(substr($mekanik->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p
                                        class="font-semibold text-gray-900 group-hover:text-orange-500 transition-colors">
                                        {{ $mekanik->nama }}</p>
                                    <p class="text-xs text-gray-400">{{ $mekanik->spesialisasi ?? '-' }}</p>
                                </div>
                            </div>
                            @if ($mekanik->status === 'aktif')
                                <span
                                    class="bg-green-100 text-green-700 text-xs font-bold px-2.5 py-1 rounded-full">Aktif</span>
                            @else
                                <span
                                    class="bg-gray-100 text-gray-600 text-xs font-bold px-2.5 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </div>

                        <div class="mt-4 space-y-1.5 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $mekanik->no_telepon }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                @php
                                    $servisAktif = $mekanik
                                        ->servis()
                                        ->whereIn('status', ['menunggu', 'proses'])
                                        ->count();
                                @endphp
                                @if ($servisAktif > 0)
                                    <span class="text-orange-600 font-medium">{{ $servisAktif }} servis sedang
                                        ditangani</span>
                                @else
                                    <span class="text-gray-400">Tidak ada servis aktif</span>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <button type="button"
                                @click="editData = {
                                    id: {{ $mekanik->id }},
                                    nama: @js($mekanik->nama),
                                    no_telepon: @js($mekanik->no_telepon),
                                    spesialisasi: @js($mekanik->spesialisasi),
                                    status: @js($mekanik->status),
                                    updateUrl: @js(route('admin.mekanik.update', $mekanik))
                                }; showEditModal = true"
                                class="flex-1 text-center py-2 rounded-lg border border-gray-200 text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                                Edit
                            </button>
                            <form action="{{ route('admin.mekanik.destroy', $mekanik) }}" method="POST" class="flex-1"
                                onsubmit="return confirm('Yakin ingin menghapus mekanik ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full py-2 rounded-lg border border-red-100 text-red-600 text-sm font-medium hover:bg-red-50 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada data mekanik.
                    </div>
                @endforelse
            </div>

            @if ($mekaniks->hasPages())
                <div class="mt-6">
                    {{ $mekaniks->links() }}
                </div>
            @endif

        </div>

        {{-- Modal Tambah Mekanik --}}
        <div x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background-color: rgba(0,0,0,0.6);">
            <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden">

                <div class="p-5 overflow-y-auto flex-1">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-extrabold text-lg text-gray-900">Tambah Mekanik</h3>
                        <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-500 text-xs mb-4">Tambahkan mekanik baru ke bengkel Anda.</p>

                    <form action="{{ route('admin.mekanik.store') }}" method="POST" class="space-y-3">
                        @csrf

                        <div>
                            <x-input-label for="nama" value="Nama Mekanik" />
                            <x-text-input id="nama" name="nama" type="text" class="block mt-1 w-full"
                                :value="old('nama')" required />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="no_telepon" value="Nomor Telepon" />
                                <x-text-input id="no_telepon" name="no_telepon" type="text"
                                    class="block mt-1 w-full" :value="old('no_telepon')" required />
                                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="spesialisasi" value="Spesialisasi" />
                                <x-text-input id="spesialisasi" name="spesialisasi" type="text"
                                    class="block mt-1 w-full" :value="old('spesialisasi')" placeholder="Motor / Mobil" />
                                <x-input-error :messages="$errors->get('spesialisasi')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="status" value="Status" />
                            <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif
                                </option>
                                <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                            <button type="button" @click="showModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                                style="background-color: #183356;">
                                Save mekanik
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Edit Mekanik (shared) --}}
        <div x-show="showEditModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background-color: rgba(0,0,0,0.6);">
            <div @click.outside="showEditModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden">

                <div class="p-5 overflow-y-auto flex-1">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-extrabold text-lg text-gray-900">Edit Mekanik</h3>
                        <button type="button" @click="showEditModal = false"
                            class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-500 text-xs mb-4">Perbarui data mekanik ini.</p>

                    <form :action="editData.updateUrl" method="POST" class="space-y-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="edit_nama" value="Nama Mekanik" />
                            <input id="edit_nama" name="nama" type="text" x-model="editData.nama" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="edit_no_telepon" value="Nomor Telepon" />
                                <input id="edit_no_telepon" name="no_telepon" type="text"
                                    x-model="editData.no_telepon" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            </div>
                            <div>
                                <x-input-label for="edit_spesialisasi" value="Spesialisasi" />
                                <input id="edit_spesialisasi" name="spesialisasi" type="text"
                                    x-model="editData.spesialisasi"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            </div>
                        </div>

                        <div>
                            <x-input-label for="edit_status" value="Status" />
                            <select id="edit_status" name="status" x-model="editData.status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
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

    <script>
        const searchInput = document.getElementById('searchMekanik');
        const cards = document.querySelectorAll('.mekanik-card');

        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            cards.forEach(card => {
                const nama = card.dataset.nama;
                const spesialisasi = card.dataset.spesialisasi;
                if (nama.includes(keyword) || spesialisasi.includes(keyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</x-app-layout>
