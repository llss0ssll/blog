@extends('layouts.app')

@section('title','Profile')

@section('content')

<div class="row mt-2 mb-5">
    <div class="col-4">
        @if ($user->avatar)
        <img src="{{ asset('storage/avatar/'.$user->avatar) }}" alt="{{ $user->avater }}" class="img-thumbnail w-100">
        @else
        <i class="fa-solid fa-image fa-10x d-block text-center"></i>
        @endif
    </div>
    <div class="col-8">
        <h2 class="display-6">{{ $user->name }}</h2>

        @if (Auth::user()->id == $user->id)
            <a href="{{ route('profile.edit', Auth::user()->id) }}" class="text-decoration-none">Edit Profile</a>
        @endif

    </div>
</div>


<ul class="list-group mb-5">
    @forelse ($user->posts ->sortByDesc('created_at') as $post)

    <li class="list-group-item py-4">
        <div class="row">
            <div class="col-4">
                <img src="{{ asset('storage/images/'.$post->image) }}" alt="{{ $post->image }}" class="w-100">
            </div>
            <div class="col-8">
                <a href="{{ route('post.show',$post->id) }}">
                    <h3 class="h4">{{ $post->title }}</h3>
                </a>
                <p class="fw-light mb-0">{{ $post->body }}</p>

                {{-- check if user is the one currently loffes in --}}
                @if (Auth::user()->id == $user->id)
                <div class="text-end mt-2">
                    <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-pen me-2"></i>Edit
                    </a>

                    <form action="{{ route('post.destroy',$post->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash-can me-2"></i>Delete
                        </button>
                    </form>
                </div>

                @endif

            </div>
        </div>
    </li>

    @empty

    <h2 class="text-muted text-center">No Posts Yet.</h2>
    <p class="text-center">
        <a href="{{ route('post.create') }}" class="text-decoration-none">Create a New Post.</a>
    </p>


    @endforelse

</ul>
@endsection
