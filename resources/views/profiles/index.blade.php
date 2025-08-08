@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3 text-center">
            <img src="{{$user->profile_image ? asset('storage/' . $user->profile_image) : 'https://via.placeholder.com/150'}}" class="img-fluid rounded-circle mb-3" alt="Profile Image">
        </div>
        <div class="col-md-9">
            <div class="d-flex align-items-center">
                <h1>{{ $user->name }}</h1>
                @if(auth()->user()->id === $user->id)
                    <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary ms-3">Edit Profile</a>
                @endif
            </div>
            <div class="d-flex mt-3">
                <div class="me-4">
                    <strong>Posts:</strong> {{ $user->posts->count() }}
                </div>
                <div class="me-4">
                    <strong>Followers:</strong> 0
                </div>
                <div>
                    <strong>Following:</strong> 0
                </div>
            </div>
            <div class="mt-3">
                <h5>{{$user->name}}</h5>
                <p>{{$user->bio}}</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        @foreach($user->posts as $post)
            <div class="col-md-4 mb-4">
                <a href="{{route('posts.show', $post->id)}}">
                    <img src="{{asset('storage/' . $post->image_path)}}" class="w-100" alt="Post Image">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
