<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user): View
    {
        return view('profiles.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        //Check if the authenticated user is the same as the user being edited
        if (auth()->user()->id!== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        // Check authorization
        if (auth()->user()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'bio' => $request->input('bio'),
        ];

        // Handle profile image upload safely
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::disk('public')->exists($user->profile_image)) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new image
            $imagePath = $request->file('profile_image')->store('profile', 'public');
            $data['profile_image'] = $imagePath;
        }

        // Update user data
        $user->update($data);

        return redirect("/profile/{$user->id}")
            ->with('success', 'Profile updated successfully!');
    }
}
