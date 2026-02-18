<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        
        // Generate QR code URL
        $qrCodeUrl = route('dosen.show', $user->id);
        
        // Generate QR sebagai SVG (inline di Blade)
        $qrCodeSvg = QrCode::size(200)
                           ->style('round')
                           ->eye('circle')
                           ->generate($qrCodeUrl);
        
        return view('profile.edit', compact('user', 'qrCodeSvg', 'qrCodeUrl'));
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
            'cropped_image' => ['nullable', 'string'],
        ]);

        // 1. Hapus foto jika user klik "Hapus Foto"
        if ($request->has('remove_photo') && $request->input('remove_photo') == '1') {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = null;
        }

        // 2. Proses foto baru kalau ada hasil crop
        if (!empty($data['cropped_image'])) {
            $base64 = $data['cropped_image'];

            if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
                $base64 = substr($base64, strpos($base64, ',') + 1);
                $extension = strtolower($type[1]);

                if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                    $extension = 'jpg';
                }

                $base64 = str_replace(' ', '+', $base64);
                $imageData = base64_decode($base64);

                if ($imageData !== false) {
                    if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                        Storage::disk('public')->delete($user->photo);
                    }

                    $fileName = 'profile-photos/' . uniqid('profile_') . '.' . $extension;
                    Storage::disk('public')->put($fileName, $imageData);

                    $data['photo'] = $fileName;
                }
            }
        }

        unset($data['cropped_image']);

        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
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

    /**
     * Download QR Code as PNG
     */
    public function downloadQrCode(Request $request)
    {
        $user = $request->user();
        $qrCodeUrl = route('dosen.show', $user->id);
        
        // Generate QR sebagai PNG
        $qrCode = QrCode::format('png')
                        ->size(400)
                        ->margin(2)
                        ->style('round')
                        ->eye('circle')
                        ->generate($qrCodeUrl);
        
        $fileName = 'qrcode-' . $user->name . '-' . now()->format('Ymd') . '.png';
        
        return response($qrCode, 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
