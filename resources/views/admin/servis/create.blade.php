<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Data Servis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.servis.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="kendaraan_id" value="Kendaraan" />
                        <select id="kendaraan_id" name="kendaraan_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}"
                                    {{ old('kendaraan_id') == $kendaraan->id ? 'selected' : '' }}>
                                    {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                                    ({{ $kendaraan->plat_nomor }})
                                    -
                                    {{ $kendaraan->user->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('kendaraan_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="mekanik_id" value="Mekanik" />
                        <select id="mekanik_id" name="mekanik_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="">-- Pilih Mekanik --</option>
                            @forelse ($mekaniks as $mekanik)
                                <option value="{{ $mekanik->id }}"
                                    {{ old('mekanik_id') == $mekanik->id ? 'selected' : '' }}>
                                    {{ $mekanik->nama }}
                                    @if ($mekanik->spesialisasi)
                                        ({{ $mekanik->spesialisasi }})
                                    @endif
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @if ($mekaniks->isEmpty())
                            <div
                                class="mt-2 p-3 bg-amber-50 border border-amber-200 rounded-lg flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <p class="text-xs text-amber-700">
                                    Semua mekanik sedang menangani servis. Tunggu hingga salah satu selesai atau tambah
                                    mekanik baru.
                                </p>
                            </div>
                        @endif
                        <x-input-error :messages="$errors->get('mekanik_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="tanggal_masuk" value="Tanggal Masuk" />
                            <x-text-input id="tanggal_masuk" name="tanggal_masuk" type="date"
                                class="block mt-1 w-full" :value="old('tanggal_masuk', date('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="tanggal_selesai" value="Tanggal Selesai (opsional)" />
                            <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date"
                                class="block mt-1 w-full" :value="old('tanggal_selesai')" />
                            <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="keluhan" value="Keluhan" />
                        <textarea id="keluhan" name="keluhan" rows="3" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('keluhan') }}</textarea>
                        <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="catatan_mekanik" value="Catatan Mekanik (opsional)" />
                        <textarea id="catatan_mekanik" name="catatan_mekanik" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('catatan_mekanik') }}</textarea>
                        <x-input-error :messages="$errors->get('catatan_mekanik')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="menunggu" {{ old('status') === 'menunggu' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="proses" {{ old('status') === 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="diambil" {{ old('status') === 'diambil' ? 'selected' : '' }}>Diambil
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="total_biaya" value="Total Biaya (Rp)" />
                        <x-text-input id="total_biaya" name="total_biaya" type="number" min="0"
                            class="block mt-1 w-full" :value="old('total_biaya', 0)" required />
                        <x-input-error :messages="$errors->get('total_biaya')" class="mt-2" />
                    </div>

                    {{-- Spare Parts --}}
                    <div>
                        <x-input-label value="Spare Part yang Digunakan (opsional)" />
                        <div id="spare-parts-container" class="mt-2 space-y-2">
                            <div class="flex gap-3 items-center spare-part-row">
                                <select name="spare_parts[0][id]"
                                    class="flex-1 border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-200">
                                    <option value="">-- Pilih Spare Part --</option>
                                    @foreach ($spareParts as $part)
                                        <option value="{{ $part->id }}">
                                            {{ $part->nama }} (Stok: {{ $part->stok }}) - Rp
                                            {{ number_format($part->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" name="spare_parts[0][jumlah]" min="1" value="1"
                                    placeholder="Jumlah"
                                    class="w-24 border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-200">
                                <button type="button" onclick="removeRow(this)"
                                    class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                            </div>
                        </div>
                        <button type="button" onclick="addSparePartRow()"
                            class="mt-2 text-sm text-blue-600 hover:underline">+ Tambah Spare Part</button>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('admin.servis.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let rowIndex = 1;
        const spareParts = @json($spareParts);

        function addSparePartRow() {
            const container = document.getElementById('spare-parts-container');
            const div = document.createElement('div');
            div.className = 'flex gap-3 items-center spare-part-row';

            let options = '<option value="">-- Pilih Spare Part --</option>';
            spareParts.forEach(part => {
                options +=
                    `<option value="${part.id}">${part.nama} (Stok: ${part.stok}) - Rp ${part.harga.toLocaleString('id-ID')}</option>`;
            });

            div.innerHTML = `
                <select name="spare_parts[${rowIndex}][id]"
                    class="flex-1 border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-200">
                    ${options}
                </select>
                <input type="number" name="spare_parts[${rowIndex}][jumlah]" min="1" value="1"
                    placeholder="Jumlah"
                    class="w-24 border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-200">
                <button type="button" onclick="removeRow(this)"
                    class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
            `;
            container.appendChild(div);
            rowIndex++;
        }

        function removeRow(btn) {
            btn.closest('.spare-part-row').remove();
        }
    </script>
</x-app-layout>
