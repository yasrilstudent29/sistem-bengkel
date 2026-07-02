<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Kendaraan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('user.kendaraan.store') }}" method="POST" class="space-y-5"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
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

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="tahun" value="Tahun" />
                            <x-text-input id="tahun" name="tahun" type="number" min="1900" :max="date('Y')"
                                class="block mt-1 w-full" :value="old('tahun')" required />
                            <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="odometer" value="Odometer (km)" />
                            <x-text-input id="odometer" name="odometer" type="number" min="0"
                                class="block mt-1 w-full" :value="old('odometer', 0)" />
                            <x-input-error :messages="$errors->get('odometer')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="warna" value="Warna" />
                            <x-text-input id="warna" name="warna" type="text" class="block mt-1 w-full"
                                :value="old('warna')" placeholder="Contoh: Hitam" />
                            <x-input-error :messages="$errors->get('warna')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="jenis" value="Jenis Kendaraan" />
                            <select id="jenis" name="jenis" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                <option value="motor" {{ old('jenis') === 'motor' ? 'selected' : '' }}>Motor</option>
                                <option value="mobil" {{ old('jenis') === 'mobil' ? 'selected' : '' }}>Mobil</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="plat_nomor" value="Plat Nomor" />
                            <x-text-input id="plat_nomor" name="plat_nomor" type="text" class="block mt-1 w-full"
                                :value="old('plat_nomor')" required />
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
                            onchange="previewFoto(this)">
                        <div id="preview-container" class="mt-3 hidden">
                            <img id="preview-foto" src="" alt="Preview"
                                class="w-40 h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                        <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('user.kendaraan.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function previewFoto(input) {
            const container = document.getElementById('preview-container');
            const preview = document.getElementById('preview-foto');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
