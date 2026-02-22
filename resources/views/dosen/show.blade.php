<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lightElegant">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $dosen->name }} - Lab WICIDA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-base-200 via-base-100 to-base-200">

    {{-- NAVBAR --}}
    <header class="navbar bg-base-100/90 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-base-300/60">
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8">
            <div class="flex-1">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 sm:gap-3 hover:opacity-90 transition">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl gradient-purple-pink flex items-center justify-center text-base-100 shadow">
                        <span class="text-xl sm:text-2xl"></span>
                    </div>
                    <div class="hidden sm:flex flex-col leading-tight">
                        <span class="font-bold text-base">Lab WICIDA</span>
                        <span class="text-xs text-base-content/60">Sistem Jadwal Dosen</span>
                    </div>
                </a>
            </div>
            <nav class="flex-none flex items-center gap-2">
                <a href="{{ route('home') }}" class="btn btn-ghost btn-xs sm:btn-sm">
                    Beranda
                </a>
                <a href="{{ route('home') }}#dosen" class="btn btn-ghost btn-xs sm:btn-sm">
                    Dosen
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-xs sm:btn-sm">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-xs sm:btn-sm">
                        Login
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">

        {{-- Back Button --}}
        <div class="mb-6 animate-fadeInUp">
            <a href="{{ route('home') }}#dosen" class="btn btn-ghost btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="hidden sm:inline">Kembali ke Daftar Dosen</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success shadow-lg mb-6 animate-fadeInUp">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error shadow-lg mb-6 animate-fadeInUp">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning shadow-lg mb-6 animate-fadeInUp">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- LAYOUT GRID: 1 kolom mobile, 3 kolom desktop --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

            {{-- SIDEBAR PROFIL (lg:col-span-4 untuk lebih lapang) --}}
            <aside class="lg:col-span-4 space-y-6 animate-fadeInUp">

                {{-- Card Profil --}}
                <div class="glass-card rounded-3xl shadow-xl border border-base-300/60 overflow-hidden">
                    <div class="card-body items-center text-center p-6 sm:p-8">

                        {{-- Avatar --}}
                        <div class="avatar mb-5">
                            @if($dosen->photo)
                                <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-full ring-4 ring-primary/70 ring-offset-base-100 ring-offset-4 overflow-hidden">
                                    <img src="{{ asset('storage/' . $dosen->photo) }}" alt="{{ $dosen->name }}" class="object-cover">
                                </div>
                            @else
                                <div class="w-32 h-32 sm:w-36 sm:h-36 rounded-full gradient-purple-pink text-base-100 ring-4 ring-primary/70 ring-offset-base-100 ring-offset-4 flex items-center justify-center">
                                    <span class="text-5xl sm:text-6xl font-bold">{{ substr($dosen->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Info basic --}}
                        <h1 class="text-xl sm:text-2xl font-black mb-2 text-base-content leading-tight">
                            {{ $dosen->name }}
                        </h1>
                        <div class="badge badge-primary badge-lg capitalize mb-3">
                            {{ str_replace('_', ' ', $dosen->role) }}
                        </div>

                        @if($dosen->nip)
                            <p class="text-xs sm:text-sm text-base-content/60 mb-4">
                                NIP: {{ $dosen->nip }}
                            </p>
                        @endif

                        @if($dosen->email)
                            <div class="flex items-center justify-center gap-2 text-xs sm:text-sm mb-4 max-w-full px-2">
                                <svg class="w-4 h-4 shrink-0 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="truncate">{{ $dosen->email }}</span>
                            </div>
                        @endif

                        {{-- Status Real-time --}}
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
                            <div class="mt-4 w-full">
                                <div class="text-[11px] text-base-content/60 mb-2">Status Saat Ini</div>
                                <div class="badge {{ $statusColor }} badge-lg gap-2 px-4">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-current opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-current"></span>
                                    </span>
                                    {{ $dosen->status->status }}
                                </div>
                                <div class="text-[10px] text-base-content/50 mt-2">
                                    Diperbarui {{ $dosen->status->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Card QR Code --}}
                <div class="glass-card rounded-3xl shadow-xl border border-base-300/60 overflow-hidden" id="qrcode-card">
                    <div class="card-body items-center text-center p-6">
                        <h3 class="font-bold text-base mb-3 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a2 2 0 00-2-2h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            QR Code Profil
                        </h3>
                        <p class="text-[11px] text-base-content/70 mb-4">
                            Scan untuk akses cepat profil dan booking.
                        </p>

                        {{-- QR Code SVG --}}
                        <div class="bg-white p-5 rounded-2xl shadow-lg inline-block mb-4" id="qr-display">
                            {!! $qrCodeSvg !!}
                        </div>

                        {{-- URL + copy --}}
                        <div class="w-full mb-3">
                            <div class="join w-full">
                                <input type="text"
                                       id="qr-url-input"
                                       readonly
                                       class="input input-bordered input-sm join-item flex-1 text-xs"
                                       value="{{ $qrCodeUrl }}">
                                <button type="button"
                                        onclick="copyQrUrl()"
                                        class="btn btn-sm btn-primary join-item"
                                        title="Copy Link">
                                    <svg id="copy-icon-qr" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                            <span id="copy-feedback-qr" class="text-success text-xs hidden mt-1 inline-block">
                                ✓ Link berhasil disalin!
                            </span>
                        </div>

                        {{-- Actions --}}
                        <div class="grid grid-cols-1 gap-2 w-full">
                            <button type="button"
                                    onclick="downloadQrCode('{{ $dosen->id }}', '{{ $dosen->name }}')"
                                    class="btn btn-primary btn-sm gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download PNG
                            </button>

                            <button type="button"
                                    onclick="printQrCode()"
                                    class="btn btn-outline btn-sm gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                Cetak QR
                            </button>

                            <button type="button"
                                    onclick="shareQrCode()"
                                    class="btn btn-ghost btn-sm gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367-2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Share Link
                            </button>
                        </div>
                    </div>
                </div>

            </aside>

            {{-- MAIN CONTENT (lg:col-span-8) --}}
            <section class="lg:col-span-8 space-y-6 animate-fadeInUp delay-100">

                {{-- Jadwal Hari Ini --}}
                <div class="glass-card rounded-3xl shadow-xl border border-base-300/60 overflow-hidden">
                    <div class="card-body p-5 sm:p-6">
                        <h2 class="font-bold text-lg sm:text-xl mb-4 flex flex-wrap items-center gap-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Jadwal Hari Ini</span>
                            <span class="badge badge-outline text-[10px] sm:text-xs">
                                {{ now()->locale('id')->translatedFormat('l, d M Y') }}
                            </span>
                        </h2>

                        @if(isset($todayEvents) && $todayEvents->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($todayEvents as $event)
                                    <div class="p-4 rounded-2xl border border-base-300/70 bg-base-200/40 hover:bg-base-200/70 transition-colors">
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                            <div class="flex-1 min-w-0">
                                                <div class="text-[10px] sm:text-xs uppercase tracking-widest text-primary font-semibold mb-1">
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['jam_mulai'])->format('H:i') }}
                                                    –
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['jam_selesai'])->format('H:i') }}
                                                </div>
                                                <div class="font-bold text-sm sm:text-base mb-2 flex flex-wrap items-center gap-2">
                                                    <span class="break-words">{{ $event['kegiatan'] }}</span>
                                                    @if($event['tipe'] === 'booking')
                                                        <span class="badge badge-success badge-xs">Booking</span>
                                                    @endif
                                                </div>
                                                <div class="text-xs text-base-content/70 space-y-1">
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        <span>{{ $event['ruangan'] ?? '-' }}</span>
                                                    </div>
                                                    @if($event['tipe'] === 'booking' && !empty($event['nama_mahasiswa']))
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            <span>{{ $event['nama_mahasiswa'] }}</span>
                                                            @if(!empty($event['nim_mahasiswa']))
                                                                <span class="opacity-60">({{ $event['nim_mahasiswa'] }})</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                @if(!empty($event['keterangan']))
                                                    <div class="text-xs text-base-content/60 mt-2 italic break-words">
                                                        "{{ $event['keterangan'] }}"
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="badge {{ $event['tipe'] === 'booking' ? 'badge-success' : 'badge-primary' }} badge-sm sm:badge-md shrink-0">
                                                {{ $event['tipe'] === 'booking' ? 'Konsultasi' : 'Rutin' }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10 text-base-content/60 text-sm">
                                <svg class="w-16 h-16 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>Belum ada jadwal atau booking untuk hari ini.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Bio --}}
                @if($dosen->bio)
                    <div class="glass-card rounded-3xl shadow-xl border border-base-300/60 overflow-hidden">
                        <div class="card-body p-5 sm:p-6">
                            <h2 class="font-bold text-lg sm:text-xl mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Tentang
                            </h2>
                            <p class="text-sm text-base-content/80 leading-relaxed whitespace-pre-line">
                                {{ $dosen->bio }}
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Keahlian & Links --}}
                @if($dosen->expertise || $dosen->scholar_url || $dosen->sinta_url || $dosen->website_url)
                    <div class="glass-card rounded-3xl shadow-xl border border-base-300/60 overflow-hidden">
                        <div class="card-body p-5 sm:p-6">
                            <h2 class="font-bold text-lg sm:text-xl mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                Informasi Akademik
                            </h2>

                            @if($dosen->expertise)
                                <div class="mb-5">
                                    <h3 class="font-semibold text-sm mb-2">Bidang Keahlian</h3>
                                    <p class="text-sm text-base-content/80">{{ $dosen->expertise }}</p>
                                </div>
                            @endif

                            @if($dosen->scholar_url || $dosen->sinta_url || $dosen->website_url)
                                <div>
                                    <h3 class="font-semibold text-sm mb-3">Tautan Riset & Portofolio</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @if($dosen->scholar_url)
                                            <a href="{{ $dosen->scholar_url }}" target="_blank"
                                               class="btn btn-outline btn-sm gap-2">
                                                <span class="w-2 h-2 rounded-full bg-primary"></span>
                                                Google Scholar
                                            </a>
                                        @endif
                                        @if($dosen->sinta_url)
                                            <a href="{{ $dosen->sinta_url }}" target="_blank"
                                               class="btn btn-outline btn-sm gap-2">
                                                <span class="w-2 h-2 rounded-full bg-secondary"></span>
                                                SINTA
                                            </a>
                                        @endif
                                        @if($dosen->website_url)
                                            <a href="{{ $dosen->website_url }}" target="_blank"
                                               class="btn btn-outline btn-sm gap-2">
                                                <span class="w-2 h-2 rounded-full bg-accent"></span>
                                                Website
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Jadwal Mingguan --}}
                <div class="glass-card rounded-3xl shadow-xl border border-base-300/60 overflow-hidden">
                    <div class="card-body p-5 sm:p-6">
                        <h2 class="font-bold text-lg sm:text-xl mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Jadwal Mingguan
                        </h2>

                        @if($dosen->jadwals->isNotEmpty())
                            <div class="overflow-x-auto -mx-2 sm:mx-0">
                                <table class="table table-zebra text-xs sm:text-sm">
                                    <thead>
                                        <tr>
                                            <th class="bg-base-200">Hari</th>
                                            <th class="bg-base-200">Jam</th>
                                            <th class="bg-base-200">Kegiatan</th>
                                            <th class="bg-base-200">Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dosen->jadwals as $jadwal)
                                            <tr>
                                                <td class="font-semibold whitespace-nowrap">{{ $jadwal->hari }}</td>
                                                <td class="whitespace-nowrap text-xs">
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                                </td>
                                                <td class="break-words max-w-xs">{{ $jadwal->kegiatan }}</td>
                                                <td>{{ $jadwal->ruangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-10 text-base-content/60 text-sm">
                                <svg class="w-16 h-16 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>Jadwal belum tersedia.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Form Booking --}}
                <div class="glass-card rounded-3xl shadow-xl border-2 border-primary/30 overflow-hidden bg-gradient-to-br from-primary/5 to-secondary/5">
                    <div class="card-body p-5 sm:p-7">
                        <h2 class="font-bold text-lg sm:text-xl mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Booking Konsultasi
                        </h2>

                        <form action="{{ route('dosen.booking.store', $dosen) }}" method="POST" class="space-y-5">
                            @csrf

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-xs sm:text-sm">
                                            Nama Lengkap <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <input type="text" name="nama_mahasiswa"
                                           class="input input-bordered @error('nama_mahasiswa') input-error @enderror"
                                           value="{{ old('nama_mahasiswa') }}" required>
                                    @error('nama_mahasiswa')
                                        <label class="label">
                                            <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-xs sm:text-sm">NIM</span>
                                    </label>
                                    <input type="text" name="nim_mahasiswa"
                                           class="input input-bordered @error('nim_mahasiswa') input-error @enderror"
                                           value="{{ old('nim_mahasiswa') }}">
                                    @error('nim_mahasiswa')
                                        <label class="label">
                                            <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-xs sm:text-sm">
                                        Email <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="email" name="email_mahasiswa"
                                       class="input input-bordered @error('email_mahasiswa') input-error @enderror"
                                       value="{{ old('email_mahasiswa') }}" required>
                                @error('email_mahasiswa')
                                    <label class="label">
                                        <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-xs sm:text-sm">
                                            Tanggal <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <input type="date" name="tanggal_booking"
                                           class="input input-bordered @error('tanggal_booking') input-error @enderror"
                                           value="{{ old('tanggal_booking') }}"
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('tanggal_booking')
                                        <label class="label">
                                            <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-xs sm:text-sm">
                                            Waktu <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="time" name="jam_mulai"
                                               class="input input-bordered @error('jam_mulai') input-error @enderror"
                                               value="{{ old('jam_mulai') }}" required>
                                        <input type="time" name="jam_selesai"
                                               class="input input-bordered @error('jam_selesai') input-error @enderror"
                                               value="{{ old('jam_selesai') }}" required>
                                    </div>
                                    @error('jam_mulai')
                                        <label class="label">
                                            <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                                        </label>
                                    @enderror
                                    @error('jam_selesai')
                                        <label class="label">
                                            <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-xs sm:text-sm">
                                        Keperluan Konsultasi <span class="text-error">*</span>
                                    </span>
                                </label>
                                <textarea name="keperluan" rows="4"
                                          class="textarea textarea-bordered @error('keperluan') textarea-error @enderror"
                                          placeholder="Jelaskan topik atau materi yang ingin dikonsultasikan..."
                                          required>{{ old('keperluan') }}</textarea>
                                @error('keperluan')
                                    <label class="label">
                                        <span class="label-text-alt text-error text-xs">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="alert alert-info text-xs sm:text-sm">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>
                                    Booking akan menunggu persetujuan dari dosen. Anda akan dihubungi via email.
                                </span>
                            </div>

                            <button type="submit" class="btn btn-primary w-full gap-2">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7" />
                                </svg>
                                Kirim Permintaan Booking
                            </button>
                        </form>
                    </div>
                </div>

            </section>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="footer footer-center p-6 sm:p-8 bg-base-100 text-base-content border-t border-base-300 mt-12">
        <div>
            <p class="text-xs sm:text-sm">
                © {{ date('Y') }} Lab WICIDA. Sistem Jadwal Dosen & Booking Konsultasi.
            </p>
        </div>
    </footer>

    <script>
        // Theme
        const savedTheme = localStorage.getItem('theme') || 'lightElegant';
        document.documentElement.setAttribute('data-theme', savedTheme);

        // Download QR
        function downloadQrCode(dosenId, dosenName) {
            const qrDisplay = document.getElementById('qr-display');
            if (!qrDisplay) {
                alert('QR Code belum tersedia');
                return;
            }

            const svg = qrDisplay.innerHTML;
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
                    link.download = `qrcode-${dosenName.replace(/\s+/g, '-')}.png`;
                    link.click();
                });
            };

            img.onerror = () => alert('Gagal memuat QR untuk diunduh.');
            img.src = url;
        }

        // Copy URL
        function copyQrUrl() {
            const urlInput = document.getElementById('qr-url-input');
            const copyIcon = document.getElementById('copy-icon-qr');
            const feedback = document.getElementById('copy-feedback-qr');

            urlInput.select();
            urlInput.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(urlInput.value)
                .then(() => {
                    feedback.classList.remove('hidden');
                    copyIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';

                    setTimeout(() => {
                        feedback.classList.add('hidden');
                        copyIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />';
                    }, 2000);
                })
                .catch(() => alert('Gagal menyalin link.'));
        }

        // Print QR
        function printQrCode() {
            const qrDisplay = document.getElementById('qr-display');
            if (!qrDisplay) {
                alert('QR Code belum tersedia');
                return;
            }
            const w = window.open('', '_blank');
            if (!w) return;
            w.document.write(`
                <html>
                <head><title>Cetak QR Code</title>
                <style>body{display:flex;align-items:center;justify-content:center;height:100vh;margin:0;}</style>
                </head>
                <body>${qrDisplay.innerHTML}</body>
                </html>
            `);
            w.document.close();
            w.focus();
            w.print();
        }

        // Share
        function shareQrCode() {
            const url = document.getElementById('qr-url-input')?.value;
            if (!url) return;

            if (navigator.share) {
                navigator.share({
                    title: 'Booking Konsultasi Dosen',
                    text: 'Link booking konsultasi Lab WICIDA',
                    url: url
                }).catch(() => {});
            } else {
                copyQrUrl();
                alert('Browser tidak support Web Share API. Link sudah disalin.');
            }
        }
    </script>

</body>
</html>
