{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard Dosen - Lab WICIDA')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-base-content">Dashboard Dosen</h1>
                <p class="text-sm text-base-content/60">
                    Selamat datang, {{ auth()->user()->name }}.
                </p>
            </div>
        </div>

        {{-- STAT KARTU --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="stat bg-base-100 shadow">
                <div class="stat-figure text-primary">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="stat-title">Total Jadwal</div>
                <div class="stat-value text-primary">{{ $totalJadwal ?? 0 }}</div>
            </div>

            <div class="stat bg-base-100 shadow">
                <div class="stat-figure text-secondary">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    </svg>
                </div>
                <div class="stat-title">Total Booking</div>
                <div class="stat-value text-secondary">{{ $totalBooking ?? 0 }}</div>
            </div>

            <div class="stat bg-base-100 shadow">
                <div class="stat-figure text-warning">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Pending</div>
                <div class="stat-value text-warning">{{ $pendingBooking ?? 0 }}</div>
            </div>

            <div class="stat bg-base-100 shadow">
                <div class="stat-figure text-success">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stat-title">Approved</div>
                <div class="stat-value text-success">{{ $approvedBooking ?? 0 }}</div>
            </div>
        </div>

        {{-- BOOKING TERBARU --}}
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">Booking Terbaru</h2>

                @if(!empty($recentBookings) && $recentBookings->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="table table-zebra">
                            <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Tanggal & Waktu</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($recentBookings as $booking)
                                <tr>
                                    <td>
                                        <div class="font-semibold">{{ $booking->nama_mahasiswa }}</div>
                                        <div class="text-xs text-base-content/60">{{ $booking->email_mahasiswa }}</div>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->translatedFormat('d M Y') }}
                                        <span class="text-xs text-base-content/60">
                                            ({{ substr($booking->jam_mulai,0,5) }}–{{ substr($booking->jam_selesai,0,5) }})
                                        </span>
                                    </td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($booking->status === 'approved')
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-error">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-sm text-base-content/60">
                        Belum ada booking konsultasi.
                    </p>
                @endif

                <div class="card-actions justify-end mt-4">
                    <a href="{{ route('booking.index') }}" class="btn btn-primary btn-sm">
                        Kelola Semua Booking
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
