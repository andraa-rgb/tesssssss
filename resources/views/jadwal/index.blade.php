@extends('layouts.app')

@section('title', 'Kelola Jadwal')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold">Kelola Jadwal</h1>
        <p class="text-base-content/70 mt-1">Manage jadwal mingguan Anda</p>
    </div>
    <a href="{{ route('jadwal.create') }}" class="btn btn-primary gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Jadwal
    </a>
</div>

<!-- Stats Cards -->
<div class="grid md:grid-cols-4 gap-4 mb-6">
    <div class="stat bg-base-100 shadow">
        <div class="stat-title">Total Jadwal</div>
        <div class="stat-value text-primary">{{ $jadwals->total() }}</div>
    </div>
    <div class="stat bg-base-100 shadow">
        <div class="stat-title">Senin - Rabu</div>
        <div class="stat-value text-secondary">{{ auth()->user()->jadwals()->whereIn('hari',['Senin','Selasa','Rabu'])->count() }}</div>
    </div>
    <div class="stat bg-base-100 shadow">
        <div class="stat-title">Kamis - Jumat</div>
        <div class="stat-value text-accent">{{ auth()->user()->jadwals()->whereIn('hari',['Kamis','Jumat'])->count() }}</div>
    </div>
    <div class="stat bg-base-100 shadow">
        <div class="stat-title">Jam Mengajar</div>
        <div class="stat-value text-info">{{ auth()->user()->jadwals()->where('kegiatan','Mengajar')->count() * 2 }}h</div>
    </div>
</div>

<!-- Table -->
<div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <div class="overflow-x-auto">
            <table class="table table-zebra">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Waktu</th>
                        <th>Kegiatan</th>
                        <th>Ruangan</th>
                        <th>Keterangan</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $jadwal)
                        <tr>
                            <td>
                                <div class="font-semibold">{{ $jadwal->hari }}</div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    {{ date('H:i', strtotime($jadwal->jam_mulai)) }} - 
                                    {{ date('H:i', strtotime($jadwal->jam_selesai)) }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $badgeColor = match($jadwal->kegiatan) {
                                        'Mengajar' => 'badge-primary',
                                        'Konsultasi' => 'badge-success',
                                        'Rapat' => 'badge-warning',
                                        default => 'badge-neutral',
                                    };
                                    $icon = match($jadwal->kegiatan) {
                                        'Mengajar' => '📚',
                                        'Konsultasi' => '💬',
                                        'Rapat' => '📋',
                                        default => '📌',
                                    };
                                @endphp
                                <div class="badge {{ $badgeColor }} gap-1">
                                    {{ $icon }} {{ $jadwal->kegiatan }}
                                </div>
                            </td>
                            <td>{{ $jadwal->ruangan ?? '-' }}</td>
                            <td>
                                <div class="text-sm text-base-content/70 max-w-xs truncate">
                                    {{ $jadwal->keterangan ?? '-' }}
                                </div>
                            </td>
                            <td class="text-right">
                                <div class="flex gap-2 justify-end">
                                    <a href="{{ route('jadwal.edit', $jadwal) }}" class="btn btn-ghost btn-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button class="btn btn-ghost btn-sm text-error" onclick="deleteModal{{ $jadwal->id }}.showModal()">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Delete Modal -->
                                <dialog id="deleteModal{{ $jadwal->id }}" class="modal">
                                    <div class="modal-box">
                                        <h3 class="font-bold text-lg">Konfirmasi Hapus</h3>
                                        <p class="py-4">Yakin ingin menghapus jadwal {{ $jadwal->hari }} ({{ $jadwal->jam_mulai }}-{{ $jadwal->jam_selesai }})?</p>
                                        <div class="modal-action">
                                            <form method="POST" action="{{ route('jadwal.destroy', $jadwal) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-ghost" onclick="deleteModal{{ $jadwal->id }}.close()">Batal</button>
                                                <button type="submit" class="btn btn-error">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </dialog>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-16 h-16 text-base-content/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="text-base-content/70">Belum ada jadwal. Klik tombol "Tambah Jadwal" untuk membuat jadwal baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($jadwals->hasPages())
            <div class="mt-6">
                {{ $jadwals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
