@extends('layouts.app')

@section('title', 'Kelola Dosen - Admin Lab WICIDA')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-2">
        <div>
            <h1 class="text-2xl font-bold">Kelola Akun Dosen</h1>
            <p class="text-sm text-base-content/70">
                Tambahkan, ubah, atau hapus akun dosen (kepala lab & staf).
            </p>
        </div>
        <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary btn-sm gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4" />
            </svg>
            Tambah Dosen
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success shadow mb-4">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Tabel Dosen --}}
    <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <div class="form-control">
                        <input id="search-admin-dosen"
                               type="text"
                               placeholder="Cari nama atau email..."
                               class="input input-sm input-bordered w-64" />
                    </div>
                </div>
                <span class="text-xs text-base-content/60">
                    Total: {{ $dosens->total() }} dosen
                </span>
            </div>

            @if($dosens->isEmpty())
                <div class="text-sm text-base-content/60">
                    Belum ada akun dosen terdaftar.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="table table-zebra text-sm" id="admin-dosen-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>NIP</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dosens as $index => $dosen)
                                <tr class="admin-dosen-row">
                                    <td>{{ $dosens->firstItem() + $index }}</td>
                                    <td class="font-semibold">{{ $dosen->name }}</td>
                                    <td class="text-xs">{{ $dosen->email }}</td>
                                    <td class="text-xs">{{ $dosen->nip ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-outline capitalize">
                                            {{ str_replace('_', ' ', $dosen->role) }}
                                        </span>
                                    </td>
                                    <td class="text-xs">
                                        {{ $dosen->created_at?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td class="text-right">
                                        <div class="flex justify-end gap-1">
                                            @if(Route::has('admin.dosen.edit'))
                                                <a href="{{ route('admin.dosen.edit', $dosen) }}"
                                                   class="btn btn-ghost btn-xs gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0
                                                                00.707-.293l9.414-9.414a2 2 0
                                                                00-2.828-2.828l-9.414 9.414A1 1 0
                                                                006.586 18H4v2z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                            @endif

                                            <form action="{{ route('admin.dosen.destroy', $dosen) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus dosen ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost btn-xs text-error gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M19 7l-.867 12.142A2 2 0
                                                                0116.138 21H7.862a2 2 0
                                                                01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0
                                                                00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>

                                            <a href="{{ route('dosen.show', $dosen) }}"
                                               target="_blank"
                                               class="btn btn-ghost btn-xs gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M13 7h4m0 0v4m0-4l-5 5m-2 4H7a2 2 0
                                                            01-2-2V7a2 2 0 012-2h6" />
                                                </svg>
                                                Profil Publik
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $dosens->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    const searchInput = document.getElementById('search-admin-dosen');
    const tableRows = document.querySelectorAll('#admin-dosen-table .admin-dosen-row');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const q = this.value.toLowerCase();
            tableRows.forEach(row => {
                const name  = row.cells[1].innerText.toLowerCase();
                const email = row.cells[2].innerText.toLowerCase();
                if (name.includes(q) || email.includes(q)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });
    }
</script>
@endpush
@endsection
