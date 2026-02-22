@extends('layouts.app')

@section('title', 'Detail Booking Konsultasi')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Tombol kembali --}}
    <div class="mb-6">
        <a href="{{ route('booking.index') }}" class="btn btn-ghost btn-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Booking
        </a>
    </div>

    <div class="card bg-base-100 shadow-xl border border-base-300">
        <div class="card-body p-5 sm:p-8">
            <h1 class="card-title text-xl sm:text-2xl mb-4 flex flex-wrap items-center gap-2">
                <span>Detail Booking Konsultasi</span>
                @php
                    $statusConfig = match($booking->status) {
                        'pending'  => ['badge' => 'badge-warning', 'text' => 'Menunggu'],
                        'approved' => ['badge' => 'badge-success', 'text' => 'Disetujui'],
                        'rejected' => ['badge' => 'badge-error',   'text' => 'Ditolak'],
                        default    => ['badge' => 'badge-ghost',   'text' => $booking->status],
                    };
                @endphp
                <span class="badge {{ $statusConfig['badge'] }} badge-lg">
                    {{ $statusConfig['text'] }}
                </span>
            </h1>

            <div class="grid md:grid-cols-2 gap-6">
                {{-- Data Mahasiswa --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-base sm:text-lg">Data Mahasiswa</h3>
                    <div class="space-y-2 text-xs sm:text-sm">
                        <div class="flex gap-2">
                            <span class="text-base-content/60 min-w-[70px]">Nama</span>
                            <span class="font-semibold">{{ $booking->nama_mahasiswa }}</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-base-content/60 min-w-[70px]">NIM</span>
                            <span class="font-semibold">{{ $booking->nim_mahasiswa ?? '-' }}</span>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-base-content/60 min-w-[70px]">Email</span>
                            <span class="font-semibold break-all">{{ $booking->email_mahasiswa }}</span>
                        </div>
                    </div>
                </div>

                {{-- Jadwal Konsultasi --}}
                <div class="space-y-4">
                    <h3 class="font-bold text-base sm:text-lg">Jadwal Konsultasi</h3>
                    <div class="space-y-2 text-xs sm:text-sm">
                        <div class="flex gap-2">
                            <span class="text-base-content/60 min-w-[70px]">Tanggal</span>
                            <span class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->tanggal_booking)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-base-content/60 min-w-[70px]">Waktu</span>
                            <span class="font-semibold">
                                {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-base-content/60 min-w-[70px]">Ruangan</span>
                            <span class="font-semibold">
                                {{ $booking->ruangan ?? 'Belum ditentukan' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keperluan --}}
            <div class="mt-6">
                <h3 class="font-bold text-base sm:text-lg mb-2">Keperluan Konsultasi</h3>
                <div class="card bg-base-200">
                    <div class="card-body p-4">
                        <p class="text-xs sm:text-sm leading-relaxed">{{ $booking->keperluan }}</p>
                    </div>
                </div>
            </div>

            {{-- Catatan Dosen --}}
            @if($booking->catatan_dosen)
                <div class="mt-4">
                    <h3 class="font-bold text-base sm:text-lg mb-2">Catatan Dosen</h3>
                    <div class="card bg-info/10 border border-info/20">
                        <div class="card-body p-4">
                            <p class="text-xs sm:text-sm leading-relaxed">{{ $booking->catatan_dosen }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Alasan Penolakan --}}
            @if($booking->status === 'rejected' && $booking->alasan_reject)
                <div class="mt-4">
                    <div class="alert alert-error">
                        <div>
                            <div class="font-bold text-sm">Alasan Penolakan</div>
                            <div class="text-xs sm:text-sm">{{ $booking->alasan_reject }}</div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Action kalau masih pending --}}
            @if($booking->status === 'pending')
                <div class="card-actions justify-end mt-6 gap-2 flex-wrap">
                    {{-- Edit --}}
                    <a href="{{ route('booking.edit', $booking) }}" class="btn btn-info btn-sm sm:btn-md">
                        Edit
                    </a>

                    {{-- Setujui: buka modal --}}
                    <button type="button"
                            class="btn btn-success btn-sm sm:btn-md"
                            onclick="approveModal{{ $booking->id }}.showModal()">
                        Setujui
                    </button>

                    {{-- Tolak: buka modal --}}
                    <button type="button"
                            class="btn btn-error btn-sm sm:btn-md"
                            onclick="rejectModal{{ $booking->id }}.showModal()">
                        Tolak
                    </button>
                </div>

                {{-- Modal Approve --}}
                <dialog id="approveModal{{ $booking->id }}" class="modal">
                    <div class="modal-box max-w-2xl">
                        <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                            <span class="text-2xl">✅</span>
                            Setujui Booking Konsultasi
                        </h3>

                        {{-- Info ringkas --}}
                        <div class="bg-base-200 rounded-lg p-4 mb-4 text-xs sm:text-sm">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div>
                                    <span class="text-base-content/60">Nama:</span>
                                    <span class="font-semibold ml-1">{{ $booking->nama_mahasiswa }}</span>
                                </div>
                                <div>
                                    <span class="text-base-content/60">NIM:</span>
                                    <span class="font-semibold ml-1">{{ $booking->nim_mahasiswa ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-base-content/60">Tanggal:</span>
                                    <span class="font-semibold ml-1">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-base-content/60">Waktu:</span>
                                    <span class="font-semibold ml-1">
                                        {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('booking.approve', $booking) }}">
                            @csrf

                            {{-- Ruangan (wajib) --}}
                            <div class="form-control w-full mb-4">
                                <label class="label">
                                    <span class="label-text font-semibold">Ruangan <span class="text-error">*</span></span>
                                </label>
                                <input 
                                    type="text"
                                    name="ruangan"
                                    class="input input-bordered w-full"
                                    placeholder="Contoh: Lab A101, Ruang Dosen 201, Online via Zoom"
                                    value="{{ $booking->ruangan }}"
                                    required
                                    minlength="3">
                                <label class="label">
                                    <span class="label-text-alt text-base-content/60">Wajib diisi - minimal 3 karakter</span>
                                </label>
                            </div>

                            {{-- Catatan dosen (opsional) --}}
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">Catatan untuk Mahasiswa</span>
                                    <span class="label-text-alt text-base-content/60">Opsional</span>
                                </label>
                                <textarea 
                                    name="catatan_dosen"
                                    class="textarea textarea-bordered h-24"
                                    placeholder="Tambahkan catatan khusus (misal: materi yang perlu disiapkan, dokumen yang dibawa, dll)">{{ $booking->catatan_dosen }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt text-base-content/60">Catatan ini akan dikirim via email ke mahasiswa</span>
                                </label>
                            </div>

                            <div class="modal-action">
                                <button type="button" class="btn btn-ghost" onclick="approveModal{{ $booking->id }}.close()">Batal</button>
                                <button type="submit" class="btn btn-success gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui Booking
                                </button>
                            </div>
                        </form>
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>

                {{-- Modal Reject --}}
                <dialog id="rejectModal{{ $booking->id }}" class="modal">
                    <div class="modal-box max-w-lg">
                        <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
                            <span class="text-2xl">❌</span>
                            Tolak Booking Konsultasi
                        </h3>

                        {{-- Info ringkas --}}
                        <div class="bg-base-200 rounded-lg p-4 mb-4 text-xs sm:text-sm">
                            <div class="space-y-1">
                                <div>
                                    <span class="text-base-content/60">Nama:</span>
                                    <span class="font-semibold ml-1">{{ $booking->nama_mahasiswa }}</span>
                                </div>
                                <div>
                                    <span class="text-base-content/60">Tanggal:</span>
                                    <span class="font-semibold ml-1">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-base-content/60">Waktu:</span>
                                    <span class="font-semibold ml-1">
                                        {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('booking.reject', $booking) }}">
                            @csrf
                            <div class="form-control w-full">
                                <label class="label">
                                    <span class="label-text font-semibold">
                                        Alasan Penolakan <span class="text-error">*</span>
                                    </span>
                                </label>
                                <textarea
                                    name="alasan_reject"
                                    class="textarea textarea-bordered h-32"
                                    placeholder="Jelaskan alasan penolakan booking ini..."
                                    required
                                    minlength="10"></textarea>
                                <label class="label">
                                    <span class="label-text-alt text-base-content/60">Minimal 10 karakter</span>
                                </label>
                            </div>

                            <div class="modal-action">
                                <button type="button" class="btn btn-ghost" onclick="rejectModal{{ $booking->id }}.close()">Batal</button>
                                <button type="submit" class="btn btn-error gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M6 18L18 6M6 6l12 12" />
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
            @endif
        </div>
    </div>
</div>
@endsection
