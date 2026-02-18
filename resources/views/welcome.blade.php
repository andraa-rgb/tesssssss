<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Jadwal Dosen - Lab WICIDA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Animated gradient background */
        .animated-gradient {
            background: linear-gradient(-45deg, #570DF8, #F000B8, #37CDBE, #1FB2A6);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float 20s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(50px) scale(0.5);
                opacity: 0;
            }
        }

        /* Glowing effect */
        .glow {
            box-shadow: 0 0 20px rgba(87, 13, 248, 0.5),
                        0 0 40px rgba(87, 13, 248, 0.3),
                        0 0 60px rgba(87, 13, 248, 0.2);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 20px rgba(87, 13, 248, 0.5),
                            0 0 40px rgba(87, 13, 248, 0.3);
            }
            50% {
                box-shadow: 0 0 30px rgba(87, 13, 248, 0.8),
                            0 0 60px rgba(87, 13, 248, 0.5);
            }
        }

        /* Button hover effects */
        .btn-hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-hover-lift:active {
            transform: translateY(-2px);
        }

        /* Card hover effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Hero text animation */
        .fade-in-up {
            opacity: 0;
            animation: fadeInUp 1s ease-out forwards;
        }

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

        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }
        .delay-4 { animation-delay: 0.8s; }

        /* Ripple effect */
        .ripple {
            position: relative;
            overflow: hidden;
        }

        .ripple::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .ripple:active::after {
            width: 300px;
            height: 300px;
        }

        /* Starfield background */
        .stars {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle 3s infinite ease-in-out;
        }

        @keyframes twinkle {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 1; }
        }
    </style>
</head>
<body class="min-h-screen bg-base-200 overflow-x-hidden">

{{-- NAVBAR DENGAN BLUR EFFECT --}}
<div class="navbar bg-base-100/80 backdrop-blur-lg shadow-lg sticky top-0 z-50 border-b border-base-300">
    <div class="max-w-7xl mx-auto w-full px-4">
        <div class="flex-1">
            <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl gap-2 btn-hover-lift ripple">
                <span class="text-3xl animate-bounce">📚</span>
                <span class="font-black bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                    Lab WICIDA
                </span>
            </a>
        </div>
        <div class="flex-none gap-2">
            <a href="#dosen" class="btn btn-ghost btn-sm btn-hover-lift">
                <span class="hidden md:inline">Dosen</span>
                <span class="md:hidden">👨‍🏫</span>
            </a>
            <a href="#features" class="btn btn-ghost btn-sm btn-hover-lift">
                <span class="hidden md:inline">Fitur</span>
                <span class="md:hidden">⚡</span>
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm btn-hover-lift ripple gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm btn-hover-lift ripple">
                    Login Dosen
                </a>
            @endauth
            
            {{-- Theme Toggle --}}
            <label class="swap swap-rotate btn btn-ghost btn-circle btn-sm">
                <input type="checkbox" id="theme-toggle" />
                <svg class="swap-on fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z"/></svg>
                <svg class="swap-off fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z"/></svg>
            </label>
        </div>
    </div>
</div>

