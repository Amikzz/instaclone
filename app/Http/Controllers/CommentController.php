<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('comment'),
        ]);

        return redirect('/posts/' . $post->id)
            ->with('success', 'Comment added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment): \Illuminate\Http\RedirectResponse
    {
        // Check if the authenticated user is the owner of the comment
        if (auth()->user()->id !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $postId = $comment->post_id;
        $comment->delete();

        return redirect('/posts/' . $postId)
            ->with('success', 'Comment deleted successfully!');
    }
}
