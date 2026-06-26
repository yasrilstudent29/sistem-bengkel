<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Mekanik
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.mekanik.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="nama" value="Nama Mekanik" />
                        <x-text-input id="nama" name="nama" type="text" class="block mt-1 w-full"
                            :value="old('nama')" required />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="no_telepon" value="Nomor Telepon" />
                        <x-text-input id="no_telepon" name="no_telepon" type="text" class="block mt-1 w-full"
                            :value="old('no_telepon')" required />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="spesialisasi" value="Spesialisasi (opsional)" />
                        <x-text-input id="spesialisasi" name="spesialisasi" type="text" class="block mt-1 w-full"
                            :value="old('spesialisasi')" />
                        <x-input-error :messages="$errors->get('spesialisasi')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('admin.mekanik.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
