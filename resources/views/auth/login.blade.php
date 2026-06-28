<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Bengkel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="h-screen flex overflow-hidden">

    {{-- KIRI — Branding --}}
    <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-14" style="background-color: #183356;">

        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background-color: #fa7c20;">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <span class="text-white text-lg font-bold">Sistem Bengkel</span>
        </div>

        {{-- Tagline --}}
        <div>
            <h1 class="text-white text-4xl font-bold leading-tight mb-4">
                Kelola bengkel Anda lebih mudah dan efisien.
            </h1>
            <p class="text-blue-200 text-sm leading-relaxed">
                Satu tempat untuk mengelola servis, mekanik, spare part, dan pelanggan Anda.
            </p>
        </div>

        {{-- Footer --}}
        <p class="text-blue-300 text-xs">
            &copy; {{ date('Y') }} Sistem Bengkel. All rights reserved.
        </p>
    </div>

    {{-- KANAN — Form Login --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-14 bg-gray-50">
        <div class="w-full max-w-md">

            {{-- Tab --}}
            <div class="flex rounded-lg bg-gray-200 p-1 mb-7">
                <span
                    class="flex-1 text-center py-1.5 rounded-md bg-white text-gray-900 font-semibold text-sm shadow-sm">
                    Masuk
                </span>
                <a href="{{ route('register') }}"
                    class="flex-1 text-center py-1.5 rounded-md text-gray-500 font-semibold text-sm hover:text-gray-700 transition">
                    Buat Akun
                </a>
            </div>

            <h2 class="text-xl font-bold text-gray-900 mb-1">Selamat datang kembali</h2>
            <p class="text-gray-500 text-xs mb-5">Masuk ke akun bengkel Anda.</p>

            <x-auth-session-status class="mb-3" :status="session('status')" />

            @if ($errors->any())
                <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-md text-red-600 text-xs">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2.5 rounded-md border border-gray-200 bg-white text-gray-900 text-sm focus:outline-none focus:ring-2 transition">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-xs font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-medium hover:underline"
                                style="color: #fa7c20;">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2.5 rounded-md border border-gray-200 bg-white text-gray-900 text-sm focus:outline-none focus:ring-2 transition">
                </div>

                <div class="flex items-center gap-2">
                    <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300">
                    <label for="remember_me" class="text-xs text-gray-600">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full py-2.5 rounded-md text-white font-semibold text-sm transition hover:opacity-90"
                    style="background-color: #fa7c20;">
                    Masuk
                </button>

                {{-- Divider --}}
                <div class="flex items-center gap-3">
                    <div class="flex-1 h-px bg-gray-200"></div>
                    <span class="text-gray-400 text-xs">atau</span>
                    <div class="flex-1 h-px bg-gray-200"></div>
                </div>

                {{-- Google Login --}}
                <a href="{{ route('auth.google.redirect') }}"
                    class="w-full flex items-center justify-center gap-2 py-2.5 rounded-md border border-gray-200 bg-white text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" viewBox="0 0 48 48">
                        <path fill="#FFC107"
                            d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C35.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z" />
                        <path fill="#FF3D00"
                            d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C33.046,6.053,28.668,4,24,4C16.318,4,9.656,8.337,6.306,14.691z" />
                        <path fill="#4CAF50"
                            d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z" />
                        <path fill="#1976D2"
                            d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z" />
                    </svg>
                    Masuk dengan Google
                </a>
            </form>

        </div>
    </div>

</body>

</html>
