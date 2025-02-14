<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
        $user = $request->user();

        // Fill user with validated input except password
        $user->fill($request->except('password'));

        // Check if password field is filled, then hash the password
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Reset email verification if the email is changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the updated user information
        $user->save();

        // Redirect back to the profile edit page with a success message
        return Redirect::route('profile.edit')->with('status', 'Berhasil update profile!');
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
