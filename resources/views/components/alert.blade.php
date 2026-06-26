@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center gap-3">
        <span class="text-xl">✓</span>
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-center gap-3">
        <span class="text-xl">✕</span>
        <p class="text-sm font-medium">{{ session('error') }}</p>
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-lg">
        <p class="text-sm font-bold mb-2">⚠ Terdapat kesalahan input:</p>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
