<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $posts = Post::with('user')->latest()->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'caption' => 'required|string|max:255',
            'cropped_image' => 'required|string',  // validate base64 string presence
        ]);

        // Get base64 string from request
        $base64Image = $request->input('cropped_image');

        // Extract the actual base64 encoded data from data URI scheme format
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $extension = strtolower($type[1]); // jpg, png, gif, etc.
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg'])) {
                return back()->withErrors(['cropped_image' => 'Unsupported image type.']);
            }
        } else {
            return back()->withErrors(['cropped_image' => 'Invalid image data.']);
        }

        // Decode base64 string
        $imageData = base64_decode($base64Image);

        if ($imageData === false) {
            return back()->withErrors(['cropped_image' => 'Base64 decode failed.']);
        }

        // Create unique filename
        $filename = 'uploads/' . Str::random(40) . '.' . $extension;

        // Save image file to storage/app/public/uploads
        Storage::disk('public')->put($filename, $imageData);

        // Save post record with image path
        auth()->user()->posts()->create([
            'caption' => $request->input('caption'),
            'image_path' => $filename,
        ]);

        return redirect('/profile/' . auth()->user()->id)
            ->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): View
    {
        //Check if the authenticated user is the owner of the post
        if (auth()->user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post): \Illuminate\Http\RedirectResponse
    {
        //Check if the authenticated user is the owner of the post
        if (auth()->user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'caption' => 'required|string|max:255',
        ]);

        $post->update([
            'caption' => $request->input('caption'),
        ]);

        return redirect('/posts/' . $post->id)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): \Illuminate\Http\RedirectResponse
    {
        //Check if the authenticated user is the owner of the post
        if (auth()->user()->id !== $post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        Storage::disk('public')->delete($post->image_path);

        $post->delete();

        return redirect('/profile/' . auth()->user()->id)
            ->with('success', 'Post deleted successfully!');
    }
}