{{-- HERO SECTION DENGAN ANIMASI --}}
<section id="home" class="relative min-h-screen flex items-center justify-center animated-gradient overflow-hidden">
    {{-- Animated particles --}}
    <div class="particles">
        <div class="particle" style="width: 10px; height: 10px; left: 10%; animation-delay: 0s;"></div>
        <div class="particle" style="width: 15px; height: 15px; left: 20%; animation-delay: 2s;"></div>
        <div class="particle" style="width: 8px; height: 8px; left: 30%; animation-delay: 4s;"></div>
        <div class="particle" style="width: 12px; height: 12px; left: 40%; animation-delay: 1s;"></div>
        <div class="particle" style="width: 10px; height: 10px; left: 50%; animation-delay: 3s;"></div>
        <div class="particle" style="width: 14px; height: 14px; left: 60%; animation-delay: 5s;"></div>
        <div class="particle" style="width: 9px; height: 9px; left: 70%; animation-delay: 2.5s;"></div>
        <div class="particle" style="width: 11px; height: 11px; left: 80%; animation-delay: 4.5s;"></div>
        <div class="particle" style="width: 13px; height: 13px; left: 90%; animation-delay: 1.5s;"></div>
    </div>

    {{-- Starfield --}}
    <div class="stars">
        <div class="star" style="width: 2px; height: 2px; top: 20%; left: 15%; animation-delay: 0s;"></div>
        <div class="star" style="width: 3px; height: 3px; top: 30%; left: 25%; animation-delay: 1s;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 40%; left: 35%; animation-delay: 2s;"></div>
        <div class="star" style="width: 3px; height: 3px; top: 50%; left: 45%; animation-delay: 0.5s;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 60%; left: 55%; animation-delay: 1.5s;"></div>
        <div class="star" style="width: 3px; height: 3px; top: 70%; left: 65%; animation-delay: 2.5s;"></div>
        <div class="star" style="width: 2px; height: 2px; top: 25%; left: 75%; animation-delay: 3s;"></div>
        <div class="star" style="width: 3px; height: 3px; top: 35%; left: 85%; animation-delay: 1.2s;"></div>
    </div>

    <div class="max-w-5xl mx-auto text-center px-4 relative z-10">
        <div class="mb-8 fade-in-up">
            <div class="inline-block p-8 bg-base-100/90 backdrop-blur-xl rounded-full shadow-2xl glow">
                <span class="text-8xl animate-pulse">📅</span>
            </div>
        </div>
        
        <h1 class="text-4xl md:text-6xl lg:text-7xl font-black mb-6 fade-in-up delay-1">
            <span class="text-white drop-shadow-lg">Sistem Jadwal Dosen</span>
            <span class="block text-white mt-2 drop-shadow-lg">
                Lab WICIDA
            </span>
        </h1>
        
        <p class="text-lg md:text-2xl text-white/90 mb-10 max-w-3xl mx-auto drop-shadow-md fade-in-up delay-2">
            Transparansi jadwal dan booking konsultasi dosen secara real-time dengan teknologi modern.
        </p>
        
        <div class="flex flex-wrap justify-center gap-4 mb-12 fade-in-up delay-3">
            <a href="#dosen" class="btn btn-lg bg-white text-primary hover:bg-white/90 border-0 btn-hover-lift ripple gap-3 shadow-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Lihat Jadwal Dosen
            </a>
            <a href="#features" class="btn btn-lg btn-outline text-white border-white hover:bg-white hover:text-primary btn-hover-lift ripple gap-3 shadow-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Lihat Fitur
            </a>
        </div>

        <div class="stats stats-vertical md:stats-horizontal bg-base-100/90 backdrop-blur-xl shadow-2xl border-2 border-white/20 fade-in-up delay-4">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="stat-title font-semibold">Dosen Aktif</div>
                <div class="stat-value text-primary">{{ \App\Models\User::whereIn('role',['kepala_lab','staf'])->count() }}</div>
                <div class="stat-desc">Siap melayani konsultasi</div>
            </div>
            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="stat-title font-semibold">Jadwal Tersedia</div>
                <div class="stat-value text-secondary">{{ \App\Models\Jadwal::count() }}</div>
                <div class="stat-desc">Minggu ini</div>
            </div>
            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div class="stat-title font-semibold">Booking Aktif</div>
                <div class="stat-value text-accent">{{ \App\Models\Booking::whereIn('status',['pending','approved'])->count() }}</div>
                <div class="stat-desc">Sedang diproses</div>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="mt-16 fade-in-up delay-4">
            <a href="#dosen" class="inline-block animate-bounce">
                <svg class="w-8 h-8 text-white drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- DOSEN SECTION --}}
