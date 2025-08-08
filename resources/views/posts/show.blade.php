@extends('layouts.app')
@section('content')

    <style>
        /* Container for post and sidebar */
        .post-container {
            margin-top: 40px;
        }
        /* Post image styling */
        .post-image {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.1);
            object-fit: cover;
            max-height: 600px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .post-image:hover {
            transform: scale(1.02);
            box-shadow: 0 12px 30px rgb(255 46 99 / 0.4);
        }
        /* User avatar */
        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #ff2e63;
            object-fit: cover;
            transition: box-shadow 0.3s ease;
            cursor: pointer;
        }
        .user-avatar:hover {
            box-shadow: 0 0 10px #ff2e63;
        }
        /* Username link */
        .username-link {
            font-weight: 700;
            color: #111;
            text-decoration: none;
        }
        .username-link:hover {
            text-decoration: underline;
            color: #ff2e63;
        }
        /* Post header flex container */
        .post-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        /* Dropdown toggle button styling */
        .dropdown-toggle-custom {
            border: none;
            background: transparent;
            color: #333;
            font-size: 20px;
            cursor: pointer;
            padding: 0;
        }
        .dropdown-toggle-custom:hover {
            color: #ff2e63;
        }
        /* Caption text */
        .post-caption {
            font-size: 1rem;
            margin-top: 15px;
            color: #222;
        }
        /* Likes and buttons */
        .like-button {
            font-size: 24px;
            cursor: pointer;
            border: none;
            background: transparent;
            transition: color 0.3s ease;
            padding: 0;
        }
        .like-button.liked i {
            color: #ff2e63;
        }
        .likes-count {
            font-weight: 700;
            margin-top: 5px;
            color: #333;
        }
        /* Post date */
        .post-date {
            font-size: 0.85rem;
            color: #999;
            margin-top: 5px;
        }
        /* Comments section */
        .comments-section {
            max-height: 300px;
            overflow-y: auto;
            margin-top: 20px;
            padding-right: 5px;
        }
        .comment-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }
        .comment-username {
            font-weight: 600;
            color: #111;
            cursor: default;
        }
        .comment-text {
            margin: 0;
            flex-grow: 1;
            color: #333;
        }
        .comment-delete-btn {
            background: transparent;
            border: none;
            color: #d9534f;
            cursor: pointer;
            font-size: 18px;
            padding: 0;
            line-height: 1;
            transition: color 0.3s ease;
        }
        .comment-delete-btn:hover {
            color: #ff2e63;
        }
        /* Comment form */
        .comment-form .form-control {
            border-radius: 25px 0 0 25px;
            padding: 10px 20px;
            font-size: 1rem;
        }
        .comment-form .btn-primary {
            border-radius: 0 25px 25px 0;
            padding: 10px 20px;
            font-weight: 600;
            background-color: #ff2e63;
            border: none;
            transition: background-color 0.3s ease;
        }
        .comment-form .btn-primary:hover {
            background-color: #e02656;
        }
        /* Responsive tweaks */
        @media (max-width: 767px) {
            .post-container {
                margin-top: 20px;
            }
        }
    </style>

    <div class="container post-container">
        <div class="row">
            <div class="col-md-8">
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="post-image" />
            </div>
            <div class="col-md-4">
                <div class="post-header mb-3">
                    @if($post->user)
                        <a href="{{ route('profile.show', $post->user->id) }}">
                            <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : 'https://via.placeholder.com/50' }}"
                                 alt="{{ $post->user->name }}" class="user-avatar" title="{{ $post->user->name }}">
                        </a>
                        <a href="{{ route('profile.show', $post->user->id) }}" class="username-link">
                            {{ $post->user->name }}
                        </a>

                        @if(auth()->user()->id === $post->user->id)
                            <div class="dropdown ms-auto">
                                <button class="dropdown-toggle-custom" type="button" id="postOptions" data-bs-toggle="dropdown" aria-expanded="false" title="Options">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="postOptions">
                                    <li><a class="dropdown-item" href="{{ route('posts.edit', $post->id) }}"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                    <li>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this post?');">
                                                <i class="fas fa-trash-alt me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @else
                        <img src="https://via.placeholder.com/50" alt="User not found" class="user-avatar" />
                        <span class="text-muted ms-2">Deleted User</span>
                    @endif
                </div>

                {{-- Caption --}}
                <div class="post-caption">
                    @if($post->user)
                        <strong>{{ $post->user->username ?? $post->user->name }}</strong> {{ $post->caption }}
                    @else
                        {{ $post->caption }}
                    @endif
                </div>
                <hr>

                {{-- Likes --}}
                <div class="d-flex align-items-center mb-2">
                    @if($post->likes->where('user_id', auth()->user()->id)->count() > 0)
                        <form action="{{ route('likes.destroy', $post->id) }}" method="POST" class="me-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="like-button liked" title="Unlike">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('likes.store', $post->id) }}" method="POST" class="me-2">
                            @csrf
                            <button type="submit" class="like-button" title="Like">
                                <i class="far fa-heart"></i>
                            </button>
                        </form>
                    @endif
                </div>
                <p class="likes-count">{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</p>
                <p class="post-date">{{ $post->created_at->diffForHumans() }}</p>
                <hr>

                {{-- Comments Section --}}
                <div class="comments-section" aria-label="Comments section">
                    @foreach($post->comments as $comment)
                        <div class="comment-item">
                            @if($comment->user)
                                <strong class="comment-username">{{ $comment->user->name }}</strong>
                            @else
                                <strong class="comment-username text-muted">Deleted User</strong>
                            @endif
                            <p class="comment-text mb-0">{{ $comment->content }}</p>

                            @if(auth()->user()->id === $comment->user_id || auth()->user()->id === $post->user_id)
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="ms-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="comment-delete-btn" title="Delete comment" onclick="return confirm('Delete this comment?');">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
                <hr>

                {{-- Add Comment Form --}}
                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="comment-form">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="comment" class="form-control @error('comment') is-invalid @enderror" placeholder="Add a comment..." required aria-label="Add a comment">
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                    @error('comment')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </form>
            </div>
        </div>
    </div>

@endsection
