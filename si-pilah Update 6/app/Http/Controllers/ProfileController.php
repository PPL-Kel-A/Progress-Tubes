<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        try {
            $user = $request->user();
            $validated = $request->validated();

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $photoFile = $request->file('profile_photo');

                // Validasi file secara ulang
                if (!in_array($photoFile->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'])) {
                    return Redirect::route('profile.edit')
                        ->withErrors(['profile_photo' => 'Format file tidak valid. Gunakan JPG, PNG, atau GIF.']);
                }

                if ($photoFile->getSize() > 2 * 1024 * 1024) {
                    return Redirect::route('profile.edit')
                        ->withErrors(['profile_photo' => 'Ukuran file terlalu besar. Maksimal 2MB.']);
                }

                // Delete old photo if exists
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                // Store new photo
                $path = $photoFile->store('profile-photos', 'public');
                if ($path) {
                    $validated['profile_photo'] = $path;
                } else {
                    return Redirect::route('profile.edit')
                        ->withErrors(['profile_photo' => 'Gagal menyimpan foto. Silakan coba lagi.']);
                }
            }

            $user->fill($validated);

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();

            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')
                ->withErrors(['profile_photo' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete the user's profile photo.
     */
    public function deletePhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'photo-deleted');
    }

    /**
     * Upload user's profile photo.
     */
    public function uploadPhoto(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ], [
                'profile_photo.required' => 'Silakan pilih foto terlebih dahulu.',
                'profile_photo.image' => 'File harus berupa gambar.',
                'profile_photo.mimes' => 'Format file harus JPG, PNG, atau GIF.',
                'profile_photo.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            ]);

            $user = $request->user();
            $photoFile = $request->file('profile_photo');

            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Store new photo
            $path = $photoFile->store('profile-photos', 'public');
            
            if ($path) {
                $user->profile_photo = $path;
                $user->save();
                return Redirect::route('profile.edit')->with('status', 'profile-updated');
            } else {
                return Redirect::route('profile.edit')
                    ->withErrors(['profile_photo' => 'Gagal menyimpan foto. Silakan coba lagi.']);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return Redirect::route('profile.edit')
                ->withErrors(['profile_photo' => $e->errors()['profile_photo'][0] ?? 'Terjadi kesalahan pada validasi file.']);
        } catch (\Exception $e) {
            return Redirect::route('profile.edit')
                ->withErrors(['profile_photo' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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
