<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sistem Bengkel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        #sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        #sidebar .sidebar-label,
        #sidebar .sidebar-section-label,
        #sidebar #sidebar-logo-text,
        #sidebar #sidebar-user-info,
        #sidebar #sidebar-logout {
            transition: opacity 0.2s ease, transform 0.2s ease;
            white-space: nowrap;
        }

        #sidebar.collapsed .sidebar-label,
        #sidebar.collapsed .sidebar-section-label,
        #sidebar.collapsed #sidebar-logo-text,
        #sidebar.collapsed #sidebar-user-info,
        #sidebar.collapsed #sidebar-logout {
            opacity: 0;
            pointer-events: none;
            transform: translateX(-10px);
        }

        #sidebar.expanded .sidebar-label,
        #sidebar.expanded .sidebar-section-label,
        #sidebar.expanded #sidebar-logo-text,
        #sidebar.expanded #sidebar-user-info,
        #sidebar.expanded #sidebar-logout {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }

        /* Mencegah flash saat pindah halaman */
        #sidebar {
            width: 256px;
        }

        #sidebar.sidebar-init-collapsed {
            width: 64px !important;
            transition: none !important;
        }
    </style>
</head>

<body class="antialiased bg-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        <aside id="sidebar" class="expanded flex flex-col min-h-screen shrink-0 w-64"
            style="background-color: #0d1b2d;">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-4 py-5 border-b border-white/10 overflow-hidden">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                    style="background-color: #fa7c20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div id="sidebar-logo-text" class="overflow-hidden">
                    <p class="text-white font-bold text-sm leading-tight">Sistem Bengkel</p>
                    <p class="text-blue-300 text-xs">{{ auth()->user()->name }}</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-2 py-4 space-y-0.5 overflow-y-auto overflow-x-hidden">
                @if (auth()->user()->isAdmin())
                    <p
                        class="sidebar-section-label text-blue-400 text-[10px] font-semibold uppercase tracking-widest px-3 mb-2">
                        Workspace</p>

                    <x-sidebar-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </x-slot>
                        Dashboard
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('admin.servis.index')" :active="request()->routeIs('admin.servis.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </x-slot>
                        Servis
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </x-slot>
                        Customer
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('admin.kendaraan.index')" :active="request()->routeIs('admin.kendaraan.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                            </svg>
                        </x-slot>
                        Kendaraan
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('admin.mekanik.index')" :active="request()->routeIs('admin.mekanik.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z" />
                            </svg>
                        </x-slot>
                        Mekanik
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('admin.spare-parts.index')" :active="request()->routeIs('admin.spare-parts.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </x-slot>
                        Spare Part
                    </x-sidebar-link>

                    <div class="pt-3">
                        <p
                            class="sidebar-section-label text-blue-400 text-[10px] font-semibold uppercase tracking-widest px-3 mb-2">
                            Account</p>
                    </div>

                    <x-sidebar-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </x-slot>
                        Manajemen User
                    </x-sidebar-link>
                @else
                    <p
                        class="sidebar-section-label text-blue-400 text-[10px] font-semibold uppercase tracking-widest px-3 mb-2">
                        Menu</p>

                    <x-sidebar-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </x-slot>
                        Dashboard
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('user.kendaraan.index')" :active="request()->routeIs('user.kendaraan.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2 2h10l2-2zM13 6h2l3 5v5h-5V6z" />
                            </svg>
                        </x-slot>
                        Kendaraan Saya
                    </x-sidebar-link>

                    <x-sidebar-link :href="route('user.servis.index')" :active="request()->routeIs('user.servis.*')">
                        <x-slot name="icon">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </x-slot>
                        Riwayat Servis
                    </x-sidebar-link>
                @endif
            </nav>

            {{-- User Footer --}}
            <div class="px-3 py-4 border-t border-white/10 overflow-hidden">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 min-w-0">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0"
                            style="background-color: #fa7c20;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div id="sidebar-user-info" class="min-w-0 overflow-hidden">
                            <p class="text-white text-xs font-medium leading-tight truncate">{{ auth()->user()->name }}
                            </p>
                            <p class="text-blue-300 text-xs truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="shrink-0" id="sidebar-logout">
                        @csrf
                        <button type="submit" title="Logout" class="text-blue-300 hover:text-white transition ml-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex flex-col flex-1 overflow-hidden">

            {{-- Top Bar --}}
            <header class="bg-white border-b border-gray-300 px-6 py-4 flex items-center justify-between shrink-0">
                <button onclick="toggleSidebar()" class="text-gray-500 hover:text-gray-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span>
                    <span
                        class="text-xs font-bold px-2 py-1 rounded-full {{ auth()->user()->isAdmin() ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto bg-white">
                @isset($header)
                    <div class="px-6 pt-6 pb-4">
                        {{ $header }}
                    </div>
                @endisset

                <div class="p-6">
                    {{ $slot }}
                </div>
            </main>

        </div>

    </div>

    <script>
        let sidebarOpen = true;

        // Jalankan SEBELUM render untuk mencegah flash
        (function() {
            const saved = localStorage.getItem('sidebarOpen');
            if (saved === 'false') {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.add('sidebar-init-collapsed');
                sidebar.classList.remove('expanded');
                sidebar.classList.add('collapsed');
                sidebarOpen = false;
            }
        })();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');

            // Hapus class no-transition kalau masih ada
            sidebar.classList.remove('sidebar-init-collapsed');

            sidebarOpen = !sidebarOpen;

            if (!sidebarOpen) {
                sidebar.style.width = '64px';
                sidebar.classList.remove('expanded');
                sidebar.classList.add('collapsed');
            } else {
                sidebar.style.width = '256px';
                sidebar.classList.remove('collapsed');
                sidebar.classList.add('expanded');
            }

            localStorage.setItem('sidebarOpen', sidebarOpen);
        }
    </script>

</body>

</html>
