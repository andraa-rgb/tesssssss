<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Lab WICIDA')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200">

    {{-- NAVBAR GLOBAL --}}
    <div class="navbar bg-base-100 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto w-full px-4">
            <div class="flex-1">
                <a href="{{ route('dashboard') }}" class="btn btn-ghost normal-case text-xl gap-2">
                    <span class="text-3xl">📚</span>
                    <div class="flex flex-col items-start leading-tight">
                        <span class="font-bold">Lab WICIDA</span>
                        <span class="text-[11px] text-base-content/60">Sistem Jadwal Dosen</span>
                    </div>
                </a>
            </div>

            @auth
                <div class="flex-none gap-2">
                    {{-- MENU DESKTOP --}}
                    <div class="hidden md:flex">
                        <ul class="menu menu-horizontal px-1">
    <li>
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active font-semibold' : '' }}">
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('jadwal.index') }}"
           class="{{ request()->routeIs('jadwal.*') ? 'active font-semibold' : '' }}">
            Jadwal
        </a>
    </li>
    <li>
        <a href="{{ route('booking.index') }}"
           class="{{ request()->routeIs('booking.*') ? 'active font-semibold' : '' }}">
            Booking
        </a>
    </li>
    <li>
        <a href="{{ route('profile.edit') }}"
           class="{{ request()->routeIs('profile.*') ? 'active font-semibold' : '' }}">
            Profil
        </a>
    </li>
</ul>

                    </div>

                    {{-- THEME TOGGLE --}}
                    <label class="swap swap-rotate btn btn-ghost btn-circle">
                        <input type="checkbox" id="theme-toggle-checkbox" />
                        <svg class="swap-on fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>
                        <svg class="swap-off fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
                    </label>

                    {{-- DROPDOWN USER - LEBIH JELAS --}}
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar placeholder">
                            @if(auth()->user()->photo)
                                <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                    <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}">
                                </div>
                            @else
                                <div class="bg-primary text-primary-content rounded-full w-10">
                                    <span class="text-xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </label>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-lg menu menu-sm dropdown-content bg-base-100 rounded-box w-60 border border-base-300">
                            {{-- Header dengan info user --}}
                            <li class="menu-title px-4 py-3 border-b border-base-300">
                                <div class="flex flex-col gap-1">
                                    <span class="font-bold text-base truncate">{{ auth()->user()->name }}</span>
                                    <span class="text-xs text-base-content/60 truncate">{{ auth()->user()->email }}</span>
                                    <span class="badge badge-primary badge-sm mt-1 capitalize">{{ str_replace('_', ' ', auth()->user()->role) }}</span>
                                </div>
                            </li>
                            
                            {{-- Menu items --}}
                            <li>
                                <a href="{{ route('profile.edit') }}" class="py-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Pengaturan Profil
                                </a>
                            </li>
                            
                            <div class="divider my-0"></div>
                            
                            {{-- Logout button yang jelas --}}
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-error font-semibold py-3 w-full justify-start">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    {{-- MENU MOBILE - TAMBAHKAN LOGOUT --}}
                    <div class="dropdown dropdown-end md:hidden">
                        <label tabindex="0" class="btn btn-ghost btn-circle">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </label>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow-lg menu menu-sm dropdown-content bg-base-100 rounded-box w-52 border border-base-300">
                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a href="{{ route('jadwal.index') }}">Jadwal</a></li>
                            <li><a href="{{ route('booking.index') }}">Booking</a></li>
                            <li><a href="{{ route('profile.edit') }}">Profil</a></li>
                            <div class="divider my-0"></div>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-error font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    {{-- KONTEN HALAMAN --}}
    <main class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    <script>
        // Theme toggle
        const html = document.documentElement;
        const toggle = document.getElementById('theme-toggle-checkbox');
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        if (toggle) toggle.checked = savedTheme === 'dark';
        if (toggle) {
            toggle.addEventListener('change', () => {
                const theme = toggle.checked ? 'dark' : 'light';
                html.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
