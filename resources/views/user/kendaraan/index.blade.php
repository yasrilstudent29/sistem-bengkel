<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kendaraan Saya
            </h2>
            <a href="{{ route('user.kendaraan.create') }}"
                class="bg-gray-800 text-white text-sm font-bold px-4 py-2 rounded hover:bg-gray-700 transition">
                + Tambah Kendaraan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama Kendaraan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Merek & Model
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Tahun</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Plat Nomor
                                </th>
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
                                        {{ $kendaraan->nama_kendaraan }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $kendaraan->merek }}
                                        {{ $kendaraan->model }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $kendaraan->tahun }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $kendaraan->plat_nomor }}</td>
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
