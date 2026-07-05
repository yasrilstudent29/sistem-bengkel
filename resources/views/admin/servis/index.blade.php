<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                Repair Jobs
            </h2>
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal-servis'))"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> New Job
            </button>
        </div>
    </x-slot>

    <div x-data="{ showModal: {{ $errors->any() || request('open_modal') ? 'true' : 'false' }} }" x-on:open-modal-servis.window="showModal = true">
        <div class="max-w-7xl">

            <x-alert />

            <p class="text-gray-500 text-base -mt-9 mb-6">
                Servis kendaraan yang sedang berjalan di bengkel Anda.
            </p>

            {{-- Filter Tabs --}}
            <div class="flex items-center gap-1 mb-6 bg-gray-100 p-1 rounded-lg w-fit">
                <a href="{{ route('admin.servis.index') }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ !$status || $status === 'all' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    All ({{ $countAll }})
                </a>
                <a href="{{ route('admin.servis.index', ['status' => 'menunggu']) }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ $status === 'menunggu' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Menunggu ({{ $countMenunggu }})
                </a>
                <a href="{{ route('admin.servis.index', ['status' => 'proses']) }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ $status === 'proses' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Proses ({{ $countProses }})
                </a>
                <a href="{{ route('admin.servis.index', ['status' => 'selesai']) }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ $status === 'selesai' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Selesai ({{ $countSelesai }})
                </a>
                <a href="{{ route('admin.servis.index', ['status' => 'diambil']) }}"
                    class="px-4 py-2 rounded-md text-sm font-semibold transition {{ $status === 'diambil' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Diambil ({{ $countDiambil }})
                </a>
            </div>

            {{-- Card Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                @forelse ($servis as $item)
                    @php
                        $statusColor = match ($item->status) {
                            'menunggu' => 'bg-yellow-100 text-yellow-700',
                            'proses' => 'bg-blue-100 text-blue-700',
                            'selesai' => 'bg-green-100 text-green-700',
                            'diambil' => 'bg-gray-100 text-gray-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <div
                        class="group bg-white rounded-xl border border-gray-300 shadow p-5 hover:border-orange-400 transition-colors">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-semibold text-gray-900 group-hover:text-orange-500 transition-colors">
                                    {{ $item->kendaraan->tahun }} {{ $item->kendaraan->merek }}
                                    {{ $item->kendaraan->model }}
                                </p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ $item->kendaraan->user->name }} — {{ $item->kendaraan->plat_nomor }}
                                </p>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $statusColor }} shrink-0">
                                {{ ucfirst($item->status) }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-600 mt-3">{{ Str::limit($item->keluhan, 80) }}</p>

                        <div class="flex items-center justify-between mt-3 text-sm">
                            <span class="text-gray-400">
                                Masuk {{ $item->tanggal_masuk->format('d M Y') }}
                            </span>
                            <span class="font-semibold text-gray-900">
                                Rp {{ number_format($item->total_biaya, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <form action="{{ route('admin.servis.update-status', $item) }}" method="POST"
                                class="flex-1">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()"
                                    class="w-full border border-gray-300 rounded-lg text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-200">
                                    <option value="menunggu" {{ $item->status === 'menunggu' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="proses" {{ $item->status === 'proses' ? 'selected' : '' }}>Proses
                                    </option>
                                    <option value="selesai" {{ $item->status === 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                    <option value="diambil" {{ $item->status === 'diambil' ? 'selected' : '' }}>Diambil
                                    </option>
                                </select>
                            </form>
                            <a href="{{ route('admin.servis.show', $item) }}"
                                class="px-5 py-2 rounded-lg text-white text-sm font-semibold hover:opacity-90 transition shrink-0"
                                style="background-color: #183356;">
                                View details
                            </a>
                            <form action="{{ route('admin.servis.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data servis ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada data servis.
                    </div>
                @endforelse
            </div>

            @if ($servis->hasPages())
                <div class="mt-6">
                    {{ $servis->links() }}
                </div>
            @endif

        </div>

        {{-- Modal Tambah Servis --}}
        <div x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background-color: rgba(0,0,0,0.6);">
            <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">

                <div class="p-5 overflow-y-auto flex-1">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-extrabold text-lg text-gray-900">New Job</h3>
                        <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-500 text-xs mb-4">Buat data servis baru untuk kendaraan yang masuk.</p>

                    <form action="{{ route('admin.servis.store') }}" method="POST" class="space-y-3">
                        @csrf

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="kendaraan_id" value="Kendaraan" />
                                <select id="kendaraan_id" name="kendaraan_id" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                    <option value="">-- Pilih Kendaraan --</option>
                                    @foreach ($kendaraans as $kendaraan)
                                        <option value="{{ $kendaraan->id }}"
                                            {{ old('kendaraan_id', request('kendaraan_id')) == $kendaraan->id ? 'selected' : '' }}>
                                            {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                                            ({{ $kendaraan->plat_nomor }})
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
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @if ($mekaniks->isEmpty())
                                    <p class="text-xs text-amber-600 mt-1">Semua mekanik sibuk.</p>
                                @endif
                                <x-input-error :messages="$errors->get('mekanik_id')" class="mt-2" />
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <x-input-label for="tanggal_masuk" value="Tanggal Masuk" />
                                <x-text-input id="tanggal_masuk" name="tanggal_masuk" type="date"
                                    class="block mt-1 w-full" :value="old('tanggal_masuk', date('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="status" value="Status" />
                                <select id="status" name="status" required
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                    <option value="menunggu" {{ old('status') === 'menunggu' ? 'selected' : '' }}>
                                        Menunggu</option>
                                    <option value="proses" {{ old('status') === 'proses' ? 'selected' : '' }}>Proses
                                    </option>
                                    <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="diambil" {{ old('status') === 'diambil' ? 'selected' : '' }}>
                                        Diambil</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="total_biaya" value="Total Biaya (Rp)" />
                                <x-text-input id="total_biaya" name="total_biaya" type="number" min="0"
                                    class="block mt-1 w-full" :value="old('total_biaya', 0)" required />
                                <x-input-error :messages="$errors->get('total_biaya')" class="mt-2" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="keluhan" value="Keluhan" />
                            <textarea id="keluhan" name="keluhan" rows="2" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('keluhan') }}</textarea>
                            <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                        </div>

                        {{-- Spare Parts (compact, hanya 1 baris default) --}}
                        <div>
                            <x-input-label value="Spare Part (opsional)" />
                            <div id="spare-parts-container" class="mt-1 space-y-2">
                                <div class="flex gap-2 items-center spare-part-row">
                                    <select name="spare_parts[0][id]"
                                        class="flex-1 border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-200">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($spareParts as $part)
                                            <option value="{{ $part->id }}">{{ $part->nama }} (Stok:
                                                {{ $part->stok }})</option>
                                        @endforeach
                                    </select>
                                    <input type="number" name="spare_parts[0][jumlah]" min="1"
                                        value="1"
                                        class="w-16 border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-200">
                                    <button type="button" onclick="removeRowServis(this)"
                                        class="text-red-500 hover:text-red-700 text-sm px-1">✕</button>
                                </div>
                            </div>
                            <button type="button" onclick="addSparePartRowServis()"
                                class="mt-1 text-xs text-blue-600 hover:underline">+ Tambah baris</button>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                            <button type="button" @click="showModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                                style="background-color: #183356;">
                                Save job
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let rowIndexServis = 1;
        const sparePartsServis = @json($spareParts);

        function addSparePartRowServis() {
            const container = document.getElementById('spare-parts-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 items-center spare-part-row';

            let options = '<option value="">-- Pilih Spare Part --</option>';
            sparePartsServis.forEach(part => {
                options +=
                    `<option value="${part.id}">${part.nama} (Stok: ${part.stok}) - Rp ${part.harga.toLocaleString('id-ID')}</option>`;
            });

            div.innerHTML = `
                <select name="spare_parts[${rowIndexServis}][id]"
                    class="flex-1 border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-200">
                    ${options}
                </select>
                <input type="number" name="spare_parts[${rowIndexServis}][jumlah]" min="1" value="1"
                    placeholder="Jml"
                    class="w-16 border-gray-300 rounded-md shadow-sm text-sm focus:ring focus:ring-indigo-200">
                <button type="button" onclick="removeRowServis(this)"
                    class="text-red-500 hover:text-red-700 text-sm">✕</button>
            `;
            container.appendChild(div);
            rowIndexServis++;
        }

        function removeRowServis(btn) {
            btn.closest('.spare-part-row').remove();
        }
    </script>
</x-app-layout>
