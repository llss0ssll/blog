@extends('layouts.app')
@section('title',"Home")

@section('content')
@forelse ($all_posts as $post)

{{-- display all of the post --}}

<div class="mt-2 border border-2 rounded py-3 px-4">
    <div class="row">
        <div class="col-4">
            <img src="{{ asset('storage/images/'.$post->image) }}" alt="{{ $post->image }}" class="w-100">
        </div>
        <div class="col-8">
            <div class="row">
                <div class="col">
                    <h3 class="h6 text-muted">
                        @if ($post->user->avatar)
                            <img src="{{ asset('storage/avatar/'.$post->user->avatar) }}"
                            alt="{{ $post->user->avatar }}" style="width: 3rem" class="rounded">
                        @else
                            <i class="fa-solid fa-user fa-3x"></i>
                        @endif
                        <a href="{{ route('profile.show',$post->user->id) }}"
                        class="text-decoration-none text-secondary">{{ $post->user->name }}</a>
                    </h3>

                </div>
                <div class="col">
                    @if($post->user_id === Auth::user()->id)
            <div class="text-end mt-2">
                <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-pen me-2"></i>Edit
                </a>

                <form action="{{ route('post.destroy',$post->id) }}" method="POST" class="d-inline">
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
            <a href="{{ route('post.show',$post->id) }}">
                <h2 class="h4">{{ $post->title }}</h2>
            </a>

            <p class="fw-light mb-0">{{ $post->body }}</p>

            {{-- check if user own the post --}}

        </div>
    </div>
</div>

@empty

<div style="margin-top: 100px">

    <h2 class="text-muted text-center">No Posts Yet.</h2>
    <p class="text-center">
        <a href="{{ route('post.create') }}" class="text-decoration-none">Create a New Post.</a>
    </p>

    </div>

@endforelse

{{-- paginate --}}
<div class="d-flex justify-content-center mt-5">
    {{ $all_posts->links() }}
</div>

@endsection
