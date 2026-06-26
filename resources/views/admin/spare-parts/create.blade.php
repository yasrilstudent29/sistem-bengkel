<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Spare Part
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.spare-parts.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="kode" value="Kode Spare Part" />
                        <x-text-input id="kode" name="kode" type="text" class="block mt-1 w-full"
                            :value="old('kode')" required />
                        <x-input-error :messages="$errors->get('kode')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nama" value="Nama Spare Part" />
                        <x-text-input id="nama" name="nama" type="text" class="block mt-1 w-full"
                            :value="old('nama')" required />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="stok" value="Stok" />
                        <x-text-input id="stok" name="stok" type="number" min="0"
                            class="block mt-1 w-full" :value="old('stok', 0)" required />
                        <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="harga" value="Harga (Rp)" />
                        <x-text-input id="harga" name="harga" type="number" min="0"
                            class="block mt-1 w-full" :value="old('harga')" required />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('admin.spare-parts.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
