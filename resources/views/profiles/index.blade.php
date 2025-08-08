@extends('layouts.app')
@section('content')

    <style>
        /* Keep the container width as is, no changes here */
        /* Only styling inside */

        /* Profile Header */
        .profile-header {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgb(0 0 0 / 0.12);
            padding: 2rem 2.5rem;
            margin-bottom: 3rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: center;
            transition: box-shadow 0.3s ease;
        }
        .profile-header:hover {
            box-shadow: 0 12px 30px rgb(255 46 99 / 0.25);
        }

        /* Profile Image */
        .profile-image-wrapper {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 5px solid #ff2e63;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
            cursor: default;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            user-select: none;
            flex-shrink: 0;
        }
        .profile-image-wrapper:hover {
            transform: scale(1.12);
            box-shadow: 0 0 18px #ff2e63;
        }
        .profile-image-wrapper img.profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 50%;
        }
        .profile-placeholder {
            font-size: 4rem;
            font-weight: 700;
            color: #ff2e63;
            text-transform: uppercase;
            user-select: none;
        }

        /* Profile Details Container */
        .profile-details {
            flex: 1;
            min-width: 260px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Name and Edit button */
        .profile-name-edit {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .profile-name-edit h2 {
            margin: 0;
            font-weight: 700;
            font-size: 2.2rem;
            color: #222;
        }
        .btn-edit {
            background-color: #ff2e63;
            border: none;
            color: white;
            padding: 10px 26px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 14px rgb(255 46 99 / 0.35);
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            text-decoration: none;
            user-select: none;
        }
        .btn-edit:hover,
        .btn-edit:focus {
            background-color: #e02656;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgb(255 46 99 / 0.55);
            outline: none;
        }

        /* Stats */
        .profile-stats {
            display: flex;
            gap: 3rem;
            font-weight: 600;
            color: #444;
            font-size: 1.2rem;
            user-select: none;
        }
        .profile-stats div {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .profile-stats strong {
            color: #222;
            font-weight: 700;
        }
        .profile-stats svg {
            width: 22px;
            height: 22px;
            fill: #ff2e63;
            transition: fill 0.3s ease;
        }
        .profile-stats div:hover svg {
            fill: #e02656;
        }

        /* Bio */
        .profile-bio {
            font-size: 1.1rem;
            color: #555;
            line-height: 1.5;
            max-width: 600px;
            user-select: text;
            margin-top: 0.8rem;
        }

        /* Community Banner */
        .community-banner {
            background: linear-gradient(135deg, #ff2e63, #ff6f91);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.15rem;
            box-shadow: 0 6px 18px rgba(255, 46, 99, 0.35);
            text-align: center;
            margin: 0 auto 3rem auto;
            user-select: none;
            letter-spacing: 0.03em;
            line-height: 1.3;
            transition: box-shadow 0.3s ease;
            cursor: default;
            max-width: 100%; /* keep within container */
        }
        .community-banner:hover {
            box-shadow: 0 10px 28px rgba(255, 46, 99, 0.6);
        }
        .community-banner span {
            display: block;
            font-weight: 400;
            font-size: 1rem;
            opacity: 0.9;
            margin-top: 6px;
            user-select: text;
            letter-spacing: 0.02em;
        }

        /* Posts Grid */
        .posts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 22px;
        }
        .posts-grid a {
            display: block;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }
        .posts-grid a:hover {
            transform: scale(1.07);
            box-shadow: 0 10px 30px rgb(255 46 99 / 0.45);
            z-index: 5;
        }
        .posts-grid img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            display: block;
            border-radius: 14px;
            user-select: none;
            pointer-events: none;
        }

        /* Responsive tweaks */
        @media (max-width: 576px) {
            .profile-header {
                flex-direction: column;
                align-items: center;
                padding: 1.5rem 1.5rem;
            }
            .profile-details {
                align-items: center;
                text-align: center;
            }
            .profile-stats {
                justify-content: center;
                gap: 2rem;
                font-size: 1.1rem;
            }
        }
    </style>

    <div class="container">

        <!-- Community Branding Banner -->
        <div class="community-banner" title="Community message">
            🌍 Welcome to The Big Circle!
            <span>
            No followers. No following. Just one big, open community.
            Post freely, connect naturally, and enjoy the family vibe.
            This is your space - belong to everyone.
        </span>
        </div>

        <div class="profile-header" role="region" aria-label="User profile header">
            <!-- Profile Image -->
            <div class="profile-image-wrapper" title="{{ $user->name }}">
                @if ($user->profile_image && file_exists(storage_path('app/public/' . $user->profile_image)))
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image of {{ $user->name }}" class="profile-image" />
                @else
                    <div class="profile-placeholder" aria-label="User initials">
                        {{ collect(explode(' ', $user->name))->map(fn($w) => strtoupper($w[0]))->implode('') }}
                    </div>
                @endif
            </div>

            <!-- Profile Details -->
            <div class="profile-details">
                <div class="profile-name-edit">
                    <h2>{{ $user->name }}</h2>
                    @if(auth()->user()->id === $user->id)
                        <a href="{{ route('profile.edit', $user->id) }}" class="btn-edit" aria-label="Edit profile for {{ $user->name }}">
                            Edit Profile
                        </a>
                    @endif
                </div>

                <div class="profile-stats" aria-label="User post count">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M12 5c-7 0-9 6-9 7s2 7 9 7 9-6 9-7-2-7-9-7zm0 12c-3.44 0-5.11-2.54-5.59-4 0 0 2.15 2 5.59 2 3.44 0 5.59-2 5.59-2-.48 1.46-2.15 4-5.59 4z"/>
                        </svg>
                        <strong>{{ $user->posts->count() }}</strong> Posts
                    </div>
                </div>

                <div class="profile-bio" aria-label="User bio">
                    <p>{{ $user->bio ?: 'This user has not added a bio yet.' }}</p>
                </div>
            </div>
        </div>

        <!-- User Posts Grid -->
        <div class="posts-grid" aria-label="User posts gallery">
            @forelse($user->posts as $post)
                <a href="{{ route('posts.show', $post->id) }}" title="View post #{{ $post->id }}">
                    <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image #{{ $post->id }}">
                </a>
            @empty
                <p class="text-muted">No posts yet.</p>
            @endforelse
        </div>
    </div>

@endsection
