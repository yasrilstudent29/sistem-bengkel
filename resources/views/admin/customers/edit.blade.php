<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Customer — {{ $customer->nama_lengkap }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">

                {{-- Info User --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-lg text-sm">
                    <p class="text-gray-500">Email</p>
                    <p class="font-medium text-gray-800">{{ $customer->user->email }}</p>
                </div>

                <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                        <x-text-input id="nama_lengkap" name="nama_lengkap" type="text"
                            class="block mt-1 w-full" :value="old('nama_lengkap', $customer->nama_lengkap)" required />
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nama_pendek" value="Nama Pendek / Panggilan" />
                        <x-text-input id="nama_pendek" name="nama_pendek" type="text"
                            class="block mt-1 w-full" :value="old('nama_pendek', $customer->nama_pendek)" />
                        <x-input-error :messages="$errors->get('nama_pendek')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="no_telepon" value="No. Telepon" />
                        <x-text-input id="no_telepon" name="no_telepon" type="text"
                            class="block mt-1 w-full" :value="old('no_telepon', $customer->no_telepon)" />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat" value="Alamat" />
                        <textarea id="alamat" name="alamat" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('alamat', $customer->alamat) }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="catatan" value="Catatan Internal (opsional)" />
                        <textarea id="catatan" name="catatan" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('catatan', $customer->catatan) }}</textarea>
                        <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Perbarui</x-primary-button>
                        <a href="{{ route('admin.customers.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>