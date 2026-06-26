<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ubah Role — {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">

            <x-alert />

            <div class="bg-white p-8 shadow-sm sm:rounded-lg">

                <div class="mb-6 p-4 bg-gray-50 rounded-lg text-sm">
                    <p class="text-gray-500">Nama</p>
                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                    <p class="text-gray-500 mt-2">Email</p>
                    <p class="font-medium text-gray-800">{{ $user->email }}</p>
                </div>

                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="role" value="Role" />
                        <select id="role" name="role" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User
                            </option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                        <a href="{{ route('admin.users.index') }}"
                            class="text-sm text-gray-600 hover:underline">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
