<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminDosenController extends Controller
{
    public function __construct()
    {
        // Hanya admin
        $this->middleware(function ($request, $next) {
            if (! auth()->check() || auth()->user()->role !== 'admin') {
                abort(403, 'Hanya admin yang dapat mengakses halaman ini.');
            }
            return $next($request);
        });
    }

    /**
     * List semua dosen.
     */
    public function index()
    {
        $dosens = User::whereIn('role', ['kepala_lab', 'staf'])
            ->orderBy('name')
            ->paginate(10);

        return view('admin.dosen.index', compact('dosens'));
    }

    /**
     * Form tambah dosen.
     */
    public function create()
    {
        return view('admin.dosen.create');
    }

    /**
     * Simpan akun dosen baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'nip'      => ['nullable', 'string', 'max:50'],
            'role'     => ['required', Rule::in(['kepala_lab', 'staf'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Akun dosen berhasil dibuat.');
    }

    /**
     * (Opsional) Form edit dosen – kalau suatu saat mau.
     */
    public function edit(User $user)
    {
        if (! in_array($user->role, ['kepala_lab', 'staf'])) {
            abort(404);
        }

        return view('admin.dosen.edit', compact('user'));
    }

    /**
     * (Opsional) Update data dosen.
     */
    public function update(Request $request, User $user)
    {
        if (! in_array($user->role, ['kepala_lab', 'staf'])) {
            abort(404);
        }

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'nip'   => ['nullable', 'string', 'max:50'],
            'role'  => ['required', Rule::in(['kepala_lab', 'staf'])],
        ]);

        $user->update($data);

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }

    /**
     * Hapus akun dosen.
     */
    public function destroy(User $user)
    {
        if (! in_array($user->role, ['kepala_lab', 'staf'])) {
            abort(403, 'Hanya akun dosen yang dapat dihapus melalui menu ini.');
        }

        // (Opsional) Cek agar admin tidak menghapus dirinya sendiri di sini
        if ($user->id === auth()->id()) {
            return back()->with('success', 'Admin tidak dapat menghapus dirinya sendiri dari menu ini.');
        }

        $user->delete();

        return back()->with('success', 'Akun dosen berhasil dihapus.');
    }
}
