@extends('layouts.app')

@section('title', 'Dashboard Dosen - Lab WICIDA')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KOLOM KIRI: CARDS STATISTIK --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- NOTIFIKASI SUCCESS/ERROR --}}
        <div id="status-alert" class="alert alert-success shadow-lg hidden">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="status-alert-message">Status berhasil diperbarui!</span>
        </div>

        {{-- STATISTIK RINGKASAN --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- JADWAL HARI INI (RUTIN + BOOKING DISETUJUI) --}}
<div class="card bg-base-100 shadow-lg border border-base-300">
    <div class="card-body">
        <h2 class="card-title mb-2 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Jadwal Hari Ini
            <span class="badge badge-outline text-xs">
                {{ now()->locale('id')->translatedFormat('l, d M Y') }}
            </span>
        </h2>

        @if(isset($todayAllEvents) && $todayAllEvents->isNotEmpty())
            <div class="space-y-3">
                @foreach($todayAllEvents as $event)
                    <div class="flex items-start justify-between p-3 rounded-xl border border-base-300/70 bg-base-200/60 hover:shadow-md transition-shadow">
                        <div class="flex-1">
                            <div class="text-xs uppercase tracking-widest text-base-content/60">
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['jam_mulai'])->format('H:i') }}
                                – {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['jam_selesai'])->format('H:i') }}
                            </div>
                            <div class="font-semibold text-sm mt-1 flex items-center gap-2">
                                {{ $event['kegiatan'] }}
                                @if($event['tipe'] === 'booking')
                                    <span class="badge badge-success badge-xs">Booking Approved</span>
                                @endif
                            </div>
                            <div class="text-xs text-base-content/70 mt-1">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $event['ruangan'] ?? '-' }}
                                </span>
                                @if($event['tipe'] === 'booking' && !empty($event['nama_mahasiswa']))
                                    <span class="ml-2">·</span>
                                    <span class="inline-flex items-center gap-1 ml-2">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ $event['nama_mahasiswa'] }}
                                        @if(!empty($event['nim_mahasiswa']))
                                            <span class="text-[10px] opacity-70">({{ $event['nim_mahasiswa'] }})</span>
                                        @endif
                                    </span>
                                @endif
                            </div>
                            @if(!empty($event['keterangan']))
                                <div class="text-[11px] text-base-content/60 mt-2 italic">
                                    "{{ $event['keterangan'] }}"
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
                <svg class="w-12 h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p>Belum ada jadwal atau booking untuk hari ini.</p>
            </div>
        @endif
    </div>
