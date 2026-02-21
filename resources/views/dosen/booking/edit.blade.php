@extends('layouts.app')

@section('title', 'Edit Booking Konsultasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('booking.index') }}" class="btn btn-ghost btn-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke daftar booking
        </a>
    </div>

    <div class="card bg-base-100 shadow-xl border border-base-300">
        <div class="card-body">
            <h2 class="card-title mb-4 flex items-center gap-2 text-2xl">
                <span class="text-3xl">✏️</span>
                Edit Booking Konsultasi
            </h2>

            {{-- Error Messages --}}
            @if(session('error'))
                <div class="alert alert-error mb-4 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error mb-4 shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <div class="font-bold">Terdapat kesalahan:</div>
                        <ul class="list-disc list-inside text-sm mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('booking.update', ['booking' => $booking->id]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Info Mahasiswa (Read-only) --}}
                <div class="card bg-base-200">
                    <div class="card-body p-4">
                        <h3 class="font-bold text-lg mb-3">Informasi Mahasiswa</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="label">
                                    <span class="label-text text-xs font-semibold text-base-content/70">Nama Mahasiswa</span>
                                </label>
                                <input type="text" class="input input-bordered input-sm w-full bg-base-300" 
                                       value="{{ $booking->nama_mahasiswa }}" disabled>
                            </div>
                            <div>
                                <label class="label">
                                    <span class="label-text text-xs font-semibold text-base-content/70">NIM</span>
                                </label>
                                <input type="text" class="input input-bordered input-sm w-full bg-base-300" 
                                       value="{{ $booking->nim_mahasiswa ?? '-' }}" disabled>
                            </div>
                            <div class="md:col-span-2">
                                <label class="label">
                                    <span class="label-text text-xs font-semibold text-base-content/70">Email</span>
                                </label>
                                <input type="text" class="input input-bordered input-sm w-full bg-base-300" 
                                       value="{{ $booking->email_mahasiswa }}" disabled>
                            </div>
                            <div class="md:col-span-2">
                                <label class="label">
                                    <span class="label-text text-xs font-semibold text-base-content/70">Keperluan (dari mahasiswa)</span>
                                </label>
                                <textarea class="textarea textarea-bordered w-full bg-base-300" rows="3" disabled>{{ $booking->keperluan }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form Edit Jadwal --}}
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Tanggal <span class="text-error">*</span></span>
                        </label>
                        <input type="date" 
                               name="tanggal_booking"
                               class="input input-bordered w-full @error('tanggal_booking') input-error @enderror"
                               value="{{ old('tanggal_booking', $booking->tanggal_booking) }}"
                               required>
                        @error('tanggal_booking')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Ruangan</span>
                        </label>
                        <input type="text" 
                               name="ruangan"
                               class="input input-bordered w-full @error('ruangan') input-error @enderror"
                               value="{{ old('ruangan', $booking->ruangan) }}"
                               placeholder="Contoh: Lab A101, Ruang Dosen 201">
                        @error('ruangan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Jam Mulai <span class="text-error">*</span></span>
                        </label>
                        <input type="time" 
                               name="jam_mulai"
                               class="input input-bordered w-full @error('jam_mulai') input-error @enderror"
                               value="{{ old('jam_mulai', substr($booking->jam_mulai, 0, 5)) }}"
                               required>
                        @error('jam_mulai')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Jam Selesai <span class="text-error">*</span></span>
                        </label>
                        <input type="time" 
                               name="jam_selesai"
                               class="input input-bordered w-full @error('jam_selesai') input-error @enderror"
                               value="{{ old('jam_selesai', substr($booking->jam_selesai, 0, 5)) }}"
                               required>
                        @error('jam_selesai')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Catatan Dosen</span>
                        <span class="label-text-alt text-base-content/60">Opsional</span>
                    </label>
                    <textarea name="catatan_dosen" 
                              rows="4"
                              class="textarea textarea-bordered w-full @error('catatan_dosen') textarea-error @enderror"
                              placeholder="Tambahkan catatan khusus untuk mahasiswa (misal: materi yang perlu disiapkan, dokumen yang dibawa, dll)">{{ old('catatan_dosen', $booking->catatan_dosen) }}</textarea>
                    @error('catatan_dosen')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-base-content/60">Catatan ini akan dikirim via email ke mahasiswa</span>
                    </label>
                </div>

                <div class="divider"></div>

                <div class="alert alert-info shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <div class="font-bold">Tips:</div>
                        <ul class="text-sm list-disc list-inside mt-1">
                            <li>Sesuaikan jadwal jika diperlukan sebelum approve</li>
                            <li>Tambahkan ruangan dan catatan untuk membantu mahasiswa</li>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('booking.index') }}" class="btn btn-ghost">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
