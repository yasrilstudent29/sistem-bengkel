<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kendaraan Saya
            </h2>
            <a href="{{ route('user.kendaraan.create') }}"
                class="flex items-center gap-1.5 px-4 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                <span>+</span> Tambah Kendaraan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            @if (!$isCustomerVerified)
                <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-lg flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-amber-800">Akun Anda belum terverifikasi sebagai customer
                        </p>
                        <p class="text-xs text-amber-700 mt-1">
                            Kendaraan yang Anda daftarkan belum muncul di sistem admin. Silakan hubungi admin bengkel
                            untuk
                            melengkapi data diri Anda agar kendaraan dapat diproses untuk servis.
                        </p>
                    </div>
                </div>
            @endif 

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Kendaraan</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Plat Nomor
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Warna</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Odometer</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Jenis</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($kendaraans as $index => $kendaraan)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $kendaraans->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $kendaraan->tahun }} {{ $kendaraan->merek }} {{ $kendaraan->model }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $kendaraan->plat_nomor }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $kendaraan->warna ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ number_format($kendaraan->odometer ?? 0, 0, ',', '.') }} km
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @if ($kendaraan->jenis === 'motor')
                                            <span
                                                class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full">Motor</span>
                                        @else
                                            <span
                                                class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded-full">Mobil</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm space-x-3">
                                        <a href="{{ route('user.kendaraan.edit', $kendaraan) }}"
                                            class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('user.kendaraan.destroy', $kendaraan) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus kendaraan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada kendaraan terdaftar.
                                        <a href="{{ route('user.kendaraan.create') }}"
                                            class="text-blue-600 hover:underline ml-1">
                                            Tambah sekarang
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($kendaraans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $kendaraans->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
