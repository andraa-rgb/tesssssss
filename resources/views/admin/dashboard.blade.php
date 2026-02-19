@extends('layouts.app')

@section('title', 'Dashboard Admin - Lab WICIDA')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-2">
        <div>
            <h1 class="text-2xl font-bold">Dashboard Admin</h1>
            <p class="text-sm text-base-content/70">
                Kelola akun dosen dan pantau aktivitas booking konsultasi.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="badge badge-outline badge-sm">
                Role: Admin
            </span>
        </div>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body flex flex-row items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-base-content/60 mb-1">Total Dosen</p>
                    <p class="text-3xl font-bold">{{ $totalDosen }}</p>
                </div>
                <div class="rounded-full bg-primary/10 text-primary p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0
                                018 0zM12 14a7 7 0 00-7 7h14a7 7 0
                                00-7-7z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body flex flex-row items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-base-content/60 mb-1">Total Jadwal Terdaftar</p>
                    <p class="text-3xl font-bold">{{ $totalJadwal }}</p>
                </div>
                <div class="rounded-full bg-secondary/10 text-secondary p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
                                002-2V7a2 2 0 00-2-2H5a2 2 0
                                00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body flex flex-row items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-base-content/60 mb-1">Booking Aktif</p>
                    <p class="text-3xl font-bold">{{ $bookingAktif }}</p>
                </div>
                <div class="rounded-full bg-accent/10 text-accent p-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0
                                002 2h10a2 2 0 002-2V7a2 2 0
                                00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0
                                002-2M9 5a2 2 0 012-2h2a2 2 0
                                012 2" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Aksi cepat --}}
<div class="flex flex-wrap gap-2">
    <a href="{{ route('admin.dosen.index') }}" class="btn btn-primary btn-sm gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 7h18M3 12h18M3 17h18" />
        </svg>
        Kelola Dosen
    </a>
    <a href="{{ route('home') }}" class="btn btn-ghost btn-sm gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0
                    001 1h3m10-11l2 2m-2-2v10a1 1 0
                    01-1 1h-3m-6 0h6" />
        </svg>
        Lihat Landing
    </a>
</div>


    {{-- Tabel dosen terbaru --}}
    <div class="card bg-base-100 shadow-lg border border-base-300 mt-4">
        <div class="card-body">
            <div class="flex items-center justify-between mb-3">
                <h2 class="card-title text-base">Dosen Terbaru</h2>
                <a href="{{ route('admin.dosen.create') }}" class="btn btn-sm btn-primary gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Dosen
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($dosens->isEmpty())
                <div class="text-sm text-base-content/60">
                    Belum ada akun dosen yang terdaftar.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="table table-zebra text-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIP</th>
                                <th>Role</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dosens as $index => $dosen)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="font-semibold">{{ $dosen->name }}</td>
                                    <td>{{ $dosen->email }}</td>
                                    <td>{{ $dosen->nip ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-outline capitalize">
                                            {{ str_replace('_', ' ', $dosen->role) }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <div class="flex justify-end gap-1">
                                            @if(Route::has('admin.dosen.edit'))
                                                <a href="{{ route('admin.dosen.edit', $dosen) }}"
                                                   class="btn btn-ghost btn-xs gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0
                                                                00.707-.293l9.414-9.414a2 2 0
                                                                00-2.828-2.828l-9.414 9.414A1 1 0
                                                                006.586 18H4v2z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                            @endif
                                            <form action="{{ route('admin.dosen.destroy', $dosen) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus dosen ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost btn-xs text-error gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0
                                                                0116.138 21H7.862a2 2 0
                                                                01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0
                                                                00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