</div>

            
            {{-- Card Total Jadwal --}}
            <div class="stats shadow-lg bg-gradient-to-br from-primary/10 to-primary/5 border border-primary/20">
                <div class="stat">
                    <div class="stat-figure text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="stat-title">Total Jadwal</div>
                    <div class="stat-value text-primary">{{ $totalJadwal }}</div>
                    <div class="stat-desc">Minggu ini</div>
                </div>
            </div>

            {{-- Card Booking Pending --}}
            <div class="stats shadow-lg bg-gradient-to-br from-warning/10 to-warning/5 border border-warning/20">
                <div class="stat">
                    <div class="stat-figure text-warning">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Booking Pending</div>
                    <div class="stat-value text-warning">{{ $pendingBooking }}</div>
                    <div class="stat-desc">Menunggu persetujuan</div>
                </div>
            </div>

            {{-- Card Status Saat Ini --}}
            <div class="stats shadow-lg bg-gradient-to-br from-success/10 to-success/5 border border-success/20">
                <div class="stat">
                    <div class="stat-figure text-success">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="stat-title">Status Saat Ini</div>
                    <div class="stat-value text-success text-xl" id="current-status-display">
                        {{ $status->status ?? 'Belum diatur' }}
                    </div>
                    <div class="stat-desc">Real-time status</div>
                </div>
            </div>

        </div>

        {{-- JADWAL MINGGU INI --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body">
                <h2 class="card-title mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Jadwal Minggu Ini
                </h2>

                @if(isset($jadwalMingguIni) && $jadwalMingguIni->isNotEmpty())
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
                                @foreach($jadwalMingguIni as $j)
                                    <tr>
                                        <td class="font-semibold">{{ $j->hari }}</td>
                                        <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                        <td>{{ $j->kegiatan }}</td>
                                        <td>{{ $j->ruangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-base-content/60">
                        <p>Belum ada jadwal minggu ini.</p>
                        <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-sm mt-4">
                            Tambah Jadwal
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('jadwal.create') }}" class="btn btn-outline btn-lg gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal
            </a>
            <a href="{{ route('booking.index') }}" class="btn btn-outline btn-lg gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Lihat Booking
            </a>
        </div>

    </div>

    {{-- KOLOM KANAN: STATUS & QR CODE --}}
    <div class="space-y-6">

        {{-- CARD UPDATE STATUS --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body">
                <h3 class="card-title text-base mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status Real-time
                </h3>

                <form id="status-form">
                    @csrf
                    <div class="form-control space-y-2">
                        @foreach(['Ada', 'Mengajar', 'Konsultasi', 'Tidak Ada'] as $s)
                            <label class="label cursor-pointer justify-start gap-3 p-3 rounded-lg hover:bg-base-200 transition-colors">
                                <input type="radio" name="status" value="{{ $s }}"
                                       class="radio radio-primary"
                                       {{ isset($status) && ($status->status ?? '') === $s ? 'checked' : '' }}>
                                <span class="label-text font-semibold">{{ $s }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mt-4" id="status-submit-btn">
                        <span class="loading loading-spinner loading-sm hidden" id="status-loading"></span>
                        <span id="status-btn-text">Update Status</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- CARD QR CODE --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body items-center text-center">
                <h3 class="card-title text-base mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    QR Code Profil
                </h3>
                <p class="text-xs text-base-content/60 mb-3">
                    Scan untuk akses cepat
                </p>
                
                {{-- QR Code SVG --}}
                <div class="bg-white p-4 rounded-lg border-2 border-base-300">
                    {!! QrCode::size(150)->style('round')->eye('circle')->generate(route('dosen.show', auth()->id())) !!}
                </div>
                
                <a href="{{ route('profile.edit') }}#qrcode" 
                   class="btn btn-sm btn-ghost mt-3 gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Kelola QR
                </a>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusForm = document.getElementById('status-form');
    const statusAlert = document.getElementById('status-alert');
    const statusAlertMessage = document.getElementById('status-alert-message');
    const statusDisplay = document.getElementById('current-status-display');
    const submitBtn = document.getElementById('status-submit-btn');
    const btnText = document.getElementById('status-btn-text');
    const loading = document.getElementById('status-loading');

    statusForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(statusForm);
        const selectedStatus = formData.get('status');

        // Show loading
        submitBtn.disabled = true;
        loading.classList.remove('hidden');
        btnText.textContent = 'Memperbarui...';

        // Send AJAX request
        fetch('{{ route("api.status.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                status: selectedStatus,
            }),
        })
        .then(response => response.json())
        .then(data => {
            // Update status display
            statusDisplay.textContent = data.data.status;

            // Show success alert
            statusAlert.classList.remove('hidden', 'alert-error');
            statusAlert.classList.add('alert-success');
            statusAlertMessage.textContent = data.message;

            setTimeout(() => {
                statusAlert.classList.add('hidden');
            }, 3000);

            submitBtn.disabled = false;
            loading.classList.add('hidden');
            btnText.textContent = 'Update Status';
        })
        .catch(error => {
            console.error('Error:', error);

            statusAlert.classList.remove('hidden', 'alert-success');
            statusAlert.classList.add('alert-error');
            statusAlertMessage.textContent = 'Gagal memperbarui status. Silakan coba lagi.';

            setTimeout(() => {
                statusAlert.classList.add('hidden');
            }, 3000);

            submitBtn.disabled = false;
            loading.classList.add('hidden');
            btnText.textContent = 'Update Status';
        });
    });
});
</script>
@endpush
