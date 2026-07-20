<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Bengkel — Manajemen Bengkel Mudah & Efisien</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-white text-gray-900">

    {{-- Navbar --}}
    <nav class="border-b border-gray-100 sticky top-0 bg-white/90 backdrop-blur z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center" style="background-color: #fa7c20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span class="font-extrabold text-lg" style="color: #183356;">Sistem Bengkel</span>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="#beranda" class="text-sm font-bold pb-1 border-b-2"
                    style="color: #183356; border-color: #fa7c20;">Beranda</a>
                <a href="#fitur" class="text-sm font-semibold text-gray-500 hover:text-orange-600 transition">Fitur</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-5 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                        style="background-color: #fa7c20;">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-semibold text-gray-700 hover:text-orange-600 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2 rounded-lg text-white text-sm font-bold hover:opacity-90 transition"
                        style="background-color: #fa7c20;">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section id="beranda"
        class="max-w-7xl mx-auto px-6 py-8 lg:py-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold mb-4"
                style="background-color: #fef3e7; color: #fa7c20;">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Sistem Informasi Manajemen Bengkel
            </span>
            <h1 class="font-extrabold text-4xl lg:text-5xl leading-tight mb-5" style="color: #183356;">
                Kelola Bengkel Anda<br>Lebih Mudah &amp; Efisien
            </h1>
            <p class="text-gray-500 text-lg mb-8 leading-relaxed">
                Tingkatkan produktivitas bengkel dengan platform terpadu untuk mengelola jadwal servis, kinerja
                mekanik, inventaris suku cadang, riwayat kendaraan, dan database pelanggan dalam satu layar.
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('register') }}"
                    class="px-8 py-3 rounded-xl text-white font-bold hover:opacity-90 transition inline-flex items-center justify-center gap-2 group"
                    style="background-color: #fa7c20;">
                    Mulai Sekarang
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="{{ route('login') }}"
                    class="px-8 py-3 rounded-xl border-2 font-bold hover:bg-gray-50 transition text-center"
                    style="border-color: #183356; color: #183356;">
                    Masuk ke Akun
                </a>
            </div>
        </div>

        {{-- Gambar Hero --}}
        <div class="relative max-w-md mx-auto lg:max-w-full">
            <img src="{{ asset('images/bengkel.jpg') }}" alt="Ilustrasi Bengkel"
                class="w-full h-auto max-h-96 object-cover rounded-3xl shadow-xl">
        </div>
    </section>

    {{-- Fitur --}}
    <section id="fitur" class="bg-gray-50 py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-extrabold text-3xl mb-3" style="color: #183356;">Semua yang Anda Butuhkan</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">
                    Solusi lengkap untuk operasional bengkel modern yang mengutamakan kecepatan dan akurasi data.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white rounded-xl border border-gray-300 shadow p-6 hover:border-orange-400 transition-colors">
                    <div class="w-12 h-12 rounded-lg bg-orange-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h3 class="font-bold mb-1" style="color: #183356;">Manajemen Servis</h3>
                    <p class="text-gray-500 text-sm">Pantau status pengerjaan kendaraan secara real-time dari
                        estimasi hingga selesai.</p>
                </div>

                <div
                    class="bg-white rounded-xl border border-gray-300 shadow p-6 hover:border-orange-400 transition-colors">
                    <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                        </svg>
                    </div>
                    <h3 class="font-bold mb-1" style="color: #183356;">Data Kendaraan</h3>
                    <p class="text-gray-500 text-sm">Simpan riwayat perbaikan tiap kendaraan pelanggan untuk analisis
                        layanan lebih baik.</p>
                </div>

                <div
                    class="bg-white rounded-xl border border-gray-300 shadow p-6 hover:border-orange-400 transition-colors">
                    <div class="w-12 h-12 rounded-lg bg-purple-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z" />
                        </svg>
                    </div>
                    <h3 class="font-bold mb-1" style="color: #183356;">Tim Mekanik</h3>
                    <p class="text-gray-500 text-sm">Alokasikan tugas dan pantau kinerja mekanik dengan sistem
                        pembagian kerja yang adil.</p>
                </div>

                <div
                    class="bg-white rounded-xl border border-gray-300 shadow p-6 hover:border-orange-400 transition-colors">
                    <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold mb-1" style="color: #183356;">Struk Digital</h3>
                    <p class="text-gray-500 text-sm">Cetak struk servis dalam format PDF yang rapi dan profesional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 lg:py-20 relative overflow-hidden" style="background-color: #183356;">
        <div class="absolute inset-0 opacity-10 pointer-events-none"
            style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;">
        </div>
        <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
            <h2 class="font-extrabold text-3xl text-white mb-4">Siap Mengelola Bengkel Anda?</h2>
            <p class="text-blue-200 mb-8">Rasakan kemudahan mengelola operasional bengkel dalam satu platform yang
                terpadu.</p>
            <a href="{{ route('register') }}"
                class="inline-flex items-center gap-2 px-8 py-3 rounded-xl text-white font-bold hover:opacity-90 transition"
                style="background-color: #fa7c20;">
                Buat Akun Gratis
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="py-8 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} Sistem Bengkel. Sistem Informasi Manajemen Bengkel &amp; Servis Kendaraan.
        </div>
    </footer>

</body>

</html>
