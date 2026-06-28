<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Customer
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="user_id" value="Email User Terdaftar" />
                        <select id="user_id" name="user_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                            onchange="isiNama(this)">
                            <option value="">-- Pilih Email --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->email }} — {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                        <x-text-input id="nama_lengkap" name="nama_lengkap" type="text"
                            class="block mt-1 w-full" :value="old('nama_lengkap')" required />
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="nama_pendek" value="Nama Pendek / Panggilan" />
                        <x-text-input id="nama_pendek" name="nama_pendek" type="text"
                            class="block mt-1 w-full" :value="old('nama_pendek')" />
                        <x-input-error :messages="$errors->get('nama_pendek')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="no_telepon" value="No. Telepon" />
                        <x-text-input id="no_telepon" name="no_telepon" type="text"
                            class="block mt-1 w-full" :value="old('no_telepon')" />
                        <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="alamat" value="Alamat" />
                        <textarea id="alamat" name="alamat" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('alamat') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="catatan" value="Catatan Internal (opsional)" />
                        <textarea id="catatan" name="catatan" rows="3"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">{{ old('catatan') }}</textarea>
                        <x-input-error :messages="$errors->get('catatan')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('admin.customers.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function isiNama(select) {
            const option = select.options[select.selectedIndex];
            const nama = option.getAttribute('data-name');
            if (nama) {
                document.getElementById('nama_lengkap').value = nama;
            }
        }
    </script>
</x-app-layout>