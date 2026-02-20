<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab WICIDA - Sistem Jadwal & Booking Dosen</title>
    <meta name="description" content="Sistem Informasi Jadwal Dosen Lab WICIDA - Booking konsultasi dengan dosen secara online, real-time status, dan manajemen jadwal yang efisien.">
    <meta name="keywords" content="jadwal dosen, booking konsultasi, lab wicida, universitas, sistem informasi">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Smooth Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slideInLeft {
            animation: slideInLeft 0.6s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        /* Gradient Background */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-primary {
            background: linear-gradient(135deg, hsl(var(--p)) 0%, hsl(var(--s)) 100%);
        }

        /* Card Hover Effect */
        .card-hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: hsl(var(--b2));
        }

        ::-webkit-scrollbar-thumb {
            background: hsl(var(--p) / 0.3);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: hsl(var(--p) / 0.5);
        }

        /* Status Dot Animation */
        @keyframes status-pulse {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(1.2);
            }
        }

        .status-dot {
            animation: status-pulse 2s ease-in-out infinite;
        }

        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        /* Text gradient */
        .text-gradient {
            background: linear-gradient(135deg, hsl(var(--p)) 0%, hsl(var(--s)) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="min-h-screen bg-base-100">

{{-- NAVBAR --}}
<div class="navbar bg-base-100/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-base-300">
    <div class="max-w-7xl mx-auto w-full px-4">
        <div class="flex-1">
            <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl gap-2 hover:scale-105 transition-transform">
                <div class="w-10 h-10 rounded-lg bg-gradient-primary flex items-center justify-center">
                    <span class="text-2xl">📚</span>
                </div>
                <div class="flex flex-col items-start leading-tight">
                    <span class="font-bold text-base-content">Lab WICIDA</span>
                    <span class="text-[10px] text-base-content/60 hidden sm:block">Sistem Jadwal Dosen</span>
                </div>
            </a>
        </div>
        
        <div class="flex-none gap-2">
            <a href="#dosen" class="btn btn-ghost btn-sm hidden md:flex">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Dosen
            </a>
            
            @auth
    @if(auth()->user()->role === 'admin')
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-sm">
            Dashboard Admin
        </a>
    @else
        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
            Dashboard
        </a>
    @endif
@else
    <a href="{{ route('login') }}" class="btn btn-outline btn-sm">
        Login
    </a>
@endauth

            
            {{-- Theme Toggle --}}
            <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm">
                <input type="checkbox" id="theme-toggle" />
                <svg class="swap-on fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/>
                </svg>
                <svg class="swap-off fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/>
                </svg>
            </label>
        </div>
    </div>
</div>

{{-- HERO SECTION --}}
<section class="relative overflow-hidden bg-gradient-to-br from-primary/10 via-secondary/10 to-accent/10 py-20 md:py-32">
    {{-- Decorative elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-secondary/20 rounded-full blur-3xl animate-pulse-slow delay-300"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Left Content --}}
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full text-sm font-medium mb-6 animate-fadeIn">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    Real-time Status Update
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black mb-6 animate-fadeInUp">
                    <span class="block text-base-content">Sistem Jadwal Dosen</span>
                    <span class="block text-gradient mt-2">Lab WICIDA</span>
                </h1>

                <p class="text-lg md:text-xl text-base-content/70 mb-8 max-w-xl mx-auto lg:mx-0 animate-fadeInUp delay-100">
                    Platform modern untuk transparansi jadwal dan booking konsultasi dosen secara online dengan update real-time.
                </p>

                <div class="flex flex-wrap gap-4 justify-center lg:justify-start animate-fadeInUp delay-200">
                    <a href="#dosen" class="btn btn-primary btn-lg gap-2 shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Lihat Jadwal Dosen
                    </a>
                    <a href="#features" class="btn btn-outline btn-lg gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Fitur Unggulan
                    </a>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-4 mt-12 animate-fadeInUp delay-300">
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary">{{ $dosens->count() }}</div>
                        <div class="text-sm text-base-content/60">Dosen</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-secondary">{{ \App\Models\Jadwal::count() }}</div>
                        <div class="text-sm text-base-content/60">Jadwal</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-accent">{{ \App\Models\Booking::count() }}</div>
                        <div class="text-sm text-base-content/60">Booking</div>
                    </div>
                </div>
            </div>

            {{-- Right Content (Illustration) --}}
            <div class="hidden lg:block animate-fadeIn delay-400">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-primary rounded-3xl opacity-20 blur-2xl animate-float"></div>
                    <div class="relative bg-base-100 rounded-3xl shadow-2xl p-8">
                        <div class="space-y-4">
                            {{-- Mock calendar UI --}}
                            <div class="flex items-center justify-between mb-6">
                                <div class="text-lg font-bold">Jadwal Hari Ini</div>
                                <div class="badge badge-primary">Live</div>
                            </div>
                            @foreach(['08:00 - 10:00', '10:00 - 12:00', '13:00 - 15:00'] as $time)
                                <div class="flex items-center gap-4 p-4 bg-base-200 rounded-xl hover:shadow-md transition-shadow">
                                    <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-sm">{{ $time }}</div>
                                        <div class="text-xs text-base-content/60">Jadwal Tersedia</div>
                                    </div>
                                    <div class="badge badge-success badge-sm gap-1">
                                        <span class="status-dot w-1.5 h-1.5 rounded-full bg-current"></span>
                                        Ada
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce hidden md:block">
        <a href="#dosen" class="flex flex-col items-center gap-2 text-base-content/50 hover:text-base-content transition-colors">
            <span class="text-xs font-medium">Scroll</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </a>
    </div>
</section>

{{-- DOSEN SECTION --}}
<section id="dosen" class="max-w-6xl mx-auto px-4 py-16">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Daftar Dosen</h2>

        <div class="flex gap-2 items-center">
            <input id="search-dosen"
                   type="text"
                   placeholder="Cari dosen..."
                   class="input input-sm input-bordered" />

            <select id="sort-dosen" class="select select-sm select-bordered">
                <option value="">Urutkan</option>
                <option value="name">Nama A-Z</option>
                <option value="name-desc">Nama Z-A</option>
            </select>
        </div>
    </div>

    <div id="no-results" class="hidden text-center text-sm text-base-content/60 py-8">
        Tidak ada dosen yang cocok dengan pencarian.
    </div>

    {{-- GRID DOSEN --}}
    <div id="dosen-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
       @foreach($dosens as $dosen)
    <div class="group relative">
        <div
            class="card bg-base-100 border border-base-300/80 shadow-sm
                   transition-all duration-300 ease-out
                   hover:-translate-y-1 hover:shadow-xl hover:border-primary/60
                   cursor-pointer overflow-hidden">

            {{-- Ribbon Role di pojok kiri atas --}}
            <div class="absolute left-0 top-0 z-10">
                @if($dosen->role === 'kepala_lab')
                    <span class="badge badge-primary badge-sm rounded-none rounded-br-lg">
                        Kepala Lab
                    </span>
                @else
                    <span class="badge badge-secondary badge-sm rounded-none rounded-br-lg">
                        Staf
                    </span>
                @endif
            </div>

            <div class="card-body gap-3">

                {{-- Header: Avatar + Nama + Status --}}
                <div class="flex items-start gap-4">
                    {{-- Avatar dengan border animasi --}}
                    <div class="relative shrink-0">
                        <div
                            class="rounded-full p-[2px]
                                   bg-gradient-to-br from-primary/70 via-secondary/70 to-accent/70
                                   transition-all duration-300
                                   group-hover:from-primary group-hover:via-secondary group-hover:to-accent">
                            <div class="avatar">
                                @if($dosen->photo)
                                    <div class="w-16 h-16 rounded-full bg-base-100 shadow-inner overflow-hidden">
                                        <img src="{{ asset('storage/' . $dosen->photo) }}" alt="{{ $dosen->name }}">
                                    </div>
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-primary to-secondary text-primary-content flex items-center justify-center text-2xl font-bold">
                                        {{ substr($dosen->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 min-w-0 space-y-1">
                        <h3 class="font-semibold text-base md:text-lg truncate">
                            {{ $dosen->name }}
                        </h3>

                        {{-- Email + NIP --}}
                        <div class="flex flex-col gap-0.5 text-[11px] text-base-content/70">
                            @if($dosen->email)
                                <div class="flex items-center gap-1.5 truncate">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 8l7.89 5.26a2 2 0
                                                002.22 0L21 8M5 19h14a2 2 0
                                                002-2V7a2 2 0 00-2-2H5a2 2 0
                                                00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <span class="truncate">{{ $dosen->email }}</span>
                                </div>
                            @endif

                            @if($dosen->nip)
                                <div class="flex items-center gap-1.5 truncate">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6M5 7h14M5 7a2 2 0
                                                012-2h10a2 2 0 012 2v10a2 2 0
                                                01-2 2H7a2 2 0 01-2-2V7z" />
                                    </svg>
                                    <span class="truncate">{{ $dosen->nip }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Bidang keahlian --}}
                        @if($dosen->expertise)
                            <p class="text-xs md:text-sm text-base-content/80 font-medium mt-1">
                                {{ $dosen->expertise }}
                            </p>
                        @endif

                        {{-- Deskripsi singkat (bio) --}}
                        @if($dosen->bio)
                            <p class="text-[11px] md:text-xs text-base-content/70 line-clamp-3 mt-1">
                                {{ \Illuminate\Support\Str::limit($dosen->bio, 160) }}
                            </p>
                        @endif

                        {{-- Status --}}
                        @if($dosen->status)
                            @php
                                $statusColors = [
                                    'Ada'        => 'badge-success',
                                    'Mengajar'   => 'badge-warning',
                                    'Konsultasi' => 'badge-info',
                                    'Tidak Ada'  => 'badge-ghost',
                                ];
                                $statusColor = $statusColors[$dosen->status->status] ?? 'badge-ghost';
                            @endphp
                            <div class="mt-1 flex items-center gap-2">
                                <span class="badge {{ $statusColor }} badge-xs gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current animate-ping"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                </span>
                                <span class="text-[11px] uppercase tracking-wide text-base-content/60">
                                    {{ $dosen->status->status }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-base-300/60 my-1.5"></div>

                {{-- Link eksternal (Scholar / SINTA / Website) --}}
                <div class="flex flex-wrap items-center gap-2 text-[11px]">
                    @if($dosen->scholar_url)
                        <a href="{{ $dosen->scholar_url }}" target="_blank"
                           class="btn btn-ghost btn-xs gap-1.5 rounded-full hover:btn-primary hover:text-primary-content">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                            <span>Google Scholar</span>
                        </a>
                    @endif

                    @if($dosen->sinta_url)
                        <a href="{{ $dosen->sinta_url }}" target="_blank"
                           class="btn btn-ghost btn-xs gap-1.5 rounded-full hover:btn-secondary hover:text-secondary-content">
                            <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                            <span>SINTA / Portal Riset</span>
                        </a>
                    @endif

                    @if($dosen->website_url)
                        <a href="{{ $dosen->website_url }}" target="_blank"
                           class="btn btn-ghost btn-xs gap-1.5 rounded-full hover:btn-accent hover:text-accent-content">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent"></span>
                            <span>Website Portofolio</span>
                        </a>
                    @endif
                </div>

                {{-- QR SVG tersembunyi --}}
                <div id="qr-svg-{{ $dosen->id }}" class="hidden">
                    {!! $dosen->qr_svg !!}
                </div>

                {{-- Actions --}}
                <div class="mt-2 flex justify-between items-center gap-2">
                    <button type="button"
                            onclick="showQrModal({{ $dosen->id }}, '{{ $dosen->name }}')"
                            class="btn btn-xs md:btn-sm btn-outline gap-2 rounded-full
                                   transition-all duration-200
                                   group-hover:btn-primary group-hover:text-primary-content">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0
                                    001-1V5a1 1 0 00-1-1H5a1 1 0
                                    00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0
                                    001-1V5a1 1 0 00-1-1h-2a1 1 0
                                    00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0
                                    001-1v-2a1 1 0 00-1-1H5a1 1 0
                                    00-1 1v2a1 1 0 001 1z" />
                        </svg>
                        QR Code
                    </button>

                    <a href="{{ route('dosen.show', $dosen) }}"
                       class="btn btn-xs md:btn-sm btn-primary rounded-full gap-2">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0
                                    11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Detail
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach

    </div>
</section>

{{-- FEATURES SECTION --}}
<section id="features" class="py-20 bg-base-200">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-black mb-4">
                <span class="text-gradient">Fitur Unggulan</span>
            </h2>
            <p class="text-base-content/70 max-w-2xl mx-auto">
                Platform lengkap untuk kemudahan booking dan transparansi jadwal dosen
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Feature 1 --}}
            <div class="card bg-base-100 shadow-lg border-2 border-success/20 hover:border-success transition-colors">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-success/10 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Real-time Status</h3>
                    <p class="text-sm text-base-content/70">
                        Update status ketersediaan dosen secara langsung dan otomatis
                    </p>
                </div>
            </div>

            {{-- Feature 2 --}}
            <div class="card bg-base-100 shadow-lg border-2 border-primary/20 hover:border-primary transition-colors">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Jadwal Lengkap</h3>
                    <p class="text-sm text-base-content/70">
                        Lihat jadwal dosen secara detail per hari dan minggu
                    </p>
                </div>
            </div>

            {{-- Feature 3 --}}
            <div class="card bg-base-100 shadow-lg border-2 border-secondary/20 hover:border-secondary transition-colors">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-secondary/10 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Booking Online</h3>
                    <p class="text-sm text-base-content/70">
                        Ajukan konsultasi dengan dosen secara online tanpa ribet
                    </p>
                </div>
            </div>

            {{-- Feature 4 --}}
            <div class="card bg-base-100 shadow-lg border-2 border-accent/20 hover:border-accent transition-colors">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-accent/10 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">QR Code</h3>
                    <p class="text-sm text-base-content/70">
                        Akses cepat profil dosen dengan scan QR code
                    </p>
                </div>
            </div>

            {{-- Feature 5 --}}
            <div class="card bg-base-100 shadow-lg border-2 border-info/20 hover:border-info transition-colors">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-info/10 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Notifikasi</h3>
                    <p class="text-sm text-base-content/70">
                        Terima pemberitahuan status booking secara real-time
                    </p>
                </div>
            </div>

            {{-- Feature 6 --}}
            <div class="card bg-base-100 shadow-lg border-2 border-warning/20 hover:border-warning transition-colors">
                <div class="card-body items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-warning/10 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Aman & Terpercaya</h3>
                    <p class="text-sm text-base-content/70">
                        Data dan privasi Anda terjaga dengan sistem keamanan modern
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer footer-center p-10 bg-base-200 text-base-content border-t border-base-300">
    <div>
        <div class="flex items-center gap-2 mb-4">
            <div class="w-12 h-12 rounded-xl bg-gradient-primary flex items-center justify-center">
                <span class="text-2xl">📚</span>
            </div>
            <span class="text-xl font-bold">Lab WICIDA</span>
        </div>
        <p class="font-semibold max-w-md">
            Sistem Informasi Jadwal Dosen<br>
            Laboratorium Waste Integration for Clean and Innovative Development Alternatives
        </p>
        <p class="text-sm text-base-content/60">
            STMIK WICIDA 
        Samarinda
        </p>
    </div>
    <div>
        <div class="grid grid-flow-col gap-4">
            <a href="#" class="link link-hover">Tentang</a>
            <a href="#" class="link link-hover">Kontak</a>
            <a href="#" class="link link-hover">Bantuan</a>
            <a href="#" class="link link-hover">Privasi</a>
        </div>
    </div>
    <div>
        <p class="text-sm">
            © {{ date('Y') }} Lab WICIDA. All rights reserved.
        </p>
    </div>
</footer>

{{-- QR CODE MODAL --}}
<dialog id="qr-modal" class="modal">
    <div class="modal-box max-w-md">
        <form method="dialog">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
        </form>
        
        <h3 class="font-bold text-xl mb-2 flex items-center gap-2" id="qr-modal-title">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            QR Code Dosen
        </h3>
        <p class="text-sm text-base-content/60 mb-6" id="qr-modal-subtitle">
            Scan untuk booking konsultasi
        </p>
        
        {{-- QR Code Display --}}
        <div id="qr-modal-content" class="flex justify-center py-8 bg-base-200 rounded-xl mb-4">
            <div class="loading loading-spinner loading-lg text-primary"></div>
        </div>
        
        {{-- URL Display & Copy --}}
        <div class="form-control w-full mb-4">
            <label class="label">
                <span class="label-text font-semibold">Link Booking:</span>
            </label>
            <div class="join w-full">
                <input type="text" 
                       id="qr-url-display" 
                       readonly 
                       class="input input-bordered input-sm join-item flex-1 text-xs" 
                       value="">
                <button type="button"
                        onclick="copyUrlToClipboard()" 
                        class="btn btn-sm btn-primary join-item">
                    <svg id="copy-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </button>
            </div>
            <label class="label">
                <span id="copy-feedback" class="label-text-alt text-success hidden">
                    ✓ Link berhasil disalin!
                </span>
            </label>
        </div>
        
        {{-- Action Buttons --}}
        <div class="flex gap-2">
            <button type="button"
                    onclick="downloadQrCode()" 
                    class="btn btn-primary btn-sm flex-1 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download
            </button>
            <button type="button"
                    onclick="shareQrCode()" 
                    class="btn btn-secondary btn-sm flex-1 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367-2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
                Share
            </button>
        </div>
    </div>
    
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

{{-- JAVASCRIPT --}}
<script>
    // Theme toggle
    const html = document.documentElement;
    const toggle = document.getElementById('theme-toggle');
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    html.setAttribute('data-theme', savedTheme);
    if (toggle) {
        toggle.checked = savedTheme === 'dark';
        toggle.addEventListener('change', () => {
            const theme = toggle.checked ? 'dark' : 'light';
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        });
    }

    // QR Modal Variables
    let currentDosenId = null;
    let currentDosenName = '';
    let currentQrUrl = '';

    // Show QR Modal
    function showQrModal(dosenId, dosenName) {
        currentDosenId = dosenId;
        currentDosenName = dosenName;
        currentQrUrl = `{{ url('/dosen') }}/${dosenId}`;
        
        document.getElementById('qr-modal-title').innerHTML = `
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            ${dosenName}
        `;
        document.getElementById('qr-modal-subtitle').textContent =
            `Scan untuk booking konsultasi dengan ${dosenName}`;
        document.getElementById('qr-url-display').value = currentQrUrl;
        document.getElementById('copy-feedback').classList.add('hidden');

        // Ambil SVG dari container tersembunyi
        const svgContainer = document.getElementById('qr-svg-' + dosenId);
        if (!svgContainer) {
            document.getElementById('qr-modal-content').innerHTML = `
                <div class="text-center py-8">
                    <svg class="w-16 h-16 mx-auto text-error mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-error font-semibold">QR Code tidak tersedia</p>
                </div>
            `;
        } else {
            document.getElementById('qr-modal-content').innerHTML = `
                <div class="bg-white p-6 rounded-xl shadow-lg inline-block" id="qr-modal-display">
                    ${svgContainer.innerHTML}
                </div>
            `;
        }

        document.getElementById('qr-modal').showModal();
    }

    // Copy URL
    function copyUrlToClipboard() {
        const input = document.getElementById('qr-url-display');
        input.select();
        
        navigator.clipboard.writeText(input.value).then(() => {
            const feedback = document.getElementById('copy-feedback');
            const icon = document.getElementById('copy-icon');
            
            feedback.classList.remove('hidden');
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
            
            setTimeout(() => {
                feedback.classList.add('hidden');
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />';
            }, 2000);
        });
    }

    // Download QR (ambil SVG dari modal, convert ke PNG)
    function downloadQrCode() {
        const display = document.getElementById('qr-modal-display');
        if (!display) {
            alert('QR Code belum tersedia');
            return;
        }

        const svg = display.innerHTML;
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const img = new Image();

        const svgBlob = new Blob([svg], {type: 'image/svg+xml;charset=utf-8'});
        const url = URL.createObjectURL(svgBlob);

        img.onload = () => {
            const size = 500;
            canvas.width = size;
            canvas.height = size;
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, size, size);
            ctx.drawImage(img, 0, 0, size, size);

            canvas.toBlob(blob => {
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = `qrcode-${currentDosenName.replace(/\s+/g, '-')}.png`;
                link.click();
            });
        };

        img.onerror = () => {
            console.error('Failed to load QR for download');
            alert('Gagal memuat QR untuk diunduh. Silakan coba lagi.');
        };

        img.src = url;
    }

    // Share QR
    function shareQrCode() {
        if (navigator.share) {
            navigator.share({
                title: `Profil Dosen - ${currentDosenName}`,
                text: `Booking konsultasi dengan ${currentDosenName}`,
                url: currentQrUrl
            }).catch(() => copyUrlToClipboard());
        } else {
            copyUrlToClipboard();
            alert('Link berhasil disalin!');
        }
    }

    // Search & Filter (tetap seperti semula)
    const searchInput = document.getElementById('search-dosen');
    const sortSelect = document.getElementById('sort-dosen');
    const grid = document.getElementById('dosen-grid');
    const noResults = document.getElementById('no-results');

    function getDosenCards() {
    if (!grid) return [];
    return Array.from(grid.querySelectorAll('.dosen-card'));
}

    if (searchInput) {
        searchInput.addEventListener('input', filterDosen);
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', sortDosen);
    }

function filterDosen() {
    const search = (searchInput?.value || '').toLowerCase();
    const cards  = getDosenCards();
    let visible  = 0;

    cards.forEach(card => {
        const name = (card.dataset.dosenName || '').toLowerCase();
        if (name && name.includes(search)) {
            card.style.display = '';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    if (noResults && grid) {
        noResults.style.display = visible === 0 ? 'block' : 'none';
        grid.style.display      = visible === 0 ? 'none'  : 'grid';
    }
}


    function sortDosen() {
    const sort  = sortSelect?.value || '';
    const cards = getDosenCards();
    if (!sort || cards.length === 0) return;

    cards.sort((a, b) => {
        const nameA = (a.dataset.dosenName || '').toLowerCase();
        const nameB = (b.dataset.dosenName || '').toLowerCase();

        if (!nameA || !nameB) return 0;

        if (sort === 'name')      return nameA.localeCompare(nameB);
        if (sort === 'name-desc') return nameB.localeCompare(nameA);
        return 0;
    });

    cards.forEach(card => grid.appendChild(card));
}


    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offset = 80;
                window.scrollTo({
                    top: target.offsetTop - offset,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>


</body>
</html>
