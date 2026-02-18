<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Generate QR Code URL (ke halaman publik dosen)
        $qrCodeUrl = route('dosen.show', $user->id);
        
        // Generate QR Code SVG
        $qrCodeSvg = QrCode::format('svg')
            ->size(250)
            ->style('round')
            ->eye('circle')
            ->margin(2)
            ->errorCorrection('H')
            ->generate($qrCodeUrl);

        return view('profile.edit', compact('qrCodeSvg', 'qrCodeUrl'));
    }

    /**
     * Update profil dosen
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Handle hapus foto
        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
                $user->photo = null;
                $user->save();
                
                return redirect()->route('profile.edit')
                    ->with('status', 'profile-updated')
                    ->with('success', 'Foto profil berhasil dihapus.');
            }
        }

        // Validasi
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'nip'         => 'nullable|string|max:50',
            'expertise'   => 'nullable|string|max:500',
            'bio'         => 'nullable|string|max:1000',
            'scholar_url' => 'nullable|url|max:500',
            'sinta_url'   => 'nullable|url|max:500',
            'website_url' => 'nullable|url|max:500',
            'cropped_image' => 'nullable|string', // base64 image
        ]);

        // Handle upload foto (dari cropped image)
        if ($request->filled('cropped_image')) {
            // Hapus foto lama
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Decode base64 dan simpan
            $imageData = $request->input('cropped_image');
            
            // Remove data:image/jpeg;base64, prefix
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif

                $imageData = base64_decode($imageData);

                if ($imageData === false) {
                    return back()->withErrors(['photo' => 'Gagal decode gambar.']);
                }
            } else {
                return back()->withErrors(['photo' => 'Format gambar tidak valid.']);
            }

            // Generate filename unik
            $filename = 'profile_photos/' . uniqid() . '_' . time() . '.jpg';
            
            // Simpan ke storage
            Storage::disk('public')->put($filename, $imageData);
            
            $validated['photo'] = $filename;
        }

        // Update user
        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.edit')
            ->with('status', 'password-updated');
    }

    /**
     * Download QR Code sebagai PNG
     */
    public function downloadQrCode()
    {
        $user = Auth::user();
        
        // URL ke halaman publik dosen
        $url = route('dosen.show', $user->id);
        
        // Generate QR sebagai PNG
        $qrCode = QrCode::format('png')
            ->size(500)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($url);

        $filename = 'qrcode-' . str_replace(' ', '-', strtolower($user->name)) . '-' . time() . '.png';

        return response($qrCode, 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Hapus akun (optional)
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
