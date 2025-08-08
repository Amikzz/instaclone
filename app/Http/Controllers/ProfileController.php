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
        if (auth()->id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('profiles.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        //Check if the authenticated user is the same as the user being updated
        if (auth()->id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $imagePath = $request->file('profile_image')->store('profile', 'public');
        $user->update([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'bio' => $request->input('bio'),
            'profile_image' => $imagePath,
        ]);

        return redirect("/profile/{$user->id}")
            ->with('success', 'Profile updated successfully!');
    }
}
