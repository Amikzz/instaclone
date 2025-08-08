@extends('layouts.app')
@section('content')

    <style>
        /* Profile header shadow and padding */
        .profile-header {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
            padding: 30px;
            margin-bottom: 40px;
        }
        /* Profile image with border and hover */
        .profile-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ff2e63; /* Instagram-like accent */
            transition: transform 0.3s ease;
            cursor: pointer;
        }
        .profile-image:hover {
            transform: scale(1.1);
            box-shadow: 0 0 15px #ff2e63;
        }
        /* User stats */
        .profile-stats {
            display: flex;
            gap: 35px;
            margin-top: 15px;
        }
        .profile-stats div {
            font-weight: 600;
            font-size: 1.1rem;
            cursor: default;
        }
        .profile-stats strong {
            color: #333;
        }
        /* Edit Profile Button */
        .btn-edit {
            background-color: #ff2e63;
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .btn-edit:hover {
            background-color: #e02656;
            color: #fff;
            text-decoration: none;
        }
        /* Bio styling */
        .profile-bio {
            margin-top: 20px;
            font-size: 1rem;
            color: #555;
            line-height: 1.4;
            max-width: 600px;
        }
        /* Posts grid */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }
        /* Individual post image hover effect */
        .posts-grid a img {
            width: 100%;
            height: 300px;  /* Increased height */
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .posts-grid a img:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgb(255 46 99 / 0.4);
        }

    </style>

    <div class="container">
        <div class="profile-header d-flex flex-column flex-md-row align-items-center gap-4">
            <!-- Profile Image -->
            <div>
                <img
                    src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/150' }}"
                    alt="Profile Image"
                    class="profile-image"
                    title="{{ $user->name }}"
                >
            </div>

            <!-- Profile Details -->
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-3 flex-wrap">
                    <h2 class="mb-0">{{ $user->name }}</h2>
                    @if(auth()->user()->id === $user->id)
                        <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-edit">
                            Edit Profile
                        </a>
                    @endif
                </div>

                <div class="profile-stats">
                    <div><strong>{{ $user->posts->count() }}</strong> Posts</div>
                    <div><strong>0</strong> Followers</div>
                    <div><strong>0</strong> Following</div>
                </div>

                <div class="profile-bio">
                    <p>{{ $user->bio ?: 'This user has not added a bio yet.' }}</p>
                </div>
            </div>
        </div>

        <!-- User Posts Grid -->
        <div class="posts-grid">
            @forelse($user->posts as $post)
                <a href="{{ route('posts.show', $post->id) }}" title="View Post">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post Image">
                </a>
            @empty
                <p class="text-muted">No posts yet.</p>
            @endforelse
        </div>
    </div>

@endsection
