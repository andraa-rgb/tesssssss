@extends('layouts.app')

@section('title', 'Tambah Akun Dosen - Lab WICIDA')

@section('content')

<div class="mb-6 flex items-center gap-3">
    <a href="{{ route('admin.dosen.index') }}" class="btn btn-ghost btn-sm btn-circle">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
    </a>
    <div>
        <h1 class="text-2xl md:text-3xl font-bold">Tambah Akun Dosen</h1>
        <p class="text-sm text-base-content/70">
            Admin mendaftarkan akun dosen. Dosen tidak dapat melakukan registrasi sendiri.
        </p>
    </div>
</div>

<div class="card bg-base-100 shadow-lg border border-base-300 max-w-2xl">
    <div class="card-body">
        <form action="{{ route('admin.dosen.store') }}" method="POST" class="space-y-4">
            @csrf

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Nama Lengkap</span>
                </label>
                <input type="text" name="name" class="input input-bordered @error('name') input-error @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Email</span>
                </label>
                <input type="email" name="email" class="input input-bordered @error('email') input-error @enderror"
                       value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">NIP (opsional)</span>
                </label>
                <input type="text" name="nip" class="input input-bordered @error('nip') input-error @enderror"
                       value="{{ old('nip') }}" placeholder="Contoh: 19801231 200501 1 001">
                @error('nip')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Role</span>
                </label>
                <select name="role" class="select select-bordered @error('role') select-error @enderror" required>
                    <option value="">Pilih role</option>
                    <option value="kepala_lab" {{ old('role')=='kepala_lab' ? 'selected' : '' }}>Kepala Lab</option>
                    <option value="staf" {{ old('role')=='staf' ? 'selected' : '' }}>Staf / Dosen</option>
                </select>
                @error('role')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Password Awal</span>
                </label>
                <input type="password" name="password" class="input input-bordered @error('password') input-error @enderror"
                       required>
                @error('password')
                    <span class="text-error text-xs mt-1">{{ $message }}</span>
                @enderror
                <label class="label">
                    <span class="label-text-alt text-xs text-base-content/60">
                        Beritahu dosen untuk segera mengganti password setelah login pertama.
                    </span>
                </label>
            </div>

            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold">Konfirmasi Password</span>
                </label>
                <input type="password" name="password_confirmation" class="input input-bordered" required>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('admin.dosen.index') }}" class="btn btn-ghost">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