<section id="dosen" class="py-20 bg-base-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-black mb-4 bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                Dosen Lab WICIDA
            </h2>
            <p class="text-lg text-base-content/70 max-w-2xl mx-auto">
                Pilih dosen untuk melihat jadwal lengkap dan booking konsultasi
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($dosens as $dosen)
                <div class="card bg-base-100 shadow-xl border border-base-300 card-hover overflow-hidden">
                    {{-- Header dengan gradient --}}
                    <div class="bg-gradient-to-br from-primary/10 to-secondary/10 p-6 pb-16 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-secondary/10 rounded-full -ml-12 -mb-12"></div>
                        
                        <div class="relative flex flex-col items-center text-center">
                            {{-- Avatar --}}
                            <div class="avatar mb-4">
                                @if($dosen->photo)
                                    <div class="w-24 rounded-full ring-4 ring-white shadow-xl">
                                        <img src="{{ asset('storage/' . $dosen->photo) }}" alt="{{ $dosen->name }}">
                                    </div>
                                @else
                                    <div class="bg-gradient-to-br from-primary to-secondary text-primary-content rounded-full w-24 h-24 ring-4 ring-white shadow-xl flex items-center justify-center">
                                        <span class="text-4xl font-bold">{{ substr($dosen->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Nama & Role --}}
                            <h3 class="font-bold text-xl mb-1">{{ $dosen->name }}</h3>
                            <div class="badge badge-primary badge-sm capitalize mb-2">
                                {{ str_replace('_', ' ', $dosen->role) }}
                            </div>
                            <p class="text-xs text-base-content/60">{{ $dosen->nip ?? 'NIP belum diisi' }}</p>
                        </div>
                    </div>

                    <div class="card-body pt-6 -mt-10 relative z-10">
                        {{-- Status Badge --}}
                        @if($dosen->status)
                            @php
                                $statusColors = [
                                    'Ada' => ['badge' => 'badge-success', 'text' => 'Tersedia'],
                                    'Mengajar' => ['badge' => 'badge-warning', 'text' => 'Sedang Mengajar'],
                                    'Konsultasi' => ['badge' => 'badge-info', 'text' => 'Sedang Konsultasi'],
                                    'Tidak Ada' => ['badge' => 'badge-ghost', 'text' => 'Tidak Tersedia'],
                                ];
                                $statusConfig = $statusColors[$dosen->status->status] ?? ['badge' => 'badge-ghost', 'text' => $dosen->status->status];
                            @endphp
                            <div class="flex justify-center mb-4">
                                <div class="badge {{ $statusConfig['badge'] }} badge-lg gap-2 shadow-md">
                                    <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                                    {{ $statusConfig['text'] }}
                                </div>
                            </div>
                        @endif

                        {{-- Bidang Keahlian --}}
                        @if($dosen->expertise)
                            <div class="mb-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                    <span class="font-semibold text-sm">Keahlian</span>
                                </div>
                                <p class="text-sm text-base-content/70 line-clamp-2">
                                    {{ $dosen->expertise }}
                                </p>
                            </div>
                        @endif

                        {{-- Bio --}}
                        @if($dosen->bio)
                            <div class="mb-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-semibold text-sm">Tentang</span>
                                </div>
                                <p class="text-sm text-base-content/70 line-clamp-3">
                                    {{ $dosen->bio }}
                                </p>
                            </div>
                        @endif

                        {{-- Links Riset --}}
                        @if($dosen->scholar_url || $dosen->sinta_url || $dosen->website_url)
                            <div class="divider my-2"></div>
                            <div class="flex flex-wrap gap-2 justify-center">
                                @if($dosen->scholar_url)
                                    <a href="{{ $dosen->scholar_url }}" target="_blank" 
                                       class="btn btn-xs btn-outline gap-1" title="Google Scholar">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 24a7 7 0 110-14 7 7 0 010 14zm0-24L0 9.5l4.838 3.94A8 8 0 0112 9a8 8 0 017.162 4.44L24 9.5z"/>
                                        </svg>
                                        Scholar
                                    </a>
                                @endif
                                @if($dosen->sinta_url)
                                    <a href="{{ $dosen->sinta_url }}" target="_blank" 
                                       class="btn btn-xs btn-outline gap-1" title="SINTA">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        SINTA
                                    </a>
                                @endif
                                @if($dosen->website_url)
                                    <a href="{{ $dosen->website_url }}" target="_blank" 
                                       class="btn btn-xs btn-outline gap-1" title="Website">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                        </svg>
                                        Website
                                    </a>
                                @endif
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="card-actions justify-between items-center mt-4 pt-4 border-t border-base-300">
                            <a href="{{ route('dosen.show', $dosen->id) }}" 
                               class="btn btn-primary btn-sm btn-hover-lift ripple gap-2 flex-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Detail & Booking
                            </a>
                            
                            <button onclick="showQrModal({{ $dosen->id }}, '{{ addslashes($dosen->name) }}')"
                                    class="btn btn-square btn-outline btn-sm btn-hover-lift ripple"
                                    title="Lihat QR Code">
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

        @if($dosens->isEmpty())
            <div class="text-center py-16">
                <div class="text-6xl mb-4">📭</div>
                <p class="text-lg text-base-content/70">Belum ada data dosen tersedia.</p>
            </div>
        @endif
    </div>
</section>


{{-- FEATURES SECTION --}}
<section id="features" class="py-20 bg-gradient-to-br from-base-200 to-base-300">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-black mb-4 bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">
                Fitur Unggulan
            </h2>
            <p class="text-lg text-base-content/70 max-w-2xl mx-auto">
                Sistem modern yang memudahkan interaksi antara dosen dan mahasiswa
            </p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {{-- Feature 1 --}}
            <div class="card bg-base-100 shadow-xl card-hover border-2 border-success/20">
                <div class="card-body items-center text-center">
                    <div class="mb-4 p-6 bg-success/10 rounded-full">
                        <svg class="w-12 h-12 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-xl mb-2">Status Real-time</h3>
                    <p class="text-base-content/70">
                        Pantau ketersediaan dosen secara langsung dengan update otomatis setiap 30 detik.
                    </p>
                </div>
            </div>

            {{-- Feature 2 --}}
            <div class="card bg-base-100 shadow-xl card-hover border-2 border-primary/20">
                <div class="card-body items-center text-center">
                    <div class="mb-4 p-6 bg-primary/10 rounded-full">
                        <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-xl mb-2">Jadwal Terstruktur</h3>
                    <p class="text-base-content/70">
                        Jadwal per hari, per jam, dan per kegiatan tersusun rapi dan mudah diakses.
                    </p>
                </div>
            </div>

            {{-- Feature 3 --}}
            <div class="card bg-base-100 shadow-xl card-hover border-2 border-secondary/20">
                <div class="card-body items-center text-center">
                    <div class="mb-4 p-6 bg-secondary/10 rounded-full">
                        <svg class="w-12 h-12 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="card-title text-xl mb-2">Booking Konsultasi</h3>
                    <p class="text-base-content/70">
                        Mahasiswa dapat mengajukan konsultasi online dengan mudah dan cepat.
                    </p>
                </div>
            </div>

            {{-- Feature 4 --}}
            <div class="card bg-base-100 shadow-xl card-hover border-2 border-accent/20">
                <div class="card-body items-center text-center">
                    <div class="mb-4 p-6 bg-accent/10 rounded-full">
                        <svg class="w-12 h-12 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-xl mb-2">QR Code Profil</h3>
                    <p class="text-base-content/70">
                        Setiap dosen memiliki QR code unik untuk akses cepat ke halaman profil.
                    </p>
                </div>
            </div>

            {{-- Feature 5 --}}
            <div class="card bg-base-100 shadow-xl card-hover border-2 border-warning/20">
                <div class="card-body items-center text-center">
                    <div class="mb-4 p-6 bg-warning/10 rounded-full">
                        <svg class="w-12 h-12 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-xl mb-2">Responsive Design</h3>
                    <p class="text-base-content/70">
                        Tampilan optimal di semua perangkat: desktop, tablet, dan smartphone.
                    </p>
                </div>
            </div>

            {{-- Feature 6 --}}
            <div class="card bg-base-100 shadow-xl card-hover border-2 border-info/20">
                <div class="card-body items-center text-center">
                    <div class="mb-4 p-6 bg-info/10 rounded-full">
                        <svg class="w-12 h-12 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-xl mb-2">Dark Mode</h3>
                    <p class="text-base-content/70">
                        Toggle tema terang dan gelap sesuai preferensi untuk kenyamanan mata.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA SECTION --}}
