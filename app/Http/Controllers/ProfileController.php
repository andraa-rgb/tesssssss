<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
public function update(Request $request)
{
    $user = $request->user();

    $data = $request->validate([
        'name'        => ['required', 'string', 'max:255'],
        'email'       => ['required', 'email', 'max:255', Rule::unique('users','email')->ignore($user->id)],
        'nip'         => ['nullable', 'string', 'max:50'],
        'expertise'   => ['nullable', 'string', 'max:255'],
        'bio'         => ['nullable', 'string', 'max:1000'],
        'scholar_url' => ['nullable', 'url', 'max:255'],
        'sinta_url'   => ['nullable', 'url', 'max:255'],
        'website_url' => ['nullable', 'url', 'max:255'],
        'cropped_image' => ['nullable', 'string'],   // base64 dari cropper
    ]);

    // 1. Hapus foto jika user klik "Hapus Foto"
    if ($request->has('remove_photo') && $request->input('remove_photo') == '1') {
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }
        $data['photo'] = null;   // kosongkan di database
    }

    // 2. Proses foto baru kalau ada hasil crop
    if (!empty($data['cropped_image'])) {
        $base64 = $data['cropped_image'];

        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $base64 = substr($base64, strpos($base64, ',') + 1);
            $extension = strtolower($type[1]); // jpg/png/dll

            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $extension = 'jpg';
            }

            $base64 = str_replace(' ', '+', $base64);
            $imageData = base64_decode($base64);

            if ($imageData !== false) {
                // hapus foto lama dulu, kecuali barusan sudah dihapus
                if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                    Storage::disk('public')->delete($user->photo);
                }

                $fileName = 'profile-photos/' . uniqid('profile_') . '.' . $extension;
                Storage::disk('public')->put($fileName, $imageData);

                $data['photo'] = $fileName;
            }
        }
    }

    // cropped_image tidak disimpan ke DB
    unset($data['cropped_image']);

    $user->fill($data);

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return back()->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
