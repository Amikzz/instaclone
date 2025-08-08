@extends('layouts.app')

@section('content')
    <style>
        /* Card Styling */
        .auth-card {
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            background: #fff;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-in-out;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .auth-header {
            background: linear-gradient(135deg, #ff4e88, #ff9ac4);
            color: #fff;
            text-align: center;
            padding: 25px 20px 15px;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .auth-slogan {
            font-size: 0.9rem;
            font-weight: 400;
            color: rgba(255,255,255,0.9);
            margin-top: 8px;
            padding: 0 15px;
            line-height: 1.4;
            animation: fadeIn 1.2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Input group icon styling */
        .input-group-text {
            background: #fff;
            border: 1px solid #e5e5e5;
            border-right: none;
            border-radius: 12px 0 0 12px;
            color: #bbb;
            transition: color 0.3s ease;
        }

        .form-control {
            border-radius: 0 12px 12px 0;
            border: 1px solid #e5e5e5;
        }

        .form-control:focus {
            border-color: #ff4e88;
            box-shadow: 0 0 0 0.25rem rgba(255,78,136,0.15);
        }

        .form-control:focus + .input-group-text,
        .input-group-text:focus-within {
            color: #ff4e88;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #ff4e88, #ff6f91);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255,78,136,0.3);
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card auth-card">
                    <div class="auth-header">
                        ✨ Join the Community!
                        <div class="auth-slogan">
                            🚀 No followers, no following. Just one big circle of connection.
                            Share freely, connect deeply, and be yourself. ❤️
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('Name') }}</label>
                                <div class="input-group">
                                    <input id="name"
                                           type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           value="{{ old('name') }}"
                                           required
                                           autocomplete="name"
                                           autofocus
                                           placeholder="Enter your full name">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                @error('name')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <input id="email"
                                           type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           required
                                           autocomplete="email"
                                           placeholder="example@domain.com">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                @error('email')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <input id="password"
                                           type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password"
                                           required
                                           autocomplete="new-password"
                                           placeholder="Enter your password">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                @error('password')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                                <div class="input-group">
                                    <input id="password-confirm"
                                           type="password"
                                           class="form-control"
                                           name="password_confirmation"
                                           required
                                           autocomplete="new-password"
                                           placeholder="Re-enter your password">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }} 🚀
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer text-center bg-white border-0 pb-4 pt-0">
                        <small class="text-muted">
                            Already have an account?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Log in</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
