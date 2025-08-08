@extends('layouts.app')

@section('content')
    <style>
        /* Card container styling */
        .post-card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }
        .post-card:hover {
            box-shadow: 0 12px 30px rgb(255 46 99 / 0.4);
        }
        /* User avatar */
        .post-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid #ff2e63;
            object-fit: cover;
            transition: box-shadow 0.3s ease;
            cursor: pointer;
        }
        .post-avatar:hover {
            box-shadow: 0 0 12px #ff2e63;
        }
        /* Username link */
        .username-link {
            color: #ff2e63;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .username-link:hover {
            color: #d02354;
            text-decoration: underline;
        }
        /* Card header layout */
        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            border-bottom: none;
            padding: 12px 20px;
        }
        /* Post image */
        .post-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }
        .post-image:hover {
            transform: scale(1.03);
            filter: brightness(1.05);
        }
        /* Like and comment buttons */
        .interaction-btn {
            font-size: 24px;
            border: none;
            background: transparent;
            padding: 0;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .interaction-btn.liked i {
            color: #ff2e63;
        }
        .interaction-btn i {
            color: #333;
        }
        .interaction-btn:hover i {
            color: #ff2e63;
        }
        /* Likes count */
        .likes-count {
            font-weight: 700;
            margin: 10px 0 5px 0;
            color: #333;
        }
        /* Caption */
        .post-caption {
            font-size: 1rem;
            color: #222;
            margin-bottom: 8px;
        }
        /* Comments link */
        .comments-link {
            color: #666;
            font-size: 0.9rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .comments-link:hover {
            color: #ff2e63;
            text-decoration: underline;
        }
        /* Timestamp */
        .post-timestamp {
            font-size: 0.8rem;
            color: #999;
            margin-top: 5px;
        }
    </style>

    <div class="container mt-4">
        <div class="row justify-content-center">
            @foreach($posts as $post)
                <div class="col-md-8 mb-5">
                    <div class="card post-card">
                        <div class="card-header">
                            @if($post->user)
                                <a href="{{ route('profile.show', $post->user->id) }}">
                                    <img src="{{ $post->user->profile_image ? asset('storage/' . $post->user->profile_image) : 'https://via.placeholder.com/50' }}"
                                         alt="{{ $post->user->name }}"
                                         class="post-avatar"
                                         title="{{ $post->user->name }}">
                                </a>
                                <a href="{{ route('profile.show', $post->user->id) }}" class="username-link">
                                    {{ $post->user->name }}
                                </a>
                            @else
                                <img src="https://via.placeholder.com/50" alt="User not found" class="post-avatar" />
                                <strong class="ms-2">User not found</strong>
                            @endif
                        </div>

                        <a href="{{ route('posts.show', $post->id) }}">
                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="post-image">
                        </a>

                        <div class="card-body">
                            <div class="d-flex mb-3 align-items-center">
                                @if($post->likes->where('user_id', auth()->user()->id)->count() > 0)
                                    <form action="{{ route('likes.destroy', $post->id) }}" method="POST" class="me-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="interaction-btn liked" title="Unlike">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('likes.store', $post->id) }}" method="POST" class="me-3">
                                        @csrf
                                        <button type="submit" class="interaction-btn" title="Like">
                                            <i class="far fa-heart"></i>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('posts.show', $post->id) }}" class="interaction-btn" title="Comments">
                                    <i class="far fa-comment"></i>
                                </a>
                            </div>

                            <p class="likes-count">{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</p>

                            @if($post->user)
                                <p class="post-caption"><strong>{{ $post->user->name }}</strong>: {{ $post->caption }}</p>
                            @else
                                <p class="post-caption">{{ $post->caption }}</p>
                            @endif

                            <a href="{{ route('posts.show', $post->id) }}" class="comments-link">
                                View all {{ $post->comments->count() }} {{ Str::plural('comment', $post->comments->count()) }}
                            </a>

                            <p class="post-timestamp">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
