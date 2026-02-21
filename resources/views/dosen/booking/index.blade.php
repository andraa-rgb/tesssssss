@extends('layouts.app')

@section('title', 'Kelola Booking Konsultasi')

@section('content')

{{-- Header Section --}}
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black mb-2 flex items-center gap-3">
                <span class="text-4xl">📝</span>
                Kelola Booking Konsultasi
            </h1>
            <p class="text-base-content/70">Manage permintaan konsultasi dari mahasiswa</p>
        </div>
        <div class="flex gap-2">
            <button onclick="refreshPage()" class="btn btn-outline btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Refresh
            </button>
        </div>
    </div>
</div>

{{-- Success/Error Messages --}}
@if(session('success'))
    <div class="alert alert-success shadow-lg mb-6 animate-fade-in">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error shadow-lg mb-6 animate-fade-in">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- Stats Cards with Gradient --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="stat bg-gradient-to-br from-primary/20 to-primary/5 rounded-xl shadow-lg border border-primary/20 hover:shadow-xl transition-all duration-300">
        <div class="stat-figure text-primary">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <div class="stat-title font-semibold">Total Booking</div>
        <div class="stat-value text-primary text-3xl">{{ auth()->user()->bookings()->count() }}</div>
        <div class="stat-desc">Semua waktu</div>
    </div>

    <div class="stat bg-gradient-to-br from-warning/20 to-warning/5 rounded-xl shadow-lg border border-warning/20 hover:shadow-xl transition-all duration-300">
        <div class="stat-figure text-warning">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="stat-title font-semibold">Menunggu</div>
        <div class="stat-value text-warning text-3xl">{{ auth()->user()->bookings()->where('status','pending')->count() }}</div>
        <div class="stat-desc">Perlu diproses</div>
    </div>

    <div class="stat bg-gradient-to-br from-success/20 to-success/5 rounded-xl shadow-lg border border-success/20 hover:shadow-xl transition-all duration-300">
        <div class="stat-figure text-success">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="stat-title font-semibold">Disetujui</div>
        <div class="stat-value text-success text-3xl">{{ auth()->user()->bookings()->where('status','approved')->count() }}</div>
        <div class="stat-desc">Konsultasi terjadwal</div>
    </div>

    <div class="stat bg-gradient-to-br from-error/20 to-error/5 rounded-xl shadow-lg border border-error/20 hover:shadow-xl transition-all duration-300">
        <div class="stat-figure text-error">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="stat-title font-semibold">Ditolak</div>
        <div class="stat-value text-error text-3xl">{{ auth()->user()->bookings()->where('status','rejected')->count() }}</div>
        <div class="stat-desc">Tidak disetujui</div>
    </div>
</div>