<section class="py-20 bg-gradient-to-r from-primary to-secondary text-white">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h2 class="text-3xl md:text-5xl font-black mb-6">
            Siap Booking Konsultasi?
        </h2>
        <p class="text-lg md:text-xl mb-8 text-white/90">
            Pilih dosen, lihat jadwal, dan ajukan konsultasi dalam hitungan detik.
        </p>
        <a href="#dosen" class="btn btn-lg bg-white text-primary hover:bg-white/90 border-0 btn-hover-lift ripple gap-3 shadow-2xl">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
            </svg>
            Mulai Sekarang
        </a>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer footer-center p-10 bg-base-100 text-base-content border-t border-base-300">
    <div>
        <div class="flex items-center gap-2 mb-2">
            <span class="text-3xl">📚</span>
            <span class="font-black text-2xl bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">
                Lab WICIDA
            </span>
        </div>
        <p class="font-semibold">
            Sistem Jadwal Dosen & Booking Konsultasi
        </p>
        <p class="text-sm text-base-content/60">
            Universitas Mulawarman - Fakultas Ilmu Komputer dan Teknologi Informasi
        </p>
    </div>
    <div>
        <div class="grid grid-flow-col gap-4">
            <a href="#" class="btn btn-ghost btn-circle btn-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
            </a>
            <a href="#" class="btn btn-ghost btn-circle btn-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
            </a>
            <a href="#" class="btn btn-ghost btn-circle btn-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
            </a>
        </div>
    </div>
    <div>
        <p class="text-xs text-base-content/60">
            © {{ date('Y') }} Lab WICIDA. Dibuat dengan ❤️ menggunakan Laravel & DaisyUI.
        </p>
    </div>
