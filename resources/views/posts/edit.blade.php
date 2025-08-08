@extends('layouts.app')
@section('content')

    <style>
        /* Card enhancements */
        .card {
            border-radius: 15px;
            box-shadow: 0 8px 20px rgb(0 0 0 / 0.1);
            margin-top: 40px;
        }

        .card-header {
            font-weight: 700;
            font-size: 1.25rem;
            background-color: #ff2e63;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            text-align: center;
            padding: 15px 20px;
        }

        /* Form label styling */
        label.form-label {
            font-weight: 600;
            color: #333;
        }

        /* Textarea styling */
        textarea.form-control {
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            resize: vertical;
            min-height: 120px;
        }

        textarea.form-control:focus {
            border-color: #ff2e63;
            box-shadow: 0 0 8px #ff2e63aa;
            outline: none;
        }

        /* Invalid input styling */
        textarea.form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 5px #dc3545aa;
        }

        /* Error message styling */
        .invalid-feedback {
            font-size: 0.9rem;
            color: #dc3545;
            margin-top: 5px;
            display: block;
        }

        /* Submit button styling */
        .btn-primary {
            background-color: #ff2e63;
            border: none;
            padding: 12px 25px;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 10px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #e02656;
            box-shadow: 0 4px 15px rgba(255, 46, 99, 0.5);
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Post</div>

                    <div class="card-body">
                        {{-- Optional: Display a success message or general errors --}}
                        @if(session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Oops! Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('posts.update', $post->id) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="caption" class="form-label">Caption</label>
                                <textarea
                                    id="caption"
                                    class="form-control @error('caption') is-invalid @enderror"
                                    name="caption"
                                    rows="4"
                                    required
                                    aria-describedby="captionHelp"
                                >{{ old('caption', $post->caption) }}</textarea>
                                @error('caption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <small id="captionHelp" class="form-text text-muted">
                                    Edit your post caption here.
                                </small>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
