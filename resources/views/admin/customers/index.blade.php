<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-3xl text-gray-900 leading-tight">
                Customers
            </h2>
            <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-modal-customer'))"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> Add customer
            </button>
        </div>
    </x-slot>

    <div x-data="{ showModal: {{ $errors->any() ? 'true' : 'false' }} }" x-on:open-modal-customer.window="showModal = true">
        <div class="max-w-7xl">

            <x-alert />

            <p class="text-gray-500 text-base -mt-9 mb-6">
                Database customer bengkel Anda — nama, kontak, dan riwayat.
            </p>

            {{-- Search Bar --}}
            <div class="relative mb-6 max-w-md">
                <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchCustomer" placeholder="Cari berdasarkan nama atau telepon..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-200">
            </div>

            {{-- Card Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5" id="customerGrid">
                @forelse ($customers as $customer)
                    <div class="group bg-white rounded-xl border border-gray-300 shadow p-5 customer-card hover:border-orange-400 transition-colors"
                        data-name="{{ strtolower($customer->nama_lengkap) }}" data-phone="{{ $customer->no_telepon }}">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0"
                                    style="background-color: #183356;">
                                    {{ strtoupper(substr($customer->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <p
                                        class="font-semibold text-gray-900 group-hover:text-orange-500 transition-colors">
                                        {{ $customer->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-400">{{ $customer->alamat ?? '-' }}</p>
                                </div>
                            </div>
                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data customer ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 space-y-1.5 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $customer->user->email }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $customer->no_telepon ?? '-' }}
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('admin.customers.show', $customer) }}"
                                class="px-5 py-2 rounded-lg text-white text-sm font-semibold hover:opacity-90 transition"
                                style="background-color: #183356;">
                                View details
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-12">
                        Belum ada data customer.
                    </div>
                @endforelse
            </div>

            @if ($customers->hasPages())
                <div class="mt-6">
                    {{ $customers->links() }}
                </div>
            @endif

        </div>

        {{-- Modal Tambah Customer --}}
        <div x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="background-color: rgba(0,0,0,0.6);">
            <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl w-full max-w-xl max-h-[90vh] flex flex-col overflow-hidden">

                <div class="p-5 overflow-y-auto flex-1">
                    <div class="flex items-start justify-between mb-1">
                        <h3 class="font-extrabold text-lg text-gray-900">Tambah Customer</h3>
                        <button type="button" @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <p class="text-gray-500 text-xs mb-4">Daftarkan data customer dari user yang sudah terdaftar.</p>

                    <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-3">
                        @csrf

                        <div>
                            <x-input-label for="user_id" value="Email User Terdaftar" />
                            <select id="user_id" name="user_id" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200"
                                onchange="isiNamaCustomer(this)">
                                <option value="">-- Pilih Email --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" data-name="{{ $user->name }}"
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

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="no_telepon" value="No. Telepon" />
                                <x-text-input id="no_telepon" name="no_telepon" type="text"
                                    class="block mt-1 w-full" :value="old('no_telepon')" />
                                <x-input-error :messages="$errors->get('no_telepon')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="alamat" value="Alamat (Kota/Wilayah)" />
                                <x-text-input id="alamat" name="alamat" type="text" class="block mt-1 w-full"
                                    :value="old('alamat')" placeholder="Contoh: Ngawi" />
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                            <button type="button" @click="showModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                                style="background-color: #183356;">
                                Save customer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchCustomer');
        const cards = document.querySelectorAll('.customer-card');

        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            cards.forEach(card => {
                const name = card.dataset.name;
                const phone = card.dataset.phone || '';
                if (name.includes(keyword) || phone.includes(keyword)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        function isiNamaCustomer(select) {
            const option = select.options[select.selectedIndex];
            const nama = option.getAttribute('data-name');
            if (nama) {
                document.getElementById('nama_lengkap').value = nama;
            }
        }
    </script>
</x-app-layout>