</footer>

{{-- QR CODE MODAL (VERSI PREMIUM) --}}
<dialog id="qr-modal" class="modal">
    <div class="modal-box max-w-lg p-0 overflow-hidden">
        {{-- Header dengan gradient --}}
        <div class="bg-gradient-to-r from-primary to-secondary text-white p-6 text-center relative overflow-hidden">
            {{-- Animated background particles --}}
            <div class="absolute inset-0 opacity-20">
                <div class="absolute w-32 h-32 bg-white rounded-full -top-16 -left-16 animate-pulse"></div>
                <div class="absolute w-24 h-24 bg-white rounded-full -bottom-12 -right-12 animate-pulse delay-700"></div>
            </div>
            
            <div class="relative z-10">
                <div class="inline-block p-3 bg-white/20 backdrop-blur-sm rounded-full mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
                <h3 class="font-black text-2xl mb-1" id="qr-modal-title">QR Code</h3>
                <p class="text-white/80 text-sm" id="qr-modal-subtitle">Scan untuk booking konsultasi</p>
            </div>
        </div>

        {{-- QR Code Content --}}
        <div class="p-8">
            <div class="bg-gradient-to-br from-base-200 to-base-300 p-6 rounded-2xl shadow-inner mb-6" id="qr-modal-content">
                <div class="loading loading-spinner loading-lg text-primary mx-auto"></div>
            </div>

            {{-- URL Display --}}
            <div class="bg-base-200 rounded-lg p-4 mb-6">
                <label class="label">
                    <span class="label-text font-semibold text-xs uppercase tracking-wide">Link Profil Dosen</span>
                </label>
                <div class="flex gap-2">
                    <input type="text" 
                           id="qr-url-display" 
                           class="input input-bordered input-sm flex-1 text-xs font-mono"
                           readonly>
                    <button onclick="copyUrlToClipboard()" 
                            class="btn btn-sm btn-square btn-primary"
                            title="Salin Link">
                        <svg id="copy-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
                <p id="copy-feedback" class="text-xs text-success mt-2 hidden">
                    ✓ Link berhasil disalin!
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="grid grid-cols-2 gap-3">
                <button onclick="downloadQrCode()" 
                        class="btn btn-outline btn-primary gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </button>
                
                <button onclick="shareQrCode()" 
                        class="btn btn-primary gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                    </svg>
                    Bagikan
                </button>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 pb-6">
            <form method="dialog">
                <button class="btn btn-ghost btn-block btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Tutup
                </button>
            </form>
        </div>
    </div>
    
    {{-- Backdrop --}}
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

