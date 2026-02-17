@extends('layouts.app')

@section('title', 'Kelola Akun Dosen - Lab WICIDA')

@section('content')

<div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold flex items-center gap-2">
            <span class="text-3xl">👨‍🏫</span>
            Kelola Akun Dosen
        </h1>
        <p class="text-sm text-base-content/70">
            Admin dapat menambahkan dan menghapus akun dosen. Dosen tidak bisa registrasi sendiri.
        </p>
    </div>
    <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Dosen
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="card bg-base-100 shadow-lg border border-base-300">
    <div class="card-body p-0">
        @if($dosens->isEmpty())
            <div class="p-6 text-center text-sm text-base-content/70">
                Belum ada akun dosen.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                            <th>Role</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dosens as $idx => $dosen)
                            <tr>
                                <td>{{ $dosens->firstItem() + $idx }}</td>
                                <td class="font-semibold">{{ $dosen->name }}</td>
                                <td>{{ $dosen->email }}</td>
                                <td>{{ $dosen->nip ?? '-' }}</td>
                                <td class="capitalize">{{ str_replace('_',' ', $dosen->role) }}</td>
                                <td class="text-right">
                                    <form action="{{ route('admin.dosen.destroy', $dosen) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus akun dosen ini? Semua data terkait bisa terpengaruh.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-error text-white gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-base-300">
                {{ $dosens->links() }}
            </div>
        @endif
    </div>
</div>

@endsection
