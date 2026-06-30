<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kendaraan — {{ $kendaraan->merek }} {{ $kendaraan->model }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">
                <form action="{{ route('user.kendaraan.update', $kendaraan) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="merek" value="Merek (Make)" />
                            <x-text-input id="merek" name="merek" type="text" class="block mt-1 w-full"
                                :value="old('merek', $kendaraan->merek)" required />
                            <x-input-error :messages="$errors->get('merek')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="model" value="Model" />
                            <x-text-input id="model" name="model" type="text" class="block mt-1 w-full"
                                :value="old('model', $kendaraan->model)" required />
                            <x-input-error :messages="$errors->get('model')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="tahun" value="Tahun" />
                            <x-text-input id="tahun" name="tahun" type="number" min="1900" :max="date('Y')"
                                class="block mt-1 w-full" :value="old('tahun', $kendaraan->tahun)" required />
                            <x-input-error :messages="$errors->get('tahun')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="odometer" value="Odometer (km)" />
                            <x-text-input id="odometer" name="odometer" type="number" min="0"
                                class="block mt-1 w-full" :value="old('odometer', $kendaraan->odometer)" />
                            <x-input-error :messages="$errors->get('odometer')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="warna" value="Warna" />
                            <x-text-input id="warna" name="warna" type="text" class="block mt-1 w-full"
                                :value="old('warna', $kendaraan->warna)" placeholder="Contoh: Hitam" />
                            <x-input-error :messages="$errors->get('warna')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="jenis" value="Jenis Kendaraan" />
                            <select id="jenis" name="jenis" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                <option value="motor" {{ old('jenis', $kendaraan->jenis) === 'motor' ? 'selected' : '' }}>Motor</option>
                                <option value="mobil" {{ old('jenis', $kendaraan->jenis) === 'mobil' ? 'selected' : '' }}>Mobil</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="plat_nomor" value="Plat Nomor" />
                            <x-text-input id="plat_nomor" name="plat_nomor" type="text" class="block mt-1 w-full"
                                :value="old('plat_nomor', $kendaraan->plat_nomor)" required />
                            <x-input-error :messages="$errors->get('plat_nomor')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="vin" value="VIN (opsional)" />
                            <x-text-input id="vin" name="vin" type="text" class="block mt-1 w-full"
                                :value="old('vin', $kendaraan->vin)" placeholder="17-character VIN" />
                            <x-input-error :messages="$errors->get('vin')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Perbarui</x-primary-button>
                        <a href="{{ route('user.kendaraan.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>