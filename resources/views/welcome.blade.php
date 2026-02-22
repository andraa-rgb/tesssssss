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
        /* Animations & helpers (tetap) */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%,100%{transform:translateY(0)}50%{transform:translateY(-15px)} }
        @keyframes pulse-slow { 0%,100%{opacity:1}50%{opacity:.8} }
        @keyframes status-pulse { 0%,100%{opacity:1;transform:scale(1)}50%{opacity:.5;transform:scale(1.2)} }

        .animate-fadeInUp { animation: fadeInUp .6s ease-out; }
        .animate-fadeIn { animation: fadeIn .8s ease-out; }
        .animate-float { animation: float 3s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
        .status-dot { animation: status-pulse 2s ease-in-out infinite; }

        html { scroll-behavior: smooth; }

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
<header class="navbar bg-base-100/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-base-300">
    <div class="max-w-7xl mx-auto w-full px-4 flex items-center justify-between gap-3">
        <div class="flex-1">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 hover:opacity-90 transition">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-base-100 shadow">
                    <span class="text-2xl">📚</span>
                </div>
                <div class="flex flex-col items-start leading-tight">
                    <span class="font-bold text-sm sm:text-base text-base-content">Lab WICIDA</span>
                    <span class="text-[10px] sm:text-xs text-base-content/60">Sistem Jadwal Dosen</span>
                </div>
            </a>
        </div>

        <div class="flex items-center gap-2 sm:gap-3">
            <a href="#dosen" class="btn btn-ghost btn-sm hidden md:inline-flex">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2
                             c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0
                             015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                             m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0
                             11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0
                             2 2 0 014 0zM7 10a2 2 0 11-4 0
                             2 2 0 014 0z" />
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
                <svg class="swap-on fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24">
                    <path
                        d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,
                           0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,
                           12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,
                           0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,
                           0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,
                           0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,
                           0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,
                           .29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,
                           0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,
                           0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,
                           0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,
                           0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,
                           19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,
                           1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,
                           6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,
                           0,0,12,6.5Z" />
                </svg>
                <svg class="swap-off fill-current w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24">
                    <path
                        d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,
                           0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,
                           5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,
                           0,8,2.36,10.14,10.14,0,1,0,22,
                           14.05,1,1,0,0,0,21.64,13Zm-9.5,
                           6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,
                           10.15,0,0,0,17.22,15.63a9.79,9.79,
                           0,0,0,2.1-.22A8.11,8.11,0,0,
                           1,12.14,19.73Z" />
                </svg>
            </label>
        </div>
    </div>
</header>

{{-- HERO SECTION --}}
<section class="relative overflow-hidden bg-gradient-to-br from-primary/10 via-secondary/10 to-accent/10 py-16 md:py-24">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-pulse-slow"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-14 items-center">
            {{-- Left --}}
            <div class="text-center lg:text-left">
                <div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full text-xs sm:text-sm font-medium mb-5 animate-fadeIn">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    Real-time Status Update
                </div>

                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-black mb-4 sm:mb-6 animate-fadeInUp">
                    <span class="block text-base-content">Sistem Jadwal Dosen</span>
                    <span class="block text-gradient mt-1">Lab WICIDA</span>
                </h1>

                <p class="text-sm sm:text-base md:text-lg text-base-content/70 mb-6 sm:mb-8 max-w-xl mx-auto lg:mx-0 animate-fadeInUp delay-100">
                    Platform modern untuk transparansi jadwal dan booking konsultasi dosen secara online dengan update real-time.
                </p>

                <div class="flex flex-wrap gap-3 sm:gap-4 justify-center lg:justify-start animate-fadeInUp delay-200">
                    <a href="#dosen" class="btn btn-primary btn-md sm:btn-lg gap-2 shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0
                                     00-5.356-1.857M17 20H7m10 0v-2
                                     c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0
                                     015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                                     m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0
                                     11-6 0 3 3 0 016 0zm6 3a2 2 0
                                     11-4 0 2 2 0 014 0zM7 10a2 2 0
                                     11-4 0 2 2 0 014 0z" />
                        </svg>
                        Lihat Jadwal Dosen
                    </a>
                    <a href="#features" class="btn btn-outline btn-md sm:btn-lg gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Fitur Unggulan
                    </a>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-3 sm:gap-4 mt-8 sm:mt-10 animate-fadeInUp delay-300">
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-black text-primary">{{ $dosens->count() }}</div>
                        <div class="text-[11px] sm:text-xs text-base-content/60">Dosen</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-black text-secondary">{{ \App\Models\Jadwal::count() }}</div>
                        <div class="text-[11px] sm:text-xs text-base-content/60">Jadwal</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl sm:text-3xl font-black text-accent">{{ \App\Models\Booking::count() }}</div>
                        <div class="text-[11px] sm:text-xs text-base-content/60">Booking</div>
                    </div>
                </div>
            </div>

            {{-- Right: schedule card --}}
            <div class="hidden lg:block animate-fadeIn delay-300">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/40 via-secondary/40 to-accent/40 rounded-3xl opacity-20 blur-2xl animate-float"></div>
                    <div class="relative bg-base-100 rounded-3xl shadow-2xl p-6 lg:p-7">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-[10px] uppercase tracking-widest text-base-content/60">
                                    Jadwal Terdekat
                                </div>
                                <div class="text-sm font-semibold flex items-center gap-2 text-base-content">
                                    Live Activity
                                    <span class="inline-flex items-center gap-1 text-[10px] text-success">
                                        <span class="w-2 h-2 rounded-full bg-success animate-ping"></span>
                                        <span class="w-2 h-2 rounded-full bg-success -ml-3"></span>
                                        Online
                                    </span>
                                </div>
                            </div>
                            <div class="badge badge-outline badge-sm">
                                {{ now()->translatedFormat('d M Y') }}
                            </div>
                        </div>

                        <div id="schedule-slider" class="space-y-3">
                            @php $items = $upcomingSchedules ?? []; @endphp

                            @forelse($items as $index => $item)
                                @php
                                    $dosen = $item->user;
                                    $statusMap = [
                                        'Ada'        => ['label' => 'Siap Konsultasi', 'class' => 'badge-success'],
                                        'Mengajar'   => ['label' => 'Sedang Mengajar', 'class' => 'badge-warning'],
                                        'Konsultasi' => ['label' => 'Dalam Konsultasi', 'class' => 'badge-info'],
                                        'Tidak Ada'  => ['label' => 'Tidak Tersedia', 'class' => 'badge-ghost'],
                                    ];
                                    $statusKey  = $dosen?->status->status ?? 'Tidak Ada';
                                    $statusConf = $statusMap[$statusKey] ?? $statusMap['Tidak Ada'];
                                @endphp

                                <div class="schedule-slide {{ $index === 0 ? '' : 'hidden' }} transition-opacity duration-500">
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="w-11 h-11 rounded-xl bg-primary/10 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 8v4l3 3m6-3a9 9 0
                                                                 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-[11px] uppercase tracking-widest text-base-content/60">
                                                        {{ $item->hari }},
                                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $item->jam_mulai)->format('H:i') }}
                                                        – {{ \Carbon\Carbon::createFromFormat('H:i:s', $item->jam_selesai)->format('H:i') }}
                                                    </div>
                                                    <div class="text-xs font-semibold text-base-content">
                                                        {{ $item->kegiatan ?? 'Kegiatan Akademik' }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex flex-col items-end gap-1">
                                                <span class="badge {{ $statusConf['class'] }} badge-xs gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-current status-dot"></span>
                                                    {{ $statusConf['label'] }}
                                                </span>
                                                <span class="text-[10px] text-base-content/60">
                                                    Ruang: {{ $item->ruangan ?? '-' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 p-3 rounded-2xl bg-base-200/70 border border-base-300/60">
                                            <div class="avatar">
                                                @if($dosen?->photo)
                                                    <div class="w-10 h-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2 overflow-hidden">
                                                        <img src="{{ asset('storage/' . $dosen->photo) }}" alt="{{ $dosen->name }}">
                                                    </div>
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-secondary text-primary-content flex items-center justify-center text-sm font-semibold">
                                                        {{ substr($dosen->name ?? 'D', 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-semibold text-xs truncate">
                                                        {{ $dosen->name ?? 'Dosen Tidak Diketahui' }}
                                                    </p>
                                                    @if($dosen?->role === 'kepala_lab')
                                                        <span class="badge badge-primary badge-xs">Kepala Lab</span>
                                                    @else
                                                        <span class="badge badge-secondary badge-xs">Staf</span>
                                                    @endif
                                                </div>
                                                <p class="text-[10px] text-base-content/60 truncate">
                                                    {{ $dosen->expertise ?? 'Bidang keahlian belum diatur' }}
                                                </p>
                                            </div>
                                            @if($dosen)
                                                <button type="button"
                                                        onclick="showQrModal({{ $dosen->id }}, '{{ $dosen->name }}')"
                                                        class="btn btn-ghost btn-xs rounded-full gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M3 4h7v7H3V4zm0 9h7v7H3v-7zm11-9h7v7h-7V4zm0 9h7v7h-7v-7z" />
                                                    </svg>
                                                    QR
                                                </button>
                                            @endif
                                        </div>

                                        <div class="flex items-center justify-between text-[10px] text-base-content/60">
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
                                                             002-2V7a2 2 0 00-2-2H5a2 2 0
                                                             00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $item->hari }}
                                            </span>
                                            @if($dosen)
                                                <a href="{{ route('dosen.show', $dosen->id) }}"
                                                   class="link link-primary text-[10px] inline-flex items-center gap-1">
                                                    Detail Dosen
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-xs text-base-content/60 py-10">
                                    Belum ada jadwal terdekat yang terdaftar.
                                </div>
                            @endforelse
                        </div>

                        @if(!empty($items) && count($items) > 1)
                            <div class="mt-3 flex items-center justify-center gap-1.5">
                                @foreach($items as $i => $item)
                                    <button type="button"
                                            class="schedule-dot w-2 h-2 rounded-full {{ $i === 0 ? 'bg-primary' : 'bg-base-300' }}"
                                            data-index="{{ $i }}"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- DOSEN SECTION --}}
<section id="dosen" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold">Daftar Dosen</h2>
            <p class="text-xs sm:text-sm text-base-content/70 mt-1">
                Lihat profil, jadwal, dan status ketersediaan dosen Lab WICIDA.
            </p>
        </div>
        <div class="flex flex-wrap gap-2 items-center w-full sm:w-auto">
            <input
                id="search-dosen"
                type="text"
                placeholder="Cari nama atau email..."
                class="input input-sm input-bordered w-full sm:w-56 md:w-64"
            />
            <select
                id="sort-dosen"
                class="select select-sm select-bordered w-full sm:w-auto"
            >
                <option value="">Urutkan berdasarkan jabatan</option>
            </select>
        </div>
    </div>

    <div id="no-results" class="hidden text-center text-xs sm:text-sm text-base-content/60 py-8">
        Tidak ada dosen yang cocok dengan pencarian.
    </div>

    <div
        id="dosen-grid"
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6"
    >
        @foreach($dosens as $dosen)
            <article
                class="group relative dosen-card h-full"
                data-dosen-name="{{ strtolower($dosen->name) }}"
                data-dosen-role="{{ $dosen->role }}"
            >
                <div
                    class="card h-full bg-base-100 border border-base-300/80 shadow-sm
                           transition-all duration-300 ease-out
                           hover:-translate-y-1 hover:shadow-xl hover:border-primary/60
                           cursor-pointer overflow-hidden flex flex-col"
                >
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

                    <div class="card-body gap-3 flex flex-col">
                        <div class="flex items-start gap-3">
                            <div class="relative shrink-0">
                                <div
                                    class="rounded-full p-[2px]
                                           bg-gradient-to-br from-primary/70 via-secondary/70 to-accent/70
                                           transition-all duration-300
                                           group-hover:from-primary group-hover:via-secondary group-hover:to-accent"
                                >
                                    <div class="avatar">
                                        @if($dosen->photo)
                                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-base-100 shadow-inner overflow-hidden">
                                                <img src="{{ asset('storage/' . $dosen->photo) }}" alt="{{ $dosen->name }}">
                                            </div>
                                        @else
                                            <div
                                                class="w-14 h-14 sm:w-16 sm:h-16 rounded-full
                                                       bg-gradient-to-br from-primary to-secondary
                                                       text-primary-content flex items-center justify-center
                                                       text-xl sm:text-2xl font-bold"
                                            >
                                                {{ substr($dosen->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0 space-y-1">
                                <h3 class="font-semibold text-sm sm:text-base md:text-lg truncate">
                                    {{ $dosen->name }}
                                </h3>

                                <div class="flex flex-col gap-0.5 text-[11px] sm:text-xs text-base-content/70">
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

                                @if($dosen->expertise)
                                    <p class="text-xs sm:text-sm text-base-content/80 font-medium mt-1 line-clamp-2">
                                        {{ $dosen->expertise }}
                                    </p>
                                @endif

                                @if($dosen->bio)
                                    <p class="text-[11px] sm:text-xs text-base-content/70 line-clamp-3 mt-1">
                                        {{ \Illuminate\Support\Str::limit($dosen->bio, 160) }}
                                    </p>
                                @endif

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

                        <div class="border-t border-base-300/60 my-2"></div>

                        <div class="flex flex-wrap items-center gap-2 text-[11px] sm:text-xs">
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

                        {{-- Bagian tombol ditempel ke bawah card agar semua tinggi card sama --}}
                        <div class="mt-auto pt-3 flex flex-col sm:flex-row gap-2">
                            <a href="{{ route('dosen.show', $dosen->id) }}"
                               class="btn btn-primary btn-sm flex-1 gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0
                                             018 0zM12 14a7 7 0 00-7 7h14a7 7 0
                                             00-7-7z" />
                                </svg>
                                Lihat Profil
                            </a>
                            <button
                                type="button"
                                onclick="showQrModal({{ $dosen->id }}, '{{ $dosen->name }}')"
                                class="btn btn-outline btn-sm gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        </div>

                        <div id="qr-svg-{{ $dosen->id }}" class="hidden">
                            {!! $dosen->qr_svg !!}
                        </div>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>

{{-- FEATURES SECTION --}}
<section id="features" class="py-16 sm:py-20 bg-base-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10 sm:mb-12">
            <h2 class="text-3xl md:text-4xl font-black mb-3">
                <span class="text-gradient">Fitur Unggulan</span>
            </h2>
            <p class="text-sm sm:text-base text-base-content/70 max-w-2xl mx-auto">
                Platform lengkap untuk kemudahan booking dan transparansi jadwal dosen.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            {{-- Feature 1 --}}
            <article class="card bg-base-100 h-full shadow-md border border-success/20 hover:border-success transition-colors">
                <div class="card-body items-center text-center space-y-3">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-success/10 flex items-center justify-center">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-base sm:text-lg mb-1">Real-time Status</h3>
                    <p class="text-xs sm:text-sm text-base-content/70">
                        Status ketersediaan dosen selalu terupdate sehingga mahasiswa dapat melihat kapan dosen siap konsultasi.
                    </p>
                </div>
            </article>

            {{-- Feature 2 --}}
            <article class="card bg-base-100 h-full shadow-md border border-primary/20 hover:border-primary transition-colors">
                <div class="card-body items-center text-center space-y-3">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-primary/10 flex items-center justify-center">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
                                     002-2V7a2 2 0 00-2-2H5a2 2 0
                                     00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-base sm:text-lg mb-1">Jadwal Lengkap</h3>
                    <p class="text-xs sm:text-sm text-base-content/70">
                        Lihat jadwal mengajar dan konsultasi dosen secara detail, per hari dan per minggu.
                    </p>
                </div>
            </article>

            {{-- Feature 3 --}}
            <article class="card bg-base-100 h-full shadow-md border border-secondary/20 hover:border-secondary transition-colors">
                <div class="card-body items-center text-center space-y-3">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-secondary/10 flex items-center justify-center">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0
                                     00-2 2v12a2 2 0
                                     002 2h10a2 2 0
                                     002-2V7a2 2 0
                                     00-2-2h-2M9 5a2 2 0
                                     002 2h2a2 2 0
                                     002-2M9 5a2 2 0
                                     012-2h2a2 2 0
                                     012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="card-title text-base sm:text-lg mb-1">Booking Online</h3>
                    <p class="text-xs sm:text-sm text-base-content/70">
                        Ajukan konsultasi tanpa perlu datang ke kampus, cukup isi form booking secara online.
                    </p>
                </div>
            </article>

            {{-- Feature 4 --}}
            <article class="card bg-base-100 h-full shadow-md border border-accent/20 hover:border-accent transition-colors">
                <div class="card-body items-center text-center space-y-3">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-accent/10 flex items-center justify-center">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 18h.01M8 21h8a2 2 0
                                     002-2V5a2 2 0
                                     00-2-2H8a2 2 0
                                     00-2 2v14a2 2 0
                                     002 2z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-base sm:text-lg mb-1">QR Code Profil</h3>
                    <p class="text-xs sm:text-sm text-base-content/70">
                        Akses cepat profil dosen dan jadwalnya hanya dengan memindai QR code.
                    </p>
                </div>
            </article>

            {{-- Feature 5 --}}
            <article class="card bg-base-100 h-full shadow-md border border-info/20 hover:border-info transition-colors">
                <div class="card-body items-center text-center space-y-3">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-info/10 flex items-center justify-center">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 17h5l-1.405-1.405A2.032 2.032 0
                                     0118 14.158V11a6.002 6.002 0
                                     00-4-5.659V5a2 2 0
                                     10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0
                                     .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0
                                     11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="card-title text-base sm:text-lg mb-1">Notifikasi Otomatis</h3>
                    <p class="text-xs sm:text-sm text-base-content/70">
                        Mahasiswa menerima email saat booking disetujui atau ditolak oleh dosen.
                    </p>
                </div>
            </article>

            {{-- Feature 6 --}}
            <article class="card bg-base-100 h-full shadow-md border border-warning/20 hover:border-warning transition-colors">
                <div class="card-body items-center text-center space-y-3">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-warning/10 flex items-center justify-center">
                        <svg class="w-7 h-7 sm:w-8 sm:h-8 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0
                                     0112 2.944a11.955 11.955 0
                                     01-8.618 3.04A12.02 12.02 0
                                     003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332
                                     9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="card-title text-base sm:text-lg mb-1">Aman &amp; Terpercaya</h3>
                    <p class="text-xs sm:text-sm text-base-content/70">
                        Data pengguna tersimpan di sistem internal Lab WICIDA dengan pengaturan akses berbasis role.
                    </p>
                </div>
            </article>
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
   // GANTI script di bawah sebelum </body>
const html = document.documentElement;
const toggle = document.getElementById('theme-toggle');
const savedTheme = localStorage.getItem('theme') || 'lightElegant';

html.setAttribute('data-theme', savedTheme);
if (toggle) {
    toggle.checked = savedTheme === 'darkElegant';
    toggle.addEventListener('change', () => {
        const theme = toggle.checked ? 'darkElegant' : 'lightElegant';
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

    // SEMUA LOGIKA DOM (SLIDER + FILTER DOSEN)
    document.addEventListener('DOMContentLoaded', function () {
        // Elemen untuk dosen grid
        const searchInput = document.getElementById('search-dosen');
        const sortSelect  = document.getElementById('sort-dosen');
        const grid        = document.getElementById('dosen-grid');
        const noResults   = document.getElementById('no-results');

        // Elemen untuk slider jadwal
        const slides = Array.from(document.querySelectorAll('.schedule-slide'));
        const dots   = Array.from(document.querySelectorAll('.schedule-dot'));

        // === SLIDER JADWAL ===
        if (slides.length > 0) {
            let currentIndex = 0;
            let timer        = null;
            const interval   = 5000; // 5 detik per slide

            function showSlide(index) {
    slides.forEach((slide, i) => {
        if (i === index) {
            slide.classList.remove('hidden', 'opacity-0');
            slide.classList.add('opacity-100');
        } else {
            slide.classList.add('hidden', 'opacity-0');
            slide.classList.remove('opacity-100');
        }
    });

    dots.forEach((dot, i) => {
        dot.classList.toggle('bg-primary', i === index);
        dot.classList.toggle('bg-base-300', i !== index);
    });

    currentIndex = index;
}


            function nextSlide() {
                const next = (currentIndex + 1) % slides.length;
                showSlide(next);
            }

            function startAuto() {
                if (timer) clearInterval(timer);
                timer = setInterval(nextSlide, interval);
            }

            // Dot click
            dots.forEach(dot => {
                dot.addEventListener('click', () => {
                    const idx = parseInt(dot.dataset.index, 10);
                    showSlide(idx);
                    startAuto();
                });
            });

            // Start slider
            showSlide(0);
            startAuto();
        }

        // === FILTER & SORT DOSEN ===
        function getDosenCards() {
            if (!grid) return [];
            return Array.from(grid.querySelectorAll('.dosen-card'));
        }

        function filterDosen() {
            const search = (searchInput?.value || '').toLowerCase().trim();
            const cards  = getDosenCards();
            let visible  = 0;

            cards.forEach(card => {
                const name  = (card.dataset.dosenName || '').toLowerCase();
                const match = !search || (name && name.includes(search));

                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            if (noResults && grid) {
                if (visible === 0) {
                    noResults.classList.remove('hidden');
                    grid.style.display = 'none';
                } else {
                    noResults.classList.add('hidden');
                    grid.style.display = 'grid';
                }
            }
        }

        function sortDosen() {
            const sort  = sortSelect?.value || '';
            const cards = getDosenCards();
            if (!sort || cards.length === 0) return;

            cards.sort((a, b) => {
                const roleA = (a.dataset.dosenRole || '').toLowerCase();
                const roleB = (b.dataset.dosenRole || '').toLowerCase();

                if (!roleA || !roleB) return 0;

                if (sort === 'role-asc')   return roleA.localeCompare(roleB);
                if (sort === 'role-desc')  return roleB.localeCompare(roleA);
                return 0;
            });

            cards.forEach(card => grid.appendChild(card));
        }

        if (searchInput) {
            searchInput.addEventListener('input', () => {
                filterDosen();
                sortDosen();
            });
        }

        if (sortSelect) {
            sortSelect.addEventListener('change', () => {
                sortDosen();
                filterDosen();
            });
        }
    });

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
