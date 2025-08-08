<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Set Homepage to show posts (with authentication)
Route::get('/', [\App\Http\Controllers\PostController::class, 'index'])->middleware('auth')->name('home');
Route::get('/home', function () {
    return redirect('/');
})->name('home');

Auth::routes();

//Post Routes
Route::get('/posts', [\App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [\App\Http\Controllers\PostController::class, 'create'])->name('posts.create');
Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');
Route::get('/posts/{post}', [\App\Http\Controllers\PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{post}/edit', [\App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');
Route::patch('/posts/{post}', [\App\Http\Controllers\PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{post}', [\App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy');

//Profile Routes
Route::get('/profile/{user}', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.show');
Route::get('/profile/{user}/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user}', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

//Comment Routes
Route::post('/posts/{post}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

//Like Routes
Route::post('/posts/{post}/like', [\App\Http\Controllers\LikeController::class, 'store'])->name('likes.store');
Route::delete('/posts/{post}/like', [\App\Http\Controllers\LikeController::class, 'destroy'])->name('likes.destroy');
