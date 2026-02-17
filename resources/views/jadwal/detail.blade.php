@extends('layouts.app')

@section('title','Detail Dosen')

@section('content')
<div class="grid md:grid-cols-3 gap-8">
    <div class="md:col-span-1">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-2">{{ $user->name }}</h2>
                <p class="text-sm text-base-content/70 mb-1">NIP: {{ $user->nip ?? '-' }}</p>
                <p class="text-sm text-base-content/70 mb-3">
                    Role: {{ str_replace('_',' ', $user->role) }}
                </p>

                @php
                    $status = optional($user->status)->status ?? 'Tidak Ada';
                    $color = match($status) {
                        'Ada' => 'badge-success',
                        'Mengajar' => 'badge-warning',
                        'Konsultasi' => 'badge-info',
                        default => 'badge-neutral',
                    };
                    $emoji = match($status) {
                        'Ada' => '🟢',
                        'Mengajar' => '🟡',
                        'Konsultasi' => '🔵',
                        default => '⚪',
                    };
                @endphp

                <div class="mb-4">
                    <div class="text-xs text-base-content/60 mb-1">Status Real-Time</div>
                    <div class="badge {{ $color }} gap-1">
                        {{ $emoji }} {{ $status }}
                    </div>
                </div>

                <div>
                    <div class="text-xs text-base-content/60 mb-1">QR Code (placeholder)</div>
                    <div class="w-24 h-24 border-dashed border-2 border-base-300 rounded-lg flex items-center justify-center text-xs text-base-content/50">
                        QR Code
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="md:col-span-2 space-y-8">
        <div>
            <h3 class="text-xl font-semibold mb-3">Jadwal Mingguan</h3>
            <div class="overflow-x-auto bg-base-100 rounded-lg shadow">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Jam</th>
                            <th>Kegiatan</th>
                            <th>Ruangan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->jadwals as $j)
                            <tr>
                                <td>{{ $j->hari }}</td>
                                <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                <td>{{ $j->kegiatan }}</td>
                                <td>{{ $j->ruangan ?? '-' }}</td>
                                <td>{{ $j->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-base-content/60">
                                    Belum ada jadwal.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="booking">
            <h3 class="text-xl font-semibold mb-3">Booking Konsultasi</h3>
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('dosen.booking.store',$user) }}">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="form-control">
                                <label class="label"><span class="label-text">Nama Mahasiswa</span></label>
                                <input type="text" name="nama_mahasiswa" class="input input-bordered" required value="{{ old('nama_mahasiswa') }}">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Email Mahasiswa</span></label>
                                <input type="email" name="email_mahasiswa" class="input input-bordered" required value="{{ old('email_mahasiswa') }}">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">NIM</span></label>
                                <input type="text" name="nim_mahasiswa" class="input input-bordered" value="{{ old('nim_mahasiswa') }}">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Tanggal Booking</span></label>
                                <input type="date" name="tanggal_booking" class="input input-bordered" min="{{ now()->addDay()->toDateString() }}" required value="{{ old('tanggal_booking') }}">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Jam Mulai</span></label>
                                <input type="time" name="jam_mulai" class="input input-bordered" required value="{{ old('jam_mulai') }}">
                            </div>
                            <div class="form-control">
                                <label class="label"><span class="label-text">Jam Selesai</span></label>
                                <input type="time" name="jam_selesai" class="input input-bordered" required value="{{ old('jam_selesai') }}">
                            </div>
                        </div>

                        <div class="form-control mt-4">
                            <label class="label"><span class="label-text">Keperluan</span></label>
                            <textarea name="keperluan" class="textarea textarea-bordered" rows="4" required>{{ old('keperluan') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary w-full md:w-auto">
                                Kirim Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
