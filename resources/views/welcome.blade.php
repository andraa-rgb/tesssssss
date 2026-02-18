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
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="hidden sm:inline">Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
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
<section id="dosen" class="py-20 bg-base-100">
    <div class="max-w-7xl mx-auto px-4">
        {{-- Section Header --}}
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-black mb-4">
                <span class="text-gradient">Daftar Dosen</span>
            </h2>
            <p class="text-base-content/70 max-w-2xl mx-auto">
                Pilih dosen untuk melihat jadwal lengkap dan melakukan booking konsultasi
            </p>
        </div>

        {{-- Search & Filter --}}
        <div class="mb-8 flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <div class="form-control">
                    <div class="input-group">
                        <span class="bg-base-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text" 
                               id="search-dosen"
                               placeholder="Cari nama dosen..." 
                               class="input input-bordered w-full" />
                    </div>
                </div>
            </div>
            <div class="form-control w-full md:w-64">
                <select id="sort-dosen" class="select select-bordered">
                    <option value="name">Urutkan: A-Z</option>
                    <option value="name-desc">Urutkan: Z-A</option>
                    <option value="status">Status: Tersedia</option>
                </select>
            </div>
        </div>

        {{-- Dosen Grid --}}
        <div id="dosen-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($dosens as $dosen)
                <div class="card bg-base-100 shadow-lg hover:shadow-2xl border border-base-300 card-hover-lift overflow-hidden transition-all duration-300"
                     data-dosen-name="{{ strtolower($dosen->name) }}"
                     data-dosen-id="{{ $dosen->id }}">
                    
                    {{-- Card Header with Gradient --}}
                    <div class="relative h-32 bg-gradient-to-br from-primary/20 to-secondary/20 overflow-hidden">
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white rounded-full -mr-16 -mt-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white rounded-full -ml-12 -mb-12"></div>
                        </div>
                        
                        {{-- Avatar --}}
                        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                            <div class="avatar">
                                @if($dosen->photo)
                                    <div class="w-24 rounded-full ring-4 ring-base-100 shadow-xl">
                                        <img src="{{ asset('storage/' . $dosen->photo) }}" alt="{{ $dosen->name }}">
                                    </div>
                                @else
                                    <div class="w-24 h-24 rounded-full ring-4 ring-base-100 shadow-xl bg-gradient-primary flex items-center justify-center text-primary-content">
                                        <span class="text-3xl font-bold">{{ substr($dosen->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body pt-16 items-center text-center">
                        {{-- Name & Role --}}
                        <h3 class="card-title text-lg mb-1">{{ $dosen->name }}</h3>
                        <div class="badge badge-primary badge-sm capitalize mb-2">
                            {{ str_replace('_', ' ', $dosen->role) }}
                        </div>
                        <p class="text-xs text-base-content/60 mb-4">{{ $dosen->nip ?? 'NIP belum diisi' }}</p>

                        {{-- Status Badge --}}
                        @if($dosen->status)
                            @php
                                $statusConfig = match($dosen->status->status) {
                                    'Ada' => ['badge' => 'badge-success', 'text' => 'Tersedia', 'icon' => '✓'],
                                    'Mengajar' => ['badge' => 'badge-warning', 'text' => 'Mengajar', 'icon' => '📚'],
                                    'Konsultasi' => ['badge' => 'badge-info', 'text' => 'Konsultasi', 'icon' => '💬'],
                                    'Tidak Ada' => ['badge' => 'badge-ghost', 'text' => 'Tidak Ada', 'icon' => '✕'],
                                    default => ['badge' => 'badge-ghost', 'text' => $dosen->status->status, 'icon' => '•'],
                                };
                            @endphp
                            <div class="badge {{ $statusConfig['badge'] }} badge-lg gap-2 mb-4">
                                <span class="status-dot w-2 h-2 rounded-full bg-current"></span>
                                {{ $statusConfig['icon'] }} {{ $statusConfig['text'] }}
                            </div>
                        @endif

                        {{-- Expertise --}}
                        @if($dosen->expertise)
                            <div class="w-full text-left mb-3">
                                <div class="text-xs font-semibold text-base-content/60 mb-1">Keahlian:</div>
                                <p class="text-sm line-clamp-2">{{ $dosen->expertise }}</p>
                            </div>
                        @endif

                        {{-- Bio --}}
                        @if($dosen->bio)
                            <div class="w-full text-left mb-3">
                                <div class="text-xs font-semibold text-base-content/60 mb-1">Tentang:</div>
                                <p class="text-sm text-base-content/70 line-clamp-3">{{ $dosen->bio }}</p>
                            </div>
                        @endif

                        {{-- Links --}}
                        @if($dosen->scholar_url || $dosen->sinta_url || $dosen->website_url)
                            <div class="divider my-2"></div>
                            <div class="flex flex-wrap gap-2 justify-center">
                                @if($dosen->scholar_url)
                                    <a href="{{ $dosen->scholar_url }}" target="_blank" 
                                       class="btn btn-xs btn-ghost gap-1 hover:btn-primary" 
                                       title="Google Scholar">
                                        🎓 Scholar
                                    </a>
                                @endif
                                @if($dosen->sinta_url)
                                    <a href="{{ $dosen->sinta_url }}" target="_blank" 
                                       class="btn btn-xs btn-ghost gap-1 hover:btn-secondary" 
                                       title="SINTA">
                                        📄 SINTA
                                    </a>
                                @endif
                                @if($dosen->website_url)
                                    <a href="{{ $dosen->website_url }}" target="_blank" 
                                       class="btn btn-xs btn-ghost gap-1 hover:btn-accent" 
                                       title="Website">
                                        🌐 Website
                                    </a>
                                @endif
                            </div>
                        @endif

                        {{-- Actions --}}
                        <div class="card-actions justify-between w-full mt-4 pt-4 border-t border-base-300">
                            <a href="{{ route('dosen.show', $dosen->id) }}" 
                               class="btn btn-primary btn-sm flex-1 gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Detail
                            </a>
                            
                            <button onclick="showQrModal({{ $dosen->id }}, '{{ addslashes($dosen->name) }}')"
                                    class="btn btn-square btn-outline btn-sm"
                                    title="QR Code">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Empty State --}}
        <div id="no-results" class="hidden text-center py-16">
            <div class="text-6xl mb-4 animate-float">🔍</div>
            <h3 class="text-xl font-bold mb-2">Tidak ada hasil</h3>
            <p class="text-base-content/70">Coba kata kunci pencarian lain</p>
        </div>

        @if($dosens->isEmpty())
            <div class="text-center py-16">
                <div class="text-6xl mb-4 animate-float">📭</div>
                <h3 class="text-xl font-bold mb-2">Belum ada data dosen</h3>
                <p class="text-base-content/70">Data dosen akan ditampilkan di sini</p>
            </div>
        @endif
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
                <button onclick="copyUrlToClipboard()" 
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
            <button onclick="downloadQrCode()" 
                    class="btn btn-primary btn-sm flex-1 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download
            </button>
            <button onclick="shareQrCode()" 
                    class="btn btn-secondary btn-sm flex-1 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
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
                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            ${dosenName}
        `;
        document.getElementById('qr-modal-subtitle').textContent = `Scan untuk booking konsultasi dengan ${dosenName}`;
        document.getElementById('qr-url-display').value = currentQrUrl;
        document.getElementById('qr-modal-content').innerHTML = '<div class="loading loading-spinner loading-lg text-primary"></div>';
        document.getElementById('copy-feedback').classList.add('hidden');
        
        document.getElementById('qr-modal').showModal();
        
        // Fetch QR Code
        fetch(`/api/qrcode/${dosenId}`)
            .then(res => {
                if (!res.ok) throw new Error('Failed to load QR');
                return res.text();
            })
            .then(svg => {
                document.getElementById('qr-modal-content').innerHTML = `
                    <div class="bg-white p-6 rounded-xl shadow-lg inline-block">
                        ${svg}
                    </div>
                `;
            })
            .catch(err => {
                document.getElementById('qr-modal-content').innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-error mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-error font-semibold">Gagal memuat QR Code</p>
                    </div>
                `;
                console.error('QR error:', err);
            });
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

    // Download QR
    function downloadQrCode() {
        fetch(`/api/qrcode/${currentDosenId}`)
            .then(res => res.text())
            .then(svg => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                
                const svgBlob = new Blob([svg], {type: 'image/svg+xml;charset=utf-8'});
                const url = URL.createObjectURL(svgBlob);
                
                img.onload = () => {
                    canvas.width = 500;
                    canvas.height = 500;
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, 500, 500);
                    ctx.drawImage(img, 0, 0, 500, 500);
                    
                    canvas.toBlob(blob => {
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = `qrcode-${currentDosenName.replace(/\s+/g, '-')}.png`;
                        link.click();
                    });
                };
                
                img.src = url;
            });
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

    // Search & Filter
    const searchInput = document.getElementById('search-dosen');
    const sortSelect = document.getElementById('sort-dosen');
    const grid = document.getElementById('dosen-grid');
    const noResults = document.getElementById('no-results');

    if (searchInput) {
        searchInput.addEventListener('input', filterDosen);
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', sortDosen);
    }

    function filterDosen() {
        const search = searchInput.value.toLowerCase();
        const cards = grid.querySelectorAll('.card');
        let visible = 0;
        
        cards.forEach(card => {
            const name = card.dataset.dosenName;
            if (name.includes(search)) {
                card.style.display = 'block';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });
        
        if (noResults) {
            noResults.style.display = visible === 0 ? 'block' : 'none';
            grid.style.display = visible === 0 ? 'none' : 'grid';
        }
    }

    function sortDosen() {
        const sort = sortSelect.value;
        const cards = Array.from(grid.querySelectorAll('.card'));
        
        cards.sort((a, b) => {
            const nameA = a.dataset.dosenName;
            const nameB = b.dataset.dosenName;
            
            if (sort === 'name') return nameA.localeCompare(nameB);
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
