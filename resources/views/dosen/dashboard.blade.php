@extends('layouts.app')

@section('title', 'Dashboard Dosen - Lab WICIDA')

@section('content')

{{-- HEADER --}}
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black flex items-center gap-3">
                <span class="text-4xl">📊</span>
                <span>Dashboard Dosen</span>
            </h1>
            <p class="text-base-content/70 mt-1">
                Ringkasan jadwal, booking, dan status kehadiran Anda di Lab WICIDA.
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('jadwal.create') }}" class="btn btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal
            </a>
            <a href="{{ route('booking.index') }}" class="btn btn-outline gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5a2 2 0 002 2h2a2 2 0 002-2" />
                </svg>
                Kelola Booking
            </a>
        </div>
    </div>
</div>

{{-- TOP GRID --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- STAT CARDS --}}
    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Total Jadwal --}}
        <div class="stat bg-gradient-to-br from-primary/20 to-primary/5 rounded-2xl shadow-lg border border-primary/20 hover:shadow-xl transition-all">
            <div class="stat-figure text-primary">
                <div class="avatar placeholder">
                    <div class="bg-primary text-primary-content rounded-full w-12">
                        <span class="text-2xl">📅</span>
                    </div>
                </div>
            </div>
            <div class="stat-title font-semibold">Total Jadwal</div>
            <div class="stat-value text-primary text-4xl">{{ $totalJadwal }}</div>
            <div class="stat-desc">Minggu berjalan</div>
        </div>

        {{-- Booking Pending --}}
        <div class="stat bg-gradient-to-br from-warning/20 to-warning/5 rounded-2xl shadow-lg border border-warning/20 hover:shadow-xl transition-all">
            <div class="stat-figure text-warning">
                <div class="avatar placeholder">
                    <div class="bg-warning text-warning-content rounded-full w-12">
                        <span class="text-2xl">📝</span>
                    </div>
                </div>
            </div>
            <div class="stat-title font-semibold">Booking Pending</div>
            <div class="stat-value text-warning text-4xl">{{ $pendingBooking }}</div>
            <div class="stat-desc">Menunggu keputusan Anda</div>
        </div>

        {{-- Status Saat Ini --}}
        @php
            $currentStatus = $status->status ?? 'Tidak Ada';
            $statusColor = match($currentStatus) {
                'Ada' => 'text-success',
                'Mengajar' => 'text-warning',
                'Konsultasi' => 'text-info',
                default => 'text-base-content/60',
            };
            $statusEmoji = match($currentStatus) {
                'Ada' => '🟢',
                'Mengajar' => '📖',
                'Konsultasi' => '💬',
                default => '⚪',
            };
        @endphp
        <div class="stat bg-gradient-to-br from-accent/20 to-accent/5 rounded-2xl shadow-lg border border-accent/20 hover:shadow-xl transition-all">
            <div class="stat-figure {{ $statusColor }}">
                <div class="avatar placeholder">
                    <div class="bg-accent text-accent-content rounded-full w-12">
                        <span class="text-2xl">{{ $statusEmoji }}</span>
                    </div>
                </div>
            </div>
            <div class="stat-title font-semibold">Status Saat Ini</div>
            <div class="stat-value {{ $statusColor }} text-2xl md:text-3xl">
                {{ $currentStatus }}
            </div>
            <div class="stat-desc">Terlihat di halaman publik</div>
        </div>
    </div>

    {{-- STATUS REAL-TIME CARD --}}
    <div class="card bg-base-100 rounded-2xl shadow-lg border border-base-300">
        <div class="card-body">
            <h2 class="card-title mb-1 flex items-center gap-2">
                <span class="text-lg">Status Real-time</span>
                <span class="badge badge-outline badge-sm">Lab</span>
            </h2>
            <p class="text-sm text-base-content/70 mb-4">
                Atur status kehadiran Anda di lab. Status ini akan tampil di halaman jadwal publik.
            </p>

            <form method="POST" action="{{ route('api.status.update') }}" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <label class="label cursor-pointer justify-start gap-3 p-3 rounded-xl border border-base-300 hover:border-success/60 hover:bg-success/5 transition-all">
                        <input type="radio" name="status" value="Ada"
                               class="radio radio-success"
                               {{ $currentStatus === 'Ada' ? 'checked' : '' }}>
                        <span class="flex flex-col">
                            <span class="font-semibold text-sm">Ada di Lab</span>
                            <span class="text-[11px] text-base-content/60">Siap ditemui di ruangan</span>
                        </span>
                    </label>

                    <label class="label cursor-pointer justify-start gap-3 p-3 rounded-xl border border-base-300 hover:border-warning/60 hover:bg-warning/5 transition-all">
                        <input type="radio" name="status" value="Mengajar"
                               class="radio radio-warning"
                               {{ $currentStatus === 'Mengajar' ? 'checked' : '' }}>
                        <span class="flex flex-col">
                            <span class="font-semibold text-sm">Mengajar</span>
                            <span class="text-[11px] text-base-content/60">Sedang di kelas/perkuliahan</span>
                        </span>
                    </label>

                    <label class="label cursor-pointer justify-start gap-3 p-3 rounded-xl border border-base-300 hover:border-info/60 hover:bg-info/5 transition-all">
                        <input type="radio" name="status" value="Konsultasi"
                               class="radio radio-info"
                               {{ $currentStatus === 'Konsultasi' ? 'checked' : '' }}>
                        <span class="flex flex-col">
                            <span class="font-semibold text-sm">Konsultasi</span>
                            <span class="text-[11px] text-base-content/60">Sedang menerima konsultasi</span>
                        </span>
                    </label>

                    <label class="label cursor-pointer justify-start gap-3 p-3 rounded-xl border border-base-300 hover:border-neutral/60 hover:bg-neutral/5 transition-all">
                        <input type="radio" name="status" value="Tidak Ada"
                               class="radio radio-neutral"
                               {{ $currentStatus === 'Tidak Ada' ? 'checked' : '' }}>
                        <span class="flex flex-col">
                            <span class="font-semibold text-sm">Tidak Ada</span>
                            <span class="text-[11px] text-base-content/60">Tidak berada di lab</span>
                        </span>
                    </label>
                </div>

                <button class="btn btn-primary btn-block mt-2 gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Status
                </button>

                <p class="text-[11px] text-base-content/60 mt-1">
                    Tip: Perbarui status saat Anda masuk/keluar lab atau mulai/selesai mengajar.
                </p>
            </form>
        </div>
    </div>
