<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Instagram Clone') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <style>
        body {
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
            padding-top: 70px; /* navbar height */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-brand {
            font-family: 'Grand Hotel', cursive;
            font-size: 1.8rem;
            font-weight: 600;
            color: #262626 !important;
            letter-spacing: 1.5px;
            user-select: none;
        }
        .nav-link {
            color: #262626;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .nav-link:hover,
        .nav-link:focus {
            color: #0095f6;
            text-decoration: none;
        }
        /* Profile dropdown avatar */
        .navbar .dropdown-toggle img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 8px;
            border: 1.5px solid #ddd;
            transition: border-color 0.3s ease;
        }
        .navbar .dropdown-toggle:hover img {
            border-color: #0095f6;
        }
        /* Smooth dropdown fade */
        .dropdown-menu {
            animation: fadeInDropdown 0.25s ease forwards;
            min-width: 10rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        @keyframes fadeInDropdown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Navbar sticky & shadow */
        nav.navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background-color: white !important;
            padding: 0.6rem 1rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
        }
        /* Bottom fixed footer placeholder for future nav */
        footer.footer-placeholder {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 50px;
            background-color: #fafafa;
            border-top: 1px solid #dbdbdb;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 0.875rem;
        }
    </style>

    <!-- Optional Google Fonts Grand Hotel for branding (Instagram-like font) -->
    <link href="https://fonts.googleapis.com/css2?family=Grand+Hotel&display=swap" rel="stylesheet" />
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Instagram Clone') }}
            </a>

            <ul class="navbar-nav d-flex flex-row align-items-center gap-3">
                @auth
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1" href="{{ route('posts.index') }}" title="Feed">
                            <i class="fas fa-home fa-lg"></i>
                            <span class="d-none d-md-inline">Feed</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1" href="{{ route('posts.create') }}" title="New Post">
                            <i class="fas fa-plus-square fa-lg"></i>
                            <span class="d-none d-md-inline">New Post</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Profile">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" />
                            @else
                                <img src="https://via.placeholder.com/32" alt="Profile" />
                            @endif
                            <span class="d-none d-md-inline">{{ Auth::user()->username ?? Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.show', Auth::user()->id) }}">
                                    <i class="fas fa-user-circle"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="footer-placeholder">
        &copy; {{ date('Y') }} {{ config('app.name', 'Instagram Clone') }}. Made with ❤️ by Amika.
    </footer>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
