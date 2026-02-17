@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('jadwal.index') }}" class="btn btn-ghost btn-sm gap-2 mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-3xl font-bold">Edit Jadwal</h1>
        <p class="text-base-content/70 mt-1">Update informasi jadwal Anda</p>
    </div>

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <form method="POST" action="{{ route('jadwal.update', $jadwal) }}">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Hari -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Hari <span class="text-error">*</span></span>
                        </label>
                        <select name="hari" class="select select-bordered @error('hari') select-error @enderror" required>
                            <option value="">Pilih Hari</option>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                                <option value="{{ $hari }}" {{ old('hari', $jadwal->hari) == $hari ? 'selected' : '' }}>
                                    {{ $hari }}
                                </option>
                            @endforeach
                        </select>
                        @error('hari')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Kegiatan -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Kegiatan <span class="text-error">*</span></span>
                        </label>
                        <select name="kegiatan" class="select select-bordered @error('kegiatan') select-error @enderror" required>
                            <option value="">Pilih Kegiatan</option>
                            <option value="Mengajar" {{ old('kegiatan', $jadwal->kegiatan) == 'Mengajar' ? 'selected' : '' }}>📚 Mengajar</option>
                            <option value="Konsultasi" {{ old('kegiatan', $jadwal->kegiatan) == 'Konsultasi' ? 'selected' : '' }}>💬 Konsultasi</option>
                            <option value="Rapat" {{ old('kegiatan', $jadwal->kegiatan) == 'Rapat' ? 'selected' : '' }}>📋 Rapat</option>
                            <option value="Lainnya" {{ old('kegiatan', $jadwal->kegiatan) == 'Lainnya' ? 'selected' : '' }}>📌 Lainnya</option>
                        </select>
                        @error('kegiatan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Jam Mulai -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Jam Mulai <span class="text-error">*</span></span>
                        </label>
                        <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" 
                               class="input input-bordered @error('jam_mulai') input-error @enderror" required />
                        @error('jam_mulai')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Jam Selesai -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Jam Selesai <span class="text-error">*</span></span>
                        </label>
                        <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" 
                               class="input input-bordered @error('jam_selesai') input-error @enderror" required />
                        @error('jam_selesai')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <!-- Ruangan -->
                <div class="form-control mt-4">
                    <label class="label">
                        <span class="label-text font-semibold">Ruangan</span>
                    </label>
                    <input type="text" name="ruangan" value="{{ old('ruangan', $jadwal->ruangan) }}" 
                           class="input input-bordered @error('ruangan') input-error @enderror" 
                           placeholder="Contoh: Lab A101, Ruang Dosen 201" />
                    @error('ruangan')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="form-control mt-4">
                    <label class="label">
                        <span class="label-text font-semibold">Keterangan</span>
                    </label>
                    <textarea name="keterangan" rows="4" 
                              class="textarea textarea-bordered @error('keterangan') textarea-error @enderror" 
                              placeholder="Deskripsi singkat tentang kegiatan ini...">{{ old('keterangan', $jadwal->keterangan) }}</textarea>
                    @error('keterangan')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-2 mt-6">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Jadwal
                    </button>
                    <a href="{{ route('jadwal.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
