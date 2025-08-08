@extends('layouts.app')

@section('content')
    <style>
        /* Card Styling */
        .login-card {
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            background: #fff;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-in-out;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .login-header {
            background: linear-gradient(135deg, #ff4e88, #ff9ac4);
            color: #fff;
            text-align: center;
            padding: 25px 20px 15px;
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .login-slogan {
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
                <div class="card login-card">
                    <div class="login-header">
                        ✨ Welcome Back!
                        <div class="login-slogan">
                            🚀 This isn’t Instagram - here, you’re connected with everyone.
                            No followers, no following - just pure vibes.
                            Post what you feel and share with the whole community ❤️
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autofocus>
                                </div>
                                @error('email')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           name="password" required>
                                </div>
                                @error('password')
                                <span class="invalid-feedback d-block mt-1" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <!-- Remember + Forgot -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Password?') }}
                                    </a>
                                @endif
                            </div>

                            <!-- Submit -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }} 🚀
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
