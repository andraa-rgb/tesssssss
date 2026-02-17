@extends('layouts.app')

@section('title', 'Dashboard Admin - Lab WICIDA')

@section('content')

<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-black flex items-center gap-3">
                <span class="text-4xl">🛠️</span>
                <span>Dashboard Admin</span>
            </h1>
            <p class="text-base-content/70 mt-1">
                Kelola akun dosen dan pantau aktivitas sistem jadwal.
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Akun Dosen
            </a>
            <a href="{{ route('admin.dosen.index') }}"" class="btn btn-outline gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M12 4a4 4 0 11-4 4 4 4 0 014-4z" />
                </svg>
                Kelola Dosen
            </a>
        </div>
    </div>
</div>

{{-- STATISTIK UTAMA --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
    <div class="stat bg-base-100 rounded-2xl shadow-lg border border-base-300">
        <div class="stat-figure text-primary">
            <span class="text-3xl">👨‍🏫</span>
        </div>
        <div class="stat-title font-semibold">Total Dosen</div>
        <div class="stat-value text-primary text-3xl">{{ $totalDosen }}</div>
        <div class="stat-desc">Termasuk kepala lab & staf</div>
    </div>

    <div class="stat bg-base-100 rounded-2xl shadow-lg border border-base-300">
        <div class="stat-figure text-secondary">
            <span class="text-3xl">📅</span>
        </div>
        <div class="stat-title font-semibold">Total Jadwal</div>
        <div class="stat-value text-secondary text-3xl">{{ $totalJadwal }}</div>
        <div class="stat-desc">Semua dosen</div>
    </div>

    <div class="stat bg-base-100 rounded-2xl shadow-lg border border-base-300">
        <div class="stat-figure text-accent">
            <span class="text-3xl">📝</span>
        </div>
        <div class="stat-title font-semibold">Booking Aktif</div>
        <div class="stat-value text-accent text-3xl">{{ $bookingAktif }}</div>
        <div class="stat-desc">Pending + disetujui</div>
    </div>
</div>

{{-- LIST DOSEN SINGKAT --}}
<div class="card bg-base-100 shadow-lg border border-base-300">
    <div class="card-body">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="card-title">Daftar Dosen</h2>
                <p class="text-sm text-base-content/70">
                    Ringkasan akun dosen yang terdaftar di sistem.
                </p>
            </div>
            <a href="{{ route('admin.dosen.index') }}" class="btn btn-sm btn-outline gap-2">
                Lihat Semua
            </a>
        </div>

        @if($dosens->isEmpty())
            <p class="text-sm text-base-content/70">Belum ada akun dosen yang terdaftar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dosens as $idx => $dosen)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td class="font-semibold">{{ $dosen->name }}</td>
                                <td>{{ $dosen->email }}</td>
                                <td class="capitalize">{{ str_replace('_',' ', $dosen->role) }}</td>
                                <td>{{ $dosen->created_at?->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
