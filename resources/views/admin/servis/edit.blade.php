<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Servis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.servis.update', $servis) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="kendaraan_id" value="Kendaraan" />
                        <select id="kendaraan_id" name="kendaraan_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}"
                                    {{ old('kendaraan_id', $servis->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>
                                    {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                                    ({{ $kendaraan->plat_nomor }}) -
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
                            @foreach ($mekaniks as $mekanik)
                                <option value="{{ $mekanik->id }}"
                                    {{ old('mekanik_id', $servis->mekanik_id) == $mekanik->id ? 'selected' : '' }}>
                                    {{ $mekanik->nama }}
                                    @if ($mekanik->spesialisasi)
                                        ({{ $mekanik->spesialisasi }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('mekanik_id')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="tanggal_masuk" value="Tanggal Masuk" />
                            <x-text-input id="tanggal_masuk" name="tanggal_masuk" type="date"
                                class="block mt-1 w-full" :value="old('tanggal_masuk', $servis->tanggal_masuk->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="tanggal_selesai" value="Tanggal Selesai (opsional)" />
                            <x-text-input id="tanggal_selesai" name="tanggal_selesai" type="date"
                                class="block mt-1 w-full" :value="old('tanggal_selesai', $servis->tanggal_selesai?->format('Y-m-d'))" />
                            <x-input-error :messages="$errors->get('tanggal_selesai')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="keluhan" value="Keluhan" />
                        <textarea id="keluhan" name="keluhan" rows="3" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('keluhan', $servis->keluhan) }}</textarea>
                        <x-input-error :messages="$errors->get('keluhan')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="catatan_mekanik" value="Catatan Mekanik (opsional)" />
                        <textarea id="catatan_mekanik" name="catatan_mekanik" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('catatan_mekanik', $servis->catatan_mekanik) }}</textarea>
                        <x-input-error :messages="$errors->get('catatan_mekanik')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="menunggu"
                                {{ old('status', $servis->status) === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="proses" {{ old('status', $servis->status) === 'proses' ? 'selected' : '' }}>
                                Proses</option>
                            <option value="selesai"
                                {{ old('status', $servis->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="diambil"
                                {{ old('status', $servis->status) === 'diambil' ? 'selected' : '' }}>Diambil</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="total_biaya" value="Total Biaya (Rp)" />
                        <x-text-input id="total_biaya" name="total_biaya" type="number" min="0"
                            class="block mt-1 w-full" :value="old('total_biaya', $servis->total_biaya)" required />
                        <x-input-error :messages="$errors->get('total_biaya')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Perbarui</x-primary-button>
                        <a href="{{ route('admin.servis.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
