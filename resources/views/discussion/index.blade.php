@extends('layouts.main')

@section('container')
    <div class="py-3">
        <small>
            <a href="/" class="text-decoration-none text-secondary">Home</a>
            /
            <a href="/discussions" class="text-decoration-none text-secondary">Discussions</a>
            /
            <a href="/discussions/{{ $discussion->slug }}" class="text-decoration-none text-secondary">{{ $discussion->title }}</a>
        </small>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex border-bottom border-dark-subtle">
        @if ($discussion->user->profile_picture)
            <div class="p-0">
                <img src="{{ $discussion->user->profile_picture_url }}" alt="" width="35" height="35" class="rounded-circle me-3">
            </div>
        @else
            <img src="/img/troefl-profile-picture.png" alt="" width="35" height="35" class="rounded-circle me-3">
        @endif
        <div class="row pe-5">
            <div class="d-flex">
                <h6>{{ $discussion->user->username }}
                    @if ($discussion->user->is_admin)
                        <small class="text-secondary"> &#40;Administator&#41;</small>
                    @endif
                </h6>
                <small class="mx-2 fw-bold">·</small>
                <small class="opacity-50">{{ $discussion->created_at->diffForHumans() }}</small>
            </div>
            <h1 class="fw-bold mt-3">{{ $discussion->title }}</h1>
            <article class="py-3 fs-5 lh-sm">{!! $discussion->body !!}</article>
        </div>
        @auth
            @if (auth()->user()->is_admin)
                <div class="ms-auto">
                    <div class="btn-group">
                        <button class="btn dropdown-toggle custom-dropdown-toggle dropdown-menu-start" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu custom-dropdown-menu text-center w-auto">
                            <li>
                                <form action="/discussions/show/{{ $discussion->slug }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item custom-dropdown-item" onclick="return confirm('Are you sure you want to delete this discussion?')">Delete</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif      
        @endauth
    </div>
    @auth
        @include('discussion.add-comment')
    @else
        <div class="d-flex justify-content-center py-3">
            <a class="btn btn-dark" href="/login">Login to leave a comment</a>
        </div>
    @endauth
    @include('discussion.comments', ['comments' => $discussion->comments, 'discussion_id' => $discussion->id])
@endsection