</div>

{{-- JADWAL MINGGU INI --}}
<div class="mt-10">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
        <div>
            <h2 class="text-xl md:text-2xl font-bold flex items-center gap-2">
                <span class="text-2xl">📆</span>
                Jadwal Minggu Ini
            </h2>
            <p class="text-sm text-base-content/70">
                Jadwal mengajar dan konsultasi dari Senin sampai Jumat.
            </p>
        </div>
        <a href="{{ route('jadwal.index') }}" class="btn btn-sm btn-outline gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Kelola Jadwal
        </a>
    </div>

    @if($jadwalMingguIni->isEmpty())
        <div class="card bg-base-100 shadow-md border border-dashed border-base-300">
            <div class="card-body text-center py-10">
                <div class="mb-4">
                    <span class="text-5xl">📭</span>
                </div>
                <h3 class="text-lg font-semibold mb-1">Belum Ada Jadwal</h3>
                <p class="text-sm text-base-content/70 mb-4">
                    Tambahkan jadwal mengajar atau konsultasi pertama Anda.
                </p>
                <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Jadwal
                </a>
            </div>
        </div>
    @else
        <div class="overflow-x-auto bg-base-100 rounded-2xl shadow-lg border border-base-300">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Kegiatan</th>
                        <th>Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwalMingguIni as $j)
                        @php
                            $badgeKegiatan = match($j->kegiatan) {
                                'Mengajar' => 'badge-primary',
                                'Konsultasi' => 'badge-secondary',
                                'Rapat' => 'badge-accent',
                                default => 'badge-ghost',
                            };
                        @endphp
                        <tr>
                            <td class="font-semibold">{{ $j->hari }}</td>
                            <td>{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }}</td>
                            <td>
                                <span class="badge {{ $badgeKegiatan }} badge-sm">
                                    {{ $j->kegiatan }}
                                </span>
                            </td>
                            <td>{{ $j->ruangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
