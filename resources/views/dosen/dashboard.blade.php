@extends('layouts.app')

@section('title','Dashboard Dosen')

@section('content')
<h1 class="text-2xl font-bold mb-6">Dashboard Dosen</h1>

<div class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="stat bg-base-100 shadow">
        <div class="stat-title">Total Jadwal</div>
        <div class="stat-value">{{ $totalJadwal }}</div>
    </div>
    <div class="stat bg-base-100 shadow">
        <div class="stat-title">Booking Pending</div>
        <div class="stat-value text-warning">{{ $pendingBooking }}</div>
    </div>
    <div class="stat bg-base-100 shadow">
        <div class="stat-title">Status Saat Ini</div>
        <div class="stat-value">{{ $status->status ?? 'Tidak Ada' }}</div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-8">
    <div>
        <h2 class="text-lg font-semibold mb-3">Jadwal Minggu Ini</h2>
        <div class="bg-base-100 rounded shadow overflow-x-auto">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Kegiatan</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalMingguIni as $j)
                        <tr>
                            <td>{{ $j->hari }}</td>
                            <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                            <td>{{ $j->kegiatan }}</td>
                            <td>
                                <a href="{{ route('jadwal.edit',$j) }}" class="btn btn-ghost btn-xs">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-base-content/60">Belum ada jadwal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <a href="{{ route('jadwal.index') }}" class="btn btn-link mt-2 p-0">Kelola semua jadwal →</a>
    </div>

    <div>
        <h2 class="text-lg font-semibold mb-3">Status Real-Time</h2>
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <form id="status-form">
                    @csrf
                    <div class="flex flex-col gap-2">
                        @foreach(['Ada','Mengajar','Konsultasi','Tidak Ada'] as $s)
                            <label class="label cursor-pointer justify-start gap-3">
                                <input type="radio" name="status" value="{{ $s }}"
                                       class="radio radio-primary"
                                       @checked(optional($status)->status === $s)>
                                <span class="label-text">{{ $s }}</span>
                            </label>
                        @endforeach
                    </div>
                </form>
                <p class="text-xs mt-2 text-base-content/60">
                    Terakhir update: {{ optional($status)->updated_at_iot ?? '-' }}
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('status-form').addEventListener('change', function (e) {
    if (e.target.name !== 'status') return;

    fetch("{{ route('api.status.update') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({status: e.target.value}),
    }).then(r => r.json()).then(() => {
        // opsional: tampilkan toast
    });
});
</script>
@endsection
