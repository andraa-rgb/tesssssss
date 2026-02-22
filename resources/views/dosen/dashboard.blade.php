@extends('layouts.app')

@section('title', 'Dashboard Dosen - Lab WICIDA')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- KOLOM KIRI: STATISTIK & JADWAL --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- NOTIFIKASI SUCCESS/ERROR --}}
        <div id="status-alert" class="alert alert-success shadow-lg hidden">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span id="status-alert-message">Status berhasil diperbarui!</span>
        </div>

        {{-- STATISTIK RINGKASAN + JADWAL HARI INI --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-stretch">

            {{-- Jadwal Hari Ini (rutin + booking approved) --}}
            <div class="md:col-span-2">
                <div class="card bg-base-100 shadow-lg border border-base-300 h-full flex flex-col">
                    <div class="card-body flex flex-col gap-3">
                        <h2 class="card-title mb-1 flex flex-wrap items-center gap-2">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm sm:text-base">Jadwal Hari Ini</span>
                            <span class="badge badge-outline text-[10px] sm:text-[11px]">
                                {{ now()->locale('id')->translatedFormat('l, d M Y') }}
                            </span>
                        </h2>

                        @if(isset($todayAllEvents) && $todayAllEvents->isNotEmpty())
                            <div class="space-y-3">
                                @foreach($todayAllEvents as $event)
                                    @php
                                        $isBooking = $event['tipe'] === 'booking';
                                        $ruanganNama = $event['ruangan_nama'] ?? $event['ruangan'] ?? '-';
                                        $hasBookingId = $isBooking && !empty($event['booking_id']);
                                    @endphp

                                    {{-- Jika booking dengan ID: bungkus dengan link --}}
                                    @if($hasBookingId)
                                        <a href="{{ route('booking.show', $event['booking_id']) }}"
                                           class="block group">
                                    @endif

                                    <div class="flex items-start justify-between p-3 rounded-xl border border-base-300/70 bg-base-200/60 
                                                {{ $hasBookingId ? 'group-hover:bg-base-200 hover:shadow-md cursor-pointer' : '' }} 
                                                transition-all text-sm">
                                        <div class="flex-1 min-w-0">
                                            <div class="text-[10px] sm:text-[11px] uppercase tracking-widest text-base-content/60 mb-1">
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['jam_mulai'])->format('H:i') }}
                                                –
                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $event['jam_selesai'])->format('H:i') }}
                                            </div>

                                            <div class="font-semibold text-xs sm:text-sm mt-1 flex flex-wrap items-center gap-2 break-words">
                                                <span>{{ $event['kegiatan'] }}</span>
                                                @if($isBooking)
                                                    <span class="badge badge-success badge-xs">
                                                        Approved
                                                    </span>
                                                @endif
                                                @if($hasBookingId)
                                                    <span class="badge badge-ghost badge-xs group-hover:badge-primary transition-colors">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                        </svg>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="text-[10px] sm:text-[11px] text-base-content/70 mt-1 flex flex-wrap items-center gap-x-2 gap-y-1">
                                                {{-- Ruangan --}}
                                                <span class="inline-flex items-center gap-1">
                                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <span>{{ $ruanganNama }}</span>
                                                </span>

                                                {{-- Info mahasiswa booking --}}
                                                @if($isBooking && !empty($event['nama_mahasiswa']))
                                                    <span class="text-base-content/40">·</span>
                                                    <span class="inline-flex items-center gap-1">
                                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        <span>{{ $event['nama_mahasiswa'] }}</span>
                                                        @if(!empty($event['nim_mahasiswa']))
                                                            <span class="text-[9px] sm:text-[10px] opacity-70">
                                                                ({{ $event['nim_mahasiswa'] }})
                                                            </span>
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>

                                            @if(!empty($event['keterangan']))
                                                <div class="text-[10px] sm:text-[11px] text-base-content/60 mt-2 italic break-words line-clamp-2">
                                                    "{{ $event['keterangan'] }}"
                                                </div>
                                            @endif
                                        </div>

                                        <div class="text-[9px] sm:text-[10px] uppercase tracking-wide px-2 py-1 rounded-full font-medium ml-2 shrink-0
                                            {{ $isBooking ? 'bg-success/10 text-success' : 'bg-primary/10 text-primary' }}">
                                            {{ $isBooking ? 'Konsultasi' : 'Rutin' }}
                                        </div>
                                    </div>

                                    @if($hasBookingId)
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-base-content/60 text-xs sm:text-sm">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p>Belum ada jadwal atau booking untuk hari ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Total Jadwal --}}
            <div class="card bg-base-100 shadow-lg border border-primary/20 h-full flex flex-col">
                <div class="card-body flex flex-col gap-2 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-[10px] sm:text-xs text-base-content/60">Total Jadwal</div>
                            <div class="text-xl sm:text-2xl font-bold text-primary">{{ $totalJadwal }}</div>
                        </div>
                        <div class="text-primary/70">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-auto text-[10px] sm:text-[11px] text-base-content/60">
                        Minggu ini
                    </div>
                </div>
            </div>

        </div>

        {{-- BARIS STATS LAIN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            {{-- Booking Pending --}}
            <div class="card bg-base-100 shadow-lg border border-warning/20 h-full flex flex-col">
                <div class="card-body flex flex-col gap-2 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-[10px] sm:text-xs text-base-content/60">Booking Pending</div>
                            <div class="text-xl sm:text-2xl font-bold text-warning">{{ $pendingBooking }}</div>
                        </div>
                        <div class="text-warning/70">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-auto text-[10px] sm:text-[11px] text-base-content/60">
                        Menunggu persetujuan
                    </div>
                </div>
            </div>

            {{-- Status Saat Ini --}}
            <div class="card bg-base-100 shadow-lg border border-success/20 h-full flex flex-col">
                <div class="card-body flex flex-col gap-2 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-[10px] sm:text-xs text-base-content/60">Status Saat Ini</div>
                            <div class="text-lg sm:text-xl font-bold text-success" id="current-status-display">
                                {{ $status->status ?? 'Belum diatur' }}
                            </div>
                        </div>
                        <div class="text-success/70">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-auto text-[10px] sm:text-[11px] text-base-content/60">
                        Ditampilkan di landing & daftar dosen
                    </div>
                </div>
            </div>
        </div>

        {{-- JADWAL MINGGU INI --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body p-4 sm:p-6">
                <h2 class="card-title text-base sm:text-lg mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Jadwal Minggu Ini
                </h2>

                @if(isset($jadwalMingguIni) && $jadwalMingguIni->isNotEmpty())
                    <div class="overflow-x-auto -mx-2 sm:mx-0">
                        <table class="table table-zebra text-xs sm:text-sm">
                            <thead>
                                <tr>
                                    <th class="bg-base-200">Hari</th>
                                    <th class="bg-base-200">Jam</th>
                                    <th class="bg-base-200">Kegiatan</th>
                                    <th class="bg-base-200">Ruangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwalMingguIni as $j)
                                    <tr>
                                        <td class="font-semibold whitespace-nowrap">{{ $j->hari }}</td>
                                        <td class="whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                        </td>
                                        <td class="break-words">{{ $j->kegiatan }}</td>
                                        <td>{{ optional($j->ruangan)->nama ?? $j->ruangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-base-content/60 text-xs sm:text-sm">
                        <p>Belum ada jadwal minggu ini.</p>
                        <a href="{{ route('jadwal.create') }}" class="btn btn-primary btn-sm mt-4">
                            Tambah Jadwal
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('jadwal.create') }}" class="btn btn-outline btn-sm sm:btn-lg gap-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal
            </a>
            <a href="{{ route('booking.index') }}" class="btn btn-outline btn-sm sm:btn-lg gap-2">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Lihat Booking
            </a>
        </div>

    </div>

    {{-- KOLOM KANAN: STATUS & QR --}}
    <div class="space-y-6">

        {{-- UPDATE STATUS --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body p-4 sm:p-6">
                <h3 class="card-title text-sm sm:text-base mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status Real-time
                </h3>

                <form id="status-form">
                    @csrf
                    <div class="form-control space-y-2 text-xs sm:text-sm">
                        @foreach(['Ada', 'Mengajar', 'Konsultasi', 'Tidak Ada'] as $s)
                            <label class="label cursor-pointer justify-start gap-3 p-2 sm:p-3 rounded-lg hover:bg-base-200 transition-colors">
                                <input type="radio" name="status" value="{{ $s }}"
                                       class="radio radio-primary radio-sm sm:radio-md"
                                       {{ isset($status) && ($status->status ?? '') === $s ? 'checked' : '' }}>
                                <span class="label-text font-semibold">{{ $s }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-sm sm:btn-md mt-4" id="status-submit-btn">
                        <span class="loading loading-spinner loading-sm hidden" id="status-loading"></span>
                        <span id="status-btn-text">Update Status</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- QR CODE PROFIL --}}
        <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body items-center text-center p-4 sm:p-6">
                <h3 class="card-title text-sm sm:text-base mb-2 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    QR Code Profil
                </h3>
                <p class="text-[10px] sm:text-xs text-base-content/60 mb-3">
                    Scan untuk akses cepat profil dan jadwal Anda.
                </p>

                <div class="bg-white p-3 sm:p-4 rounded-lg border-2 border-base-300">
                    {!! QrCode::size(120)->style('round')->eye('circle')->generate(route('dosen.show', auth()->id())) !!}
                </div>

                <a href="{{ route('profile.edit') }}#qrcode"
                   class="btn btn-xs sm:btn-sm btn-ghost mt-3 gap-2">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
document.addEventListener('DOMContentLoaded', function () {
    const statusForm   = document.getElementById('status-form');
    const statusAlert  = document.getElementById('status-alert');
    const statusAlertMessage = document.getElementById('status-alert-message');
    const statusDisplay = document.getElementById('current-status-display');
    const submitBtn    = document.getElementById('status-submit-btn');
    const btnText      = document.getElementById('status-btn-text');
    const loading      = document.getElementById('status-loading');

    if (!statusForm) return;

    statusForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(statusForm);
        const selectedStatus = formData.get('status');
        if (!selectedStatus) return;

        submitBtn.disabled = true;
        loading.classList.remove('hidden');
        btnText.textContent = 'Memperbarui...';

        fetch('{{ route("api.status.update") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status: selectedStatus }),
        })
        .then(response => response.json())
        .then(data => {
            statusDisplay.textContent = (data.data && data.data.status) ? data.data.status : selectedStatus;

            statusAlert.classList.remove('hidden', 'alert-error');
            statusAlert.classList.add('alert-success');
            statusAlertMessage.textContent = data.message || 'Status berhasil diperbarui!';

            setTimeout(() => statusAlert.classList.add('hidden'), 3000);

            submitBtn.disabled = false;
            loading.classList.add('hidden');
            btnText.textContent = 'Update Status';
        })
        .catch(error => {
            console.error(error);

            statusAlert.classList.remove('hidden', 'alert-success');
            statusAlert.classList.add('alert-error');
            statusAlertMessage.textContent = 'Gagal memperbarui status. Silakan coba lagi.';

            setTimeout(() => statusAlert.classList.add('hidden'), 3000);

            submitBtn.disabled = false;
            loading.classList.add('hidden');
            btnText.textContent = 'Update Status';
        });
    });
});
</script>
@endpush
