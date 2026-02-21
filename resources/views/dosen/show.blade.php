<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $dosen->name }} - Lab WICIDA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0);   }
        }
    </style>
</head>
<body class="min-h-screen bg-base-200">

    {{-- NAVBAR --}}
    <div class="navbar bg-base-100 shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto w-full px-4">
            <div class="flex-1">
                <a href="{{ route('home') }}" class="btn btn-ghost normal-case text-xl gap-2">
                    <span class="text-3xl">📚</span>
                    <span class="font-bold">Lab WICIDA</span>
                </a>
            </div>
            <div class="flex-none gap-2">
                <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                    Beranda
                </a>
                <a href="{{ route('home') }}#dosen" class="btn btn-ghost btn-sm">
                    Dosen
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 py-8">

        {{-- Back Button --}}
        <div class="mb-6 fade-in">
            <a href="{{ route('home') }}#dosen" class="btn btn-ghost btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Dosen
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success shadow-lg mb-4 fade-in">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error shadow-lg mb-4 fade-in">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-warning shadow-lg mb-4 fade-in">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0
                             11-18 0 9 9 0 0118 0z" />
                </svg>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-6">

            {{-- SIDEBAR PROFIL --}}
            <div class="lg:col-span-1 space-y-6 fade-in">

                {{-- Card Profil --}}
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body items-center text-center">
                        {{-- Avatar --}}
                        <div class="avatar mb-4">
                            @if($dosen->photo)
                                <div class="w-32 rounded-full ring-4 ring-primary ring-offset-base-100 ring-offset-4">
                                    <img src="{{ asset('storage/' . $dosen->photo) }}" alt="{{ $dosen->name }}">
                                </div>
                            @else
                                <div class="bg-gradient-to-br from-primary to-secondary text-primary-content rounded-full w-32 h-32 ring-4 ring-primary ring-offset-base-100 ring-offset-4 flex items-center justify-center">
                                    <span class="text-5xl font-bold">{{ substr($dosen->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <h1 class="text-2xl font-black mb-2">{{ $dosen->name }}</h1>
                        <div class="badge badge-primary capitalize mb-2">
                            {{ str_replace('_', ' ', $dosen->role) }}
                        </div>

                        @if($dosen->nip)
                            <p class="text-sm text-base-content/60 mb-4">NIP: {{ $dosen->nip }}</p>
                        @endif

                        @if($dosen->email)
                            <div class="flex items-center gap-2 text-sm mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0
                                             00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
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
                            <div class="mt-4">
                                <div class="text-xs text-base-content/60 mb-2">Status Saat Ini</div>
                                <div class="badge {{ $statusColor }} badge-lg gap-2">
                                    <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                                    {{ $dosen->status->status }}
                                </div>
                                <div class="text-xs text-base-content/50 mt-1">
                                    Diperbarui: {{ $dosen->status->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Card QR Code --}}
                <div class="card bg-base-100 shadow-xl border border-base-300" id="qrcode-card">
                    <div class="card-body items-center text-center">
                        <h3 class="card-title text-base mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a2 2 0 00-2-2h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                            QR Code Profil
                        </h3>
                        <p class="text-xs text-base-content/70 mb-4">
                            Scan untuk akses cepat ke halaman ini dan booking konsultasi.
                        </p>

                        {{-- QR Code SVG --}}
                        <div class="bg-white p-6 rounded-xl shadow-lg inline-block mb-4" id="qr-display">
                            {!! $qrCodeSvg !!}
                        </div>

                        {{-- URL Display + copy --}}
                        <div class="form-control w-full mb-4">
                            <label class="label">
                                <span class="label-text text-xs font-semibold">Link Booking:</span>
                            </label>
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
                            <label class="label">
                                <span id="copy-feedback-qr" class="label-text-alt text-success hidden">
                                    ✓ Link berhasil disalin!
                                </span>
                            </label>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col gap-2 w-full">
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
                                          d="M17 17h2a2 2 0 002-2v-4a2 2 0
                                             00-2-2H5a2 2 0 00-2 2v4a2 2 0
                                             002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0
                                             00-2-2H9a2 2 0 00-2 2v4a2 2 0
                                             002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0
                                             00-2 2v4h10z" />
                                </svg>
                                Cetak QR Code
                            </button>

                            <button type="button"
                                    onclick="shareQrCode()"
                                    class="btn btn-ghost btn-sm gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Share Link
                            </button>
                        </div>

                        <div class="text-[10px] text-base-content/50 mt-2 break-all">
                            {{ $qrCodeUrl }}
                        </div>
                    </div>
                </div>

            </div>

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-2 space-y-6 fade-in">

{{-- Card Jadwal Hari Ini --}}
<div class="card bg-base-100 shadow-xl border border-base-300">
    <div class="card-body">
        <h2 class="card-title text-xl mb-3 flex items-center gap-2">
            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Jadwal Hari Ini
            <span class="badge badge-outline text-xs">
                {{ now()->locale('id')->translatedFormat('l, d M Y') }}
            </span>
        </h2>

        @if(isset($todayEvents) && $todayEvents->isNotEmpty())
            <div class="space-y-3">
                @foreach($todayEvents as $event)
                    <div class="flex items-start justify-between p-3 rounded-xl border border-base-300/70 bg-base-200/60">
                        <div class="flex-1">
                            <div class="text-xs uppercase tracking-widest text-base-content/60">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['jam_mulai'])->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['jam_selesai'])->format('H:i') }}
                            </div>
                            <div class="font-semibold text-sm mt-1 flex items-center gap-2">
                                {{ $event['kegiatan'] }}
                                @if($event['tipe'] === 'booking')
                                    <span class="badge badge-success badge-xs">Booking Approved</span>
                                @endif
                            </div>
                            <div class="text-xs text-base-content/70 mt-1">
                                Ruang: {{ $event['ruangan'] ?? '-' }}
                                @if($event['tipe'] === 'booking' && !empty($event['nama_mahasiswa']))
                                    · Mahasiswa: {{ $event['nama_mahasiswa'] }}
                                    @if(!empty($event['nim_mahasiswa']))
                                        <span class="text-[10px] opacity-70">({{ $event['nim_mahasiswa'] }})</span>
                                    @endif
                                @endif
                            </div>
                            @if(!empty($event['keterangan']))
                                <div class="text-[11px] text-base-content/60 mt-1">
                                    {{ $event['keterangan'] }}
                                </div>
                            @endif
                        </div>
                        <div class="text-[10px] uppercase tracking-wide px-2 py-1 rounded-full font-medium
                                    {{ $event['tipe'] === 'booking' ? 'bg-success/10 text-success' : 'bg-primary/10 text-primary' }}">
                            {{ $event['tipe'] === 'booking' ? 'Konsultasi' : 'Jadwal Rutin' }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-base-content/60 text-sm">
                Belum ada jadwal atau booking untuk hari ini.
            </div>
        @endif
    </div>
</div>


                {{-- Card Bio --}}
                @if($dosen->bio)
                    <div class="card bg-base-100 shadow-xl border border-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-3 flex itemscenter gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0
                                             018 0zM12 14a7 7 0 00-7 7h14a7 7 0
                                             00-7-7z" />
                                </svg>
                                Tentang
                            </h2>
                            <p class="text-base-content/80 leading-relaxed whitespace-pre-line">
                                {{ $dosen->bio }}
                            </p>
                        </div>
                    </div>
                @endif

                {{-- Card Keahlian & Links --}}
                @if($dosen->expertise || $dosen->scholar_url || $dosen->sinta_url || $dosen->website_url)
                    <div class="card bg-base-100 shadow-xl border border-base-300">
                        <div class="card-body">
                            <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4
                                             12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0
                                             117.072 0l-.548.547A3.374 3.374 0
                                             0014 18.469V19a2 2 0 11-4
                                             0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                Informasi Akademik
                            </h2>

                            @if($dosen->expertise)
                                <div class="mb-4">
                                    <h3 class="font-semibold mb-2">Bidang Keahlian</h3>
                                    <p class="text-base-content/80">{{ $dosen->expertise }}</p>
                                </div>
                            @endif

                            @if($dosen->scholar_url || $dosen->sinta_url || $dosen->website_url)
                                <div>
                                    <h3 class="font-semibold mb-3">Tautan Riset & Portofolio</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @if($dosen->scholar_url)
                                            <a href="{{ $dosen->scholar_url }}" target="_blank" class="btn btn-outline btn-sm gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 24a7 7 0 110-14 7 7 0 010 14zm0-24L0 9.5l4.838 3.94A8 8 0
                                                             0112 9a8 8 0 017.162 4.44L24 9.5z"/>
                                                </svg>
                                                Google Scholar
                                            </a>
                                        @endif
                                        @if($dosen->sinta_url)
                                            <a href="{{ $dosen->sinta_url }}" target="_blank" class="btn btn-outline btn-sm gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0
                                                             01-2-2V5a2 2 0 012-2h5.586a1 1 0
                                                             01.707.293l5.414 5.414a1 1 0
                                                             01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                SINTA
                                            </a>
                                        @endif
                                        @if($dosen->website_url)
                                            <a href="{{ $dosen->website_url }}" target="_blank" class="btn btn-outline btn-sm gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M21 12a9 9 0 01-9 9m9-9a9 9 0
                                                             00-9-9m9 9H3m9 9a9 9 0
                                                             01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0
                                                             18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9
                                                             9a9 9 0 019-9" />
                                                </svg>
                                                Website
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Card Jadwal --}}
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
                                         002-2V7a2 2 0 00-2-2H5a2 2 0
                                         00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Jadwal Mingguan
                        </h2>

                        @if($dosen->jadwals->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="table table-zebra">
                                    <thead>
                                        <tr>
                                            <th>Hari</th>
                                            <th>Jam</th>
                                            <th>Kegiatan</th>
                                            <th>Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dosen->jadwals as $jadwal)
                                            <tr>
                                                <td class="font-semibold">{{ $jadwal->hari }}</td>
                                                <td class="whitespace-nowrap">
                                                    {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                                                </td>
                                                <td>{{ $jadwal->kegiatan }}</td>
                                                <td>{{ $jadwal->ruangan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 text-base-content/60">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
                                             002-2V7a2 2 0 00-2-2H5a2 2 0
                                             00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>Jadwal belum tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Card Form Booking --}}
                <div class="card bg-gradient-to-br from-primary/5 to-secondary/5 shadow-xl border-2 border-primary/20">
                    <div class="card-body">
                        <h2 class="card-title text-xl mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0
                                         002 2h10a2 2 0 002-2V7a2 2 0
                                         00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0
                                         002-2M9 5a2 2 0 012-2h2a2 2 0
                                         012 2" />
                            </svg>
                            Booking Konsultasi
                        </h2>

                        <form action="{{ route('dosen.booking.store', $dosen) }}" method="POST" class="space-y-4">
                            @csrf

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">
                                            Nama Lengkap <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <input type="text" name="nama_mahasiswa"
                                           class="input input-bordered @error('nama_mahasiswa') input-error @enderror"
                                           value="{{ old('nama_mahasiswa') }}" required>
                                    @error('nama_mahasiswa')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">NIM</span>
                                    </label>
                                    <input type="text" name="nim_mahasiswa"
                                           class="input input-bordered @error('nim_mahasiswa') input-error @enderror"
                                           value="{{ old('nim_mahasiswa') }}">
                                    @error('nim_mahasiswa')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">
                                        Email <span class="text-error">*</span>
                                    </span>
                                </label>
                                <input type="email" name="email_mahasiswa"
                                       class="input input-bordered @error('email_mahasiswa') input-error @enderror"
                                       value="{{ old('email_mahasiswa') }}" required>
                                @error('email_mahasiswa')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">
                                            Tanggal <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <input type="date" name="tanggal_booking"
                                           class="input input-bordered @error('tanggal_booking') input-error @enderror"
                                           value="{{ old('tanggal_booking') }}"
                                           min="{{ date('Y-m-d') }}" required>
                                    @error('tanggal_booking')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>

                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold">
                                            Waktu <span class="text-error">*</span>
                                        </span>
                                    </label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <input type="time" name="jam_mulai"
                                               class="input input-bordered input-sm @error('jam_mulai') input-error @enderror"
                                               value="{{ old('jam_mulai') }}" required>
                                        <input type="time" name="jam_selesai"
                                               class="input input-bordered input-sm @error('jam_selesai') input-error @enderror"
                                               value="{{ old('jam_selesai') }}" required>
                                    </div>
                                    @error('jam_mulai')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                    @error('jam_selesai')
                                        <label class="label">
                                            <span class="label-text-alt text-error">{{ $message }}</span>
                                        </label>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold">
                                        Keperluan Konsultasi <span class="text-error">*</span>
                                    </span>
                                </label>
                                <textarea name="keperluan" rows="4"
                                          class="textarea textarea-bordered @error('keperluan') textarea-error @enderror"
                                          placeholder="Jelaskan topik atau materi yang ingin dikonsultasikan..."
                                          required>{{ old('keperluan') }}</textarea>
                                @error('keperluan')
                                    <label class="label">
                                        <span class="label-text-alt text-error">{{ $message }}</span>
                                    </label>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0
                                             11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm">
                                    Booking akan menunggu persetujuan dari dosen. Anda akan dihubungi melalui email.
                                </span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-full gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M5 13l4 4L19 7" />
                                </svg>
                                Kirim Permintaan Booking
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="footer footer-center p-6 bg-base-100 text-base-content border-t border-base-300 mt-12">
        <div>
            <p class="text-sm">
                © {{ date('Y') }} Lab WICIDA. Sistem Jadwal Dosen & Booking Konsultasi.
            </p>
        </div>
    </footer>

    <script>
        // Theme dari localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);

        // DOWNLOAD QR (SVG -> PNG via canvas)
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

            img.src = url;
        }

        // COPY URL QR
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
                .catch(err => {
                    console.error('Copy failed:', err);
                    alert('Gagal menyalin link. Silakan copy manual.');
                });
        }

        // PRINT QR
        function printQrCode() {
            const qrDisplay = document.getElementById('qr-display');
            if (!qrDisplay) {
                alert('QR Code belum tersedia');
                return;
            }

            const userName = @json($dosen->name);
            const userNip = @json($dosen->nip ?? '-');
            const qrUrl   = @json($qrCodeUrl);

            const w = window.open('', '_blank', 'width=600,height=700');
            w.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>QR Code - ${userName}</title>
                    <style>
                        body {
                            font-family: system-ui, -apple-system, sans-serif;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            min-height: 100vh;
                            margin: 0;
                            background: white;
                        }
                        .qr-container {
                            text-align: center;
                            padding: 2rem;
                            border-radius: 1rem;
                        }
                        h2 { margin: 0 0 0.5rem; font-size: 1.5rem; }
                        p { margin: 0.25rem 0; color: #555; font-size: 0.9rem; }
                        .qr-box {
                            background: white;
                            padding: 1.5rem;
                            border-radius: 0.75rem;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                            display: inline-block;
                            margin: 1rem 0;
                        }
                        .url {
                            font-size: 0.75rem;
                            color: #777;
                            word-break: break-all;
                            max-width: 400px;
                            margin: 1rem auto 0;
                        }
                        @media print {
                            body { background: white; }
                        }
                    </style>
                </head>
                <body>
                    <div class="qr-container">
                        <h2>${userName}</h2>
                        <p>NIP: ${userNip}</p>
                        <p><strong>Scan untuk booking konsultasi</strong></p>
                        <div class="qr-box">
                            ${qrDisplay.innerHTML}
                        </div>
                        <div class="url">${qrUrl}</div>
                    </div>
                </body>
                </html>
            `);
            w.document.close();
            setTimeout(() => w.print(), 500);
        }

        // SHARE QR URL
        function shareQrCode() {
            const qrUrl   = @json($qrCodeUrl);
            const userName = @json($dosen->name);

            if (navigator.share) {
                navigator.share({
                    title: 'Profil Dosen - ' + userName,
                    text: 'Booking konsultasi dengan ' + userName + ' di Lab WICIDA',
                    url: qrUrl
                }).catch(err => {
                    console.error('Share failed:', err);
                    copyQrUrl();
                });
            } else {
                copyQrUrl();
                alert('Link berhasil disalin! Bagikan melalui aplikasi favorit Anda.');
            }
        }
    </script>

</body>
</html>