{{-- Filter Tabs - Enhanced --}}
<div class="card bg-base-100 shadow-lg border border-base-300 mb-6">
    <div class="card-body p-4">
        <div class="flex items-center gap-3 flex-wrap">
            <span class="font-semibold text-base-content/70">Filter:</span>
            <div class="tabs tabs-boxed">
                <a href="{{ route('booking.index') }}" 
                   class="tab {{ !request('status') ? 'tab-active' : '' }}">
                    Semua
                </a>
                <a href="{{ route('booking.index', ['status' => 'pending']) }}" 
                   class="tab gap-2 {{ request('status') == 'pending' ? 'tab-active' : '' }}">
                    <span class="badge badge-warning badge-xs"></span>
                    Menunggu
                </a>
                <a href="{{ route('booking.index', ['status' => 'approved']) }}" 
                   class="tab gap-2 {{ request('status') == 'approved' ? 'tab-active' : '' }}">
                    <span class="badge badge-success badge-xs"></span>
                    Disetujui
                </a>
                <a href="{{ route('booking.index', ['status' => 'rejected']) }}" 
                   class="tab gap-2 {{ request('status') == 'rejected' ? 'tab-active' : '' }}">
                    <span class="badge badge-error badge-xs"></span>
                    Ditolak
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Booking Cards - Enhanced --}}
<div class="space-y-4">
    @forelse($bookings as $booking)
        <div class="card bg-base-100 shadow-lg hover:shadow-2xl transition-all duration-300 border border-base-300 hover:border-primary/30 group">
            <div class="card-body">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                    
                    {{-- Main Info --}}
                    <div class="flex-1 space-y-4">
                        {{-- Header with avatar --}}
                        <div class="flex items-start gap-4">
                            <div class="avatar placeholder">
                                <div class="bg-primary text-primary-content rounded-full w-14 ring-2 ring-primary/20">
                                    <span class="text-xl font-bold">{{ substr($booking->nama_mahasiswa, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    <h3 class="card-title text-xl">{{ $booking->nama_mahasiswa }}</h3>
                                    @php
                                        $statusConfig = match($booking->status) {
                                            'pending' => ['badge' => 'badge-warning', 'icon' => '⏳', 'text' => 'Menunggu'],
                                            'approved' => ['badge' => 'badge-success', 'icon' => '✅', 'text' => 'Disetujui'],
                                            'rejected' => ['badge' => 'badge-error', 'icon' => '❌', 'text' => 'Ditolak'],
                                        };
                                    @endphp
                                    <div class="badge {{ $statusConfig['badge'] }} badge-lg gap-2 shadow-md">
                                        <span>{{ $statusConfig['icon'] }}</span>
                                        <span class="font-semibold">{{ $statusConfig['text'] }}</span>
                                    </div>
                                </div>
                                
                                {{-- Info Grid --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="avatar placeholder">
                                            <div class="bg-base-200 rounded-lg w-8 h-8">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-base-content/60">NIM</div>
                                            <div class="font-semibold">{{ $booking->nim_mahasiswa ?? '-' }}</div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="avatar placeholder">
                                            <div class="bg-base-200 rounded-lg w-8 h-8">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="truncate">
                                            <div class="text-xs text-base-content/60">Email</div>
                                            <div class="font-semibold truncate">{{ $booking->email_mahasiswa }}</div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="avatar placeholder">
                                            <div class="bg-base-200 rounded-lg w-8 h-8">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-base-content/60">Tanggal</div>
                                            <div class="font-semibold">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="avatar placeholder">
                                            <div class="bg-base-200 rounded-lg w-8 h-8">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-base-content/60">Waktu</div>
                                            <div class="font-semibold">{{ date('H:i', strtotime($booking->jam_mulai)) }} - {{ date('H:i', strtotime($booking->jam_selesai)) }}</div>
                                        </div>
                                    </div>

                                    {{-- Display Ruangan if exists --}}
                                    @if($booking->ruangan)
                                        <div class="flex items-center gap-2 text-sm md:col-span-2">
                                            <div class="avatar placeholder">
                                                <div class="bg-base-200 rounded-lg w-8 h-8">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs text-base-content/60">Ruangan</div>
                                                <div class="font-semibold">{{ $booking->ruangan }}</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Keperluan --}}
                        <div class="card bg-base-200 shadow-sm">
                            <div class="card-body p-4">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-primary mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="flex-1">
                                        <div class="text-sm font-semibold text-base-content/70 mb-1">Keperluan Konsultasi:</div>
                                        <p class="text-base leading-relaxed">{{ $booking->keperluan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan Dosen --}}
                        @if($booking->catatan_dosen)
                            <div class="card bg-info/10 shadow-sm border border-info/20">
                                <div class="card-body p-4">
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-info mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <div class="flex-1">
                                            <div class="text-sm font-semibold text-info mb-1">Catatan Dosen:</div>
                                            <p class="text-base leading-relaxed">{{ $booking->catatan_dosen }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Alasan Reject --}}
                        @if($booking->status == 'rejected' && $booking->alasan_reject)
                            <div class="alert alert-error shadow-md">
                                <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <div>
                                    <div class="font-bold">Alasan Penolakan:</div>
                                    <div class="text-sm">{{ $booking->alasan_reject }}</div>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex lg:flex-col gap-2 lg:min-w-[140px]">
                        @if($booking->status == 'pending')
                            {{-- Tombol Edit --}}
                            <a href="{{ route('booking.edit', $booking) }}" 
                               class="btn btn-info btn-outline w-full gap-2 shadow-lg hover:shadow-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>

                            {{-- Tombol Setujui Langsung --}}
                            <form method="POST" action="{{ route('booking.approve', $booking) }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-full gap-2 shadow-lg hover:shadow-xl transition-all"
                                        onclick="return confirm('Setujui booking ini tanpa perubahan?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui
                                </button>
                            </form>

                            {{-- Tombol Tolak --}}
                            <button class="btn btn-error w-full gap-2 shadow-lg hover:shadow-xl transition-all" 
                                    onclick="rejectModal{{ $booking->id }}.showModal()">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Tolak
                            </button>

                            {{-- Reject Modal --}}
                            <dialog id="rejectModal{{ $booking->id }}" class="modal">
                                <div class="modal-box max-w-md">
                                    <h3 class="font-bold text-xl mb-2 flex items-center gap-2">
                                        <span class="text-error text-2xl">⚠️</span>
                                        Tolak Booking Konsultasi
                                    </h3>
                                    <p class="text-sm text-base-content/70 mb-4">
                                        Booking dari <span class="font-semibold">{{ $booking->nama_mahasiswa }}</span>
                                    </p>
                                    
                                    <form method="POST" action="{{ route('booking.reject', $booking) }}" class="space-y-4">
                                        @csrf
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold">Alasan Penolakan <span class="text-error">*</span></span>
                                            </label>
                                            <textarea name="alasan_reject" 
                                                      class="textarea textarea-bordered h-32" 
                                                      placeholder="Jelaskan dengan jelas mengapa booking ini ditolak. Informasi ini akan membantu mahasiswa memahami alasan penolakan."
                                                      required></textarea>
                                            <label class="label">
                                                <span class="label-text-alt text-base-content/60">Minimal 10 karakter</span>
                                            </label>
                                        </div>

                                        <div class="alert alert-warning">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm">Mahasiswa akan melihat alasan penolakan ini.</span>
                                        </div>

                                        <div class="modal-action">
                                            <button type="button" class="btn btn-ghost" onclick="rejectModal{{ $booking->id }}.close()">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-error gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Tolak Booking
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <form method="dialog" class="modal-backdrop">
                                    <button>close</button>
                                </form>
                            </dialog>
                        @elseif($booking->status == 'approved')
                            <div class="badge badge-success badge-lg gap-2 p-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Sudah Disetujui
                            </div>
                        @elseif($booking->status == 'rejected')
                            <div class="badge badge-error badge-lg gap-2 p-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Sudah Ditolak
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card bg-base-100 shadow-xl border-2 border-dashed border-base-300">
            <div class="card-body text-center py-16">
                <div class="mb-6">
                    <div class="inline-block p-6 bg-base-200 rounded-full">
                        <svg class="w-20 h-20 text-base-content/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold mb-2">
                    @if(request('status'))
                        Tidak ada booking dengan status "{{ ucfirst(request('status')) }}"
                    @else
                        Belum Ada Booking
                    @endif
                </h3>
                <p class="text-base-content/70 max-w-md mx-auto">
                    @if(request('status'))
                        Coba filter status lain untuk melihat booking konsultasi.
                    @else
                        Mahasiswa dapat melakukan booking konsultasi melalui halaman detail dosen.
                    @endif
                </p>
                @if(request('status'))
                    <div class="mt-6">
                        <a href="{{ route('booking.index') }}" class="btn btn-primary btn-sm gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Tampilkan Semua Booking
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($bookings->hasPages())
    <div class="flex justify-center mt-8">
        <div class="join">
            {{ $bookings->links() }}
        </div>
    </div>
@endif

<script>
function refreshPage() {
    location.reload();
}
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>

@endsection
