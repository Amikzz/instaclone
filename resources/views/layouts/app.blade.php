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

    <!-- Logo -->
    <link rel="icon" href="{{ asset('images/logo.ico') }}" type="image/ico" />

    <style>
        body {
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
            padding-top: 70px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            opacity: 0;
            animation: fadeInPage 0.6s ease forwards;
        }

        @keyframes fadeInPage {
            to { opacity: 1; }
        }

        /* Smooth fade for main content */
        main {
            animation: fadeUp 0.5s ease forwards;
            opacity: 0;
            transform: translateY(15px);
        }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .nav-profile-avatar, .navbar .dropdown-toggle img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .nav-profile-avatar:hover,
        .navbar .dropdown-toggle:hover img {
            transform: scale(1.1);
            border-color: #ff4e88;
        }

        .nav-letter-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #ff4e88;
            color: white;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
            user-select: none;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .nav-letter-avatar:hover {
            transform: scale(1.1);
            background: #ff79a8;
        }

        .navbar-brand {
            font-family: 'Grand Hotel', cursive;
            font-size: 1.8rem;
            font-weight: 600;
            color: #262626 !important;
            letter-spacing: 1.5px;
            user-select: none;
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover {
            transform: scale(1.05);
        }

        .nav-link {
            color: #262626;
            font-weight: 500;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .nav-link:hover,
        .nav-link:focus {
            color: #ff4e88;
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: #fff !important;
            background: linear-gradient(135deg, #ff4e88, #ff9ac4);
            border-radius: 12px;
            padding: 5px 12px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(255,78,136,0.4);
            animation: pulseActive 1.5s infinite ease-in-out;
        }

        @keyframes pulseActive {
            0%, 100% { box-shadow: 0 4px 12px rgba(255,78,136,0.4); }
            50% { box-shadow: 0 6px 16px rgba(255,78,136,0.6); }
        }

        .dropdown-menu {
            animation: fadeInDropdown 0.25s ease forwards;
            min-width: 10rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform-origin: top right;
        }

        @keyframes fadeInDropdown {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        nav.navbar {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background-color: white !important;
            padding: 0.6rem 1rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1050;
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); }
            to { transform: translateY(0); }
        }

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
            transition: background 0.3s ease;
        }
        footer.footer-placeholder:hover {
            background: #f5f5f5;
        }
    </style>

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
                        <a class="nav-link d-flex align-items-center gap-1 {{ request()->routeIs('posts.index') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                            <i class="fas fa-home fa-lg"></i>
                            <span class="d-none d-md-inline">Feed</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-1 {{ request()->routeIs('posts.create') ? 'active' : '' }}" href="{{ route('posts.create') }}">
                            <i class="fas fa-plus-square fa-lg"></i>
                            <span class="d-none d-md-inline">New Post</span>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" role="button" data-bs-toggle="dropdown">
                            @if(Auth::user()->profile_image)
                                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile" class="nav-profile-avatar">
                            @else
                                <div class="nav-letter-avatar">
                                    {{ strtoupper(substr(Auth::user()->username ?? Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="d-none d-md-inline">{{ Auth::user()->username ?? Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
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
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
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