{{-- SCRIPTS --}}
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

    // Global variables untuk QR modal
    let currentDosenId = null;
    let currentDosenName = '';
    let currentQrUrl = '';

    // QR Modal - Show & Load
    function showQrModal(dosenId, dosenName) {
        currentDosenId = dosenId;
        currentDosenName = dosenName;
        currentQrUrl = `{{ url('/dosen') }}/${dosenId}`;
        
        // Update modal content
        document.getElementById('qr-modal-title').textContent = dosenName;
        document.getElementById('qr-modal-subtitle').textContent = `Scan untuk booking konsultasi dengan ${dosenName}`;
        document.getElementById('qr-url-display').value = currentQrUrl;
        document.getElementById('qr-modal-content').innerHTML = '<div class="loading loading-spinner loading-lg text-primary mx-auto"></div>';
        
        // Reset feedback
        document.getElementById('copy-feedback').classList.add('hidden');
        
        // Open modal
        document.getElementById('qr-modal').showModal();
        
        // Fetch QR code
        fetch(`/api/qrcode/${dosenId}`)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.text();
            })
            .then(svg => {
                // Wrap SVG dengan styling
                document.getElementById('qr-modal-content').innerHTML = `
                    <div class="flex justify-center">
                        <div class="bg-white p-4 rounded-xl shadow-lg inline-block">
                            ${svg}
                        </div>
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
                        <p class="text-error font-semibold mb-2">Gagal Memuat QR Code</p>
                        <p class="text-xs text-base-content/60">Silakan coba lagi nanti</p>
                    </div>
                `;
                console.error('QR Code error:', err);
            });
    }

    // Copy URL to clipboard
    function copyUrlToClipboard() {
        const input = document.getElementById('qr-url-display');
        input.select();
        input.setSelectionRange(0, 99999); // For mobile
        
        navigator.clipboard.writeText(input.value).then(() => {
            // Show success feedback
            const feedback = document.getElementById('copy-feedback');
            const copyIcon = document.getElementById('copy-icon');
            
            feedback.classList.remove('hidden');
            copyIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            `;
            
            // Reset after 2 seconds
            setTimeout(() => {
                feedback.classList.add('hidden');
                copyIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                `;
            }, 2000);
        }).catch(err => {
            console.error('Failed to copy:', err);
            alert('Gagal menyalin link. Silakan copy manual.');
        });
    }

    // Download QR Code as PNG
    function downloadQrCode() {
        if (!currentDosenId) return;
        
        // Create a temporary link to download
        const downloadUrl = `/profile/qrcode/download?dosen_id=${currentDosenId}`;
        const link = document.createElement('a');
        link.href = downloadUrl;
        link.download = `qrcode-${currentDosenName.replace(/\s+/g, '-')}.png`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        // Alternative: Download via API fetch
        fetch(`/api/qrcode/${currentDosenId}`)
            .then(res => res.text())
            .then(svg => {
                // Convert SVG to PNG using canvas
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                
                const svgBlob = new Blob([svg], {type: 'image/svg+xml;charset=utf-8'});
                const url = URL.createObjectURL(svgBlob);
                
                img.onload = () => {
                    canvas.width = 400;
                    canvas.height = 400;
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0, 400, 400);
                    
                    canvas.toBlob(blob => {
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = `qrcode-${currentDosenName.replace(/\s+/g, '-')}.png`;
                        link.click();
                        URL.revokeObjectURL(url);
                    });
                };
                
                img.src = url;
            })
            .catch(err => {
                console.error('Download error:', err);
                alert('Gagal mendownload QR Code. Silakan screenshot manual.');
            });
    }

    // Share QR Code via Web Share API
    function shareQrCode() {
        const shareData = {
            title: `Profil Dosen - ${currentDosenName}`,
            text: `Booking konsultasi dengan ${currentDosenName} melalui Lab WICIDA`,
            url: currentQrUrl
        };
        
        if (navigator.share) {
            navigator.share(shareData)
                .then(() => console.log('Share successful'))
                .catch(err => console.error('Share failed:', err));
        } else {
            // Fallback: Copy to clipboard
            copyUrlToClipboard();
            alert('Link profil dosen berhasil disalin! Anda bisa paste ke WhatsApp, Email, atau media sosial lainnya.');
        }
    }

    // Smooth scroll with offset
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const offset = 80;
                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>

</body>
</html>
