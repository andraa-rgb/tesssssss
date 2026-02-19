@extends('layouts.app')

@section('title', 'Edit Akun Dosen - Admin Lab WICIDA')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-2">
        <div>
            <h1 class="text-2xl font-bold">Edit Akun Dosen</h1>
            <p class="text-sm text-base-content/70">
                Perbarui data akun dosen: nama, email, NIP, role, dan password (jika diperlukan).
            </p>
        </div>
        <a href="{{ route('admin.dosen.index') }}" class="btn btn-ghost btn-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Form --}}
    <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body">
            <form action="{{ route('admin.dosen.update', $user) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Nama Lengkap</span>
                    </label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="input input-bordered @error('name') input-error @enderror"
                           required>
                    @error('name')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Email</span>
                    </label>
                    <input type="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           class="input input-bordered @error('email') input-error @enderror"
                           required>
                    @error('email')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- NIP --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">NIP (opsional)</span>
                    </label>
                    <input type="text"
                           name="nip"
                           value="{{ old('nip', $user->nip) }}"
                           class="input input-bordered @error('nip') input-error @enderror"
                           placeholder="Contoh: 19801231 200501 1 001">
                    @error('nip')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Role --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Role</span>
                    </label>
                    <select name="role"
                            class="select select-bordered @error('role') select-error @enderror"
                            required>
                        <option value="kepala_lab" {{ old('role', $user->role) === 'kepala_lab' ? 'selected' : '' }}>
                            Kepala Lab
                        </option>
                        <option value="staf" {{ old('role', $user->role) === 'staf' ? 'selected' : '' }}>
                            Staf
                        </option>
                    </select>
                    @error('role')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <div class="divider my-2">Password (opsional)</div>

                {{-- Password baru (opsional) --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Password Baru</span>
                    </label>
                    <input type="password"
                           name="password"
                           class="input input-bordered @error('password') input-error @enderror"
                           placeholder="Biarkan kosong jika tidak ingin mengubah password">
                    @error('password')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                    @enderror
                    <label class="label">
                        <span class="label-text-alt text-xs text-base-content/60">
                            Admin dapat mengatur ulang password dosen dari sini tanpa perlu password lama.
                        </span>
                    </label>
                </div>

                <div class="alert alert-info mt-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0
                                11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs">
                        Kosongkan field password jika tidak ingin mengganti password dosen.
                    </span>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <button type="submit" class="btn btn-primary gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
